@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-2 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Tổng số phim</h5>
                <p class="card-text display-6">{{ $totalMovies }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Lượt xem</h5>
                <p class="card-text display-6">{{ number_format($totalViews) }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Danh mục</h5>
                <p class="card-text display-6">{{ $totalCategories }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5 class="card-title">Thể loại</h5>
                <p class="card-text display-6">{{ $totalGenres }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Phim mới hôm nay</h5>
                <p class="card-text display-6">{{ $newToday }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Phim mới nhất</h5>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body">
                @if($recentMovies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tên phim</th>
                                    <th>Danh mục</th>
                                    <th>Ngày thêm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMovies as $movie)
                                <tr>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->category->name }}</td>
                                    <td>{{ $movie->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Chưa có phim nào</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Phim phổ biến</h5>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body">
                @if($popularMovies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tên phim</th>
                                    <th>Danh mục</th>
                                    <th>Lượt xem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularMovies as $movie)
                                <tr>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->category->name }}</td>
                                    <td>{{ number_format($movie->views) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Chưa có phim nào</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh mục phổ biến</h5>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body">
                @if($popularCategories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tên danh mục</th>
                                    <th>Số phim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularCategories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->movies_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Chưa có danh mục nào</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 