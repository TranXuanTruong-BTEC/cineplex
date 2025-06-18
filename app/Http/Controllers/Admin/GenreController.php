<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::with('categories')->get();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.genres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:genres',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);
        $genre = Genre::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);
        if (!empty($validated['categories'])) {
            $genre->categories()->sync($validated['categories']);
        }
        return redirect()->route('admin.genres.index')->with('success', 'Thể loại đã được tạo thành công.');
    }

    public function edit(Genre $genre)
    {
        $categories = Category::all();
        $selected = $genre->categories->pluck('id')->toArray();
        return view('admin.genres.edit', compact('genre', 'categories', 'selected'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:genres,name,' . $genre->id,
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);
        $genre->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);
        $genre->categories()->sync($validated['categories'] ?? []);
        return redirect()->route('admin.genres.index')->with('success', 'Thể loại đã được cập nhật thành công.');
    }

    public function destroy(Genre $genre)
    {
        $genre->categories()->detach();
        $genre->movies()->detach();
        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Thể loại đã được xóa.');
    }
} 