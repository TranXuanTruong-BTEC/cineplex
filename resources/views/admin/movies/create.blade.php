@extends('layouts.admin')

@section('title', 'Thêm phim mới')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Thêm phim mới</h1>
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề phim <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                        <input type="file" 
                               class="form-control @error('thumbnail') is-invalid @enderror" 
                               id="thumbnail" 
                               name="thumbnail" 
                               accept="image/*"
                               required>
                        <div class="form-text">Chấp nhận: JPG, PNG, GIF, SVG. Tối đa 2MB.</div>
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="video_url" class="form-label">YouTube Video URL hoặc Video ID <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('video_url') is-invalid @enderror" 
                               id="video_url" 
                               name="video_url" 
                               value="{{ old('video_url') }}" 
                               placeholder="https://www.youtube.com/watch?v=VIDEO_ID hoặc VIDEO_ID"
                               required>
                        <div class="form-text">
                            Có thể nhập URL YouTube đầy đủ hoặc chỉ Video ID (11 ký tự).<br>
                            Ví dụ: https://www.youtube.com/watch?v=dQw4w9WgXcQ hoặc dQw4w9WgXcQ
                        </div>
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Thời lượng (tự động lấy từ YouTube)</label>
                            <input type="text" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration') }}" 
                                   placeholder="1h 30m"
                                   readonly>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="release_year" class="form-label">Năm phát hành <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('release_year') is-invalid @enderror" 
                                   id="release_year" 
                                   name="release_year" 
                                   value="{{ old('release_year', date('Y')) }}" 
                                   min="1900" 
                                   max="{{ date('Y') + 1 }}"
                                   required>
                            @error('release_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đã đăng</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="genres" class="form-label">Thể loại</label>
                        <select class="form-select" id="genres" name="genres[]" multiple>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', [])) ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Chọn một hoặc nhiều thể loại phù hợp với phim.</div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu phim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let ytPlayer;
    let pendingVideoId = null;
    let ytReady = false;

    function onYouTubeIframeAPIReady() {
        ytReady = true;
        if (pendingVideoId) {
            loadYoutubeDuration(pendingVideoId);
            pendingVideoId = null;
        }
    }

    function loadYoutubeDuration(videoId) {
        if (!ytReady) {
            pendingVideoId = videoId;
            return;
        }
        if (ytPlayer) ytPlayer.destroy();
        ytPlayer = new YT.Player('hidden-yt-player', {
            height: '0', width: '0', videoId: videoId,
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
                        document.getElementById('duration').value = text.trim();
                    }
                }
            }
        });
    }

    function extractYoutubeId(url) {
        if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
        var regExp = /(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
        var match = url.match(regExp);
        return match ? match[1] : null;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('video_url');
        if (!input) return;
        input.addEventListener('change', function() {
            var videoId = extractYoutubeId(this.value);
            if (videoId) {
                loadYoutubeDuration(videoId);
            }
        });
    });
</script>
<div id="hidden-yt-player" style="display:none"></div>
@endsection 