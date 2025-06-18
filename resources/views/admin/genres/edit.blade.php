@extends('layouts.admin')

@section('title', 'Sửa thể loại')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Sửa thể loại: {{ $genre->name }}</h1>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.genres.update', $genre) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thể loại <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $genre->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="categories" class="form-label">Danh mục liên kết</label>
                    <select class="form-select" id="categories" name="categories[]" multiple>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', $selected)) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 