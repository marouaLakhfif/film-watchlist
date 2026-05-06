@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Movies</h1>
    <a href="{{ route('movies.create') }}" class="btn btn-primary mb-3">Add Movie</a>

    <!-- Search/Filter Form -->
    <form method="GET" action="{{ route('movies.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All status</option>
                <option value="watchlist" {{ request('status') == 'watchlist' ? 'selected' : '' }}>Watchlist</option>
                <option value="watched" {{ request('status') == 'watched' ? 'selected' : '' }}>Watched</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($movies->count())
        @foreach($movies as $movie)
            @php
                // Determine poster URL (local or external)
                $posterUrl = $movie->poster;
                if ($posterUrl && !filter_var($posterUrl, FILTER_VALIDATE_URL)) {
                    $posterUrl = asset('storage/' . $posterUrl);
                }
            @endphp
            <div class="list-group-item mb-2">
                <div class="d-flex align-items-center">
                    @if($posterUrl)
                        <img src="{{ $posterUrl }}" width="60" height="80" style="object-fit: cover; border-radius: 5px; margin-right: 15px;">
                    @else
                        <div style="width:60px; height:80px; background:#ddd; display:inline-flex; align-items:center; justify-content:center; border-radius:5px; margin-right:15px;"></div>
                    @endif
                    <div class="flex-grow-1">
                        <strong>{{ $movie->title }}</strong> ({{ $movie->year ?? 'N/A' }})
                        @if($movie->rating)
                            <span class="badge bg-warning text-dark ms-2">{{ $movie->rating }} </span>
                        @endif
                        <span class="badge bg-secondary ms-2">{{ ucfirst($movie->status) }}</span>
                    </div>
                    @if($movie->review)
    <div class="mt-2">
        <button class="btn btn-sm btn-link p-0 toggle-review" data-target="review-{{ $movie->id }}" style="text-decoration: none;">
             Show review
        </button>
        <div id="review-{{ $movie->id }}" class="small text-muted mt-1" style="display: none;">
            <strong>My review:</strong> {{ $movie->review }}
        </div>
    </div>
@endif
                    <div>
                        <a href="{{ route('movies.edit', $movie) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('movies.destroy', $movie) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                        <form method="POST" action="{{ route('movies.toggle', $movie) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $movie->status == 'watched' ? 'btn-success' : 'btn-outline-secondary' }}">
                                {{ $movie->status == 'watched' ? 'Watched ✓' : 'Watchlist' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No movies yet. Click "Add Movie" to start.</p>
    @endif
</div>
@endsection