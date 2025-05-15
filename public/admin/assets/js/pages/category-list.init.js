document.addEventListener("DOMContentLoaded", function () {
    const modalTitle = document.querySelector('.modal-title');
    const form = document.getElementById('category-form');
    const addBtn = document.getElementById('add-btn');
    const editBtn = document.getElementById('edit-btn');
    const idField = document.getElementById('id-field');
    const nameField = document.getElementById('category-name-field');
    const deleteBtn = document.getElementById('delete-btn');  // Nút Xóa

    // Lấy storeUrl từ button Add Category
    const addCategoryBtn = document.querySelector('.add-category-btn');
    const storeUrl = addCategoryBtn ? addCategoryBtn.getAttribute('data-store-url') : '';

    // URL cho Edit (Cần thay {id} khi sửa)
    const editUrlTemplate = "/categories/{id}";
    const deleteUrlTemplate = "/categories/{id}";  // URL cho xóa

    // Xử lý nút Add
    document.querySelectorAll('.add-category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            modalTitle.textContent = 'Add Category';
            form.reset();  // Reset form khi mở modal
            form.action = storeUrl;  // Gán URL store khi bấm Add

            // Ẩn nút Edit, hiển thị nút Add
            addBtn.style.display = 'inline-block';
            editBtn.style.display = 'none';
            deleteBtn.style.display = 'none';  // Ẩn nút Xóa khi bấm Add

            // Xóa method _method nếu có
            removeMethodInput();
        });
    });

    // Xử lý nút Edit
    document.querySelectorAll('.edit-item-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const row = btn.closest('tr');
            const name = row.querySelector('.category_name').textContent.trim();

            modalTitle.textContent = 'Edit Category';
            nameField.value = name;
            idField.value = id;

            // Cập nhật form.action và phương thức PATCH
            form.action = editUrlTemplate.replace('{id}', id);  // Cập nhật URL cho Edit
            removeMethodInput();

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            form.appendChild(methodInput);

            // Ẩn nút Add, hiển thị nút Edit
            addBtn.style.display = 'none';
            editBtn.style.display = 'inline-block';
            deleteBtn.style.display = 'inline-block';  // Hiển thị nút Xóa khi bấm Edit
        });
    });

    // Xử lý nút Xóa
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const deleteUrl = deleteUrlTemplate.replace('{id}', id); // Cập nhật URL cho xóa

            // Hiển thị một modal xác nhận hoặc hỏi người dùng có chắc chắn xóa không
            if (confirm("Are you sure you want to delete this category?")) {
                // Gửi yêu cầu xóa với phương thức DELETE
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Category deleted successfully');
                        // Xóa dòng tương ứng trong bảng
                        btn.closest('tr').remove();
                    } else {
                        alert('Error deleting category');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    // Hàm xóa _method khi không cần thiết
    function removeMethodInput() {
        const methodInput = document.getElementById('method-field');
        if (methodInput) methodInput.remove();
    }
});
