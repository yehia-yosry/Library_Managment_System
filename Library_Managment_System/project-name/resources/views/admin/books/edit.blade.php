@extends('admin.layouts.app')

@section('content')
    <h1>Edit Book</h1>
    <form method="post" action="{{ route('admin.books.update', $book->ISBN) }}">
        @method('PUT')
        @include('admin.books.form')
        <button class="btn btn-primary">Save</button>
    </form>
@endsection