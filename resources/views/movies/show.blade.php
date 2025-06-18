@extends('layouts.app')

@section('title', $movie->title ?? 'Chi tiết phim')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('movies.index') }}">Phim</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $movie->title ?? 'Không tìm thấy' }}</li>
        </ol>
    </nav>

    @if($movie)
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Video Player -->
            <div class="card bg-dark text-white mb-4">
                <div class="card-body p-0">
                    @if(!empty($movie->youtube_video_id))
                        <div class="ratio ratio-16x9">
                            <iframe id="youtube-player" src="{{ $movie->youtube_embed_url }}"
                                    title="{{ $movie->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                        <span id="video-duration" class="badge bg-info mt-2"></span>
                    @else
                        <div class="ratio ratio-16x9 bg-secondary d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <i class="fas fa-video fa-3x mb-3"></i>
                                <p>Video không khả dụng</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Movie Information -->
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ $movie->thumbnail_url ?? asset('images/default-thumbnail.jpg') }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $movie->title }}">
                        </div>
                        <div class="col-md-9">
                            <h1 class="h3 mb-3">{{ $movie->title }}</h1>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if($movie->category)
                                    <span class="badge bg-primary">{{ $movie->category->name }}</span>
                                @endif
                                @foreach($movie->genres as $genre)
                                    <span class="badge bg-warning text-dark">{{ $genre->name }}</span>
                                @endforeach
                                @if($movie->release_year)
                                    <span class="badge bg-secondary">{{ $movie->release_year }}</span>
                                @endif
                                @if($movie->duration)
                                    <span class="badge bg-info">{{ $movie->duration }}</span>
                                @endif
                                <span class="badge bg-success">{{ number_format($movie->views) }} lượt xem</span>
                            </div>

                            @if($movie->description)
                                <p class="text-muted">{{ $movie->description }}</p>
                            @endif

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">
                                    <i class="fas fa-play me-2"></i>Xem phim
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-heart me-2"></i>Yêu thích
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-share me-2"></i>Chia sẻ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Movies -->
            @if(isset($relatedMovies) && $relatedMovies->count() > 0)
            <div class="card bg-dark text-white">
                <div class="card-header">
                    <h5 class="mb-0">Phim liên quan</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedMovies as $relatedMovie)
                    <div class="d-flex mb-3">
                        <img src="{{ $relatedMovie->thumbnail_url ?? asset('images/default-thumbnail.jpg') }}" 
                             class="rounded me-3" 
                             style="width: 80px; height: 60px; object-fit: cover;" 
                             alt="{{ $relatedMovie->title }}">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('movies.show', $relatedMovie->id) }}" 
                                   class="text-white text-decoration-none">
                                    {{ $relatedMovie->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $relatedMovie->category->name ?? '' }} • {{ $relatedMovie->duration }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="alert alert-danger">Không tìm thấy phim.</div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    function onYouTubeIframeAPIReady() {
        var player = new YT.Player('youtube-player', {
            events: {
                'onReady': function(event) {
                    var duration = event.target.getDuration();
                    if (duration > 0) {
                        var h = Math.floor(duration / 3600);
                        var m = Math.floor((duration % 3600) / 60);
                        var s = Math.floor(duration % 60);
                        let text = '';
                        if (h > 0) text += h + 'h ';
                        if (m > 0) text += m + 'm ';
                        if (h == 0 && m == 0) text += s + 's';
                        document.getElementById('video-duration').innerText = text.trim();
                    }
                }
            }
        });
    }
</script>
@endsection 