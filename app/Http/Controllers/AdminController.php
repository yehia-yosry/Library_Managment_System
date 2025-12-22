<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // ==================== 1. ADD NEW BOOKS ====================

    // Show form to add new book
    public function createBook()
    {
        // Get all categories for dropdown
        $categories = DB::select("SELECT * FROM CATEGORY");

        // Get all publishers for dropdown
        $publishers = DB::select("SELECT * FROM PUBLISHER");

        // Get all authors for dropdown
        $authors = DB::select("SELECT * FROM AUTHOR");

        return view('admin.books.create', compact('categories', 'publishers', 'authors'));
    }

    // Store new book with full integrity validation
    public function storeBook(Request $request)
    {
        // Manual validation
        $errors = [];

        // Validate ISBN
        if (empty($request->isbn)) {
            $errors[] = "ISBN is required";
        } elseif (strlen($request->isbn) != 13) {
            $errors[] = "ISBN must be 13 characters";
        }

        // Validate Title
        if (empty($request->title)) {
            $errors[] = "Title is required";
        }

        // Validate Publication Year
        if (empty($request->publication_year)) {
            $errors[] = "Publication year is required";
        } elseif (!is_numeric($request->publication_year)) {
            $errors[] = "Publication year must be numeric";
        }

        // Validate Price
        if (empty($request->price)) {
            $errors[] = "Price is required";
        } elseif (!is_numeric($request->price) || $request->price < 0) {
            $errors[] = "Price must be a positive number";
        }

        // Validate Quantity
        if (!isset($request->quantity)) {
            $errors[] = "Quantity is required";
        } elseif (!is_numeric($request->quantity) || $request->quantity < 0) {
            $errors[] = "Quantity must be a non-negative number";
        }

        // Validate Threshold
        if (!isset($request->threshold)) {
            $errors[] = "Threshold is required";
        } elseif (!is_numeric($request->threshold) || $request->threshold < 0) {
            $errors[] = "Threshold must be a non-negative number";
        }

        // Validate Category
        if (empty($request->category_id)) {
            $errors[] = "Category is required";
        }

        // Validate Publisher
        if (empty($request->publisher_id)) {
            $errors[] = "Publisher is required";
        }

        // Validate Authors
        if (empty($request->author_ids)) {
            $errors[] = "At least one author is required";
        }

        // If there are validation errors, return back
        if (!empty($errors)) {
            return redirect()->back()->with('error', implode('<br>', $errors))->withInput();
        }

        try {
            DB::beginTransaction();

            // Check if ISBN already exists
            $existing = DB::select("SELECT ISBN FROM BOOK WHERE ISBN = ?", [$request->isbn]);
            if (!empty($existing)) {
                throw new Exception("Book with this ISBN already exists");
            }

            // Insert book
            DB::insert("INSERT INTO BOOK (ISBN, Title, PublicationYear, Price, Quantity, Threshold, CategoryID, PublisherID) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $request->isbn,
                    $request->title,
                    $request->publication_year,
                    $request->price,
                    $request->quantity,
                    $request->threshold,
                    $request->category_id,
                    $request->publisher_id
                ]
            );

            // Insert book-author relationships
            foreach ($request->author_ids as $author_id) {
                DB::insert(
                    "INSERT INTO BOOK_AUTHOR (ISBN, AuthorID) VALUES (?, ?)",
                    [$request->isbn, $author_id]
                );
            }

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Book added successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    // ==================== 2. MODIFY EXISTING BOOKS ====================

    // Search for book to edit
    public function searchBookForEdit(Request $request)
    {
        $books = [];
        $search_term = $request->search;

        if (!empty($search_term)) {
            // Search by ISBN or Title
            $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                FROM BOOK B
                                JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                WHERE B.ISBN LIKE ? OR B.Title LIKE ?",
                ['%' . $search_term . '%', '%' . $search_term . '%']
            );
        }

        return view('admin.books.search', compact('books', 'search_term'));
    }

    // Show edit form for specific book
    public function editBook($isbn)
    {
        // Get book details
        $book = DB::select("SELECT * FROM BOOK WHERE ISBN = ?", [$isbn]);

        if (empty($book)) {
            return redirect()->route('admin.books.search')->with('error', 'Book not found');
        }

        $book = $book[0];

        // Get categories
        $categories = DB::select("SELECT * FROM CATEGORY");

        // Get publishers
        $publishers = DB::select("SELECT * FROM PUBLISHER");

        // Get all authors
        $authors = DB::select("SELECT * FROM AUTHOR");

        // Get current authors for this book
        $current_authors = DB::select("SELECT AuthorID FROM BOOK_AUTHOR WHERE ISBN = ?", [$isbn]);
        $current_author_ids = array_map(function ($a) {
            return $a->AuthorID;
        }, $current_authors);

        return view('admin.books.edit', compact('book', 'categories', 'publishers', 'authors', 'current_author_ids'));
    }

    // Update book details
    public function updateBook(Request $request, $isbn)
    {
        // Manual validation
        $errors = [];

        if (!empty($request->title) && empty(trim($request->title))) {
            $errors[] = "Title cannot be empty";
        }

        if (!empty($request->publication_year) && !is_numeric($request->publication_year)) {
            $errors[] = "Publication year must be numeric";
        }

        if (!empty($request->price) && (!is_numeric($request->price) || $request->price < 0)) {
            $errors[] = "Price must be a positive number";
        }

        if (isset($request->quantity)) {
            if (!is_numeric($request->quantity) || $request->quantity < 0) {
                $errors[] = "Quantity must be a non-negative number";
            }
        }

        if (isset($request->threshold) && (!is_numeric($request->threshold) || $request->threshold < 0)) {
            $errors[] = "Threshold must be a non-negative number";
        }

        if (!empty($errors)) {
            return redirect()->back()->with('error', implode('<br>', $errors))->withInput();
        }

        try {
            DB::beginTransaction();

            // Build dynamic update query based on provided fields
            $updates = [];
            $params = [];

            if (!empty($request->title)) {
                $updates[] = "Title = ?";
                $params[] = $request->title;
            }

            if (!empty($request->publication_year)) {
                $updates[] = "PublicationYear = ?";
                $params[] = $request->publication_year;
            }

            if (!empty($request->price)) {
                $updates[] = "Price = ?";
                $params[] = $request->price;
            }

            if (isset($request->quantity)) {
                $updates[] = "Quantity = ?";
                $params[] = $request->quantity;
            }

            if (isset($request->threshold)) {
                $updates[] = "Threshold = ?";
                $params[] = $request->threshold;
            }

            if (!empty($request->category_id)) {
                $updates[] = "CategoryID = ?";
                $params[] = $request->category_id;
            }

            if (!empty($request->publisher_id)) {
                $updates[] = "PublisherID = ?";
                $params[] = $request->publisher_id;
            }

            // Execute update if there are changes
            if (!empty($updates)) {
                $params[] = $isbn;
                $sql = "UPDATE BOOK SET " . implode(", ", $updates) . " WHERE ISBN = ?";
                DB::update($sql, $params);
            }

            // Update authors if provided
            if (!empty($request->author_ids)) {
                // Delete existing author relationships
                DB::delete("DELETE FROM BOOK_AUTHOR WHERE ISBN = ?", [$isbn]);

                // Insert new author relationships
                foreach ($request->author_ids as $author_id) {
                    DB::insert(
                        "INSERT INTO BOOK_AUTHOR (ISBN, AuthorID) VALUES (?, ?)",
                        [$isbn, $author_id]
                    );
                }
            }

            DB::commit();
            return redirect()->route('admin.books.search')->with('success', 'Book updated successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    // ==================== 4. CONFIRM ORDERS ====================

    // List all pending replenishment orders
    public function listOrders()
    {
        // Get all pending orders with book and publisher details
        $orders = DB::select("SELECT RO.*, B.Title, B.Quantity as CurrentStock, P.Name as PublisherName
                             FROM REPLENISHMENT_ORDER RO
                             JOIN BOOK B ON RO.ISBN = B.ISBN
                             JOIN PUBLISHER P ON RO.PublisherID = P.PublisherID
                             ORDER BY RO.Status ASC, RO.OrderDate DESC");

        return view('admin.orders.list', compact('orders'));
    }

    // Confirm order and update stock
    public function confirmOrder($id)
    {
        try {
            DB::beginTransaction();

            // Get order details
            $order = DB::select("SELECT * FROM REPLENISHMENT_ORDER WHERE ReplenishmentOrderID = ? AND Status = 'Pending'", [$id]);

            if (empty($order)) {
                throw new Exception("Order not found or already confirmed");
            }

            $order = $order[0];

            // Update order status to Confirmed
            DB::update("UPDATE REPLENISHMENT_ORDER SET Status = 'Confirmed' WHERE ReplenishmentOrderID = ?", [$id]);

            // Add ordered quantity to book stock
            DB::update(
                "UPDATE BOOK SET Quantity = Quantity + ? WHERE ISBN = ?",
                [$order->Quantity, $order->ISBN]
            );

            DB::commit();
            return redirect()->route('admin.orders.list')->with('success', 'Order confirmed and stock updated');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ==================== 5. SEARCH FOR BOOKS ====================

    // General search for books
    public function searchBooks(Request $request)
    {
        $books = [];
        $search_type = $request->search_type;
        $search_term = $request->search_term;

        if (!empty($search_term)) {
            try {
                if ($search_type == 'isbn') {
                    // Search by ISBN
                    $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                        FROM BOOK B
                                        JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                        JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                        WHERE B.ISBN = ?", [$search_term]);

                } elseif ($search_type == 'title') {
                    // Search by Title
                    $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                        FROM BOOK B
                                        JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                        JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                        WHERE B.Title LIKE ?", ['%' . $search_term . '%']);

                } elseif ($search_type == 'category') {
                    // Search by Category
                    $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                        FROM BOOK B
                                        JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                        JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                        WHERE C.CategoryName = ?", [$search_term]);

                } elseif ($search_type == 'author') {
                    // Search by Author
                    $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                        FROM BOOK B
                                        JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                        JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                        JOIN BOOK_AUTHOR BA ON B.ISBN = BA.ISBN
                                        JOIN AUTHOR A ON BA.AuthorID = A.AuthorID
                                        WHERE A.AuthorName LIKE ?", ['%' . $search_term . '%']);

                } elseif ($search_type == 'publisher') {
                    // Search by Publisher
                    $books = DB::select("SELECT B.*, C.CategoryName, P.Name as PublisherName 
                                        FROM BOOK B
                                        JOIN CATEGORY C ON B.CategoryID = C.CategoryID
                                        JOIN PUBLISHER P ON B.PublisherID = P.PublisherID
                                        WHERE P.Name LIKE ?", ['%' . $search_term . '%']);
                }

                // Get authors for each book
                foreach ($books as $book) {
                    $authors = DB::select("SELECT A.AuthorName 
                                          FROM AUTHOR A
                                          JOIN BOOK_AUTHOR BA ON A.AuthorID = BA.AuthorID
                                          WHERE BA.ISBN = ?", [$book->ISBN]);
                    $book->authors = implode(', ', array_map(function ($a) {
                        return $a->AuthorName;
                    }, $authors));
                }

            } catch (Exception $e) {
                return view('admin.books.search-general', [
                    'books' => [],
                    'search_type' => $search_type,
                    'search_term' => $search_term,
                    'error' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return view('admin.books.search-general', compact('books', 'search_type', 'search_term'));
    }

    // ==================== 6. SYSTEM REPORTS ====================

    // Reports menu
    public function reportsMenu()
    {
        return view('admin.reports.menu');
    }

    // a) Total sales for previous month
    public function previousMonthSales()
    {
        // Calculate previous month date range
        $first_day_previous_month = DB::select("SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01') as date")[0]->date;
        $last_day_previous_month = DB::select("SELECT LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) as date")[0]->date;

        // Get total sales for previous month
        $result = DB::select("SELECT COALESCE(SUM(TotalPrice), 0) as total_sales
                             FROM CUSTOMER_ORDER
                             WHERE OrderDate >= ? AND OrderDate <= ?",
            [$first_day_previous_month, $last_day_previous_month]
        );

        $total_sales = $result[0]->total_sales;

        return view('admin.reports.previous-month', compact('total_sales', 'first_day_previous_month', 'last_day_previous_month'));
    }

    // b) Show form for specific day sales
    public function specificDaySalesForm()
    {
        return view('admin.reports.specific-day-form');
    }

    // b) Total sales for specific day
    public function specificDaySales(Request $request)
    {
        if (empty($request->date)) {
            return redirect()->back()->with('error', 'Please select a date');
        }

        $date = $request->date;

        // Get total sales for the specific date
        $result = DB::select("SELECT COALESCE(SUM(TotalPrice), 0) as total_sales
                             FROM CUSTOMER_ORDER
                             WHERE DATE(OrderDate) = ?",
            [$date]
        );

        $total_sales = $result[0]->total_sales;

        return view('admin.reports.specific-day', compact('total_sales', 'date'));
    }

    // c) Top 5 customers for last 3 months
    public function topCustomers()
    {
        // Calculate date 3 months ago
        $three_months_ago = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 3 MONTH) as date")[0]->date;

        // Get top 5 customers by total purchase amount
        $customers = DB::select("SELECT C.CustomerID, C.FirstName, C.LastName, C.Email, 
                                       COALESCE(SUM(CO.TotalPrice), 0) as total_spent
                                FROM CUSTOMER C
                                LEFT JOIN CUSTOMER_ORDER CO ON C.CustomerID = CO.CustomerID
                                WHERE CO.OrderDate >= ? OR CO.OrderDate IS NULL
                                GROUP BY C.CustomerID, C.FirstName, C.LastName, C.Email
                                HAVING total_spent > 0
                                ORDER BY total_spent DESC
                                LIMIT 5",
            [$three_months_ago]
        );

        return view('admin.reports.top-customers', compact('customers', 'three_months_ago'));
    }

    // d) Top 10 selling books for last 3 months
    public function topBooks()
    {
        // Calculate date 3 months ago
        $three_months_ago = DB::select("SELECT DATE_SUB(CURDATE(), INTERVAL 3 MONTH) as date")[0]->date;

        // Get top 10 books by total copies sold
        $books = DB::select("SELECT B.ISBN, B.Title, COALESCE(SUM(OI.Quantity), 0) as total_sold
                            FROM BOOK B
                            LEFT JOIN ORDER_ITEM OI ON B.ISBN = OI.ISBN
                            LEFT JOIN CUSTOMER_ORDER CO ON OI.OrderID = CO.OrderID
                            WHERE CO.OrderDate >= ? OR CO.OrderDate IS NULL
                            GROUP BY B.ISBN, B.Title
                            HAVING total_sold > 0
                            ORDER BY total_sold DESC
                            LIMIT 10",
            [$three_months_ago]
        );

        return view('admin.reports.top-books', compact('books', 'three_months_ago'));
    }

    // e) Show form for book order count
    public function bookOrdersForm()
    {
        return view('admin.reports.book-orders-form');
    }

    // e) Total number of times a specific book has been ordered (replenishment)
    public function bookOrdersCount(Request $request)
    {
        if (empty($request->isbn)) {
            return redirect()->back()->with('error', 'Please enter an ISBN');
        }

        $isbn = $request->isbn;

        // Check if book exists
        $book = DB::select("SELECT * FROM BOOK WHERE ISBN = ?", [$isbn]);

        if (empty($book)) {
            return redirect()->back()->with('error', 'Book not found');
        }

        $book = $book[0];

        // Count total replenishment orders for this book
        $result = DB::select("SELECT COUNT(*) as order_count
                             FROM REPLENISHMENT_ORDER
                             WHERE ISBN = ?",
            [$isbn]
        );

        $order_count = $result[0]->order_count;

        return view('admin.reports.book-orders', compact('book', 'order_count', 'isbn'));
    }
}