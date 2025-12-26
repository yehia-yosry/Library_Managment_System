<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CustomerOrder;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function add(Request $request, $isbn)
    {
        $book = Book::findOrFail($isbn);

        if ($book->Quantity <= 0) {
            return Redirect::back()->with('error', 'Book is out of stock');
        }

        $cart = session('cart', []);

        if (isset($cart[$isbn])) {
            $cart[$isbn]['qty'] = min($cart[$isbn]['qty'] + 1, $book->Quantity);
        } else {
            $cart[$isbn] = [
                'isbn' => $book->ISBN,
                'title' => $book->Title,
                'price' => (float)$book->Price,
                'qty' => 1,
            ];
        }

        session(['cart' => $cart]);

        return Redirect::back()->with('success', 'Added to cart');
    }

    public function view()
    {
        $cart = session('cart', []);
        $items = array_values($cart);
        $total = 0;
        foreach ($items as $it) {
            $total += $it['price'] * $it['qty'];
        }
        return view('cart', compact('items','total'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'qty' => 'array',
            'qty.*' => 'integer|min:0'
        ]);

        $cart = session('cart', []);
        $quantities = $data['qty'] ?? [];
        foreach ($quantities as $isbn => $q) {
            if (isset($cart[$isbn])) {
                $cart[$isbn]['qty'] = max(0, (int)$q);
                if ($cart[$isbn]['qty'] === 0) {
                    unset($cart[$isbn]);
                }
            }
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.view')->with('success', 'Cart updated');
    }

    public function remove($isbn)
    {
        $cart = session('cart', []);
        if (isset($cart[$isbn])) {
            unset($cart[$isbn]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.view')->with('success', 'Removed');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Cart empty');
        }

        // Validate stock and perform transactional checkout
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // re-check stock
            foreach ($cart as $isbn => $it) {
                $book = Book::find($isbn);
                if (!$book) {
                    throw new \Exception("Book $isbn not found");
                }
                if ($book->Quantity < $it['qty']) {
                    throw new \Exception("Not enough stock for $book->Title");
                }
            }

            $total = array_reduce($cart, fn($s,$it) => $s + $it['price'] * $it['qty'], 0);

            // Use existing seeded customer (CustomerID = 1) for checkout
            $order = CustomerOrder::create([
                'CustomerID' => 1,
                'OrderDate' => now(),
                'TotalPrice' => $total,
            ]);

            foreach ($cart as $isbn => $it) {
                OrderItem::create([
                    'OrderID' => $order->OrderID,
                    'ISBN' => $isbn,
                    'Quantity' => $it['qty'],
                ]);

                // Decrement stock
                $book = Book::find($isbn);
                $book->Quantity = max(0, $book->Quantity - $it['qty']);
                $book->save();
            }

            \Illuminate\Support\Facades\DB::commit();

            // clear session cart
            session(['cart' => []]);

            return redirect()->route('home')->with('success', 'Order placed');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->route('cart.view')->with('error', 'Checkout failed: '.$e->getMessage());
        }
    }
}
