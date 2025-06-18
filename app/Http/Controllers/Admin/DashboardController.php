<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalCategories = Category::count();
        $totalGenres = Genre::count();
        $totalViews = Movie::sum('views');
        $newToday = Movie::whereDate('created_at', today())->count();

        $recentMovies = Movie::with('category')
            ->latest()
            ->take(5)
            ->get();

        $popularMovies = Movie::with('category')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        $popularCategories = Category::withCount('movies')
            ->orderByDesc('movies_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMovies',
            'totalCategories',
            'totalGenres',
            'totalViews',
            'newToday',
            'recentMovies',
            'popularMovies',
            'popularCategories'
        ));
    }
}
