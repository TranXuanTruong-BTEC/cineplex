<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy tất cả phim từ database
        $movies = Movie::all();
        // Truyền danh sách phim sang view
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo phim mới
        return view('admin.movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate dữ liệu từ request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:255',
            'release_year' => 'nullable|string|max:4',
            'duration' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'trailer_link' => 'nullable|string|max:255',
        ]);

        // Tạo phim mới trong database
        Movie::create($request->all());

        // Sau khi lưu thành công, chuyển hướng đến trang danh sách phim admin
        return redirect()->route('admin.movies.index')->with('success', 'Phim đã được thêm thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Tìm phim theo ID
        $movie = Movie::findOrFail($id);
        // Truyền thông tin phim sang view
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // Validate dữ liệu từ request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:255',
            'release_year' => 'nullable|string|max:4',
            'duration' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'trailer_link' => 'nullable|string|max:255',
        ]);
        
        // Tìm phim theo ID và cập nhật thông tin
        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        // Sau khi cập nhật thành công, chuyển hướng đến trang danh sách phim admin
        return redirect()->route('admin.movies.index')->with('success', 'Thông tin phim đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Tìm phim theo ID và xóa
        $movie = Movie::findOrFail($id);
        $movie->delete();

        // Sau khi xóa thành công, chuyển hướng đến trang danh sách phim admin
        return redirect()->route('admin.movies.index')->with('success', 'Phim đã được xóa!');
    }
}
