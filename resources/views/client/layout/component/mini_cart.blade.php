
    <div class="offcanvas offcanvas-end product-list" tabindex="-1" id="ecommerceCart" aria-labelledby="ecommerceCartLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="ecommerceCartLabel">My Cart <span class="badge bg-danger align-middle ms-1 cartitem-badge">{{ $cartItems->count() }}</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-0">
            <div data-simplebar  class="h-100">
                <ul class="list-group list-group-flush cartlist">
                    @forelse($cartItems as $item)
                        <li class="list-group-item product">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md" style="height: 100%;">
                                        <div class="avatar-title bg-warning-subtle rounded-3">
                                            <img src="{{ asset('client/images/fashion/product/' . $item->productVariant->product->image) }}" alt="" class="avatar-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="{{ route('client.products.show', $item->productVariant->product->id) }}">
                                        <h5 class="fs-15">{{ $item->productVariant->product->name }}</h5>
                                    </a>
                                    <div class="d-flex mb-3 gap-2">
                                        <div class="text-muted fw-medium mb-0">$<span class="product-price">{{ number_format($item->price, 2) }}</span></div>
                                        <div class="vr"></div>
                                        <span class="text-success fw-medium">In Stock</span>
                                    </div>
                                    
                                </div>
                                <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                                    <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-id="{{ $item->id }}"><i class="ri-close-fill fs-16"></i></button>
                                    <div class="fw-medium mb-0 fs-16">$<span class="product-line-price">{{ number_format($item->price * $item->quantity, 2) }}</span></div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Cart is empty</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 fs-16 text-muted">Total:</h6>
                <div class="px-2">
                    <h6 class="m-0 fs-16 cart-total">${{ $cartTotal }}</h6>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('client.cart.index') }}" class="btn btn-light w-100">View Cart</a>
                </div>
                <div class="col-6">
                    <a href="#!" target="_blank" class="btn btn-info w-100">Continue to Checkout</a>
                </div>
            </div>
        </div>
    </div>
