@extends('layouts.app')

@section('title', 'Danh sách phim')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Danh sách phim</h1>
                <div class="btn-group">
                    <button class="btn btn-outline-primary btn-sm active">Mới nhất</button>
                    <button class="btn btn-outline-primary btn-sm">Phổ biến</button>
                </div>
            </div>

            @if($movies->count() > 0)
                <div class="row g-4">
                    @foreach($movies as $movie)
                    <div class="col-md-4 col-lg-3">
                        <div class="movie-card card bg-dark text-white h-100">
                            <div class="position-relative">
                                <img src="{{ $movie->thumbnail_url }}" 
                                     class="card-img-top" 
                                     style="height: 250px; object-fit: cover;" 
                                     alt="{{ $movie->title }}">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-danger">HD</span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                        <small>{{ $movie->duration }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="card-title h6 mb-1">{{ $movie->title }}</h5>
                                <p class="card-text small text-muted">
                                    {{ $movie->category->name ?? '' }}
                                    @foreach($movie->genres as $genre)
                                        <span class="badge bg-warning text-dark ms-1">{{ $genre->name }}</span>
                                    @endforeach
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                <div class="d-grid">
                                    <a href="{{ route('movies.show', $movie->id) }}" 
                                       class="btn btn-primary btn-sm">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $movies->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-film fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không có phim nào</h5>
                    <p class="text-muted">Chưa có phim nào được đăng.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 