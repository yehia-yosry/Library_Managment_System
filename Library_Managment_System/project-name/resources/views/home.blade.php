@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <form method="get" action="{{ route('home') }}" class="mb-3">
            <div class="input-group">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search title, ISBN, or author">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                <button class="btn btn-outline-secondary">Search</button>
            </div>
        </form>

        <h5>Categories</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item {{ request('category') ? '' : 'active' }}"><a href="{{ route('home') }}" class="text-decoration-none {{ request('category') ? '' : 'text-white' }}">All</a></li>
            @foreach($categories as $cat)
                <li class="list-group-item {{ request('category') == $cat->CategoryID ? 'active' : '' }}">
                    <a href="?category={{ $cat->CategoryID }}&q={{ urlencode(request('q')) }}" class="text-decoration-none {{ request('category') == $cat->CategoryID ? 'text-white' : '' }}">{{ $cat->CategoryName }}</a>
                </li>
            @endforeach
        </ul>

        <h5>Cart Summary</h5>
        @if (count($items))
            <ul class="list-group">
                @foreach ($items as $it)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $it['title'] }}
                        <span class="badge bg-primary rounded-pill">{{ $it['qty'] }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2"><strong>Total: ${{ number_format($total,2) }}</strong></div>
            <a href="{{ route('cart.view') }}" class="btn btn-sm btn-outline-primary mt-2">View Cart</a>
        @else
            <p>No items in cart.</p>
        @endif
    </div>

    <div class="col-md-9">
        <h1>Available Books</h1>

        @if(request('q'))
            <p>Showing <strong>{{ $books->total() }}</strong> result(s) for "<em>{{ request('q') }}</em>"</p>
        @endif

        <div class="row">
            @forelse ($books as $book)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->Title }}</h5>
                            <p class="card-text">ISBN: {{ $book->ISBN }}</p>
                            <p class="card-text">Category: {{ $book->category->CategoryName ?? '-' }}</p>
                            <p class="card-text">Price: ${{ number_format($book->Price, 2) }}</p>
                            <p class="card-text">Stock: {{ $book->Quantity }}</p>
                            @if($book->Quantity > 0)
                                <a href="{{ route('cart.add', $book->ISBN) }}" class="btn btn-primary">Add to cart</a>
                            @else
                                <button class="btn btn-secondary" disabled>Out of stock</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">No books found.</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $books->links() }}</div>
    </div>
</div>
@endsection