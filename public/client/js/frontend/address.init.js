/*
Template Name: Toner eCommerce + Admin HTML Template
Author: Themesbrand
Version: 1.2.0 Refactored Logic
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Address Js File
*/

// --- BIẾN GLOBAL VÀ HẰNG SỐ ---
var editlist = false;
var currentEditId = null;
const ADDRESS_LIMIT = 2; // Số địa chỉ hiển thị ban đầu

// --- CÁC HÀM HELPER VÀ LOGIC CHÍNH (GLOBAL SCOPE) ---

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
}

function createToastContainer() {
    // Đảm bảo chỉ tạo container một lần
    let container = document.getElementById("toast-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        container.className = "toast-container position-fixed top-0 end-0 p-3";
        container.style.zIndex = "1090"; // Đảm bảo trên modal
        document.body.appendChild(container);
    }
    return container;
}

function showToast(message, type = "info") {
    const toastContainer = createToastContainer(); // Luôn gọi để đảm bảo container tồn tại
    const toast = document.createElement("div");
    const bgClass = type === "success" ? "bg-success" : type === "error" ? "bg-danger" : "bg-info";
    toast.className = `toast align-items-center text-white ${bgClass} border-0`;
    toast.setAttribute("role", "alert");
    toast.setAttribute("aria-live", "assertive");
    toast.setAttribute("aria-atomic", "true");
    toast.setAttribute("data-bs-delay", "3000"); // Thời gian hiển thị

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toast);

    // Khởi tạo và hiển thị toast bằng Bootstrap
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const bsToast = new bootstrap.Toast(toast); // Không cần option delay ở đây nếu đã set data attribute
        bsToast.show();
        // Tự động xóa element khỏi DOM sau khi toast ẩn đi
        toast.addEventListener('hidden.bs.toast', function () {
           if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        });
    } else {
        // Fallback nếu không có Bootstrap Toast
        toast.style.display = 'block';
        setTimeout(() => {
             if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }
}


// -- Render danh sách địa chỉ --
function renderAddresses(dataArray, showAll = false) {
    const addressList = document.getElementById("address-list");
    if (!addressList) {
        console.error("Element #address-list not found in renderAddresses");
        return;
    }
    addressList.innerHTML = ""; // Clear list trước khi render
    const itemsToShow = showAll ? dataArray : dataArray.slice(0, ADDRESS_LIMIT);

    const viewAllContainer = document.getElementById("view-all-container");
    const viewAllBtn = document.getElementById("view-all-btn");

    if (itemsToShow.length === 0) {
        addressList.innerHTML = `
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có địa chỉ nào. Vui lòng thêm địa chỉ mới.</p>
            </div>`;
        if (viewAllContainer) viewAllContainer.style.display = "none"; // Ẩn nút ViewAll nếu không có item
        return; // Kết thúc sớm
    }

    // Render từng item
    itemsToShow.forEach(function (listdata) {
        const id = listdata?.id ?? 'unknown-' + Date.now(); // ID dự phòng
        const isChecked = listdata?.is_default ?? false;
        const name = listdata?.name ?? 'N/A';
        const displayAddress = listdata?.full_address ?? 'N/A'; // Ưu tiên full_address từ controller
        const phone = listdata?.phone ?? 'N/A';

        const checkinput = isChecked ? "checked" : "";
        const checkedText = isChecked ? "Địa chỉ mặc định" : "Địa chỉ khác";
        const defaultButton = isChecked ? "" : `
            <div>
                <a href="#" class="d-block text-body p-1 px-2 set-default" data-default-id="${id}">
                    <i class="ri-star-fill text-muted align-bottom me-1"></i> Đặt làm mặc định
                </a>
            </div>`;

        // Thêm HTML vào list
        addressList.insertAdjacentHTML('beforeend', `
            <div class="col-lg-6 mb-3">
                <div>
                    <div class="form-check card-radio">
                        <input id="shippingAddress${id}" name="shippingAddress" type="radio" class="form-check-input" ${checkinput} value="${id}">
                        <label class="form-check-label w-100" for="shippingAddress${id}"> <span class="mb-3 fw-semibold fs-12 d-block text-muted text-uppercase">${checkedText}</span>
                            <span class="fs-14 mb-2 fw-semibold d-block">${name}</span>
                            <span class="text-muted fw-normal text-wrap mb-1 d-block">${displayAddress}</span>
                            <span class="text-muted fw-normal d-block">SĐT: ${phone}</span>
                        </label>
                    </div>
                    <div class="d-flex flex-wrap p-2 py-1 bg-light rounded-bottom border mt-n1 fs-13">
                        <div>
                            <a href="#" class="d-block text-body p-1 px-2 edit-list" data-edit-id="${id}" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="ri-pencil-fill text-muted align-bottom me-1"></i> Sửa
                            </a>
                        </div>
                        <div>
                            <a href="#" class="d-block text-body p-1 px-2 remove-list" data-remove-id="${id}" data-bs-toggle="modal" data-bs-target="#removeAddressModal">
                                <i class="ri-delete-bin-fill text-muted align-bottom me-1"></i> Xóa
                            </a>
                        </div>
                        ${defaultButton}
                    </div>
                </div>
            </div>`);
    });

    // Cập nhật nút View All
    if (viewAllContainer && viewAllBtn) {
        if (dataArray.length > ADDRESS_LIMIT) {
            viewAllContainer.style.display = "block";
            viewAllBtn.textContent = showAll ? "Thu gọn" : "Xem tất cả";
            // Lưu trạng thái expand vào attribute để dùng khi reload
            viewAllBtn.setAttribute('data-expanded', showAll ? 'true' : 'false');
        } else {
            viewAllContainer.style.display = "none";
        }
    }

    // Gắn lại các event handlers cho các nút vừa render
    initializeEventHandlers(dataArray);
}

// -- Gắn các Event Handlers cho các nút trong danh sách địa chỉ --
function initializeEventHandlers(dataArray) {

    // Helper function để gắn listener an toàn (xóa listener cũ nếu có)
    const addSafeEventListener = (selector, eventType, handler) => {
        document.querySelectorAll(selector).forEach(element => {
            const newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
            newElement.addEventListener(eventType, handler);
        });
    };

    // Xử lý nút Set Default
    addSafeEventListener(".set-default", "click", function(e) {
        e.preventDefault();
        const addressId = this.getAttribute("data-default-id");
        setDefaultAddress(addressId);
    });

    // Xử lý nút Edit
    addSafeEventListener(".edit-list", "click", function(e) {
        const addressId = this.getAttribute("data-edit-id");
        // Cần dataArray để tìm đúng dữ liệu cần sửa
        prepareEditModal(addressId, dataArray);
    });

    // Xử lý nút Remove (chỉ gắn ID vào nút confirm)
    addSafeEventListener(".remove-list", "click", function(e) {
        const addressId = this.getAttribute("data-remove-id");
        const removeConfirmBtn = document.getElementById('remove-address');
        if (removeConfirmBtn) {
            removeConfirmBtn.setAttribute('data-confirm-remove-id', addressId);
        } else {
            console.error("Remove confirmation button (#remove-address) not found.");
            showToast("Lỗi: Không tìm thấy nút xác nhận xóa.", "error");
        }
    });
}

// -- Đặt làm mặc định (Tương tác Server) --
function setDefaultAddress(addressId) {
    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        return showToast("Lỗi: CSRF token không tìm thấy", "error");
    }
    console.log(`Setting address ${addressId} as default...`);

    fetch(`/addresses/${addressId}/set-default`, { // Giữ URL này nếu route là addresses/.../set-default
        method: "POST",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(err.message || `Lỗi ${response.status}`) });
        }
        return response.json();
    })
    .then(data => {
        console.log("Set default successful:", data);
        showToast(data.message || "Đặt địa chỉ mặc định thành công!", "success");
        reloadAddressList(); // Tải lại danh sách để cập nhật UI
    })
    .catch(error => {
        console.error("Error setting default address:", error);
        showToast(error.message || "Lỗi khi đặt địa chỉ mặc định.", "error");
    });
}

