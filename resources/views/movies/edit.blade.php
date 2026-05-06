@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Movie</h1>

    <form method="POST" action="{{ route('movies.update', $movie) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $movie->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $movie->year) }}" min="1900" max="{{ date('Y') }}">
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <select class="form-select" id="rating" name="rating">
                <option value="">Not rated</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('rating', $movie->rating) == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Poster Image (leave empty to keep current)</label>
            <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
            @if($movie->poster)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $movie->poster) }}" width="50" class="img-thumbnail">
                </div>
            @endif
        </div>
        <div class="mb-3">
    <label for="review" class="form-label">Your Review (optional)</label>
    <textarea class="form-control" id="review" name="review" rows="4" placeholder="Write your thoughts about this movie...">{{ old('review', $movie->review) }}</textarea>
</div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection