var productListAllData = JSON.parse(document.getElementById('productListAllData').textContent || '[]');
var inputValueJson = sessionStorage.getItem("inputValue")
    , editinputValueJson = (inputValueJson && (inputValueJson = JSON.parse(inputValueJson),
        Array.from(inputValueJson).forEach(e => {
            productListAllData.unshift(e)
        }
        )),
        sessionStorage.getItem("editInputValue"))
    , productListAll = (editinputValueJson && (editinputValueJson = JSON.parse(editinputValueJson),
        productListAllData = productListAllData.map(function (e) {
            return e.id == editinputValueJson.id ? editinputValueJson : e
        })),
        document.getElementById("addproduct-btn").addEventListener("click", function () {
            sessionStorage.setItem("editInputValue", "")
        }),
        new gridjs.Grid({
            columns: [{
                name: "ID",
                hidden: true,
                data: (e) => e.id
            }, {
                name: "#",
                width: "40px",
                sort: {
                    enabled: !1
                },
                data: function (e) {
                    return gridjs.html('<div class="form-check checkbox-product-list">\t\t\t\t\t<input class="form-check-input" type="checkbox" value="' + e.id + '" id="checkbox-' + e.id + '">\t\t\t\t\t<label class="form-check-label" for="checkbox-' + e.id + '"></label>\t\t\t\t  </div>')
                }
            }, {
                name: "Product",
                width: "360px",
                data: function (e) {
                    return gridjs.html('<div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="avatar-sm bg-light rounded p-1"><img src="' + e.product.img + '" alt="" class="img-fluid d-block"></div></div><div class="flex-grow-1"><h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details.html" class="text-body">' + e.product.title + '</a></h5><p class="text-muted mb-0">Category : <span class="fw-medium">' + e.product.category + "</span></p></div></div>")
                }
            }, {
                name: "Stock",
                width: "94px",
                formatter: function (e) {
                    return gridjs.html('<span class="badge bg-' + (e > 0 ? 'success' : 'danger') + '">' + e + '</span>')
                }
            }, {
                name: "Price",
                width: "101px",
                formatter: function (e) {
                    return gridjs.html("$" + e)
                }
            }, {
                name: "Published",
                width: "220px",
                data: function (e) {
                    return gridjs.html(e.published.publishDate + '<small class="text-muted ms-1">' + e.published.publishTime + "</small>")
                }
            }, {
                name: "Action",
                width: "80px",
                sort: {
                    enabled: !1
                },
                formatter: (cell, row) => {
                    const id = row.cells[0].data;
                    return gridjs.html(`
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/admin/products/${id}">
                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                </a></li>
                                <li><a class="dropdown-item edit-list" data-edit-id="${id}" href="/admin/products/${id}/edit">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                </a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item remove-list" href="#" data-id="${id}" data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    `);
                }
            }],
            className: {
                th: "text-muted"
            },
            pagination: {
                limit: 10
            },
            sort: !0,
            data: productListAllData
        }).render(document.getElementById("table-product-list-all")))
// Parse dữ liệu và kiểm tra
var productListPublishedData = JSON.parse(document.getElementById('productListDeletedData').textContent || '[]');
// console.log('[Init] productListPublishedData:', productListPublishedData);

// Kiểm tra dữ liệu có trường id hợp lệ
if (!productListPublishedData.every(item => item && typeof item.id === 'number' && item.id > 0)) {
    // console.error('[Init] Invalid productListPublishedData: Some items missing valid id', productListPublishedData);
    alert('Lỗi: Dữ liệu sản phẩm không hợp lệ. Vui lòng kiểm tra dữ liệu đầu vào.');
}