// -- Tải lại danh sách từ Server --
function reloadAddressList() {
    console.log("Reloading address list from server...");
    const viewAllBtn = document.getElementById("view-all-btn");
    // Lấy trạng thái expand hiện tại (nếu có) để giữ nguyên sau khi load lại
    let shouldShowAll = viewAllBtn ? viewAllBtn.getAttribute('data-expanded') === 'true' : false;

    fetch("/address", { // URL lấy danh sách địa chỉ
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Lỗi HTTP! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(newDatas => {
        // Đảm bảo newDatas là mảng
        const addressesData = Array.isArray(newDatas) ? newDatas : (newDatas.data && Array.isArray(newDatas.data) ? newDatas.data : []);
        console.log("Addresses reloaded:", addressesData);
        // Sắp xếp lại (mặc định lên đầu)
        const sortedDatas = [...addressesData].sort((a, b) => (b.is_default ? 1 : 0) - (a.is_default ? 1 : 0));

        // Nếu số lượng item ít hơn giới hạn, luôn thu gọn
        if (addressesData.length <= ADDRESS_LIMIT) {
            shouldShowAll = false;
        }
        // Render lại danh sách với dữ liệu mới và trạng thái expand phù hợp
        renderAddresses(sortedDatas, shouldShowAll);
    })
    .catch(error => {
        console.error("Lỗi khi tải lại danh sách địa chỉ:", error);
        showToast("Lỗi khi tải lại danh sách địa chỉ", "error");
        const addressList = document.getElementById("address-list");
        if(addressList) {
            addressList.innerHTML = `<div class="col-12 text-center text-danger">Không thể tải danh sách địa chỉ. Vui lòng làm mới trang.</div>`;
        }
    });
}


// --- CÁC HÀM CHUẨN BỊ MODAL ---

function prepareAddModal() {
    editlist = false;
    currentEditId = null;
    const form = document.getElementById("createAddress-form");
    const modalLabel = document.getElementById("addAddressModalLabel");
    const submitButton = document.getElementById("addNewAddress");

    if(modalLabel) modalLabel.innerHTML = "Thêm địa chỉ mới";
    if(submitButton) submitButton.innerHTML = "Thêm";
    if(form) {
        form.reset(); // Reset các trường input
        form.classList.remove('was-validated'); // Bỏ trạng thái validation cũ
        // Set lại giá trị mặc định nếu cần (ví dụ: country)
        const countryInput = form.querySelector('#country');
        if (countryInput) countryInput.value = "Việt Nam";
        // Reset dropdown tỉnh/huyện/xã
        const provinceSelect = form.querySelector('#province');
        const districtSelect = form.querySelector('#district');
        const wardSelect = form.querySelector('#ward');
         if (provinceSelect) provinceSelect.value = ""; // Đảm bảo chọn lại từ đầu
        if (districtSelect) districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        if (wardSelect) wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';
         // Reset trường ẩn ID
         const idInput = form.querySelector('#addressid-input');
         if (idInput) idInput.value = "";
    }
}

// Sử dụng async để chờ load dropdown huyện/xã khi sửa
async function prepareEditModal(addressId, dataArray) {
    const addressData = dataArray.find(item => item.id == addressId);
    if (!addressData) {
        return showToast("Không tìm thấy dữ liệu địa chỉ để sửa.", "error");
    }
    console.log("Dữ liệu địa chỉ đang sửa:", addressData);

    editlist = true;
    currentEditId = addressId;
    const form = document.getElementById("createAddress-form");
    const modalLabel = document.getElementById("addAddressModalLabel");
    const submitButton = document.getElementById("addNewAddress");

    if(modalLabel) modalLabel.innerHTML = "Sửa địa chỉ";
    if(submitButton) submitButton.innerHTML = "Lưu thay đổi";
    if(form) form.classList.remove('was-validated');

    // Điền các trường input thông thường
    const idInput = form.querySelector('#addressid-input');
    const nameInput = form.querySelector('#addaddress-name');
    const phoneInput = form.querySelector('#addaddress-phone');
    const countryInput = form.querySelector('#country');
    const notesInput = form.querySelector('#addaddress-notes');
    const defaultCheckbox = form.querySelector('#addaddress-is_default'); // Đảm bảo ID checkbox đúng

    if(idInput) idInput.value = addressData.id;
    if(nameInput) nameInput.value = addressData.name || '';
    if(phoneInput) phoneInput.value = addressData.phone || '';
    if(countryInput) countryInput.value = addressData.country || 'Việt Nam';
    if(notesInput) notesInput.value = addressData.notes || '';
    if(defaultCheckbox) defaultCheckbox.checked = addressData.is_default || false;

    // Xử lý Dropdown Địa chỉ
    const provinceSelect = form.querySelector('#province');
    const districtSelect = form.querySelector('#district');
    const wardSelect = form.querySelector('#ward');

    // Reset huyện, xã trước khi chọn tỉnh
    if(districtSelect) districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
    if(wardSelect) wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

    // Hàm chờ (delay)
    const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

    if (addressData.province && provinceSelect) {
        provinceSelect.value = addressData.province;
        if (provinceSelect.value === addressData.province) {
            console.log("Đã chọn Tỉnh/Thành:", addressData.province);
            if (typeof window.loadDistricts === 'function') {
                window.loadDistricts(addressData.province);
                await delay(300); // Chờ load huyện

                if (addressData.district && districtSelect) {
                    districtSelect.value = addressData.district;
                    if (districtSelect.value === addressData.district) {
                        console.log("Đã chọn Quận/Huyện:", addressData.district);
                        if (typeof window.loadWards === 'function') {
                            window.loadWards(addressData.province, addressData.district);
                            await delay(300); // Chờ load xã

                            if (addressData.ward && wardSelect) {
                                wardSelect.value = addressData.ward;
                                if (wardSelect.value === addressData.ward) {
                                    console.log("Đã chọn Xã/Phường:", addressData.ward);
                                } else {
                                    console.warn(`Giá trị Xã/Phường "${addressData.ward}" không tìm thấy.`);
                                }
                            }
                        }
                    } else {
                        console.warn(`Giá trị Quận/Huyện "${addressData.district}" không tìm thấy.`);
                    }
                }
            }
        } else {
            console.warn(`Giá trị Tỉnh/Thành "${addressData.province}" không tìm thấy.`);
        }
    } else {
        console.log("Không có dữ liệu Tỉnh/Thành.");
        if (provinceSelect) provinceSelect.value = "";
    }
}


// --- XỬ LÝ SUBMIT FORM THÊM/SỬA ---
function handleAddressFormSubmit(event) {
    event.preventDefault();
    event.stopPropagation();
    const form = event.target; // Lấy form được submit

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; // Dừng nếu validation HTML cơ bản thất bại
    }

    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        return showToast("Lỗi: CSRF token không tìm thấy.", "error");
    }

    // Thu thập dữ liệu từ form
    // Sử dụng FormData để lấy dễ hơn hoặc lấy từng cái bằng ID/name
    const addressData = {
        name: form.querySelector('#addaddress-name').value,
        phone: form.querySelector('#addaddress-phone').value,
        country: form.querySelector('#country').value,
        province: form.querySelector('#province').value,
        district: form.querySelector('#district').value,
        ward: form.querySelector('#ward').value,
        notes: form.querySelector('#addaddress-notes').value,
        is_default: form.querySelector('#addaddress-is_default')?.checked ? 1 : 0,
    };

    // Xác định URL và Method
    let url = "/address"; // Mặc định là thêm mới - URL số nhiều
    let method = "POST";
    if (editlist && currentEditId) {
        url = `/address/${currentEditId}`; // URL sửa số nhiều với ID
        method = "PUT";
        // addressData.id = currentEditId; // PUT không cần gửi ID trong body nếu đã có ở URL
    }

    // Xử lý trạng thái loading cho nút submit
    const submitButton = form.querySelector('#addNewAddress');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...`;

    // Gửi request Fetch
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(addressData)
    })
    .then(response => {
        if (!response.ok) {
             // Cố gắng đọc lỗi JSON từ server
             return response.json().then(errData => {
                 console.error("Server Error Data:", errData);
                 let errorMessage = `Lỗi ${response.status}: `;
                 if (response.status === 422 && errData.errors) { // Lỗi validation
                     const errorMessages = Object.values(errData.errors).flat();
                     errorMessage += errorMessages.join(' ');
                 } else { // Lỗi khác
                     errorMessage += errData.message || "Có lỗi xảy ra.";
                 }
                 throw new Error(errorMessage);
             }).catch((jsonError) => {
                  // Nếu không đọc được JSON lỗi (ví dụ 404, 500 trả về HTML)
                  console.error("Non-JSON error response:", jsonError);
                  throw new Error(`Lỗi ${response.status}: Không thể ${editlist ? 'cập nhật' : 'thêm'} địa chỉ.`);
             });
         }
         return response.json(); // Trả về JSON nếu thành công
    })
    .then(data => {
        showToast(data.message || `Địa chỉ đã được ${editlist ? 'cập nhật' : 'thêm'} thành công!`, "success");
        reloadAddressList(); // Tải lại danh sách
        // Đóng modal (Tìm nút đóng trong modal và click)
        const closeButton = document.getElementById('addAddress-close');
        if (closeButton) {
            closeButton.click();
        } else {
            // Hoặc tìm modal và dùng bootstrap instance để ẩn
            const modalElement = document.getElementById('addAddressModal');
            if (modalElement && bootstrap.Modal.getInstance(modalElement)) {
                bootstrap.Modal.getInstance(modalElement).hide();
            }
        }
    })
    .catch(error => {
        console.error(`Error ${editlist ? 'updating' : 'adding'} address:`, error);
        showToast(error.message || `Đã xảy ra lỗi khi ${editlist ? 'cập nhật' : 'thêm'} địa chỉ.`, "error");
    })
    .finally(() => {
        // Khôi phục trạng thái nút submit
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    });
}


// --- XỬ LÝ XÁC NHẬN XÓA ---
function handleDeleteConfirmation() {
    const button = this; // Nút "Yes, Delete It!" vừa được click
    const addressId = button.getAttribute('data-confirm-remove-id');
    if (!addressId) {
        console.error("Address ID not found on confirmation button for deletion.");
        return showToast("Lỗi: Không tìm thấy ID địa chỉ để xóa.", "error");
    }

    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        return showToast("Lỗi: CSRF token không tìm thấy.", "error");
    }

    const originalButtonText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xóa...`;

    // *** SỬA URL Ở ĐÂY ***
    // Nếu dùng Route::resource('address',...) thì URL là /address/{id}
    // Nếu dùng Route::delete('addresses/{id}',...) thì URL là /addresses/{id}
    // Chọn 1 trong 2 URL dưới đây cho phù hợp với route của bạn:
    const deleteUrl = `/address/${addressId}`; // <<< DÙNG URL NÀY NẾU BẠN GIỮ Route::resource('address',...)
    // const deleteUrl = `/addresses/${addressId}`; // <<< DÙNG URL NÀY NẾU BẠN ĐỊNH NGHĨA ROUTE RIÊNG LÀ addresses/{id}

    fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(err.message || `Lỗi ${response.status}`) });
        }
        // Xử lý 204 No Content (không có body) hoặc 200 OK (có body)
        if (response.status === 204) {
            return { message: "Địa chỉ đã được xóa thành công!" }; // Tạo message mặc định
        }
        return response.json();
    })
    .then(data => {
        reloadAddressList(); // Tải lại danh sách
        showToast(data.message || "Địa chỉ đã được xóa thành công!", "success");
        // Đóng modal xác nhận xóa
        const closeButton = document.getElementById('close-removeAddressModal');
         if (closeButton) {
             closeButton.click();
         } else {
            const modalElement = document.getElementById('removeAddressModal');
            if (modalElement && bootstrap.Modal.getInstance(modalElement)) {
                bootstrap.Modal.getInstance(modalElement).hide();
            }
         }
    })
    .catch(error => {
        console.error("Error deleting address:", error);
        showToast(error.message || "Đã xảy ra lỗi khi xóa địa chỉ.", "error");
    })
    .finally(() => {
        // Khôi phục nút và xóa attribute ID
        button.disabled = false;
        button.innerHTML = originalButtonText;
        button.removeAttribute('data-confirm-remove-id');
    });
}


