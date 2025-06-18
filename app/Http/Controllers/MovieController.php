<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Movie::with(['category', 'genres'])->where('status', 'published');
        
        // Filter theo danh mục nếu có
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        $movies = $query->latest()->paginate(12);
        $categories = Category::withCount('movies')->get();
        
        return view('movies.index', compact('movies', 'categories'));
    }

    /**
     * Display the specified movie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::with(['category', 'genres'])->findOrFail($id);
        
        // Tăng lượt xem
        $movie->increment('views');
        
        // Lấy phim liên quan (cùng danh mục)
        $relatedMovies = Movie::with('category')
            ->where('category_id', $movie->category_id)
            ->where('id', '!=', $movie->id)
            ->where('status', 'published')
            ->take(4)
            ->get();
            
        return view('movies.show', compact('movie', 'relatedMovies'));
    }
}
