<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')->latest()->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $categories = Category::with('genres')->get();
        $genres = \App\Models\Genre::all();
        return view('admin.movies.create', compact('categories', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'required|string',
            'duration' => 'nullable|string|max:20',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'status' => ['required', Rule::in(['published', 'draft'])],
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $youtubeVideoId = $this->extractYouTubeVideoId($validated['video_url']);
        if (!$youtubeVideoId) {
            return back()->withErrors(['video_url' => 'URL YouTube không hợp lệ.'])->withInput();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['youtube_video_id'] = $youtubeVideoId;
        unset($validated['video_url']);

        // Lấy thời lượng từ YouTube nếu có video ID
        $duration = $this->getYoutubeDuration($youtubeVideoId);
        if ($duration) {
            $validated['duration'] = $duration;
        }

        $movie = Movie::create($validated);
        if (!empty($validated['genres'])) {
            $movie->genres()->sync($validated['genres']);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được thêm thành công.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Movie $movie)
    {
        $categories = Category::with('genres')->get();
        $genres = \App\Models\Genre::all();
        $selectedGenres = $movie->genres->pluck('id')->toArray();
        return view('admin.movies.edit', compact('movie', 'categories', 'genres', 'selectedGenres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'video_url' => 'required|string',
            'duration' => 'nullable|string|max:20',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'status' => ['required', Rule::in(['published', 'draft'])],
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $youtubeVideoId = $this->extractYouTubeVideoId($validated['video_url']);
        if (!$youtubeVideoId) {
            return back()->withErrors(['video_url' => 'URL YouTube không hợp lệ.'])->withInput();
        }

        if ($request->hasFile('thumbnail')) {
            if ($movie->thumbnail) {
                Storage::disk('public')->delete($movie->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($validated['thumbnail']);
        }

        $validated['youtube_video_id'] = $youtubeVideoId;
        unset($validated['video_url']);

        // Lấy thời lượng từ YouTube nếu có video ID
        $duration = $this->getYoutubeDuration($youtubeVideoId);
        if ($duration) {
            $validated['duration'] = $duration;
        }

        $movie->update($validated);
        $movie->genres()->sync($validated['genres'] ?? []);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được cập nhật thành công.');
    }

    public function destroy(Movie $movie)
    {
        // Xóa thumbnail file
        if ($movie->thumbnail) {
            Storage::disk('public')->delete($movie->thumbnail);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được xóa thành công.');
    }

    /**
     * Trích xuất YouTube video ID từ URL
     */
    private function extractYouTubeVideoId($url)
    {
        // Nếu đã là video ID (11 ký tự)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Xử lý các dạng URL YouTube khác nhau
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Lấy thời lượng video từ YouTube API
     */
    private function getYoutubeDuration($videoId)
    {
        $apiKey = config('services.youtube.api_key');
        if (!$apiKey) return null;
        $url = "https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id={$videoId}&key={$apiKey}";
        $response = Http::get($url);
        if ($response->ok() && isset($response['items'][0]['contentDetails']['duration'])) {
            return $this->convertYoutubeDuration($response['items'][0]['contentDetails']['duration']);
        }
        return null;
    }

    /**
     * Chuyển đổi định dạng ISO 8601 duration sang dạng 1h 23m
     */
    private function convertYoutubeDuration($isoDuration)
    {
        $interval = new \DateInterval($isoDuration);
        $parts = [];
        if ($interval->h > 0) $parts[] = $interval->h . 'h';
        if ($interval->i > 0) $parts[] = $interval->i . 'm';
        if ($interval->h == 0 && $interval->i == 0 && $interval->s > 0) $parts[] = $interval->s . 's';
        return implode(' ', $parts);
    }
} 