@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<style>
    /* Hover effects for movie cards */
    .movie-card .position-relative:hover .opacity-0 {
        opacity: 1 !important;
    }
    
    .movie-card .position-relative:hover img {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    
    /* Quick actions styling */
    .btn-group .btn:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-1px);
    }
    
    /* Search bar styling */
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
    }
    
    /* Heart button animation */
    .btn-outline-light:hover .fa-heart {
        color: #e50914;
        transform: scale(1.1);
        transition: all 0.3s ease;
    }
    
    /* Smooth transitions */
    .transition-opacity {
        transition: opacity 0.3s ease;
    }
    
    /* Loading skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endsection

@section('content')
    @php
        $featuredMovie = $latestMovies->first();
    @endphp
    <!-- Hero Section with Featured Movie -->
    <section class="hero-section position-relative text-white overflow-hidden">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, rgba(0,0,0,0.4) 100%); z-index: 1;">
        </div>
        @if($featuredMovie && $featuredMovie->thumbnail)
            <img src="{{ $featuredMovie->thumbnail_url }}" 
                 class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 0;" alt="{{ $featuredMovie->title }}">
        @else
            <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
                 class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 0;" alt="Featured Movie">
        @endif
        
        <div class="container position-relative" style="z-index: 2; padding-top: 10vh; padding-bottom: 10vh;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 mb-3">{{ __('messages.featured_movie') }}</h1>
                    <h2 class="mb-3">{{ $featuredMovie ? $featuredMovie->title : 'The Last Adventure' }}</h2>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        @if($featuredMovie && $featuredMovie->category)
                            <span class="badge bg-primary">{{ $featuredMovie->category->name }}</span>
                        @endif
                        @foreach($featuredMovie->genres ?? [] as $genre)
                            <span class="badge bg-warning text-dark">{{ $genre->name }}</span>
                        @endforeach
                        @if($featuredMovie && $featuredMovie->release_year)
                            <span class="badge bg-secondary">{{ $featuredMovie->release_year }}</span>
                        @endif
                        @if($featuredMovie && $featuredMovie->duration)
                            <span class="badge bg-info">{{ $featuredMovie->duration }}</span>
                        @endif
                        <span class="badge bg-success">{{ number_format($featuredMovie->views ?? 0) }} lượt xem</span>
                    </div>
                    <p class="lead mb-4">{{ $featuredMovie->description ?? __('messages.featured_movie_description_placeholder') }}</p>
                    <div class="d-flex gap-3">
                        <a href="{{ $featuredMovie ? route('movies.show', $featuredMovie->id) : '#' }}" class="btn btn-primary btn-lg {{ $featuredMovie ? '' : 'disabled' }}">
                            <i class="fas fa-play me-2"></i>{{ __('messages.watch_now') }}
                        </a>
                        @if($featuredMovie)
                            <button class="btn btn-outline-light btn-lg" title="Thêm vào yêu thích">
                                <i class="far fa-heart"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions Bar -->
    <section class="bg-dark py-3 border-bottom border-secondary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-random me-1"></i>Ngẫu nhiên
                        </button>
                        <button type="button" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-fire me-1"></i>Trending
                        </button>
                        <button type="button" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-clock me-1"></i>Mới nhất
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- Main Content Area -->
            <div class="col-12">
                <!-- Popular Movies -->
                <section class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.popular_movies') }}</h2>
                        <a href="{{ route('movies.index') }}" class="text-primary text-decoration-none">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="row g-4">
                        @forelse($popularMovies as $movie)
                        <div class="col-md-4 col-lg-3">
                            <div class="movie-card card bg-dark text-white h-100">
                                <div class="position-relative">
                                    <img src="{{ $movie->thumbnail_url }}" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $movie->title }}">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-danger">HD</span>
                                        <button class="btn btn-sm btn-outline-light ms-1" title="Thêm vào yêu thích">
                                            <i class="far fa-heart"></i>
                                        </button>
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
                                    <!-- Hover overlay -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center opacity-0 transition-opacity" style="transition: opacity 0.3s ease;">
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-lg mb-2">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <div class="text-white">
                                                <small>{{ $movie->views ?? 0 }} lượt xem</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title h6 mb-1">{{ $movie->title }}</h5>
                                    <p class="card-text small text-muted mb-2">
                                        {{ $movie->category->name ?? '' }}
                                        @foreach($movie->genres as $genre)
                                            <span class="badge bg-warning text-dark ms-1">{{ $genre->name }}</span>
                                        @endforeach
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $movie->release_year ?? '' }}</small>
                                        <small class="text-muted">{{ $movie->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary btn-sm">{{ __('messages.watch_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">Chưa có phim phổ biến</div>
                        @endforelse
                    </div>
                </section>

                <!-- Recently Added -->
                <section class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.recently_added') }}</h2>
                        <a href="{{ route('movies.index') }}" class="text-primary text-decoration-none">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="row g-4">
                        @forelse($latestMovies as $movie)
                        <div class="col-md-4 col-lg-3">
                            <div class="movie-card card bg-dark text-white h-100">
                                <div class="position-relative">
                                    <img src="{{ $movie->thumbnail_url }}" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $movie->title }}">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-danger">HD</span>
                                        <button class="btn btn-sm btn-outline-light ms-1" title="Thêm vào yêu thích">
                                            <i class="far fa-heart"></i>
                                        </button>
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
                                    <!-- Hover overlay -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center opacity-0 transition-opacity" style="transition: opacity 0.3s ease;">
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-lg mb-2">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <div class="text-white">
                                                <small>{{ $movie->views ?? 0 }} lượt xem</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title h6 mb-1">{{ $movie->title }}</h5>
                                    <p class="card-text small text-muted mb-2">
                                        {{ $movie->category->name ?? '' }}
                                        @foreach($movie->genres as $genre)
                                            <span class="badge bg-warning text-dark ms-1">{{ $genre->name }}</span>
                                        @endforeach
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $movie->release_year ?? '' }}</small>
                                        <small class="text-muted">{{ $movie->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary btn-sm">{{ __('messages.watch_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">Chưa có phim mới</div>
                        @endforelse
                    </div>
                </section>

                <!-- Trending Now -->
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.trending_now') }}</h2>
                        <a href="{{ route('movies.index') }}" class="text-primary text-decoration-none">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="row g-4">
                        @forelse($trendingMovies ?? [] as $movie)
                        <div class="col-md-4 col-lg-3">
                            <div class="movie-card card bg-dark text-white h-100">
                                <div class="position-relative">
                                    <img src="{{ $movie->thumbnail_url }}" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $movie->title }}">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-danger">HD</span>
                                        <button class="btn btn-sm btn-outline-light ms-1" title="Thêm vào yêu thích">
                                            <i class="far fa-heart"></i>
                                        </button>
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
                                    <!-- Hover overlay -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center opacity-0 transition-opacity" style="transition: opacity 0.3s ease;">
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-lg mb-2">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <div class="text-white">
                                                <small>{{ $movie->views ?? 0 }} lượt xem</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title h6 mb-1">{{ $movie->title }}</h5>
                                    <p class="card-text small text-muted mb-2">
                                        {{ $movie->category->name ?? '' }}
                                        @foreach($movie->genres as $genre)
                                            <span class="badge bg-warning text-dark ms-1">{{ $genre->name }}</span>
                                        @endforeach
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $movie->release_year ?? '' }}</small>
                                        <small class="text-muted">{{ $movie->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary btn-sm">{{ __('messages.watch_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">Chưa có phim trending</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection