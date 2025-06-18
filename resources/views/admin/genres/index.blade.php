@extends('layouts.admin')

@section('title', 'Quản lý thể loại')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý thể loại</h1>
        <a href="{{ route('admin.genres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm thể loại
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            @if($genres->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tên thể loại</th>
                                <th>Slug</th>
                                <th>Danh mục liên kết</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($genres as $genre)
                                <tr>
                                    <td>{{ $genre->name }}</td>
                                    <td>{{ $genre->slug }}</td>
                                    <td>
                                        @foreach($genre->categories as $cat)
                                            <span class="badge bg-info">{{ $cat->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" style="display:inline" onsubmit="return confirm('Xóa thể loại này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">Chưa có thể loại nào.</div>
            @endif
        </div>
    </div>
</div>
@endsection 