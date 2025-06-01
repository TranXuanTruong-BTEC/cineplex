@extends('layouts.app')

@section('title', 'Movie Detail')

@section('content')
    <div class="container py-4">
        <h1>Movie Detail - ID: {{ $movieId }}</h1>
        {{-- Đây là nơi hiển thị thông tin chi tiết phim --}}
    </div>
@endsection 