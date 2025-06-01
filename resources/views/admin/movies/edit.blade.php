@extends('layouts.admin')

@section('title', 'Sửa phim')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Sửa phim</h1>
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề phim <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $movie->title) }}" 
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
                                  required>{{ old('description', $movie->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Ảnh đại diện</label>
                        <input type="file" 
                               class="form-control @error('thumbnail') is-invalid @enderror" 
                               id="thumbnail" 
                               name="thumbnail">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($movie->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $movie->thumbnail) }}" alt="Current Thumbnail" style="width: 100px; height: auto;">
                                <p class="text-muted mt-1 mb-0">Ảnh hiện tại</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="video_url" class="form-label">URL Video <span class="text-danger">*</span></label>
                        <input type="url" 
                               class="form-control @error('video_url') is-invalid @enderror" 
                               id="video_url" 
                               name="video_url" 
                               value="{{ old('video_url', $movie->video_url) }}" 
                               required>
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Thời lượng (ví dụ: 1h 30m) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration', $movie->duration) }}" 
                                   required>
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
                                   value="{{ old('release_year', $movie->release_year) }}" 
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
                                <option value="{{ $category->id }}" {{ old('category_id', $movie->category_id) == $category->id ? 'selected' : '' }}>
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
                            <option value="draft" {{ old('status', $movie->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="published" {{ old('status', $movie->status) == 'published' ? 'selected' : '' }}>Đã đăng</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật phim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 