@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add a Movie</h1>

    <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') }}">
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <select class="form-select" id="rating" name="rating">
                <option value="">Not rated</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }} ★</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Poster Image</label>
            <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
        </div>
        <div class="mb-3">
    <label for="review" class="form-label">Your Review (optional)</label>
    <textarea class="form-control" id="review" name="review" rows="4" placeholder="Write your thoughts about this movie...">{{ old('review') }}</textarea>
</div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection