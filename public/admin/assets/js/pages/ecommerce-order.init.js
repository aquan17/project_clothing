var str_dt = function(e) {
    var e = new Date(e),
        t = (e.getHours() + ":" + e.getMinutes()).split(":"),
        a = 12 <= (n = t[0]) ? "PM" : "AM",
        n = (n %= 12) || 12,
        t = (t = t[1]) < 10 ? "0" + t : t;
    return month = "" + ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][e.getMonth()],
    day = "" + e.getDate(),
    year = e.getFullYear(),
    month.length < 2 && (month = "0" + month),
    [(day = day.length < 2 ? "0" + day : day) + " " + month + "," + year + " <small class='text-muted'>" + n + ":" + t + " " + a + "</small>"]
};

var isChoiceEl = document.getElementById("idStatus"),
    choices = new Choices(isChoiceEl, { searchEnabled: !1 });

var isPaymentEl = document.getElementById("idPayment"),
    choices = new Choices(isPaymentEl, { searchEnabled: !1 });

var checkAll = document.getElementById("checkAll"),
    perPage = 8;

if (checkAll) {
    checkAll.onclick = function() {
        for (var e = document.querySelectorAll('.form-check-all input[type="checkbox"]'), t = document.querySelectorAll('.form-check-all input[type="checkbox"]:checked').length, a = 0; a < e.length; a++)
            e[a].checked = this.checked,
            e[a].checked ? e[a].closest("tr").classList.add("table-active") : e[a].closest("tr").classList.remove("table-active");
        document.getElementById("remove-actions").style.display = 0 < t ? "none" : "block";
    };
}

var options = {
    valueNames: ["id", "customer_name", "product_name", "date", "amount", "payment", "status"],
    page: perPage,
    pagination: !0,
    plugins: [ListPagination({ left: 2, right: 2 })]
};

var orderList = new List("orderList", options).on("updated", function(e) {
    
    0 == e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "block" : document.getElementsByClassName("noresult")[0].style.display = "none";
    var t = 1 == e.i,
        a = e.i > e.matchingItems.length - e.page;
    document.querySelector(".pagination-prev.disabled") && document.querySelector(".pagination-prev.disabled").classList.remove("disabled"),
    document.querySelector(".pagination-next.disabled") && document.querySelector(".pagination-next.disabled").classList.remove("disabled"),
    t && document.querySelector(".pagination-prev").classList.add("disabled"),
    a && document.querySelector(".pagination-next").classList.add("disabled"),
    e.matchingItems.length <= perPage ? document.querySelector(".pagination-wrap").style.display = "none" : document.querySelector(".pagination-wrap").style.display = "flex",
    e.matchingItems.length == perPage && document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click(),
    0 < e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "none" : document.getElementsByClassName("noresult")[0].style.display = "block";
});

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
    var data = JSON.parse(this.responseText);
    Array.from(data).forEach(function(item) {
        var truncatedProductName = item.product_name.length > 20 ? item.product_name.substring(0, 20) + "..." : item.product_name;
        orderList.add({
            id: '<a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">' + item.id + "</a>",
            customer_name: item.customer_name,
            product_name: truncatedProductName,
            date: str_dt(item.date),
            amount: item.amount,
            payment: item.payment,
            status: isStatus(item.status)
        });
        orderList.sort("id", { order: "desc" });
    });
    refreshCallbacks();
    orderList.remove("id", '<a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2101</a>')
};
xhttp.open("GET", "admin/orders/data");
xhttp.send();

function isStatus(e) {
    switch (e) {
        case "completed":
            return '<span class="badge bg-success-subtle text-success text-uppercase">Completed</span>';
        case "cancelled":
            return '<span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>';
        case "confirmed":
            return '<span class="badge bg-info-subtle text-info text-uppercase">Confirmed</span>';
        case "pending":
            return '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
        default:
            return '<span class="badge bg-light text-dark text-uppercase">' + e + '</span>';
    }
}

    
var idField = document.getElementById("orderId"),
    statusField = document.getElementById("status"),
    editBtns = document.getElementsByClassName("edit-item-btn"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    tabEl = document.querySelectorAll('a[data-bs-toggle="tab"]');

function filterOrder(e) {
    var t = e;
    orderList.filter(function(e) {
        e = (matchData = (new DOMParser).parseFromString(e.values().status, "text/html")).body.firstElementChild.innerHTML;
        return "All" == e || "All" == t || e == t;
    });
    orderList.update();
    refreshCallbacks();
}

Array.from(tabEl).forEach(function(e) {
    e.addEventListener("shown.bs.tab", function(e) {
        filterOrder(e.target.id);
    });
});

document.getElementById("showModal").addEventListener("show.bs.modal", function(e) {
    if (e.relatedTarget.classList.contains("edit-item-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = "Edit Order Status";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = "Update";
    }
});

document.getElementById("showModal").addEventListener("hidden.bs.modal", function() {
    clearFields();
});

var forms = document.querySelectorAll(".tablelist-form");
Array.prototype.slice.call(forms).forEach(function(form) {
    form.addEventListener("submit", function(e) {
      e.preventDefault();
  
      // Gán lại ID mỗi lần submit để đảm bảo tồn tại
      var idField = document.getElementById("orderId"),
      statusField = document.getElementById("status");
  
  console.log("📌 idField:", idField);
  console.log("📌 idField.value:", idField?.value);
  console.log("📌 statusField.value:", statusField?.value);
  
  var orderId = idField?.value.trim();
  var newStatus = statusField?.value;
  
  if (!idField || !statusField) {
    console.error("idField or statusField is missing!");
    Swal.fire({
        position: "center",
        icon: "error",
        title: "Form fields are missing!",
        showConfirmButton: false,
        timer: 2000,
        showCloseButton: true
    });
    return;
}
  
  console.log("🔗 GỬI PUT TỚI: /admin/orders/" + orderId);
  console.log('orderId:', idField.value);
console.log('status:', statusField.value);

fetch('/admin/orders/' + idField.value, {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    status: statusField.value
  })
})
.then(response => {
  console.log('Response Status:', response.status);
  console.log('Response Headers:', response.headers);
  if (!response.ok) {
    throw new Error('Request failed with status ' + response.status);
  }
  return response.json();
})
.then(data => {
    console.log('Response Data:', data);
    const newStatusHtml = isStatus(statusField.value);
    // Tìm và cập nhật item trong orderList
    orderList.items.forEach(item => {
        const parsedId = (new DOMParser).parseFromString(item.values().id, "text/html").body.firstElementChild.innerHTML;
        if (parsedId === idField.value) {
            item.values({
                ...item.values(),
                status: newStatusHtml
            });
               // Cập nhật DOM
               const row = document.querySelector(`tr[data-id="${parsedId}"]`);
               if (row) {
                   const statusCell = row.querySelector('td:nth-child(8)');
                   if (statusCell) {
                       statusCell.innerHTML = newStatusHtml;
                   }
               }
        }
    });
    orderList.update();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Order status updated!",
        showConfirmButton: false,
        timer: 2000,
        showCloseButton: true
    });
    // Ẩn modal
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
    bootstrap.Modal.getInstance(document.getElementById("showModal")).hide();
})
.catch(error => {
  console.error('Error:', error);
});

  
    });
  });
  
  

var statusVal = new Choices(statusField);

function clearFields() {
    idField.value = "";
    statusField.value = "";
    if (statusVal) statusVal.destroy();
    statusVal = new Choices(statusField);
}