// Khởi tạo Grid.js cho bảng sản phẩm đã xóa
var productListPublished = new gridjs.Grid({
    columns: [{
        name: "ID",
        hidden: true,
        data: (e) => {
            const id = e.id;
            console.log('[Grid] ID for item:', id, e);
            return id;
        }
    }, {
        name: "#",
        width: "40px",
        sort: {
            enabled: false
        },
        data: function (e) {
            const id = e.id;
            if (!id) {
                console.error('[Grid] Checkbox: Invalid ID for item', e);
                return '';
            }
            return gridjs.html('<div class="form-check checkbox-product-list">\t\t\t\t\t<input class="form-check-input" type="checkbox" value="' + id + '" id="checkbox-' + id + '">\t\t\t\t\t<label class="form-check-label" for="checkbox-' + id + '"></label>\t\t\t\t  </div>');
        }
    }, {
        name: "Product",
        width: "360px",
        data: function (e) {
            return gridjs.html('<div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="avatar-sm bg-light rounded p-1"><img src="' + e.product.img + '" alt="" class="img-fluid d-block"></div></div><div class="flex-grow-1"><h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details.html" class="text-body">' + e.product.title + '</a></h5><p class="text-muted mb-0">Category : <span class="fw-medium">' + e.product.category + "</span></p></div></div>");
        }
    }, {
        name: "Stock",
        width: "94px",
        formatter: function (e) {
            return gridjs.html('<span class="badge bg-' + (e > 0 ? 'success' : 'danger') + '">' + e + '</span>');
        }
    }, {
        name: "Price",
        width: "101px",
        formatter: function (e) {
            return gridjs.html("$" + e);
        }
    }, {
        name: "Published",
        width: "220px",
        data: function (e) {
            return gridjs.html(e.published.publishDate + '<small class="text-muted ms-1">' + e.published.publishTime + "</small>");
        }
    }, {
        name: "Action",
        width: "80px",
        sort: {
            enabled: false
        },
        formatter: function (e, t) {
            const id = t.cells[0].data;
            console.log('[Grid] Action column ID:', id, t);
            if (!id || id === 'null' || id === null) {
                console.error('[Grid] Invalid ID in Action column', t);
                return gridjs.html('<div class="dropdown"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" disabled><i class="ri-more-fill"></i></button></div>');
            }
            return gridjs.html(`
                <div class="dropdown">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item restore-list" href="#" data-id="${id}" data-bs-toggle="modal" data-bs-target="#restoreItemModal">
                            <i class="ri-restore-fill align-bottom me-2 text-muted"></i> Restore
                        </a></li>
                       <li>
    <a class="dropdown-item open-force-delete-modal" 
       href="#" 
       data-id="${id}" 
       data-bs-toggle="modal" 
       data-bs-target="#forceDeleteModal">
        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete Permanently
    </a>
</li>

                    </ul>
                </div>
            `);
        }
    }],
    className: {
        th: "text-muted"
    },
    pagination: {
        limit: 10
    },
    sort: true,
    data: productListPublishedData
}).render(document.getElementById("table-product-list-published"))
    , searchProductList = document.getElementById("searchProductList")
    , slider = (searchProductList.addEventListener("keyup", function () {
        var e = searchProductList.value.toLowerCase();
        function t(e, t) {
            return e.filter(function (e) {
                return -1 !== e.product.title.toLowerCase().indexOf(t.toLowerCase())
            })
        }
        var i = t(productListAllData, e)
            , e = t(productListPublishedData, e);
        productListAll.updateConfig({
            data: i
        }).forceRender(),
            productListPublished.updateConfig({
                data: e
            }).forceRender(),
            checkRemoveItem()
    }),
        Array.from(document.querySelectorAll(".filter-list a")).forEach(function (r) {
            r.addEventListener("click", function () {
                var e = document.querySelector(".filter-list a.active")
                    , t = (e && e.classList.remove("active"),
                        r.classList.add("active"),
                        r.querySelector(".listname").innerHTML)
                    , e = productListAllData.filter(e => e.product.category === t)
                    , i = productListPublishedData.filter(e => e.product.category === t);
                productListAll.updateConfig({
                    data: e
                }).forceRender(),
                    productListPublished.updateConfig({
                        data: i
                    }).forceRender(),
                    checkRemoveItem()
            })
        }),
        document.getElementById("product-price-range"))
    , minCostInput = (noUiSlider.create(slider, {
        start: [0, 2e3],
        step: 10,
        margin: 20,
        connect: !0,
        behaviour: "tap-drag",
        range: {
            min: 0,
            max: 2e3
        },
        format: wNumb({
            decimals: 0,
            prefix: "$ "
        })
    }),
        document.getElementById("minCost"))
    , maxCostInput = document.getElementById("maxCost")
    , filterDataAll = ""
    , filterDataPublished = ""
    , filterChoicesInput = (slider.noUiSlider.on("update", function (e, t) {
        var i = productListAllData
            , r = productListPublishedData
            , s = (t ? maxCostInput.value = e[t] : minCostInput.value = e[t],
                maxCostInput.value.substr(2))
            , a = minCostInput.value.substr(2);
        filterDataAll = i.filter(e => parseFloat(e.price) >= a && parseFloat(e.price) <= s),
            filterDataPublished = r.filter(e => parseFloat(e.price) >= a && parseFloat(e.price) <= s),
            productListAll.updateConfig({
                data: filterDataAll
            }).forceRender(),
            productListPublished.updateConfig({
                data: filterDataPublished
            }).forceRender(),
            checkRemoveItem()
    }),
        minCostInput.addEventListener("change", function () {
            slider.noUiSlider.set([null, this.value])
        }),
        maxCostInput.addEventListener("change", function () {
            slider.noUiSlider.set([null, this.value])
        }),
        new Choices(document.getElementById("filter-choices-input"), {
            addItems: !0,
            delimiter: ",",
            editItems: !0,
            maxItemCount: 10,
            removeItems: !0,
            removeItemButton: !0
        }))
    , searchBrandsOptions = (Array.from(document.querySelectorAll(".filter-accordion .accordion-item")).forEach(function (r) {
        var s = r.querySelectorAll(".filter-check .form-check .form-check-input:checked").length;
        r.querySelector(".filter-badge").innerHTML = s,
            Array.from(r.querySelectorAll(".form-check .form-check-input")).forEach(function (t) {
                var i = t.value;
                t.checked && filterChoicesInput.setValue([i]),
                    t.addEventListener("click", function (e) {
                        t.checked ? (s++,
                            r.querySelector(".filter-badge").innerHTML = s,
                            r.querySelector(".filter-badge").style.display = 0 < s ? "block" : "none",
                            filterChoicesInput.setValue([i])) : filterChoicesInput.removeActiveItemsByValue(i)
                    }),
                    filterChoicesInput.passedElement.element.addEventListener("removeItem", function (e) {
                        e.detail.value == i && (t.checked = !1,
                            s--,
                            r.querySelector(".filter-badge").innerHTML = s,
                            r.querySelector(".filter-badge").style.display = 0 < s ? "block" : "none")
                    }, !1),
                    document.getElementById("clearall").addEventListener("click", function () {
                        t.checked = !1,
                            filterChoicesInput.removeActiveItemsByValue(i),
                            s = 0,
                            r.querySelector(".filter-badge").innerHTML = s,
                            r.querySelector(".filter-badge").style.display = 0 < s ? "block" : "none",
                            productListAll.updateConfig({
                                data: productListAllData
                            }).forceRender(),
                            productListPublished.updateConfig({
                                data: productListPublishedData
                            }).forceRender()
                    })
            })
    }),
        document.getElementById("searchBrandsList"))
    , isSelected = (searchBrandsOptions.addEventListener("keyup", function () {
        var i = searchBrandsOptions.value.toLowerCase()
            , e = document.querySelectorAll("#flush-collapseBrands .form-check");
        Array.from(e).forEach(function (e) {
            var t = e.getElementsByClassName("form-check-label")[0].innerText.toLowerCase();
            e.style.display = t.includes(i) ? "block" : "none"
        })
    }),
        0);
function checkRemoveItem() {
    var e = document.querySelectorAll('a[data-bs-toggle="tab"]');
    Array.from(e).forEach(function (e) {
        e.addEventListener("show.bs.tab", function (e) {
            isSelected = 0,
                document.getElementById("selection-element").style.display = "none"
        })
    }),
        setTimeout(function () {
            Array.from(document.querySelectorAll(".checkbox-product-list input")).forEach(function (e) {
                e.addEventListener("click", function (e) {
                    1 == e.target.checked ? e.target.closest("tr").classList.add("gridjs-tr-selected") : e.target.closest("tr").classList.remove("gridjs-tr-selected");
                    var t = document.querySelectorAll(".checkbox-product-list input:checked");
                    isSelected = t.length,
                        e.target.closest("tr").classList.contains("gridjs-tr-selected"),
                        document.getElementById("select-content").innerHTML = isSelected,
                        document.getElementById("selection-element").style.display = 0 < isSelected ? "block" : "none"
                })
            }),
                removeItems(),
                removeSingleItem()
        }, 100)
}
var checkboxes = document.querySelectorAll(".checkbox-wrapper-mail input");
function removeItems() {
    document.getElementById("removeItemModal").addEventListener("show.bs.modal", function (e) {
        isSelected = 0,
            document.getElementById("delete-product").addEventListener("click", function () {
                Array.from(document.querySelectorAll(".gridjs-table tr")).forEach(function (e) {
                    var t, i = "";
                    function r(e, t) {
                        return e.filter(function (e) {
                            return e.id != t
                        })
                    }
                    e.classList.contains("gridjs-tr-selected") && (t = e.querySelector(".form-check-input").value,
                        i = r(productListAllData, t),
                        t = r(productListPublishedData, t),
                        productListAllData = i,
                        productListPublishedData = t,
                        e.remove())
                }),
                    document.getElementById("btn-close").click(),
                    document.getElementById("selection-element") && (document.getElementById("selection-element").style.display = "none"),
                    checkboxes.checked = !1
            })
    })
}
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast-message');
    toast.textContent = message;
    toast.className = `show ${type} fixed top-5 right-5 z-50 px-4 py-2 rounded text-white shadow-lg`;

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000); // 3 giây ẩn đi
}

