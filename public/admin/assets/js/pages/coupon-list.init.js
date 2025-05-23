document.addEventListener("DOMContentLoaded", function () {
    // DOM elements with null checks
    const modalTitle = document.querySelector('.modal-title');
    const form = document.getElementById('coupon-form');
    const addBtn = document.getElementById('add-btn');
    const editBtn = document.getElementById('edit-btn');
    const idField = document.getElementById('id-field');
    const deleteBtn = document.getElementById('delete-btn');
    const discountTypeField = document.getElementById('discount_type-field');
    const discountSymbol = document.getElementById('discount-symbol');

   

    // Get store URL from Add Coupon button
    const addCouponBtn = document.querySelector('.add-coupon-btn');
    const storeUrl = addCouponBtn ? addCouponBtn.getAttribute('data-store-url') : '';

    // URLs for CRUD operations
    const editUrlTemplate = "/admin/coupons/{id}";
    const deleteUrlTemplate = "/admin/coupons/{id}";

    // Helper function to format date for input
    const formatDateTimeLocal = (dateStr) => {
        try {
            const date = new Date(dateStr);
            if (isNaN(date)) throw new Error('Invalid date');
            const pad = (n) => n.toString().padStart(2, '0');
            return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
        } catch (error) {
            console.error('Date formatting error:', error);
            return '';
        }
    };

    // Helper function to reset form and modal
    const resetForm = (title, action, showAddBtn = true) => {
        modalTitle.textContent = title;
        form.reset();
        idField.value = '';
        discountSymbol.textContent = '%';
        form.action = action;
        addBtn.style.display = showAddBtn ? 'block' : 'none';
        editBtn.style.display = showAddBtn ? 'none' : 'inline-block';
        deleteBtn.style.display = showAddBtn ? 'none' : 'inline-block';
        removeMethodInput();
    };

    // Handle Add button
    // Handle Add button
document.querySelectorAll('.add-coupon-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Reset form and set title
        modalTitle.textContent = 'Add Coupon';
        form.reset();

        // Clear the id field
        idField.value = '';

        // Set default symbol for discount type
        document.getElementById('discount-symbol').textContent = '%';
        
        // Reset form action
        form.action = storeUrl;

        // Show Add button, hide Edit button
        addBtn.style.display = 'block';
        editBtn.style.display = 'none';

        removeMethodInput();
    });
});

    // Handle discount type change
    discountTypeField.addEventListener('change', function () {
        discountSymbol.textContent = this.value === 'percentage' ? '%' : '';
    });

    // Handle Edit button
    document.querySelectorAll('.edit-item-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const row = btn.closest('tr');
            if (!row) {
                console.error('Row not found for edit button');
                return;
            }

            resetForm('Edit Coupon', editUrlTemplate.replace('{id}', id), false);
            idField.value = id;

            // Populate form fields
            document.getElementById('code-field').value = row.querySelector('.code')?.textContent.trim() || '';
            const discountType = row.querySelector('.discount_type')?.textContent.trim() || 'percentage';
            discountTypeField.value = discountType;
            discountSymbol.textContent = discountType === 'percentage' ? '%' : '';

            const discountText = row.querySelector('.discount_value')?.textContent.trim() || '0';
            const discountValue = parseFloat(discountText.replace('%', '')) || 0;
            document.getElementById('discount_value-field').value = discountValue;

            document.getElementById('usage_limit-field').value = row.querySelector('.usage_limit')?.textContent.trim() || '';
            document.getElementById('used_count-field').value = row.querySelector('.used_count')?.textContent.trim() || '';
            document.getElementById('status-field').value = row.querySelector('.status')?.textContent.trim() || '';

            // Parse coupon data
            try {
                const coupon = JSON.parse(btn.getAttribute('data-coupon') || '{}');
                document.getElementById('start_date-field').value = coupon.start_date ? formatDateTimeLocal(coupon.start_date) : '';
                document.getElementById('end_date-field').value = coupon.end_date ? formatDateTimeLocal(coupon.end_date) : '';
            } catch (error) {
                console.error('Error parsing coupon data:', error);
            }

            // Add PATCH method input
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            methodInput.id = 'method-field';
            form.appendChild(methodInput);
        });
    });

    // Handle Delete button
  // Handle Delete button
document.querySelectorAll('.remove-item-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const deleteUrl = deleteUrlTemplate.replace('{id}', id);

        if (confirm("Are you sure you want to delete this coupon?")) {
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
                        alert('Coupon deleted successfully');
                        btn.closest('tr').remove();
                    } else {
                        alert('Error deleting coupon');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});

    // Helper function to remove method input
    function removeMethodInput() {
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
    }
});