function refreshCallbacks() {
    const orderTable = document.getElementById("orderList");
    if (orderTable) {
        orderTable.addEventListener("click", function(e) {
            const removeBtn = e.target.closest(".remove-item-btn");
            if (removeBtn) {
                const row = removeBtn.closest("tr");
                if (!row) {
                    console.error("Row not found for remove button!");
                    return;
                }
                const idTd = row.querySelector("td.id");
                if (!idTd) {
                    console.error("ID column not found in row:", row);
                    return;
                }
                let orderId = idTd.innerText.trim();
                console.log("orderId:", orderId);
                document.getElementById("delete-record").onclick = function() {
                    fetch(`/admin/orders/${orderId}`, {
                        method: "DELETE",
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then((response) => {
                        if (response.ok) {
                            orderList.remove("id", `<a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">${orderId}</a>`);
                            document.getElementById("deleteRecord-close").click();
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Order deleted successfully!",
                                showConfirmButton: false,
                                timer: 2000,
                                showCloseButton: true
                            });
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Failed to delete order!",
                                showConfirmButton: false,
                                timer: 2000,
                                showCloseButton: true
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Error connecting to server!",
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    });
                };
            }

            const editBtn = e.target.closest(".edit-item-btn");
            if (editBtn) {
                const row = editBtn.closest("tr");
                const itemId = row.querySelector("td.id").innerText.trim();
                const item = orderList.get({
                    id: '<a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">' + itemId + "</a>"
                });
                Array.from(item).forEach(function(e) {
                    const isid = (new DOMParser).parseFromString(e._values.id, "text/html").body.firstElementChild.innerHTML;
                    if (isid == itemId) {
                        idField.value = itemId;
                        const status = (new DOMParser).parseFromString(e._values.status, "text/html").body.firstElementChild.innerHTML;
                        if (statusVal) statusVal.destroy();
                        statusVal = new Choices(statusField, { searchEnabled: false });
                        statusVal.setChoiceByValue(status);
                    }
                });
            }

            const viewLink = e.target.closest('a[title="View"]');
            if (viewLink) {
                e.preventDefault();
                const row = viewLink.closest("tr");
                if (!row) {
                    console.error("Row not found for view link!");
                    return;
                }
                const idTd = row.querySelector("td.id");
                if (!idTd) {
                    console.error("ID column not found in row:", row);
                    return;
                }
                let orderId;
                const idElement = idTd.querySelector("a");
                if (idElement) {
                    orderId = idElement.innerHTML;
                } else {
                    orderId = idTd.innerText.trim();
                }
                console.log("Navigating to order details for ID:", orderId);
                window.location.href = `/admin/orders/${orderId}`;
            }
        });
    }
}
// console.log("Edit button clicked, itemId:", itemId);
// console.log("Found item:", item);

function ischeckboxcheck() {
    Array.from(document.getElementsByName("checkAll")).forEach(function(a) {
        a.addEventListener("change", function(e) {
            a.checked ? e.target.closest("tr").classList.add("table-active") : e.target.closest("tr").classList.remove("table-active");
            var t = document.querySelectorAll('[name="checkAll"]:checked').length;
            document.getElementById("remove-actions").style.display = 0 < t ? "block" : "none";
        });
    });
}

function deleteMultiple() {
    var ids_array = [];
    var checkboxes = document.querySelectorAll(".form-check [value=option1]");
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            var id = checkboxes[i].parentNode.parentNode.parentNode.querySelector("td a").innerHTML;
            ids_array.push(id);
        }
    }
    if (ids_array.length > 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            customClass: {
                confirmButton: "btn btn-primary w-xs me-2 mt-2",
                cancelButton: "btn btn-danger w-xs mt-2"
            },
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function(e) {
            if (e.value) {
                for (var i = 0; i < ids_array.length; i++) {
                    orderList.remove("id", '<a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">' + ids_array[i] + "</a>");
                }
                document.getElementById("remove-actions").style.display = "none";
                document.getElementById("checkAll").checked = !1;
                Swal.fire({
                    title: "Deleted!",
                    text: "Your data has been deleted.",
                    icon: "success",
                    customClass: {
                        confirmButton: "btn btn-info w-xs mt-2"
                    },
                    buttonsStyling: !1
                });
    }
});
} else {
    Swal.fire({
        title: "Please select at least one checkbox",
        customClass: {
            confirmButton: "btn btn-info"
        },
        buttonsStyling: !1,
        showCloseButton: !0
    });
}
}

document.querySelector(".pagination-next").addEventListener("click", function() {
    var pagination = document.querySelector(".pagination.listjs-pagination");
    if (pagination && pagination.querySelector(".active")) {
        pagination.querySelector(".active").nextElementSibling.children[0].click();
    }
});

document.querySelector(".pagination-prev").addEventListener("click", function() {
    var pagination = document.querySelector(".pagination.listjs-pagination");
    if (pagination && pagination.querySelector(".active")) {
        pagination.querySelector(".active").previousSibling.children[0].click();
    }
});