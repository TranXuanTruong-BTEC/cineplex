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
            <div class="alert alert-success">
                {{ session('success') }}
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh đại diện</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Lượt xem</th>
                                <th>Thời lượng</th>
                                <th>Năm phát hành</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movies as $movie)
                            <tr>
                                <td>{{ $movie->id }}</td>
                                <td>
                                    @if($movie->thumbnail)
                                        <img src="{{ asset('storage/' . $movie->thumbnail) }}" alt="Thumbnail" style="width: 60px; height: auto;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $movie->title }}</td>
                                <td>{{ $movie->category->name }}</td>
                                <td>{{ number_format($movie->views) }}</td>
                                <td>{{ $movie->duration }}</td>
                                <td>{{ $movie->release_year }}</td>
                                <td>
                                    <span class="badge bg-{{ $movie->status == 'published' ? 'success' : 'warning' }}">
                                        {{ $movie->status == 'published' ? 'Đã đăng' : 'Nháp' }}
                                    </span>
                                </td>
                                <td>{{ $movie->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.movies.edit', $movie) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.movies.destroy', $movie) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa phim này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Không có phim nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 