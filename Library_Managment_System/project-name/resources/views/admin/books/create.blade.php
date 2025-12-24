@extends('admin.layouts.app')

@section('content')
    <h1>Create Book</h1>
    <form method="post" action="{{ route('admin.books.store') }}">
        @include('admin.books.form')
        <button class="btn btn-primary">Create</button>
    </form>
@endsection