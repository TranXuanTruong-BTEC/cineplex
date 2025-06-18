@extends('layouts.admin')

@section('title', 'Quản lý phim')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Quản lý phim</h1>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm phim mới
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Bảng hiển thị danh sách phim --}}
        <div class="card">
            <div class="card-body">
                @if($movies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Danh mục</th>
                                    <th>Thời lượng</th>
                                    <th>Năm</th>
                                    <th>Trạng thái</th>
                                    <th>Lượt xem</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movies as $movie)
                                    <tr>
                                        <td>
                                            <img src="{{ $movie->thumbnail_url }}" 
                                                 alt="{{ $movie->title }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $movie->title }}</strong>
                                                @if($movie->slug)
                                                    <br><small class="text-muted">{{ $movie->slug }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($movie->category)
                                                <span class="badge bg-info">{{ $movie->category->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $movie->duration ?? '-' }}</td>
                                        <td>{{ $movie->release_year ?? '-' }}</td>
                                        <td>
                                            @if($movie->status == 'published')
                                                <span class="badge bg-success">Đã đăng</span>
                                            @else
                                                <span class="badge bg-warning">Nháp</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ number_format($movie->views) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.movies.edit', $movie) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.movies.destroy', $movie) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa phim này?')"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-film fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có phim nào</h5>
                        <p class="text-muted">Bắt đầu bằng cách thêm phim mới.</p>
                        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm phim đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 