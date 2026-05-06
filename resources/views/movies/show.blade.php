@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $movie->title }}</h1>
    <p>Year: {{ $movie->year }}</p>
    <p>Rating: {{ $movie->rating }} ★</p>
    <p>Status: {{ $movie->status }}</p>
    <p>Review: {{ $movie->review }}</p>
    @if($movie->poster)
        <img src="{{ filter_var($movie->poster, FILTER_VALIDATE_URL) ? $movie->poster : asset('storage/'.$movie->poster) }}" width="200">
    @endif
    <a href="{{ route('movies.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection