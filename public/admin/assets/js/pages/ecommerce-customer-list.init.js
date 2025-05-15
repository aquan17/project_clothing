var checkAll = document.getElementById("checkAll")
    , perPage = (checkAll && (checkAll.onclick = function () {
        for (var e = document.querySelectorAll('.form-check-all input[type="checkbox"]'), t = document.querySelectorAll('.form-check-all input[type="checkbox"]:checked').length, a = 0; a < e.length; a++)
            e[a].checked = this.checked,
                e[a].checked ? e[a].closest("tr").classList.add("table-active") : e[a].closest("tr").classList.remove("table-active");
        document.getElementById("remove-actions").style.display = 0 < t ? "none" : "block"
    }
    ),
        8)
    , editlist = !1
    , options = {
        valueNames: ["id", "customer_name", "email", "date", "phone", "status", "role", "password"],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({
            left: 2,
            right: 2
        })]
    }
    , customerList = new List("customerList", options).on("updated", function (e) {
        0 == e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "block" : document.getElementsByClassName("noresult")[0].style.display = "none";
        var t = 1 == e.i
            , a = e.i > e.matchingItems.length - e.page;
        document.querySelector(".pagination-prev.disabled") && document.querySelector(".pagination-prev.disabled").classList.remove("disabled"),
            document.querySelector(".pagination-next.disabled") && document.querySelector(".pagination-next.disabled").classList.remove("disabled"),
            t && document.querySelector(".pagination-prev").classList.add("disabled"),
            a && document.querySelector(".pagination-next").classList.add("disabled"),
            e.matchingItems.length <= perPage ? document.querySelector(".pagination-wrap").style.display = "none" : document.querySelector(".pagination-wrap").style.display = "flex",
            e.matchingItems.length == perPage && document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click(),
            0 < e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "none" : document.getElementsByClassName("noresult")[0].style.display = "block"
    });
const xhttp = new XMLHttpRequest;
xhttp.onload = function () {
    var e = JSON.parse(this.responseText);
    console.log(e);

    Array.from(e).forEach(e => {
        customerList.add({
            id: '<a href="javascript:void(0);" class="fw-medium link-primary">' + e.id + "</a>",
            customer_name: e.customer_name,
            email: e.email,
            date: e.date,
            phone: e.phone,
            status: isStatus(e.status),
            role: formatRole(e.role),
            password: e.password
        }),
            customerList.sort("id", {
                order: "desc"
            }),
            refreshCallbacks()
    }
    ),
        customerList.remove("id", '<a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a>')
}
    ,
    xhttp.open("GET", "admin/users/data");
xhttp.send();
var isValue = (isCount = (new DOMParser).parseFromString(customerList.items.slice(-1)[0]._values.id, "text/html")).body.firstElementChild.innerHTML
    , idField = document.getElementById("id-field")
    , customerNameField = document.getElementById("customername-field")
    , emailField = document.getElementById("email-field")
    , dateField = document.getElementById("date-field")
    , phoneField = document.getElementById("phone-field")
    , statusField = document.getElementById("status-field")
    , roleField = document.getElementById("role-field")
    , passwordField = document.getElementById("password-field")

    , addBtn = document.getElementById("add-btn")
    , editBtn = document.getElementById("edit-btn")
    , removeBtns = document.getElementsByClassName("remove-item-btn")
    , editBtns = document.getElementsByClassName("edit-item-btn");
function filterContact(e) { 
    var t = e;
    customerList.filter(function (e) {
        e = (matchData = (new DOMParser).parseFromString(e.values().status, "text/html")).body.firstElementChild.innerHTML;
        return "All" == e || "All" == t || e == t
    }),
        customerList.update()
}
function updateList() {
    var t = document.querySelector("input[name=status]:checked").value;
    data = userList.filter(function (e) {
        return "All" == t || e.values().sts == t
    }),
        userList.update()
}
refreshCallbacks(),
    document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
        e.relatedTarget.classList.contains("edit-item-btn") ? (document.getElementById("exampleModalLabel").innerHTML = "Edit Customer",
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block",
            document.getElementById("add-btn").innerHTML = "Update") : e.relatedTarget.classList.contains("add-btn") ? (document.getElementById("exampleModalLabel").innerHTML = "Add Customer",
                document.getElementById("showModal").querySelector(".modal-footer").style.display = "block",
                document.getElementById("add-btn").innerHTML = "Add Customer") : (document.getElementById("exampleModalLabel").innerHTML = "List Customer",
                    document.getElementById("showModal").querySelector(".modal-footer").style.display = "none")
    }),
    ischeckboxcheck(),
    document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
        clearFields()
    }),
    document.querySelector("#customerList").addEventListener("click", function () {
        ischeckboxcheck()
    });
var table = document.getElementById("customerTable")
    , tr = table.getElementsByTagName("tr")
    , trlist = table.querySelectorAll(".list tr");
function SearchData() {
    var l = document.getElementById("idStatus").value
        , i = document.getElementById("datepicker-range").value
        , s = i.split(" to ")[0]
        , o = i.split(" to ")[1];
    customerList.filter(function (e) {
        var t = (matchData = (new DOMParser).parseFromString(e.values().status, "text/html")).body.firstElementChild.innerHTML
            , a = !1
            , n = !1
            , a = "all" == t || "all" == l || t == l
            , n = new Date(e.values().date.slice(0, 12)) >= new Date(s) && new Date(e.values().date.slice(0, 12)) <= new Date(o);
        return a && n || (a && "" == i ? a : n && "" == i ? n : void 0)
    }),
        customerList.update()
}
var count = 11
    , forms = document.querySelectorAll(".tablelist-form")
    , statusVal = (Array.prototype.slice.call(forms).forEach(function (a) {
        a.addEventListener("submit", function (e) {
            console.log("Form submitted",e);
            e.preventDefault(); // Ngừng hành động mặc định của form

            // Kiểm tra tính hợp lệ của form
            if (a.checkValidity()) {
                // Lấy dữ liệu từ form
                // const formData = new FormData(a);
                const data = {
                    customer_name: customerNameField.value,
                    email: emailField.value,
                    phone: phoneField.value,
                    date: dateField.value,
                    status: statusField.value,
                    role: roleField.value,
                    password: passwordField.value,
                };
                // console.log("Form Data:", data); // Dòng này sẽ in dữ liệu ra console
                // Kiểm tra thao tác add hay edit
                const url = editlist ? `/admin/users/${idField.value}` : '/admin/users/'; // Đường dẫn API
                const method = editlist ? 'PUT' : 'POST'; // Phương thức HTTP
                console.log("Request URL:", url);
        console.log("HTTP Method:", method);
                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // bắt buộc
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data),
                })
                .then(response => {
                    console.log("Response status:", response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP Error: ${response.status}`);
                    }
                    return response.json(); // <--- sửa ở đây
                })
                    .then(responseData => {
                        console.log('Response Data:', responseData); // Log nội dung trả về
                        const newStatusHtml = isStatus(statusField.value);
                        if (responseData.message === 'User added successfully!' || responseData.message === 'User updated successfully!') {
                            // Nếu là ADD
                            if (!editlist) {
                                customerList.add({
                                    id: `<a href="javascript:void(0);" class="fw-medium link-primary">${responseData.user.id}</a>`,
                                    customer_name: data.customer_name,
                                    email: data.email,
                                    date: data.date,
                                    phone: data.phone,
                                    status: newStatusHtml,
                                    role: data.role,
                                    password: data.password,
                                });
                                customerList.sort("id", { order: "desc" });
                                count++;
                            } else {
                                // Nếu là EDIT
                                let t = customerList.get({ id: idField.value });
                                Array.from(t).forEach(function (e) {
                                    let parsedId = (new DOMParser).parseFromString(e._values.id, "text/html");
                                    if (parsedId.body.firstElementChild.innerHTML === itemId) {
                                        e.values({
                                            id: `<a href="javascript:void(0);" class="fw-medium link-primary">${idField.value}</a>`,
                                            customer_name: data.customer_name,
                                            email: data.email,
                                            date: data.date,
                                            phone: data.phone,
                                            status: newStatusHtml,
                                            role: data.role,
                                            password: data.password,
                                        });
                                    }
                                });
                            }

                            // Thông báo thành công
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: editlist ? "Customer updated successfully!" : "Customer inserted successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                                showCloseButton: true
                            });

                            // Đóng modal, reset form
                            document.getElementById("close-modal").click();
                            clearFields();
                            refreshCallbacks();
                            filterContact("All");
                        } else {
                            // Thông báo lỗi nếu có
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: responseData.message || 'An error occurred',
                                showConfirmButton: true,
                                showCloseButton: true
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: 'An error occurred, please try again.',
                            showConfirmButton: true,
                            showCloseButton: true
                        });
                    });
            } else {
                e.preventDefault();
                e.stopPropagation();
            }
        });

    }),
        new Choices(statusField));
        // Thêm hàm để định dạng hiển thị role
function formatRole(role) {
    switch (role) {
        case "admin":
            return '<span class="badge bg-danger-subtle text-danger text-uppercase">' + role + "</span>";
        case "manager":
            return '<span class="badge bg-info-subtle text-info text-uppercase">' + role + "</span>";
        case "editor":
            return '<span class="badge bg-primary-subtle text-primary text-uppercase">' + role + "</span>";
        case "user":
            return '<span class="badge bg-success-subtle text-info text-uppercase">' + role + "</span>";
        default:
            return '<span class="badge bg-secondary-subtle text-secondary text-uppercase">' + role + "</span>";
    }
}
function isStatus(e) {
    switch (e) {
        case "active":
            return '<span class="badge bg-success-subtle text-success text-uppercase">' + e + "</span>";
        case "locked":
            return '<span class="badge bg-warning-subtle text-warning text-uppercase">' + e + "</span>"
        case "banned":
            return '<span class="badge bg-danger-subtle text-danger text-uppercase">' + e + "</span>"
        default:
            return '<span class="badge bg-secondary-subtle text-secondary text-uppercase">' + e + "</span>"
    }
}
function ischeckboxcheck() {
    Array.from(document.getElementsByName("chk_child")).forEach(function (a) {
        a.addEventListener("change", function (e) {
            1 == a.checked ? e.target.closest("tr").classList.add("table-active") : e.target.closest("tr").classList.remove("table-active");
            var t = document.querySelectorAll('[name="chk_child"]:checked').length;
            e.target.closest("tr").classList.contains("table-active"),
                document.getElementById("remove-actions").style.display = 0 < t ? "block" : "none"
        })
    })
}

var roleVal = new Choices(roleField, {
    searchEnabled: false,
    
    });
function refreshCallbacks() {
    removeBtns && Array.from(removeBtns).forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            // Lấy ID của người dùng cần xóa
            const userRow = e.target.closest("tr");
            const itemId = userRow.children[1].innerText;
            
            // Lưu ID người dùng để sử dụng trong xác nhận xóa
            document.getElementById("user-id-to-delete").value = itemId;
        });
    });
    
    // Xử lý nút xác nhận xóa - chỉ thêm một lần
    const deleteRecordBtn = document.getElementById("delete-record");
    if (deleteRecordBtn) {
        // Xóa tất cả event listener cũ trước khi thêm mới
        deleteRecordBtn.replaceWith(deleteRecordBtn.cloneNode(true));
        
        // Thêm event listener mới
        document.getElementById("delete-record").addEventListener("click", function() {
            const userId = document.getElementById("user-id-to-delete").value;
            if (userId) {
                deleteUserFromDatabase(userId);
            }
        });
    }
    
    editBtns && Array.from(editBtns).forEach(function (e) {
        e.addEventListener("click", function (e) {
            e.target.closest("tr").children[1].innerText,
                itemId = e.target.closest("tr").children[1].innerText;
            e = customerList.get({
                id: itemId
            });
            Array.from(e).forEach(function (e) {
                var t = (isid = (new DOMParser).parseFromString(e._values.id, "text/html")).body.firstElementChild.innerHTML;
                if (t == itemId) {
                    editlist = !0;
                    idField.value = t;
                    customerNameField.value = e._values.customer_name;
                    emailField.value = e._values.email;
                    dateField.value = e._values.date;
                    phoneField.value = e._values.phone;
                    passwordField.value = e._values.password;
                    // Xử lý status
                    statusVal && statusVal.destroy();
                    statusVal = new Choices(statusField, {
                        searchEnabled: false
                    });
                    var statusText = (new DOMParser).parseFromString(e._values.status, "text/html").body.firstElementChild.innerHTML;
                    statusVal.setChoiceByValue(statusText);
                    // Xử lý role
                    const roleElement = (new DOMParser).parseFromString(e._values.role, "text/html");
const actualRole = roleElement.body.firstElementChild.innerHTML.toLowerCase();
roleVal.setChoiceByValue(actualRole || "user");
                    // Xử lý date
                    flatpickr("#date-field", {
                        enableTime: true,
                        dateFormat: "d M, Y",
                        defaultDate: e._values.date
                    });
                }
            });
        });
    });
}
// Thêm input ẩn để lưu ID người dùng đang xóa
document.addEventListener('DOMContentLoaded', function() {
    // Tạo input ẩn nếu chưa tồn tại
    if (!document.getElementById('user-id-to-delete')) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.id = 'user-id-to-delete';
        document.body.appendChild(hiddenInput);
    }
});

// Hàm xóa user từ database
function deleteUserFromDatabase(userId) {
    console.log("Deleting user with ID:", userId);
    
    // Gọi API xóa user
    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        console.log("Delete response status:", response.status);
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Delete response:', data);
        
        if (data.success) {
            // Xóa user khỏi danh sách UI
            customerList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary">${userId}</a>`);
            
            // Đóng modal xác nhận xóa
            document.getElementById("deleteRecord-close").click();
            
            // Hiển thị thông báo thành công
            Swal.fire({
                position: "center",
                icon: "success",
                title: "User deleted successfully!",
                showConfirmButton: false,
                timer: 1000,
                showCloseButton: true
            });
        } else {
            // Hiển thị thông báo lỗi
            Swal.fire({
                position: "center",
                icon: "error",
                title: data.message || "Failed to delete user",
                showConfirmButton: true,
                showCloseButton: true
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Hiển thị thông báo lỗi
        Swal.fire({
            position: "center",
            icon: "error",
            title: "An error occurred while deleting the user",
            text: error.message,
            showConfirmButton: true,
            showCloseButton: true
        });
    });
}
function clearFields() {
    customerNameField.value = "",
        emailField.value = "",
        dateField.value = "",
        phoneField.value = ""
}
function deleteMultiple() {
    ids_array = [];
    var e, t = document.getElementsByName("chk_child");
    for (i = 0; i < t.length; i++)
        1 == t[i].checked && (e = t[i].parentNode.parentNode.parentNode.querySelector("td a").innerHTML,
            ids_array.push(e));
    
    if (typeof ids_array !== "undefined" && ids_array.length > 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-primary w-xs me-2 mt-2",
                cancelButton: "btn btn-danger w-xs mt-2"
            },
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                // Xóa nhiều user
                const deletePromises = ids_array.map(id => 
                    fetch(`/admin/users/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Failed to delete user ${id}`);
                        }
                        return response.json();
                    })
                );
                
                Promise.all(deletePromises)
                    .then(() => {
                        // Xóa các user khỏi UI
                        for (i = 0; i < ids_array.length; i++) {
                            customerList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`);
                        }
                        
                        // Ẩn options xóa và bỏ chọn checkAll
                        document.getElementById("remove-actions").style.display = "none";
                        document.getElementById("checkAll").checked = false;
                        
                        // Hiển thị thông báo thành công
                        Swal.fire({
                            title: "Deleted!",
                            text: "Users have been deleted.",
                            icon: "success",
                            customClass: {
                                confirmButton: "btn btn-info w-xs mt-2"
                            },
                            buttonsStyling: false
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: "Error!",
                            text: error.message,
                            icon: "error",
                            customClass: {
                                confirmButton: "btn btn-info w-xs mt-2"
                            },
                            buttonsStyling: false
                        });
                    });
            }
        });
    } else {
        Swal.fire({
            title: "Please select at least one checkbox",
            customClass: {
                confirmButton: "btn btn-info"
            },
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}
document.querySelector(".pagination-next").addEventListener("click", function () {
    document.querySelector(".pagination.listjs-pagination") && document.querySelector(".pagination.listjs-pagination").querySelector(".active") && document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click()
}),
    document.querySelector(".pagination-prev").addEventListener("click", function () {
        document.querySelector(".pagination.listjs-pagination") && document.querySelector(".pagination.listjs-pagination").querySelector(".active") && document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click()
    });
