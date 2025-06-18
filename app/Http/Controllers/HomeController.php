<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('movies')->get();
        $latestMovies = Movie::with(['category', 'genres'])->where('status', 'published')->orderByDesc('created_at')->take(8)->get();
        $popularMovies = Movie::with(['category', 'genres'])->where('status', 'published')->orderByDesc('views')->take(8)->get();
        $trendingMovies = Movie::with(['category', 'genres'])->where('status', 'published')->where('views', '>', 0)->orderByDesc('views')->take(8)->get();
        
        return view('home', compact('categories', 'latestMovies', 'popularMovies', 'trendingMovies'));
    }
} 