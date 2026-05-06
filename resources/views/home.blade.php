@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1> Welcome to Film Watchlist</h1>
    <p class="lead">Track movies you want to watch and rate them.</p>

    @guest
        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Login</a>
    @else
        <a href="{{ route('movies.index') }}" class="btn btn-primary">Go to My Movies</a>
    @endguest
</div>
@endsection