// Khai báo biến toàn cục
let deleteProductId = null;

function removeSingleItem() {
    const modalElement = document.querySelector('#removeItemModal');
    const confirmDeleteBtn = document.getElementById('delete-product');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!modalElement || !confirmDeleteBtn || !csrfToken) {
        console.error('Essential DOM elements or CSRF token missing');
        return;
    }

    const modal = new bootstrap.Modal(modalElement);

    // Lắng nghe sự kiện đóng modal
    modalElement.addEventListener('hidden.bs.modal', function () {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
        // Không reset deleteProductId ở đây
    });

    // Lắng nghe sự kiện click "close" và "x" button để reset ID
    document.querySelector('#removeItemModal button.btn-light').addEventListener('click', function () {
        console.log('Close button clicked, resetting deleteProductId');
        deleteProductId = null;
    });

    document.querySelector('#removeItemModal #btn-close').addEventListener('click', function () {
        console.log('X button clicked, resetting deleteProductId');
        deleteProductId = null;
    });

    // Hàm gắn sự kiện cho các link xóa sản phẩm - cải tiến để sử dụng event delegation
    function setupDeleteEventHandlers() {
        // Sử dụng event delegation thay vì gắn event cho từng phần tử
        document.addEventListener('click', function (event) {
            const removeLink = event.target.closest('.remove-list');
            if (!removeLink) return; // Nếu không phải click vào nút xóa thì bỏ qua

            event.preventDefault();
            // Cập nhật deleteProductId mỗi khi click vào link xóa
            deleteProductId = removeLink.getAttribute('data-id');

            if (deleteProductId) {
                console.log('Selected product ID for deletion:', deleteProductId);
                modal.show();
            } else {
                console.error('Product ID is missing or invalid:', removeLink);
            }
        });
    }

    // Lắng nghe sự kiện click vào nút "Delete" trong modal
    confirmDeleteBtn.addEventListener('click', () => {
        console.log('Confirm delete clicked, product ID:', deleteProductId);

        if (!deleteProductId) {
            console.error('No product ID found for deletion');
            alert('No product selected.');
            return;
        }

        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.innerHTML = 'Deleting...';

        // Lưu lại ID trước khi gửi request
        const currentProductId = deleteProductId;

        // Gửi yêu cầu xóa sản phẩm
        fetch(`/admin/products/${currentProductId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(res => {
                if (!res.ok) throw new Error(`Server returned ${res.status}`);
                return res.json();
            })
            .then(({ success, message }) => {
                if (!success) throw new Error(message || 'Delete failed.');
                showToast(message, 'success');
                console.log(`Product ${currentProductId} deleted successfully`);

                // Cập nhật giao diện: Xóa dòng sản phẩm và dữ liệu liên quan
                const deletedRow = document.querySelector(`[data-id="${currentProductId}"]`)?.closest('.gridjs-tr');
                if (deletedRow) {
                    deletedRow.remove(); // Xóa dòng sản phẩm trong giao diện
                } else {
                    console.warn(`Row for product ID ${currentProductId} not found in DOM`);
                }

                // Cập nhật dữ liệu đã xóa khỏi nguồn dữ liệu
                productListAllData = productListAllData.filter(item => item.id != currentProductId);
                productListPublishedData = productListPublishedData.filter(item => item.id != currentProductId);

                // Cập nhật bảng
                if (typeof productListAll !== 'undefined' && productListAll.updateConfig) {
                    productListAll.updateConfig({ data: productListAllData }).forceRender();
                }
                if (typeof productListPublished !== 'undefined' && productListPublished.updateConfig) {
                    productListPublished.updateConfig({ data: productListPublishedData }).forceRender();
                }

                // Reset deleteProductId sau khi xóa thành công
                deleteProductId = null;
            })
            .catch(err => {
                console.error('Delete error:', err.message);
                // showToast(err.message, 'error');
                // alert(`Error during deletion: ${err.message}`);
            })
            .finally(() => {
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = 'Delete';
                modal.hide();
            });
    });

    // Thiết lập event handlers
    setupDeleteEventHandlers();
}

// Đảm bảo chức năng xóa được khởi tạo khi trang đã load
document.addEventListener('DOMContentLoaded', function () {
    removeSingleItem();

});





// Xử lý sự kiện restore bằng event delegation trên document
const restoreModalEl = document.getElementById('restoreItemModal');

// Xử lý sự kiện mở modal khôi phục
document.addEventListener('click', function (e) {
    const button = e.target.closest('.restore-list');
    if (!button) return;

    e.preventDefault();
    const productId = button.getAttribute('data-id');

    if (!productId || isNaN(productId) || Number(productId) <= 0) {
        alert('Lỗi: ID sản phẩm không hợp lệ.');
        return;
    }

    const confirmBtn = document.getElementById('confirmRestoreBtn');
    confirmBtn.setAttribute('data-id', productId);

    const modal = new bootstrap.Modal(restoreModalEl);
    modal.show();
});

// Xử lý nút xác nhận khôi phục
document.getElementById('confirmRestoreBtn').addEventListener('click', function () {
    const productId = this.getAttribute('data-id');
    if (!productId || isNaN(productId)) {
        alert('Lỗi: ID sản phẩm không hợp lệ.');
        return;
    }

    fetch(`/admin/products/restore/${productId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        },
    })
        .then(response => {
            if (!response.ok) throw new Error('Không tìm thấy API');

            return response.json();
        })
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`input[value="${productId}"]`)?.closest('tr');
                if (row) row.remove();

                // Đóng modal sau khi xử lý thành công
                const modal = bootstrap.Modal.getInstance(restoreModalEl);
                modal.hide();

                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            // console.error(error);
            showToast('Đã xảy ra lỗi khi khôi phục sản phẩm.', 'error');
        });
});

