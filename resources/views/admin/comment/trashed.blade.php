@extends('admin.layout.Adminlayout')
@section('title', 'Quản lý Bình Luận')
@section('css')

@endsection
@section('content')
<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Bình Luận</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                                <li class="breadcrumb-item active">Bình Luận</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Danh sách bình luận xóa mềm</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->customer->user->name }}</td>
                                        <td>
                                            <a href="{{ route('client.products.show', $comment->product->id) }}" target="_blank">
                                                {{ $comment->product->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $comment->rating_value)
                                                    <i class="ri-star-fill text-warning"></i>
                                                @else
                                                    <i class="ri-star-line text-warning"></i>
                                                @endif
                                            @endfor
                                        </td>
                                            {{-- @php
                                            dd($comment->rating_value);
                                            @endphp --}}
                                        <td>{{ $comment->content }}</td>
                                        <td>{{ $comment->created_at->format('H:i:s d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                               <a href="{{ route('admin.comments.show',$comment->id) }}" class="btn btn-warning" >Xem chi tiết</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa bình luận này?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush