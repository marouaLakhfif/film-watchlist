@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search for a Movie Review</h1>

    <form method="GET" action="{{ route('movies.search.submit') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="title" class="form-control" placeholder="Enter movie title (e.g., Gone Girl)" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @if(isset($movie) && !isset($movie['Error']))
        <div class="card">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x400?text=No+Poster' }}" class="img-fluid rounded-start" alt="{{ $movie['Title'] }}">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie['Title'] }} ({{ $movie['Year'] }})</h5>
                        <p><strong>Rating:</strong> {{ $movie['imdbRating'] }}/10</p>
                        <p><strong>Plot:</strong> {{ $movie['Plot'] }}</p>
                        <p><strong>Director:</strong> {{ $movie['Director'] }}</p>
                        <p><strong>Actors:</strong> {{ $movie['Actors'] }}</p>

                        <!-- ADD REVIEW TEXTAREA -->
                        <form method="POST" action="{{ route('movies.store') }}">
                            @csrf
                            <input type="hidden" name="title" value="{{ $movie['Title'] }}">
                            <input type="hidden" name="year" value="{{ $movie['Year'] }}">
                            <input type="hidden" name="rating" value="{{ round((float)$movie['imdbRating']) }}">
                            <input type="hidden" name="poster" value="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : '' }}">

                            <div class="mb-3">
                                <label for="review" class="form-label">Your Review (optional)</label>
                                <textarea class="form-control" id="review" name="review" rows="3" placeholder="Write your thoughts about this movie..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Add to My Watchlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection