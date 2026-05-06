<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index(Request $request)
{
    $query = auth()->user()->movies();

    // Filter by status (watchlist/watched)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Search by title
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $movies = $query->latest()->get();

    return view('movies.index', compact('movies'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'year' => 'nullable|integer',
        'rating' => 'nullable|integer',
        'poster' => 'nullable|string',
        'review' => 'nullable|string|max:1000', 
    ]);

    auth()->user()->movies()->create([
        'title' => $request->title,
        'year' => $request->year,
        'rating' => $request->rating,
        'poster' => $request->poster,
        'review' => $request->review,
    ]);

    return redirect()->route('movies.index')->with('success', 'Movie added!');
}
   public function edit(Movie $movie)
{
    return view('movies.edit', compact('movie'));
}

public function update(Request $request, Movie $movie)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'year' => 'nullable|integer|min:1900|max:' . date('Y'),
        'rating' => 'nullable|integer|min:1|max:10',
        'poster' => 'nullable|image|max:2048',
        'review' => 'nullable|string|max:1000',
    ]);

   
    if ($request->hasFile('poster')) {
        $posterPath = $request->file('poster')->store('posters', 'public');
        $movie->poster = $posterPath;
    }

    $movie->update($request->only(['title', 'year', 'rating', 'review']));

    return redirect()->route('movies.index')->with('success', 'Movie updated!');
}
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie deleted!');
    }

    public function toggle(Movie $movie)
    {
        $movie->status = $movie->status === 'watchlist' ? 'watched' : 'watchlist';
        $movie->save();
        return redirect()->route('movies.index')->with('success', 'Status updated!');
    }
    public function create()
{
    return view('movies.create');
}
public function show(Movie $movie)
{
    return view('movies.show', compact('movie'));
}
}