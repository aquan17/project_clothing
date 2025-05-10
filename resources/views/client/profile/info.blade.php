@extends('client.layout.clientlayout')
@section('title', 'Profile')
@section('content')
    <section class="position-relative">
        <div class="profile-basic position-relative"
            style="background-image: url('{{ asset('client/images/profile-bg.jpg') }}');background-size: cover;background-position: center; height: 300px;">
            <div class="bg-overlay bg-primary" style="--bs-bg-opacity: 0.99;"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pt-3">
                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <img src="{{ asset('client/images/users/avatar-1.jpg') }}" alt=""
                                class="avatar-xl rounded p-1 bg-light mt-n3">
                            <div>
                                <h5 class="fs-18">{{ $user->name }}</h5>
                                <div class="text-muted">
                                    <i class="bi bi-geo-alt"></i> {{ $customer->address ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="ms-md-auto">
                                <a href="{{ route('client.products') }}" class="btn btn-success btn-hover"><i
                                        class="bi bi-cart4 me-1 align-middle"></i> Shopping Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column gap-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15 active" data-bs-toggle="tab" href="#custom-v-pills-profile"
                                        role="tab" aria-selected="true"><i
                                            class="bi bi-person-circle align-middle me-1"></i> Account Info</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-list"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-bookmark-check align-middle me-1"></i> Wish list</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-order"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-bag align-middle me-1"></i> Order</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-setting"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-gear align-middle me-1"></i> Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right align-middle me-1"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content text-muted">
                        <!-- Account Info Tab -->
                        <div class="tab-pane fade show active" id="custom-v-pills-profile" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-4">
                                                <h6 class="fs-16 text-decoration-underline flex-grow-1 mb-0">Personal Info
                                                </h6>
                                                <div class="flex-shrink-0">
                                                    <a href="#!" class="badge bg-dark-subtle text-dark">Edit</a>
                                                </div>
                                            </div>

                                            <div class="table-responsive table-card px-1">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Customer Name</td>
                                                            <td class="fw-medium">{{ $customer->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile / Phone Number</td>
                                                            <td class="fw-medium">{{ $customer->phone ?? 'Chưa cập nhật' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email Address</td>
                                                            <td class="fw-medium">{{ $customer->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Location</td>
                                                            <td class="fw-medium">
                                                                {{ $customer->address ?? 'Chưa cập nhật' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Since Member</td>
                                                            <td class="fw-medium">
                                                                {{ $customer->created_at->format('M, Y') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-4">
                                                <h6 class="fs-16 text-decoration-underline">Billing & Shipping Address</h6>
                                            </div>
                                            <div class="row mt-4">
                                                @foreach ($shippingAddresses as $address)
                                                    <div class="col-md-6">
                                                        <div class="card mb-md-0">
                                                            <div class="card-body">
                                                                <div class="float-end clearfix">
                                                                    <a href="#"
                                                                        class="badge bg-primary-subtle text-primary">
                                                                        <i class="ri-pencil-fill align-bottom me-1"></i>
                                                                        Edit
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <p
                                                                        class="mb-3 fw-semibold fs-12 d-block text-muted text-uppercase">
                                                                        Shipping Address</p>
                                                                    <h6 class="fs-14 mb-2 d-block">{{ $address->name }}
                                                                    </h6>
                                                                    <span
                                                                        class="text-muted fw-normal text-wrap mb-1 d-block">
                                                                        {{ $address->ward }}, {{ $address->district }},
                                                                        {{ $address->province }}, {{ $address->country }}
                                                                    </span>
                                                                    <span class="text-muted fw-normal d-block">Mo.
                                                                        {{ $address->phone }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist Tab -->
                        <div class="tab-pane fade" id="custom-v-pills-list" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card overflow-hidden">
                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table class="table fs-15 align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Stock Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($wishlists as $wishlist)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex gap-3">
                                                                        <div class="avatar-sm flex-shrink-0">
                                                                            <div
                                                                                class="avatar-title bg-dark-subtle rounded">
                                                                                <img src="{{ asset($wishlist->product->image) }}"
                                                                                    alt="" class="avatar-xs">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <a
                                                                                href="{{ route('client.products.show', $wishlist->product->id) }}">
                                                                                <h6 class="fs-16">
                                                                                    {{ $wishlist->product->name }}</h6>
                                                                            </a>
                                                                            <p class="mb-0 text-muted fs-13">
                                                                                {{ $wishlist->product->category->name }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ number_format($wishlist->product->price) }}đ</td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-{{ $wishlist->product->stock > 0 ? 'success' : 'danger' }}-subtle text-{{ $wishlist->product->stock > 0 ? 'success' : 'danger' }}">
                                                                        {{ $wishlist->product->stock > 0 ? 'In Stock' : 'Out Of Stock' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled d-flex gap-3 mb-0">
                                                                        <li>
                                                                            <a href="{{ route('client.cart.add') }}"
                                                                                class="btn btn-soft-info btn-icon btn-sm">
                                                                                <i
                                                                                    class="ri-shopping-cart-2-line fs-13"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href=""
                                                                                class="btn btn-soft-danger btn-icon btn-sm">
                                                                                <i class="ri-close-line fs-13"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="custom-v-pills-order" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table fs-15 align-middle table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Total Amount</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                @foreach ($order->items as $item)
                                                    @php
                                                        $productVariant = $item->productVariant;
                                                        $product = $productVariant?->product;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="#" class="text-body">{{ $order->order_code }}</a>
                                                        </td>
                                                        <td>
                                                            @if ($product)
                                                                <a href="{{ route('client.products.show', $product->id) }}">
                                                                    <h6 class="fs-15 mb-1">{{ $product->name }}</h6>
                                                                </a>
                                                                <p class="mb-0 text-muted fs-13">
                                                                    {{ $product->category?->name }}
                                                                </p>
                                                            @else
                                                                <span class="text-danger">Sản phẩm không tồn tại</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">{{ $order->created_at->format('d M, Y') }}</span>
                                                        </td>
                                                        <td class="fw-medium">
                                                            ${{ number_format($order->total_price, 2) }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}-subtle text-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('client.profile.invoice', $order->id) }}" class="btn btn-secondary btn-sm">Invoice</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="custom-v-pills-setting" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5 class="fs-16 text-decoration-underline mb-4">Personal Details
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ $customer->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Phone Number</label>
                                                            <input type="text" class="form-control" id="phone"
                                                                name="phone" value="{{ $customer->phone }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                name="address" value="{{ $customer->address }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-sm-end">
                                                    <button type="submit"
                                                        class="btn btn-secondary d-block d-sm-inline-block">
                                                        <i class="ri-edit-box-line align-middle me-2"></i> Update Profile
                                                    </button>
                                                </div>
                                            </form>

                                            <div class="mb-3" id="changePassword">
                                                <h5 class="fs-16 text-decoration-underline mb-4">Change Password</h5>
                                                <form action="" method="POST">
                                                    @csrf
                                                    <div class="row g-2">
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="current_password" class="form-label">Old
                                                                    Password*</label>
                                                                <input type="password" class="form-control"
                                                                    id="current_password" name="current_password">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="password" class="form-label">New
                                                                    Password*</label>
                                                                <input type="password" class="form-control"
                                                                    id="password" name="password">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="password_confirmation"
                                                                    class="form-label">Confirm Password*</label>
                                                                <input type="password" class="form-control"
                                                                    id="password_confirmation"
                                                                    name="password_confirmation">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm-end mt-3">
                                                        <button type="submit" class="btn btn-primary">Change
                                                            Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
  <!-- Invoice Modal -->
<!-- Invoice Modal -->
{{-- <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="invoiceModalLabel">Invoice <span id="order-code"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Loading indicator -->
                <div id="loading" style="display: none; text-align: center; padding: 30px;"></div>
                
                <!-- Invoice Card -->
                <div class="card mb-0">
                    <div class="row">
                        <!-- Company Information -->
                        <div class="col-lg-12">
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-sm-flex">
                                    <div class="flex-grow-1">
                                        <img src="{{ asset('client/images/logo-dark.png') }}"
                                            class="card-logo card-logo-dark" alt="logo dark" height="26">
                                        <img src="{{ asset('client/images/logo-light.png') }}"
                                            class="card-logo card-logo-light" alt="logo light" height="26">
                                        <div class="mt-sm-5 mt-4">
                                            <h6 class="text-muted text-uppercase fw-semibold fs-14">Address</h6>
                                            <p class="text-muted mb-1" id="address-details">
                                                <span id="shipping-country"></span>
                                                <span id="shipping-province"></span>
                                                <span id="shipping-district"></span>
                                                <span id="shipping-ward"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h6><span class="text-muted fw-normal">Email:</span> <span
                                                id="email">quapc2004@gmail.com</span></h6>
                                        <h6><span class="text-muted fw-normal">Website:</span> <a
                                                href="https://themesbrand.com/" class="link-primary"
                                                id="website">www.themesbrand.com</a></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span
                                                id="contact-no">0862579104</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Order Code</p>
                                        <h5 class="fs-15 mb-0">#<span id="invoice-no-display"></span></h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Date</p>
                                        <h5 class="fs-15 mb-0"><span id="invoice-date"></span> <small
                                                class="text-muted" id="invoice-time"></small></h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Payment Status</p>
                                        <span class="badge bg-success-subtle text-success"
                                            id="payment-status">Paid</span>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Total Amount</p>
                                        <h5 class="fs-15 mb-0">$<span id="total-amount"></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Billing & Shipping Address -->
                        <div class="col-lg-12">
                            <div class="card-body p-4 border-top border-top-dashed">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">Billing Address
                                        </h6>
                                        <p class="fw-medium mb-2 fs-16" id="billing-name"></p>
                                        <p class="text-muted mb-1" id="billing-district"></p>
                                        <p class="text-muted mb-1"><span>Phone: </span><span
                                                id="billing-phone"></span></p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">Shipping Address
                                        </h6>
                                        <p class="fw-medium mb-2 fs-16" id="shipping-name"></p>
                                        <p class="text-muted mb-1" id="shipping-district"></p>
                                        <p class="text-muted mb-1"><span>Phone: </span><span
                                                id="shipping-phone"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Invoice Items & Totals -->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <!-- Products Table -->
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice-items">
                                            <!-- Items will be inserted here via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Totals Table -->
                                <div class="border-top border-top-dashed mt-2">
                                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                        style="width:250px">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end">$<span id="sub-total">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Tax</td>
                                                <td class="text-end">$<span id="invoice-tax">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-end">-$<span id="invoice-discount">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge</td>
                                                <td class="text-end">$<span id="invoice-shipping">0.00</span></td>
                                            </tr>
                                            <tr class="border-top border-top-dashed fs-15">
                                                <th scope="row">Total Amount</th>
                                                <th class="text-end">$<span id="total-amount">0.00</span></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Payment Details -->
                                <div class="mt-3">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                    <p class="text-muted mb-1">Payment Method: <span class="fw-medium"
                                            id="payment-method">Mastercard</span></p>
                                    <p class="text-muted mb-1">Card Holder: <span class="fw-medium"
                                            id="card-holder-name">N/A</span></p>
                                    <p class="text-muted mb-1">Card Number: <span class="fw-medium"
                                            id="card-number">xxxx xxxx xxxx xxxx</span></p>
                                    <p class="text-muted">Total Amount: <span class="fw-medium">$ </span><span
                                            id="card-total-amount">0.00</span></p>
                                </div>
                                
                                <!-- Notes -->
                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                            <span id="note">All accounts are to be paid within 7 days from receipt
                                                of invoice.</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <a href="javascript:window.print()" class="btn btn-success"><i
                                            class="ri-printer-line align-bottom me-1"></i> Print</a>
                                    <a href="javascript:void(0);" class="btn btn-primary"><i
                                            class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
{{-- <script>
// JavaScript for handling the invoice functionality
document.addEventListener('DOMContentLoaded', function() {
    // Preload modal structure as soon as page loads
    const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
    
    // Add fade-in animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        .loading-spinner {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #007bff;
            animation: spin 1s ease infinite;
        }
        .skeleton-loading {
            position: relative;
            overflow: hidden;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .skeleton-loading::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transform: translateX(-100%);
            background-image: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0,
                rgba(255, 255, 255, 0.2) 20%,
                rgba(255, 255, 255, 0.5) 60%,
                rgba(255, 255, 255, 0)
            );
            animation: shimmer 2s infinite;
            content: '';
        }
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    // Create a function to show skeleton loading in the modal
    function showSkeletonLoading() {
        const skeletonElements = document.querySelectorAll('#invoice-items, #shipping-name, #billing-name, #invoice-date, #order-code, #shipping-country, #shipping-phone');
        skeletonElements.forEach(el => {
            if (el.id === 'invoice-items') {
                // Clear table and add skeleton rows
                el.innerHTML = '';
                for (let i = 0; i < 3; i++) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><div class="skeleton-loading" style="height: 20px; width: 20px;"></div></td>
                        <td><div class="skeleton-loading" style="height: 20px; width: 120px;"></div></td>
                        <td><div class="skeleton-loading" style="height: 20px; width: 60px;"></div></td>
                        <td><div class="skeleton-loading" style="height: 20px; width: 40px;"></div></td>
                        <td class="text-end"><div class="skeleton-loading" style="height: 20px; width: 80px;"></div></td>
                    `;
                    el.appendChild(row);
                }
            } else {
                // Store original content if needed later
                el.dataset.originalContent = el.innerHTML;
                // Replace with skeleton loading
                el.innerHTML = `<div class="skeleton-loading" style="height: 20px; width: 100%;"></div>`;
            }
        });
        
        // Also show loading for summary fields
        ['sub-total', 'invoice-tax', 'invoice-discount', 'invoice-shipping', 'total-amount'].forEach(id => {
            const elements = document.querySelectorAll(`[id="${id}"]`);
            elements.forEach(el => {
                el.innerHTML = '...';
            });
        });
    }
    
    // Enhance loading indicator
    const loadingElement = document.getElementById('loading');
    loadingElement.innerHTML = '<div class="loading-spinner"></div><p class="mt-2">Loading invoice data...</p>';
    
    // Listen for clicks on "Invoice" buttons
    document.querySelectorAll('.btn-invoice').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id'); // Get order ID
            
            // Show modal immediately with skeleton content
            showSkeletonLoading();
            invoiceModal.show();
            
            // Send AJAX request to get invoice data
            fetch(`/order/invoice/${orderId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Add a small delay to make transition smoother
                    setTimeout(() => {
                    
                        if (data && data.items) {
                            console.log('Invoice data:', data);
                            
                            // Customer and shipping information
                            if (data.customer && data.customer.address) {
                                const address = data.customer.address;
                                
                                // Update shipping address
                                document.getElementById('shipping-country').textContent = address.country || '';
                                document.getElementById('shipping-province').textContent = address.province || '';
                                document.getElementById('shipping-district').textContent = address.district || '';
                                document.getElementById('shipping-ward').textContent = address.ward || '';
                                
                                // Additional customer info
                                document.getElementById('shipping-name').textContent = data.customer.name || '';
                                document.getElementById('billing-name').textContent = data.customer.name || '';
                                document.getElementById('shipping-phone').textContent = data.customer.phone || '';
                                document.getElementById('billing-district').textContent = 
                                    [address.district, address.ward, address.province, address.country].filter(Boolean).join(', ');
                            } else {
                                console.error('Invalid address information');
                            }
                            
                            // Order details
                            document.getElementById('invoice-date').textContent = 
                                new Date(data.created_at).toLocaleDateString();
                            document.getElementById('order-code').textContent = data.order_code || '';
                            document.getElementById('invoice-no-display').textContent = data.order_code || '';
                            
                            // Set payment status if available
                            if (data.payment_status) {
                                document.getElementById('payment-status').textContent = data.payment_status;
                                document.getElementById('payment-method').textContent = data.payment_method || 'N/A';
                            }
                            
                            // Financial calculations
                            document.getElementById('sub-total').textContent = 
                                (data.totals?.subtotal || 0).toFixed(2);
                            document.getElementById('invoice-tax').textContent = 
                                (data.totals?.tax || 0).toFixed(2);
                            document.getElementById('invoice-discount').textContent = 
                                (data.totals?.discount || 0).toFixed(2);
                            document.getElementById('invoice-shipping').textContent = 
                                (data.totals?.shipping || 0).toFixed(2);
                                
                            // Set total amount in all locations
                            const totalAmount = (data.totals?.total || 0).toFixed(2);
                            const totalElements = document.querySelectorAll('[id="total-amount"]');
                            totalElements.forEach(el => {
                                el.textContent = totalAmount;
                            });
                            document.getElementById('card-total-amount').textContent = totalAmount;
                            
                            // Update product items table
                            const itemsTableBody = document.getElementById('invoice-items');
                            itemsTableBody.innerHTML = ''; // Clear table before adding new data
                            
                            data.items.forEach((item, index) => {
                                const row = document.createElement('tr');
                                // Calculate item total
                                const quantity = parseInt(item.quantity) || 0;
                                const price = parseFloat(item.price) || 0;
                                const itemTotal = (quantity * price).toFixed(2);
                                
                                row.innerHTML = `
                                    <td>${index + 1}</td>
                                    <td>${item.product_name || ''}</td>
                                    <td>$${price.toFixed(2)}</td>
                                    <td>${quantity}</td>
                                    <td class="text-end">$${itemTotal}</td>
                                `;
                                itemsTableBody.appendChild(row);
                            });
                            
                        } else {
                            // Show error in modal instead of alert
                            document.getElementById('invoice-items').innerHTML = `
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="alert alert-danger mb-0">
                                            <i class="ri-error-warning-line fs-3 me-2 align-middle"></i>
                                            Invalid invoice data. Please try again later.
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }
                    }, 300);
                })
                .catch(error => {
                    console.error('Error fetching invoice details:', error);
                    
                    // Show error message in modal instead of alert
                    document.getElementById('invoice-items').innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="alert alert-danger mb-0">
                                    <i class="ri-error-warning-line fs-3 me-2 align-middle"></i>
                                    Failed to load invoice data. Please try again.
                                </div>
                            </td>
                        </tr>
                    `;
                    
                    // Reset totals
                    ['sub-total', 'invoice-tax', 'invoice-discount', 'invoice-shipping', 'total-amount'].forEach(id => {
                        const elements = document.querySelectorAll(`[id="${id}"]`);
                        elements.forEach(el => {
                            el.textContent = '0.00';
                        });
                    });
                });
        });
    });
    
    // Pre-cache invoice data for common orders to improve performance
    // This runs in the background after page loads to make clicking faster later
    function precacheCommonInvoices() {
        // Get most viewed orders from localStorage or use default common IDs
        const commonOrderIds = JSON.parse(localStorage.getItem('commonOrderIds')) || [];
        
        // Limit to only 3 most common to avoid excessive requests
        commonOrderIds.slice(0, 3).forEach(orderId => {
            // Low priority fetch - won't block other operations
            fetch(`/order/invoice/${orderId}`, { priority: 'low' })
                .then(response => response.json())
                .then(data => {
                    // Store in sessionStorage for quick access
                    if (data && data.items) {
                        sessionStorage.setItem(`invoice_${orderId}`, JSON.stringify(data));
                        console.log(`Precached invoice data for order ${orderId}`);
                    }
                })
                .catch(() => {
                    // Silently fail - this is just optimization
                });
        });
    }
    
    // Run precache after page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(precacheCommonInvoices, 2000); // Delay by 2 seconds
    });
    
    // Print functionality with enhanced behavior
    document.querySelector('.btn-success').addEventListener('click', function() {
        // Add print-specific class to body
        document.body.classList.add('printing-invoice');
        
        // Set up print styling
        const printStyle = document.createElement('style');
        printStyle.innerHTML = `
            @media print {
                body * {
                    visibility: hidden;
                }
                .modal-content, .modal-content * {
                    visibility: visible;
                }
                .modal-content {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }
                .d-print-none {
                    display: none !important;
                }
            }
        `;
        document.head.appendChild(printStyle);
        
        // Print and remove styles afterward
        window.print();
        
        // Clean up
        setTimeout(() => {
            document.head.removeChild(printStyle);
            document.body.classList.remove('printing-invoice');
        }, 500);
    });
    
    // Download button with enhanced functionality
    document.querySelector('.btn-primary').addEventListener('click', function() {
        // Show processing indicator
        this.innerHTML = '<i class="ri-loader-2-line align-bottom me-1 spin"></i> Processing...';
        this.disabled = true;
        
        setTimeout(() => {
            this.innerHTML = '<i class="ri-download-2-line align-bottom me-1"></i> Download';
            this.disabled = false;
            
            // Implementation depends on backend capability
            // Either generate PDF client-side or trigger server-side generation
            alert('Download functionality will be implemented soon.');
        }, 1000);
    });
});
</script> --}}
