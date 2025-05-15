/**
 * Shopping Cart Module
 * Handles product selection, quantity updates, voucher application, and price calculations
 */
const ShoppingCart = (() => {
    // Configuration
    const CONFIG = {
       currencySign: '$',
    discountRate: 0,
    discountAmount: 0, // Thêm để lưu số tiền giảm giá cố định
    discountType: 'percentage', // Mặc định là percentage
    shippingRate: 0,
        selectors: {
            productList: '.product-list',
            product: '.product',
            selectAll: '#select-all',
            deselectAll: '#deselect-all',
            quantity: '.product-quantity',
            price: '.product-price',
            linePrice: '.product-line-price',
            subtotal: '.cart-subtotal',
            shipping: '.cart-shipping',
            total: '.cart-total',
            discount: '.cart-discount',
            cartItemBadge: '.cartitem-badge',
            productCount: '.product-count',
            removeModal: '#removeItemModal',
            removeButton: '#remove-product',        
            closeModal: '#close-modal',
            checkoutButton: '#checkout-button',
            removeVoucherBtn: '#remove-voucher',
            clearCartBtn: '#clear-cart'
            
        },
        messages: {
            emptyVoucher: 'Vui lòng nhập mã voucher',
            noSelectedProducts: 'Vui lòng chọn ít nhất một sản phẩm để áp dụng voucher',
            voucherApplied: 'Áp dụng voucher thành công',
            voucherRemoved: 'Đã xóa voucher',
            voucherError: 'Đã xảy ra lỗi khi áp dụng voucher',
            cartCleared: 'Đã xóa giỏ hàng',
            noVoucher: 'Chưa áp dụng voucher'
            
        }
    };

    // Cache for DOM elements
    let domCache = {};
    let csrfToken = '';
    let currentVoucher = null;

    /**
     * Initialize the shopping cart
     */
    const init = () => {
        // Cache DOM elements
        domCache.productLists = document.querySelectorAll(CONFIG.selectors.productList);
        domCache.selectAllBtn = document.querySelector(CONFIG.selectors.selectAll);
        domCache.deselectAllBtn = document.querySelector(CONFIG.selectors.deselectAll);
        domCache.removeModal = document.querySelector(CONFIG.selectors.removeModal);
        domCache.clearCartBtn = document.querySelector(CONFIG.selectors.clearCartBtn);
        domCache.voucherMessage = document.getElementById('voucher-message');
        domCache.voucherName = document.getElementById('voucher-name');
        domCache.voucherCodeInput = document.getElementById('voucher-code');
        domCache.applyVoucherBtn = document.getElementById('apply-voucher');
        domCache.removeVoucherBtn = document.querySelector(CONFIG.selectors.removeVoucherBtn);
        domCache.checkoutBtn = document.querySelector(CONFIG.selectors.checkoutButton);
        domCache.checkoutForm = document.getElementById('checkout-form'); // <<<--- THÊM DÒNG NÀY
        // Get CSRF token
        csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Initialize event listeners
        initEventListeners();
        
        // Initial cart calculation
        updateAllCartCalculations();
        
        // Initially hide remove voucher button if no voucher is applied
        updateRemoveVoucherButtonVisibility();
    };

    /**
     * Set up all event listeners
     */
    /**
     * *** HÀM MỚI HOÀN TOÀN: Xử lý trước khi submit form checkout ***
     * Vô hiệu hóa input của các sản phẩm không được chọn.
     */
    const handleCheckoutSubmit = (event) => {
        // Lấy tất cả các card sản phẩm trong form
        const productCards = domCache.checkoutForm.querySelectorAll(`${CONFIG.selectors.product}.selectable`);
        let selectedCount = 0; // Biến đếm số sản phẩm được chọn

        productCards.forEach(card => {
            // Tìm input ẩn 'selected_items[]' bên trong card này
            const input = card.querySelector('input.selected-item-input[name="selected_items[]"]');
            
            if (input) {
                // Kiểm tra xem card có class 'selected' hay không
                if (card.classList.contains('selected')) {
                    // Nếu ĐƯỢC CHỌN: Đảm bảo input này được kích hoạt (không bị disabled)
                    input.disabled = false;
                    selectedCount++; // Tăng số lượng đã chọn
                } else {
                    // Nếu KHÔNG ĐƯỢC CHỌN: Vô hiệu hóa input này đi
                    input.disabled = true; // Input bị disabled sẽ không được gửi đi khi submit form
                }
            }
        });

        // Kiểm tra lại lần cuối xem có sản phẩm nào được chọn không
        if (selectedCount === 0) {
            event.preventDefault(); // Ngăn không cho form submit
            alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');

            // Rất quan trọng: Phải kích hoạt lại các input đã bị disable,
            // phòng trường hợp người dùng không submit nữa mà quay lại chọn tiếp.
             productCards.forEach(card => {
                const input = card.querySelector('input.selected-item-input[name="selected_items[]"]');
                if (input) {
                    input.disabled = false; 
                }
            });

            return false; // Dừng thực thi
        }

        // Nếu có ít nhất 1 sản phẩm được chọn (selectedCount > 0),
        // form sẽ tiếp tục quá trình submit bình thường.
        console.log('Form is submitting with selected items...'); // (Tùy chọn) log để kiểm tra
    }; // <<<--- KẾT THÚC HÀM MỚI
    const initEventListeners = () => {
        console.log("Attaching event listeners..."); // <<<--- Thêm log này
        // Select/Deselect all products
        domCache.selectAllBtn?.addEventListener('click', () => toggleSelectAll(true));
        domCache.deselectAllBtn?.addEventListener('click', () => toggleSelectAll(false));
        domCache.checkoutForm?.addEventListener('submit', handleCheckoutSubmit); // <<<--- THÊM DÒNG NÀY
        // Product selection and quantity adjustments
        domCache.productLists.forEach(list => {
            list.addEventListener('click', handleProductListClick);
        });

        // Remove product modal
        domCache.removeModal?.addEventListener('show.bs.modal', handleRemoveModalShow);
        domCache.clearCartBtn?.addEventListener('click', clearCart);
        // Apply voucher
        domCache.applyVoucherBtn?.addEventListener('click', handleVoucherApply);
        
        // Remove voucher
        domCache.removeVoucherBtn?.addEventListener('click', handleRemoveVoucher);
    };

    /**
     * Handle clicks on the product list
     */
    const handleProductListClick = (e) => {
        console.log("handleProductListClick triggered"); // <<<--- Thêm log này
        const target = e.target;
        console.log('Clicked element:', target); // Xem phần tử nào được click
        const product = target.closest(CONFIG.selectors.product);
        if (!product) return;

        // Handle product selection (excluding clicks on quantity controls)
        if (!target.matches('.plus, .minus, .product-quantity')) {
            product.classList.toggle('selected');
            setTimeout(checkAllProductsSelected, 0);
            recalculateCart(product.closest(CONFIG.selectors.productList));
            return;
        }

        // Handle quantity adjustments
        const quantityInput = product.querySelector(CONFIG.selectors.quantity);
        if (!quantityInput) return;

        const currentQty = parseInt(quantityInput.value) || 1;
        console.log('Current Quantity:', currentQty); // Xem số lượng hiện tại
        const maxQty = parseInt(quantityInput.getAttribute('max')) || Infinity;
        const minQty = parseInt(quantityInput.getAttribute('min')) || 1;

        if (target.matches('.plus') && currentQty < maxQty) {
            quantityInput.value = currentQty + 1;
            updateQuantity(quantityInput);
        } else if (target.matches('.minus') && currentQty > minQty) {
            quantityInput.value = currentQty - 1;
            updateQuantity(quantityInput);
        }
    };

    /**
     * Handle voucher application
     */
    const handleVoucherApply = () => {
        const voucherCode = domCache.voucherCodeInput.value;
        if (!voucherCode) {
            showVoucherMessage(CONFIG.messages.emptyVoucher, false);
            return;
        }

        applyVoucher(voucherCode);
    };
    
    /**
     * Handle voucher removal
     */
    const handleRemoveVoucher = () => {
        if (!currentVoucher) return;
        
        removeVoucher();
    };

    /**
     * Handle remove modal show event
     */
    const handleRemoveModalShow = (e) => {
        document.querySelector(CONFIG.selectors.removeButton).addEventListener('click', () => {
            const product = e.relatedTarget.closest(CONFIG.selectors.product);
            const list = product.closest(CONFIG.selectors.productList);
            const productId = product.dataset.id;
            
            removeProduct(productId);
            product.remove();
            updateCartItemCount();
            
            list.querySelectorAll(CONFIG.selectors.productCount)
                .forEach(elem => elem.textContent = list.querySelectorAll(CONFIG.selectors.product).length);
            
            recalculateCart(list);
            document.querySelector(CONFIG.selectors.closeModal)?.click();
        }, { once: true });
    };

    /**
     * Toggle selection of all products
     */
    const toggleSelectAll = (isSelectAll) => {
        domCache.productLists.forEach(list => {
            list.querySelectorAll(CONFIG.selectors.product).forEach(product => {
                product.classList.toggle('selected', isSelectAll);
            });
            recalculateCart(list);
        });
        
        domCache.selectAllBtn.style.display = isSelectAll ? 'none' : 'inline';
        domCache.deselectAllBtn.style.display = isSelectAll ? 'inline' : 'none';
    };

    /**
     * Check if all products are selected and update buttons accordingly
     */
    const checkAllProductsSelected = () => {
        const allSelected = Array.from(document.querySelectorAll(CONFIG.selectors.product))
            .every(product => product.classList.contains('selected'));
            
        domCache.selectAllBtn.style.display = allSelected ? 'none' : 'inline';
        domCache.deselectAllBtn.style.display = allSelected ? 'inline' : 'none';
    };

    /**
     * Recalculate cart totals
     */
    const recalculateCart = (list) => {
        try {
            const cartData = calculateCartTotals(list);
            updateCartDisplay(list, cartData);
            updateCheckoutButton(cartData.total);
        } catch (error) {
            console.error('Error recalculating cart:', error);
        }
    };

    /**
     * Calculate cart totals based on selected products
     */
    const calculateCartTotals = (list) => {
        let subtotal = 0;
        let hasSelectedProduct = false;
    
        // Calculate subtotal from selected products
        list.querySelectorAll(`${CONFIG.selectors.product}.selected`).forEach(item => {
            const linePrice = parseFloat(item.querySelector(CONFIG.selectors.linePrice)?.textContent || 0);
            subtotal += linePrice;
            hasSelectedProduct = true;
        });
    
        // Calculate discount based on discount_type
        let discount = 0;
        if (CONFIG.discountType === 'percentage') {
            discount = subtotal * (CONFIG.discountRate || 0);
        } else if (CONFIG.discountType === 'fixed') {
            discount = CONFIG.discountAmount || 0;
            // Đảm bảo discount không vượt quá subtotal
            discount = Math.min(discount, subtotal);
        }
    
        // Calculate other values
        const shipping = subtotal > 0 ? CONFIG.shippingRate : 0;
        const total = subtotal + shipping - discount;
    
        return {
            subtotal,
            discount,
            shipping,
            total,
            hasSelectedProduct
        };
    };

    /**
     * Update cart display with calculated values
     */
    const updateCartDisplay = (list, cartData) => {
        const { subtotal, discount, shipping, total } = cartData;
        
        list.querySelector(CONFIG.selectors.subtotal).textContent = `${CONFIG.currencySign}${subtotal.toFixed(2)}`;
        list.querySelector(CONFIG.selectors.shipping).textContent = `${CONFIG.currencySign}${shipping.toFixed(2)}`;
        list.querySelector(CONFIG.selectors.total).textContent = `${CONFIG.currencySign}${total.toFixed(2)}`;
        list.querySelector(CONFIG.selectors.discount).textContent = discount > 0 
            ? `-${CONFIG.currencySign}${discount.toFixed(2)}` 
            : `${CONFIG.currencySign}0.00`;
    };

    /**
     * Update checkout button state
     */
    const updateCheckoutButton = (total) => {
        const checkoutButton = document.querySelector(CONFIG.selectors.checkoutButton);
        if (!checkoutButton) return;
        
        if (total > 0) {
            checkoutButton.disabled = false;
            checkoutButton.classList.remove('disabled');
        } else {
            checkoutButton.disabled = true;
            checkoutButton.classList.add('disabled');
        }
    };
    
    /**
     * Update remove voucher button visibility
     */
    const updateRemoveVoucherButtonVisibility = () => {
        if (!domCache.removeVoucherBtn) return;
        
        domCache.removeVoucherBtn.style.display = currentVoucher ? 'inline-block' : 'none';
    };

    /**
     * Update quantity for a product
     */
    const updateQuantity = (input) => {
        try {
            const product = input.closest(CONFIG.selectors.product);
            const productId = product.dataset.id;
            const price = parseFloat(product.dataset.price || 0);
            const quantity = parseInt(input.value) || 1;
            const linePrice = price * quantity;
            console.log(`Updating Product ID: ${productId}, Quantity: ${quantity}, Price: ${price}, Line Price: ${linePrice}`);
    
            const linePriceElement = product.querySelector(CONFIG.selectors.linePrice);
            if (linePriceElement) {
                 linePriceElement.textContent = linePrice.toFixed(2);
            } else {
                console.warn('Line price element NOT FOUND for product:', productId);
            }
    
            recalculateCart(product.closest(CONFIG.selectors.productList)); 
            updateQuantityViaApi(productId, quantity); 
        } catch (error) {
            console.error('Error in updateQuantity:', error);
        }
    };

    /**
     * Update quantity via API
     */
    const updateQuantityViaApi = (productId, quantity) => {
        const cartData = { product_id: productId, quantity: quantity };

        fetch(`/cart/update/${productId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(cartData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Quantity updated:', data);
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    };

    /**
     * Update cart item count
     */
    const updateCartItemCount = () => {
        const count = document.querySelectorAll('.cartlist li').length;
        document.querySelectorAll(CONFIG.selectors.cartItemBadge)
            .forEach(badge => badge.textContent = count);
    };

    /**
     * Remove product from cart
     */
    const removeProduct = (productId) => {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Product removed:', data);
            updateAllCartCalculations();
            // Hiển thị thông báo thành công
            Toastify({
                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#4CAF50"
                }
            }).showToast();
        })  
        .catch(error => {
            console.error('Error removing product:', error);
        });
    };

    /**
 * Clear entire cart
 */
    const clearCart = () => {
        const isConfirmed = window.confirm('Bạn chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?');
    
        if (isConfirmed) {
            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(CONFIG.messages.cartCleared, data);
    
                // Xóa sản phẩm khỏi DOM
                domCache.productLists.forEach(list => {
                    list.querySelectorAll(CONFIG.selectors.product).forEach(product => {
                        product.remove();
                    });
    
                    // Reset số lượng sản phẩm hiển thị
                    list.querySelectorAll(CONFIG.selectors.productCount)
                        .forEach(elem => elem.textContent = 0);
    
                    // Reset hiển thị giá
                    updateCartDisplay(list, {
                        subtotal: 0,
                        discount: 0,
                        shipping: 0,
                        total: 0
                    });
                });
    
                updateCartItemCount();
                updateCheckoutButton(0);
    
                // Chỉ gọi removeVoucher nếu có voucher đang được áp dụng
                if (currentVoucher) {
                    removeVoucher();
                } else {
                    // Cập nhật giao diện để đảm bảo hiển thị không có voucher
                    domCache.voucherName.textContent = CONFIG.messages.noVoucher;
                    domCache.voucherCodeInput.value = '';
                    updateRemoveVoucherButtonVisibility();
                    updateAllCartCalculations();
                }
                const cartMessage = document.querySelector('#cartCleared');
            if (cartMessage) {
                cartMessage.textContent = CONFIG.messages.cartCleared;
                cartMessage.classList.add('text-danger'); // Tùy chỉnh kiểu dáng nếu cần
            }
            })
            .catch(error => {
                console.error('Error clearing cart:', error);
            });
        }
    };

    /**
     * Apply voucher to selected products
     */
    const applyVoucher = (voucherCode) => {
        // Get selected product IDs
        const selectedItems = Array.from(document.querySelectorAll('.card.product.selectable.selected'))
            .map(card => parseInt(card.dataset.id));
        
        if (selectedItems.length === 0) {
            showVoucherMessage(CONFIG.messages.noSelectedProducts, false);
            return;
        }

        const data = {
            voucher_code: voucherCode.trim(),
            selected_items: selectedItems,
        };

        fetch('/voucher/apply', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Unknown error');
                });
            }
            return response.json();
        })
        .then(data => {
            handleVoucherSuccess(data);
        })
        .catch(error => {
            handleVoucherError(error);
        });
    };
    
    /**
     * Remove voucher
     */
    const removeVoucher = () => {
        if (!currentVoucher) {
            domCache.voucherName.textContent = CONFIG.messages.noVoucher;
            domCache.voucherCodeInput.value = '';
            updateRemoveVoucherButtonVisibility();
            updateAllCartCalculations();
            return;
        }
    
        fetch('/voucher/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ voucher_code: currentVoucher })
        })
        .then(response => response.json())
        .then(data => {
            // Reset discount values
            CONFIG.discountRate = 0;
            CONFIG.discountAmount = 0;
            CONFIG.discountType = 'percentage'; // Đặt lại mặc định
            
            // Clear current voucher
            currentVoucher = null;
            
            // Update display
            domCache.voucherName.textContent = CONFIG.messages.noVoucher;
            domCache.voucherCodeInput.value = '';
            showVoucherMessage(CONFIG.messages.voucherRemoved, true);
            
            // Update button visibility
            updateRemoveVoucherButtonVisibility();
            
            // Recalculate cart
            updateAllCartCalculations();
        })
        .catch(error => {
            console.error('Error removing voucher:', error);
            showVoucherMessage(error.message || 'Error removing voucher', false);
        });
    };

    /**
     * Handle successful voucher application
     */
    const handleVoucherSuccess = (data) => {
        showVoucherMessage(data.message || CONFIG.messages.voucherApplied, true);
    
        // Lấy thông tin từ API response
        const discount = parseFloat(data.discount) || 0;
        const cartTotal = parseFloat(data.cart_total) || 0;
        const discountType = data.discount_type || 'percentage'; // Mặc định là percentage nếu không có discount_type
    
        // Lưu discount type
        CONFIG.discountType = discountType;
    
        if (discountType === 'percentage') {
            // Tính tỷ lệ giảm giá cho percentage
            CONFIG.discountRate = discount > 0 && cartTotal > 0 ? discount / cartTotal : 0;
            CONFIG.discountAmount = 0; // Không cần lưu discountAmount cho percentage
        } else if (discountType === 'fixed') {
            // Lưu số tiền giảm giá cố định
            CONFIG.discountAmount = discount;
            CONFIG.discountRate = 0; // Không cần tỷ lệ cho fixed
        }
    
        // Store current voucher code
        currentVoucher = data.voucher_code || null;
    
        // Update voucher name and display
        if (data.voucher_code && discount > 0) {
            if (discountType === 'percentage') {
                domCache.voucherName.textContent = `${data.voucher_code} (${(CONFIG.discountRate * 100).toFixed(0)}% off)`;
            } else {
                domCache.voucherName.textContent = `${data.voucher_code} (${CONFIG.currencySign}${discount.toFixed(2)} off)`;
            }
        } else {
            domCache.voucherName.textContent = CONFIG.messages.noVoucher;
        }
    
        // Update remove voucher button visibility
        updateRemoveVoucherButtonVisibility();
    
        // Recalculate cart
        updateAllCartCalculations();
    };

    /**
     * Handle voucher application error
     */
    const handleVoucherError = (error) => {
        showVoucherMessage(error.message || CONFIG.messages.voucherError, false);
        // Reset tất cả các giá trị discount
     CONFIG.discountRate = 0;
    CONFIG.discountAmount = 0;
    CONFIG.discountType = 'percentage';
    
    // Reset voucher hiện tại
    currentVoucher = null;
    
    // Cập nhật giao diện
    domCache.voucherName.textContent = CONFIG.messages.noVoucher;
    updateRemoveVoucherButtonVisibility();
    updateAllCartCalculations();
    
    // Clear input field
    // if (domCache.voucherCodeInput) {
    //     domCache.voucherCodeInput.value = '';
    // }
    };

    /**
     * Show voucher application message
     */
    const showVoucherMessage = (message, isSuccess) => {
        domCache.voucherMessage.textContent = message;
        domCache.voucherMessage.classList.toggle('text-success', isSuccess);
        domCache.voucherMessage.classList.toggle('text-danger', !isSuccess);
    };

    /**
     * Update all cart calculations
     */
    const updateAllCartCalculations = () => {
        domCache.productLists.forEach(list => {
            recalculateCart(list);
        });
    };

    // Public API
    return {
        init,
        updateQuantity,
        removeProduct,
        clearCart,
        applyVoucher,
        removeVoucher,
        recalculateCart
    };
})();

// Initialize the shopping cart when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', ShoppingCart.init);