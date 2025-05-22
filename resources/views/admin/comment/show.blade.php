@extends('admin.layout.Adminlayout')
@section('title', 'Chi tiết bình luận')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Chi tiết bình luận</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Bình luận</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th width="200">ID</th>
                                                <td>{{ $comment->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Khách hàng</th>
                                                <td>{{ $comment->customer->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <td>
                                                    <a href="{{ route('client.products.show', $comment->product->id) }}" target="_blank">
                                                        {{ $comment->product->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Đánh giá</th>
                                                <td>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $comment->rating_value)
                                                            <i class="ri-star-fill text-warning"></i>
                                                        @else
                                                            <i class="ri-star-line text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nội dung</th>
                                                <td>{{ $comment->content }}</td>
                                            </tr>
                                            <tr>
                                                <th>Thời gian tạo</th>
                                                <td>{{ $comment->created_at->format('H:i:s d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Trạng thái</th>
                                                <td>
                                                    @if($comment->trashed())
                                                        <span class="badge bg-danger">Đã ẩn</span>
                                                    @else
                                                        <span class="badge bg-success">Hiện</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                @if(!$comment->trashed())
                                    <button type="button" class="btn btn-warning" 
                                            onclick="confirmAction('{{ route('admin.comments.destroy', $comment->id) }}', 'hide')">
                                        <i class="ri-eye-off-line align-bottom"></i> Ẩn bình luận
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success" 
                                            onclick="confirmAction('{{ route('admin.comments.restore', $comment->id) }}', 'restore')">
                                        <i class="ri-refresh-line align-bottom"></i> Khôi phục
                                    </button>
                                @endif

                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmAction('{{ route('admin.comments.forceDelete', $comment->id) }}', 'delete')">
                                    <i class="ri-delete-bin-line align-bottom"></i> Xóa vĩnh viễn
                                </button>

                                <a href="{{ route('admin.comments.index') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line align-bottom"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage">
            </div>
            <div class="modal-footer">
                <form id="actionForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn" id="confirmButton">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmAction(url, action) {
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        const form = document.getElementById('actionForm');
        const confirmButton = document.getElementById('confirmButton');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');

        form.action = url;

        switch(action) {
            case 'hide':
                modalTitle.textContent = 'Xác nhận ẩn';
                modalMessage.textContent = 'Bạn có chắc chắn muốn ẩn bình luận này?';
                confirmButton.classList.add('btn-warning');
                break;
            case 'restore':
                modalTitle.textContent = 'Xác nhận khôi phục';
                modalMessage.textContent = 'Bạn có chắc chắn muốn khôi phục bình luận này?';
                confirmButton.classList.add('btn-success');
                form.querySelector('input[name="_method"]').value = 'PATCH';
                break;
            case 'delete':
                modalTitle.textContent = 'Xác nhận xóa';
                modalMessage.textContent = 'Bạn có chắc chắn muốn xóa vĩnh viễn bình luận này? Hành động này không thể hoàn tác!';
                confirmButton.classList.add('btn-danger');
                break;
        }

        modal.show();
    }
</script>
@endpush