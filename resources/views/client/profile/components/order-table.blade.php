<div class="table-responsive">
    <table class="table table-centered table-hover align-middle mb-0">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
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
                                'processing' => 'warning',
                                'shipping' => 'info',
                                'cancelled' => 'danger',
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
                    <td colspan="6" class="text-center py-4">
                        <div class="text-muted">No orders found</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>