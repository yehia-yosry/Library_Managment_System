<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category','publisher'])->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $publishers = \App\Models\Publisher::all();
        return view('admin.books.create', compact('categories','publishers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ISBN' => 'required|string|max:13|unique:BOOK,ISBN',
            'Title' => 'required|string|max:255',
            'PublicationYear' => 'nullable|integer',
            'Price' => 'nullable|numeric',
            'Quantity' => 'nullable|integer|min:0',
            'Threshold' => 'nullable|integer|min:0',
            'CategoryID' => 'nullable|integer',
            'PublisherID' => 'nullable|integer',
        ]);

        Book::create($data);

        return Redirect::route('admin.books.index')->with('success', 'Book created');
    }

    public function show($isbn)
    {
        $book = Book::with(['authors','category','publisher'])->findOrFail($isbn);
        return view('admin.books.show', compact('book'));
    }

    public function edit($isbn)
    {
        $book = Book::findOrFail($isbn);
        $categories = \App\Models\Category::all();
        $publishers = \App\Models\Publisher::all();
        return view('admin.books.edit', compact('book','categories','publishers'));
    }

    public function update(Request $request, $isbn)
    {
        $book = Book::findOrFail($isbn);
        $data = $request->validate([
            'Title' => 'required|string|max:255',
            'PublicationYear' => 'nullable|integer',
            'Price' => 'nullable|numeric',
            'Quantity' => 'nullable|integer|min:0',
            'Threshold' => 'nullable|integer|min:0',
            'CategoryID' => 'nullable|integer',
            'PublisherID' => 'nullable|integer',
        ]);

        $book->update($data);

        return Redirect::route('admin.books.index')->with('success', 'Book updated');
    }

    public function destroy($isbn)
    {
        $book = Book::findOrFail($isbn);
        $book->delete();
        return Redirect::route('admin.books.index')->with('success', 'Book deleted');
    }
}