restoreModalEl.addEventListener('hidden.bs.modal', function () {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
    document.body.classList.remove('modal-open');
    document.body.style.paddingRight = '';  // Reset paddingRight nếu cần

    // Đảm bảo body có thể cuộn lại
    document.body.style.overflow = ''; // Reset lại overflow

    // Reset data-id về null để tránh rác
    document.getElementById('confirmRestoreBtn').removeAttribute('data-id');
});

let forceDeleteProductId = null;

function handleForceDelete() {
    const modalElement = document.querySelector('#forceDeleteModal');
    const confirmDeleteBtn = document.getElementById('confirm-force-delete');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!modalElement || !confirmDeleteBtn || !csrfToken) {
        console.error('[Force Delete] Missing required elements or CSRF token');
        return;
    }

    const modal = new bootstrap.Modal(modalElement);

    // Reset ID khi đóng modal
    const resetForceDeleteState = () => {
        console.log('[Force Delete] Resetting forceDeleteProductId');
        forceDeleteProductId = null;
    };

    document.querySelector('#forceDeleteModal button.btn-light').addEventListener('click', resetForceDeleteState);
    document.querySelector('#forceDeleteModal #btn-force-close').addEventListener('click', resetForceDeleteState);

    // Xử lý sự kiện đóng modal
    modalElement.addEventListener('hidden.bs.modal', () => {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();

        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
        resetForceDeleteState();
    });

    // Xử lý click vào link force delete
    document.addEventListener('click', (event) => {
        const forceDeleteLink = event.target.closest('.open-force-delete-modal');
        if (!forceDeleteLink) {
            console.log('[Force Delete] No open-force-delete-modal element found for click');
            return;
        }

        event.preventDefault();
        forceDeleteProductId = forceDeleteLink.getAttribute('data-id');

        if (!forceDeleteProductId) {
            console.error('[Force Delete] data-id attribute missing or empty on open-force-delete-modal');
            showToast('Invalid product ID', 'error');
            return;
        }

        console.log(`[Force Delete] Selected product ID: ${forceDeleteProductId}`);
        modal.show();
    });

    // Xử lý xác nhận xóa vĩnh viễn
    confirmDeleteBtn.addEventListener('click', () => {
        if (!forceDeleteProductId) {
            console.error('[Force Delete] No product ID selected for deletion');
            showToast('No product selected', 'error');
            return;
        }

        console.log(`[Force Delete] Initiating force delete for product ID: ${forceDeleteProductId}`);
        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.innerHTML = 'Deleting...';

        const url = `/admin/products/force-delete/${forceDeleteProductId}`;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => {
            console.log(`[Force Delete] Server response status: ${res.status}`);
            if (!res.ok) throw new Error(`Server returned ${res.status}`);
            return res.json();
        })
        .then(({ success, message }) => {
            if (!success) throw new Error(message);

            console.log(`[Force Delete] Product ID ${forceDeleteProductId} permanently deleted`);
            showToast(message, 'success');

            // Xóa sản phẩm khỏi giao diện
            const deletedRow = document.querySelector(`[data-id="${forceDeleteProductId}"]`)?.closest('.gridjs-tr');
            if (deletedRow) {
                console.log(`[Force Delete] Removing row for product ID: ${forceDeleteProductId}`);
                deletedRow.remove();
            } else {
                console.warn(`[Force Delete] Row for product ID ${forceDeleteProductId} not found in DOM`);
            }

            // Cập nhật dữ liệu
            if (typeof productListAllData !== 'undefined') {
                productListAllData = productListAllData.filter(item => item.id != forceDeleteProductId);
                if (typeof productListAll !== 'undefined' && productListAll.updateConfig) {
                    console.log('[Force Delete] Updating productListAll table');
                    productListAll.updateConfig({ data: productListAllData }).forceRender();
                }
            }

            if (typeof productListPublishedData !== 'undefined') {
                productListPublishedData = productListPublishedData.filter(item => item.id != forceDeleteProductId);
                if (typeof productListPublished !== 'undefined' && productListPublished.updateConfig) {
                    console.log('[Force Delete] Updating productListPublished table');
                    productListPublished.updateConfig({ data: productListPublishedData }).forceRender();
                }
            }

            resetForceDeleteState();
        })
        .catch(err => {
            console.error(`[Force Delete] Error: ${err.message}`);
            showToast(`Failed to permanently delete product: ${err.message}`, 'error');
        })
        .finally(() => {
            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = 'Yes, Permanently Delete';
            modal.hide();
        });
    });
}

document.addEventListener('DOMContentLoaded', handleForceDelete);