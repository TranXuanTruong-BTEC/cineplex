<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')->latest()->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.movies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'required|url',
            'duration' => 'required|string|max:20',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'status' => ['required', Rule::in(['published', 'draft'])],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được thêm thành công.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        return view('admin.movies.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'video_url' => 'required|url',
            'duration' => 'required|string|max:20',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'status' => ['required', Rule::in(['published', 'draft'])],
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($movie->thumbnail) {
                Storage::disk('public')->delete($movie->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            // Keep the old thumbnail if no new file is uploaded
            unset($validated['thumbnail']);
        }

        $validated['slug'] = Str::slug($validated['title']);

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được cập nhật thành công.');
    }

    public function destroy(Movie $movie)
    {
        // Delete thumbnail file
        if ($movie->thumbnail) {
            Storage::disk('public')->delete($movie->thumbnail);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được xóa thành công.');
    }
} 