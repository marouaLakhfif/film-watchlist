<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieSearchController extends Controller
{
    public function index()
    {
        return view('movies.search');
    }

    public function search(Request $request)
    {
        $title = $request->query('title');
        if (!$title) {
            return redirect()->route('movies.search');
        }

       
        $apiKey = 'af7f115';
        $response = Http::get("http://www.omdbapi.com/", [
            'apikey' => $apiKey,
            't' => $title,
            'plot' => 'short',
        ]);

        $movie = $response->json();

        if (isset($movie['Error'])) {
            return view('movies.search')->with('error', 'Movie not found!');
        }

        return view('movies.search', compact('movie'));
    }
}