// --- XỬ LÝ DROPDOWN TỈNH/HUYỆN/XÃ ---
// (Giữ nguyên phần xử lý dropdown với data hardcoded hoặc sửa để fetch từ server nếu có API)
const locations = {
    'Hà Nội': {
        'Ba Đình': ['Phúc Xá', 'Trúc Bạch', 'Vĩnh Phúc', 'Cống Vị', 'Liễu Giai', 'Nguyễn Trung Trực', 'Quán Thánh', 'Ngọc Hà', 'Điện Biên', 'Đội Cấn', 'Ngọc Khánh', 'Kim Mã', 'Giảng Võ', 'Thành Công'],
        'Hoàn Kiếm': ['Phúc Tân', 'Đồng Xuân', 'Hàng Mã', 'Hàng Buồm', 'Hàng Đào', 'Hàng Bạc', 'Văn Miếu', 'Chương Dương', 'Hàng Trống', 'Lý Thái Tổ', 'Hàng Bồ', 'Cửa Đông', 'Hàng Gai', 'Hàng Bài', 'Trần Hưng Đạo', 'Phan Chu Trinh', 'Tràng Tiền', 'Cửa Nam'],
        'Cầu Giấy': ['Nghĩa Đô', 'Nghĩa Tân', 'Mai Dịch', 'Dịch Vọng', 'Dịch Vọng Hậu', 'Quan Hoa', 'Yên Hòa', 'Trung Hòa'],
    },
    'TP. Hồ Chí Minh': {
        'Quận 1': ['Tân Định', 'Đa Kao', 'Bến Nghé', 'Bến Thành', 'Nguyễn Thái Bình', 'Phạm Ngũ Lão', 'Cầu Ông Lãnh', 'Cô Giang', 'Nguyễn Cư Trinh', 'Cầu Kho'],
        'Quận 3': ['Phường 01', 'Phường 02', 'Phường 03', 'Phường 04', 'Phường 05', 'Phường 09', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Võ Thị Sáu'],
    },
    'Đà Nẵng': {
        'Hải Châu': ['Thanh Bình', 'Thuận Phước', 'Thạch Thang', 'Hải Châu I', 'Hải Châu II', 'Phước Ninh', 'Hòa Thuận Tây', 'Hòa Thuận Đông', 'Nam Dương', 'Bình Hiên', 'Bình Thuận', 'Hòa Cường Bắc', 'Hòa Cường Nam'],
    },
};
function loadProvinces() {
    const provinceSelect = document.getElementById('province');
    if (!provinceSelect) return console.error("Province select not found.");
    provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>'; // Reset
    for (let province in locations) {
        if (Object.prototype.hasOwnProperty.call(locations, province)) {
            const option = document.createElement('option');
            option.value = province; option.textContent = province;
            provinceSelect.appendChild(option);
        }
    }
}
window.loadDistricts = function(province) {
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    if(districtSelect) districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>'; // Reset huyện
    if(wardSelect) wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>'; // Reset xã
    if (!districtSelect || !province || typeof locations[province] !== 'object' || locations[province] === null) return;
    for (let district in locations[province]) {
         if (Object.prototype.hasOwnProperty.call(locations[province], district)) {
            const option = document.createElement('option');
            option.value = district; option.textContent = district;
            districtSelect.appendChild(option);
        }
    }
}
window.loadWards = function(province, district) {
    const wardSelect = document.getElementById('ward');
    if(wardSelect) wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>'; // Reset xã
    if (!wardSelect || !province || !district || typeof locations[province] !== 'object' || locations[province] === null || !Array.isArray(locations[province][district])) {
         console.warn(`No wards found or invalid data for ${district}, ${province}`);
         return;
     }
    locations[province][district].forEach(ward => {
        const option = document.createElement('option');
        option.value = ward; option.textContent = ward;
        wardSelect.appendChild(option);
    });
}
// ... Các event listener cho provinceSelect, districtSelect ...


// --- KHỞI TẠO KHI TÀI LIỆU SẴN SÀNG (DOMContentLoaded) ---
document.addEventListener("DOMContentLoaded", function() {

    // 1. Khởi tạo danh sách địa chỉ ban đầu
    if (typeof addressListData !== 'undefined' && Array.isArray(addressListData)) {
        console.log("Loading initial addresses from page data:", addressListData);
        // initializeAddressList(addressListData); // Hàm cũ đã bị bỏ, gọi render trực tiếp hoặc reload
         const sortedInitialData = [...addressListData].sort((a, b) => (b.is_default ? 1 : 0) - (a.is_default ? 1 : 0));
         renderAddresses(sortedInitialData, false); // Render lần đầu

         // Gắn listener cho nút View All sau lần render đầu tiên
         const viewAllBtn = document.getElementById("view-all-btn");
         if (viewAllBtn && sortedInitialData.length > ADDRESS_LIMIT) {
            const newViewAllBtn = viewAllBtn.cloneNode(true);
            viewAllBtn.parentNode.replaceChild(newViewAllBtn, viewAllBtn);
            newViewAllBtn.addEventListener('click', function() {
                let isCurrentlyExpanded = newViewAllBtn.getAttribute('data-expanded') === 'true';
                renderAddresses(sortedInitialData, !isCurrentlyExpanded);
            });
         }

    } else {
        console.log("No initial address data found. Fetching from server...");
        reloadAddressList(); // Tải từ server nếu không có dữ liệu sẵn
    }

    // 2. Gắn listener cho nút "Add New Address"
    document.querySelectorAll(".addAddress-modal").forEach(button => {
        // Gắn listener an toàn
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        newButton.addEventListener('click', prepareAddModal);
    });

    // 3. Gắn listener cho nút Submit trong form Thêm/Sửa
    document.querySelectorAll('.createAddress-form').forEach(form => {
        // Gắn listener an toàn
        const newForm = form.cloneNode(true); // Clone form để xóa listener cũ có thể có
        form.parentNode.replaceChild(newForm, form);
        newForm.addEventListener('submit', handleAddressFormSubmit);
    });

    // 4. Gắn listener cho nút xác nhận Xóa trong modal xóa
    const removeConfirmBtn = document.getElementById('remove-address');
    if (removeConfirmBtn) {
         // Gắn listener an toàn
         const newConfirmBtn = removeConfirmBtn.cloneNode(true);
         removeConfirmBtn.parentNode.replaceChild(newConfirmBtn, removeConfirmBtn);
         newConfirmBtn.addEventListener('click', handleDeleteConfirmation);
    }

    // 5. Gắn listener để reset form khi modal Thêm/Sửa đóng
    const addAddressModal = document.getElementById('addAddressModal');
    if (addAddressModal) {
        addAddressModal.addEventListener('hidden.bs.modal', function () {
            editlist = false; // Reset trạng thái edit
            currentEditId = null;
            const form = this.querySelector("form"); // Tìm form bên trong modal này
            if(form) {
                form.classList.remove('was-validated');
                // Không cần reset form ở đây nữa vì prepareAddModal sẽ được gọi khi mở lại
                // form.reset();
            }
        });
    }

    // 6. Khởi tạo dropdown địa chỉ (Tỉnh)
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    if(provinceSelect && districtSelect && wardSelect) {
         // Load provinces initially
         loadProvinces();

         // Add change listeners
         provinceSelect.addEventListener('change', function () {
             window.loadDistricts(this.value);
         });
         districtSelect.addEventListener('change', function () {
             const selectedProvince = provinceSelect.value;
             if(selectedProvince) {
                 window.loadWards(selectedProvince, this.value);
             }
         });
    }

}); // Kết thúc DOMContentLoaded