<div class="order-history-responsive">
    <!-- Desktop Table (hiển thị trên màn hình lớn) -->
    <div class="table-responsive d-none d-md-block">
        <table class="table table-centered table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Mã Đơn Hàng</th>
                    <th scope="col">Ngày Đặt</th>
                    <th scope="col">Tổng Tiền</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Chức Năng</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="fw-medium">{{ $order->order_code }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td>
                            @php
                                $statusColor = match($order->status) {
                                    'completed' => 'success',
                                    'pending' => 'warning',
                                    'cancelled' => 'danger',
                                    'confirmed' => 'info',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('client.profile.invoice', $order->id) }}" 
                               class="btn btn-sm btn-soft-primary">
                                <i class="ri-file-text-line align-middle"></i> Invoice
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">No orders found</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards (hiển thị trên điện thoại) -->
    <div class="d-md-none">
        @forelse($orders as $order)
            <div class="card mb-3 order-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="card-title mb-0">Mã: {{ $order->order_code }}</h6>
                        @php
                            $statusColor = match($order->status) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                'confirmed' => 'info',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Ngày đặt:</small>
                        <span class="ms-1">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Tổng tiền:</small>
                        <span class="ms-1 fw-medium">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('client.profile.invoice', $order->id) }}" 
                           class="btn btn-sm btn-soft-primary">
                            <i class="ri-file-text-line align-middle"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center py-4">
                    <div class="text-muted">Không tìm thấy đơn hàng nào</div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Thêm một số style để làm đẹp giao diện mobile */
    @media (max-width: 767px) {
        .order-card {
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .order-card .card-body {
            padding: 12px 15px;
        }
    }
</style>