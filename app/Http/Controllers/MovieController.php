<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic để lấy danh sách phim, tạm thời trả về view rỗng
        return view('movies.index');
    }

    /**
     * Display the specified movie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Logic để lấy thông tin phim theo ID, tạm thời trả về view rỗng
        return view('movies.show', ['movieId' => $id]);
    }
}
