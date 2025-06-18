<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cineplex - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e50914;
            --secondary-color: #141414;
            --text-color: #ffffff;
        }
        
        body {
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.9) !important;
            padding: 1rem 0;
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .nav-link {
            color: var(--text-color) !important;
            margin: 0 1rem;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .btn {
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #ff0f1a;
            border-color: #ff0f1a;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(var(--primary-color), 0.4);
        }

        .btn-primary:active {
             transform: translateY(0);
             box-shadow: 0 4px 8px rgba(var(--primary-color), 0.3);
        }

        .btn-outline-light {
            color: var(--text-color);
            border-color: var(--text-color);
        }

        .btn-outline-light:hover {
            color: var(--secondary-color);
            background-color: var(--text-color);
            border-color: var(--text-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
        }

        .btn-outline-light:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.15);
        }

        .movie-card {
            background-color: #1f1f1f;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .movie-card .card-body {
            padding: 1rem;
        }

        .movie-card .card-title {
            color: var(--text-color);
            font-weight: bold;
        }

        .movie-card .card-text {
            color: #b3b3b3;
        }

        footer {
            background-color: #0a0a0a;
            padding: 3rem 0 1.5rem 0;
            margin-top: 4rem;
            color: #b3b3b3;
            border-top: 1px solid #222;
            text-align: center;
        }

        footer .container {
            border-bottom: 1px solid #222;
            padding-bottom: 2rem;
            margin-bottom: 1.5rem;
        }

        footer h5 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        footer p {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        footer ul {
            padding: 0;
            list-style: none;
        }

        footer ul li {
            margin-bottom: 0.8rem;
        }

        footer a {
            color: #b3b3b3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        .social-links a {
            font-size: 1.6rem;
            margin: 0 0.8rem;
            color: #b3b3b3;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--primary-color);
        }

        /* Copyright style */
        .copyright {
            font-size: 0.85rem;
            color: #777;
            margin-top: 1.5rem;
        }

        /* Custom Styles for Home Page Effects */
        .movie-card.card {
            border: none;
        }

        .movie-card .card-body, .movie-card .card-footer {
             transition: opacity 0.3s ease;
             opacity: 1;
        }

        .movie-card:hover .card-body, .movie-card:hover .card-footer {
            opacity: 1;
        }

        .movie-card .position-relative img {
            transition: transform 0.5s ease;
        }

        .movie-card:hover .position-relative img {
            transform: scale(1.05);
        }

        .movie-card .position-absolute {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .movie-card:hover .position-absolute {
            opacity: 1;
        }

        .list-group-item {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: var(--primary-color) !important;
            color: var(--text-color) !important;
        }

        /* Dropdown styles */
        .dropdown-menu-dark {
            background-color: rgba(0, 0, 0, 0.95);
            border: 1px solid #333;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .dropdown-item {
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: var(--text-color);
            transform: translateX(5px);
        }

        .dropdown-divider {
            border-color: #333;
        }

        .dropdown-item-text {
            color: #777;
        }

    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">CINEPLEX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('messages.nav_home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">{{ __('messages.nav_movies') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.categories') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="{{ route('movies.index') }}">
                                <i class="fas fa-film me-2"></i>Tất cả phim
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            @forelse($categories ?? [] as $category)
                                <li><a class="dropdown-item" href="{{ route('movies.index', ['category' => $category->id]) }}">
                                    <i class="fas fa-tag me-2"></i>{{ $category->name }}
                                    <span class="badge bg-primary float-end">{{ $category->movies_count }}</span>
                                </a></li>
                            @empty
                                <li><span class="dropdown-item-text">Chưa có danh mục</span></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.trending_now') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.recently_added') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.nav_contact') }}</a>
                    </li>
                </ul>
                <form class="d-flex ms-auto" role="search">
                  <input class="form-control me-2 bg-dark text-white border-secondary" type="search" placeholder="{{ __('messages.search_placeholder') }}" aria-label="Search">
                  <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">{{ __('messages.about_cineplex_title') }}</h5>
                    <p>{{ __('messages.about_cineplex_description') }}</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">{{ __('messages.quick_links_title') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('movies.index') }}">{{ __('messages.nav_movies') }}</a></li>
                        <li><a href="#">{{ __('messages.categories') }}</a></li>
                        <li><a href="#">{{ __('messages.trending_now') }}</a></li>
                        <li><a href="#">{{ __('messages.recently_added') }}</a></li>
                        <li><a href="#">{{ __('messages.nav_contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white">{{ __('messages.connect_with_us_title') }}</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center copyright">
            &copy; {{ date('Y') }} Cineplex. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 