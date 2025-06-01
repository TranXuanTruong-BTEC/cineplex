@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section with Featured Movie -->
    <section class="hero-section position-relative text-white overflow-hidden">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, rgba(0,0,0,0.4) 100%); z-index: 1;">
        </div>
        <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
             class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 0;" alt="Featured Movie">
        
        <div class="container position-relative" style="z-index: 2; padding-top: 10vh; padding-bottom: 10vh;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 mb-3">{{ __('messages.featured_movie') }}</h1>
                    <h2 class="mb-3">The Last Adventure</h2>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <span class="badge bg-primary">{{ __('messages.genre_action') }}</span>
                        <span class="badge bg-primary">{{ __('messages.genre_adventure') }}</span>
                        <span class="badge bg-primary">PG-13</span>
                        <span>2024</span>
                        <span>2h 15m</span>
                    </div>
                    <p class="lead mb-4">{{ __('messages.featured_movie_description_placeholder') }}</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('movies.show', 1) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-play me-2"></i>{{ __('messages.watch_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3">
                <!-- Categories -->
                <div class="card bg-dark text-white mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('messages.categories') }}</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($categories as $category)
                            <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                                <i class="fas fa-tag me-2"></i>{{ $category->name }}
                            </a>
                        @empty
                            <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                                Chưa có danh mục
                            </a>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9">
                <!-- Popular Movies -->
                <section class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.popular_movies') }}</h2>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm active">{{ __('messages.filter_all') }}</button>
                            <button class="btn btn-outline-primary btn-sm">{{ __('messages.genre_action') }}</button>
                            <button class="btn btn-outline-primary btn-sm">{{ __('messages.genre_drama') }}</button>
                            <button class="btn btn-outline-primary btn-sm">{{ __('messages.genre_comedy') }}</button>
                        </div>
                    </div>
                    <div class="row g-4">
                        <!-- Movie Card 1 -->
                        <div class="col-md-4 col-lg-3">
                            <div class="movie-card card bg-dark text-white h-100">
                                <div class="position-relative">
                                    <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;" alt="Movie 1">
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
                                            <small>2h 15m</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title h6 mb-1">The Last Adventure</h5>
                                    <p class="card-text small text-muted">{{ __('messages.genre_action') }}, {{ __('messages.genre_adventure') }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid">
                                        <a href="{{ route('movies.show', 2) }}" class="btn btn-primary btn-sm">{{ __('messages.watch_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add more movie cards -->
                    </div>
                </section>

                <!-- Recently Added -->
                <section class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.recently_added') }}</h2>
                        <a href="{{ route('movies.index') }}" class="text-primary text-decoration-none">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="row g-4">
                        <!-- Add recently added movie cards -->
                    </div>
                </section>

                <!-- Trending Now -->
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">{{ __('messages.trending_now') }}</h2>
                        <a href="{{ route('movies.index') }}" class="text-primary text-decoration-none">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="row g-4">
                        <!-- Add trending movie cards -->
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection