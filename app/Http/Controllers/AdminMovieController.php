<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMovieController extends Controller
{
    public function index()
    {
        return view('admin.movies.index');
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        // Xử lý thêm phim mới
        return redirect()->route('admin.movies.index');
    }

    public function edit($id)
    {
        return view('admin.movies.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật phim
        return redirect()->route('admin.movies.index');
    }

    public function destroy($id)
    {
        // Xử lý xóa phim
        return redirect()->route('admin.movies.index');
    }
} 