<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $query = Book::with(['category','publisher','authors']);

        // search by title, ISBN, or author name
        if ($search = request('q')) {
            $query->where(function($qry) use ($search) {
                $qry->where('Title', 'like', "%{$search}%")
                    ->orWhere('ISBN', 'like', "%{$search}%")
                    ->orWhereHas('authors', function($a) use ($search) {
                        $a->where('AuthorName', 'like', "%{$search}%");
                    });
            });
        }

        // filter by category if provided
        if ($cat = request('category')) {
            $query->where('CategoryID', $cat);
        }

        // paginate and preserve query string
        $books = $query->paginate(9)->withQueryString();

        // categories for filtering
        $categories = \App\Models\Category::all();

        // get session cart summary
        $cart = session('cart', []);
        $items = array_values($cart);
        $total = 0;
        foreach ($items as $it) {
            $total += $it['price'] * $it['qty'];
        }

        return view('home', compact('books','items','total','categories'));
    }
}
