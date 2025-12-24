@extends('admin.layouts.app')

@section('content')
    <h1>{{ $book->Title }}</h1>
    <p><strong>ISBN:</strong> {{ $book->ISBN }}</p>
    <p><strong>Price:</strong> ${{ number_format($book->Price,2) }}</p>
    <p><strong>Stock:</strong> {{ $book->Quantity }}</p>
    <p><strong>Category:</strong> {{ $book->category->CategoryName ?? '-' }}</p>
    <p><strong>Publisher:</strong> {{ $book->publisher->Name ?? '-' }}</p>
@endsection