<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NewSeeder extends Seeder
{
    public function run(): void
    {


        $categories = DB::select("SELECT * FROM CATEGORY");
        if (empty($categories)) {
            echo "WARNING: No categories found. Please insert categories first!\n";
            echo "INSERT INTO CATEGORY (CategoryName) VALUES ('Science'), ('Art'), ('Religion'), ('History'), ('Geography');\n";
            return;
        }

        DB::insert(
            "INSERT INTO ADMIN (Username, Password, Email) VALUES (?, ?, ?)",
            ['admin1', Hash::make('password123'), 'admin1@bookstore.com']
        );
        DB::insert(
            "INSERT INTO ADMIN (Username, Password, Email) VALUES (?, ?, ?)",
            ['admin2', Hash::make('password123'), 'admin2@bookstore.com']
        );


        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Penguin Random House', '1745 Broadway, New York, NY 10019', '212-782-9000']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['HarperCollins', '195 Broadway, New York, NY 10007', '212-207-7000']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Simon & Schuster', '1230 Avenue of the Americas, New York, NY 10020', '212-698-7000']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Macmillan Publishers', '120 Broadway, New York, NY 10271', '646-307-5151']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Hachette Book Group', '1290 Avenue of the Americas, New York, NY 10104', '212-364-1100']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Oxford University Press', 'Great Clarendon Street, Oxford, OX2 6DP', '+44-1865-556767']
        );
        DB::insert(
            "INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES (?, ?, ?)",
            ['Cambridge University Press', 'University Printing House, Cambridge CB2 8BS', '+44-1223-358331']
        );

        $authors = [
            'Stephen King',
            'J.K. Rowling',
            'George R.R. Martin',
            'Agatha Christie',
            'Dan Brown',
            'Margaret Atwood',
            'Haruki Murakami',
            'Gabriel García Márquez',
            'Paulo Coelho',
            'Yuval Noah Harari',
            'Malcolm Gladwell',
            'Michelle Obama',
            'Barack Obama',
            'Bill Bryson',
            'Richard Dawkins',
            'Carl Sagan',
            'Neil deGrasse Tyson',
            'Leonardo da Vinci',
            'Vincent van Gogh',
            'Pablo Picasso',
            'John Smith',
            'Emily Johnson',
            'Michael Brown',
            'Sarah Davis',
            'David Wilson',
            'Jennifer Taylor',
            'Robert Anderson',
            'Lisa Thomas'
        ];

        foreach ($authors as $author) {
            DB::insert("INSERT INTO AUTHOR (AuthorName) VALUES (?)", [$author]);
        }

        $categoryIds = array_map(fn($c) => $c->CategoryID, $categories);
        $publisherIds = DB::select("SELECT PublisherID FROM PUBLISHER");
        $publisherIds = array_map(fn($p) => $p->PublisherID, $publisherIds);
        $authorIds = DB::select("SELECT AuthorID FROM AUTHOR");
        $authorIds = array_map(fn($a) => $a->AuthorID, $authorIds);

        $books = [
            // Science Books
            ['9780307887894', 'Sapiens: A Brief History of Humankind', 2011, 24.99, 45, 10, 'Science', 0, [9]],
            ['9780593418932', 'Astrophysics for People in a Hurry', 2017, 18.99, 60, 15, 'Science', 1, [16]],
            ['9780141036250', 'The Selfish Gene', 1976, 16.99, 30, 8, 'Science', 5, [14]],
            ['9780345539434', 'Cosmos', 1980, 22.99, 25, 10, 'Science', 0, [15]],
            ['9780393330403', 'A Brief History of Time', 1988, 19.99, 35, 12, 'Science', 2, [15, 16]],

            // Art Books
            ['9780714847030', 'The Story of Art', 1950, 39.99, 20, 8, 'Art', 3, [17, 18]],
            ['9780714838519', 'Leonardo da Vinci', 2006, 45.99, 15, 5, 'Art', 3, [17]],
            ['9780500204146', 'Van Gogh: The Life', 2011, 35.99, 18, 7, 'Art', 4, [18]],
            ['9780393355635', 'Picasso: Creator and Destroyer', 1988, 29.99, 22, 10, 'Art', 2, [19]],
            ['9780714869735', 'Modern Art 1870-2000', 1994, 42.99, 12, 5, 'Art', 3, [19, 20]],

            // Religion Books
            ['9780060935467', 'The Holy Bible (NIV)', 1978, 29.99, 100, 20, 'Religion', 1, [20]],
            ['9780385508841', 'The Alchemist', 1988, 16.99, 80, 25, 'Religion', 0, [8]],
            ['9780062316110', 'Sapiens: A Brief History of Humankind', 2011, 24.99, 40, 15, 'Religion', 1, [9]],
            ['9780143127741', 'The Power of Now', 1997, 17.99, 55, 18, 'Religion', 0, [21]],
            ['9780062457714', 'Becoming', 2018, 32.99, 65, 20, 'Religion', 1, [11]],

            // History Books
            ['9780385537858', 'The Guns of August', 1962, 21.99, 28, 10, 'History', 0, [12]],
            ['9781476746838', 'Team of Rivals', 2005, 27.99, 32, 12, 'History', 2, [22]],
            ['9780679783190', 'A People\'s History', 1980, 23.99, 25, 10, 'History', 0, [23]],
            ['9780743273565', 'John Adams', 2001, 26.99, 30, 11, 'History', 2, [24]],
            ['9780375424441', 'The Rise and Fall of the Third Reich', 1960, 35.99, 20, 8, 'History', 0, [25]],

            // Geography Books
            ['9780767908184', 'A Walk in the Woods', 1998, 18.99, 42, 15, 'Geography', 0, [13]],
            ['9780767919388', 'In a Sunburned Country', 2000, 19.99, 38, 14, 'Geography', 0, [13]],
            ['9780385537865', 'The Lost City of Z', 2009, 22.99, 27, 10, 'Geography', 0, [26]],
            ['9780307387981', 'Into Thin Air', 1997, 20.99, 33, 12, 'Geography', 0, [27]],
            ['9780375507250', 'The Worst Journey in the World', 1922, 24.99, 18, 7, 'Geography', 0, [28]],

            // Additional books for testing (varied quantities to trigger orders)
            ['9780141439518', 'Pride and Prejudice', 1813, 14.99, 3, 10, 'Art', 5, [1, 2]],
            ['9780061120084', 'To Kill a Mockingbird', 1960, 15.99, 7, 15, 'History', 1, [3]],
            ['9780451524935', '1984', 1949, 16.99, 2, 8, 'History', 2, [4]],
            ['9780316769488', 'The Catcher in the Rye', 1951, 13.99, 5, 12, 'Art', 4, [5]],
            ['9780140283334', 'The Great Gatsby', 1925, 12.99, 4, 10, 'History', 5, [6]]
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat->CategoryName] = $cat->CategoryID;
        }

        foreach ($books as $book) {
            $isbn = $book[0];
            $title = $book[1];
            $year = $book[2];
            $price = $book[3];
            $quantity = $book[4];
            $threshold = $book[5];
            $categoryName = $book[6];
            $publisherIndex = $book[7];
            $authorIndices = $book[8];

            $categoryId = $categoryMap[$categoryName];
            $publisherId = $publisherIds[$publisherIndex];

            // Insert book
            DB::insert("INSERT INTO BOOK (ISBN, Title, PublicationYear, Price, Quantity, Threshold, CategoryID, PublisherID) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                [$isbn, $title, $year, $price, $quantity, $threshold, $categoryId, $publisherId]
            );

            // Insert book authors
            foreach ($authorIndices as $authorIndex) {
                $authorId = $authorIds[$authorIndex];
                DB::insert("INSERT INTO BOOK_AUTHOR (ISBN, AuthorID) VALUES (?, ?)", [$isbn, $authorId]);
            }
        }

        $customers = [
            ['john_doe', 'John', 'Doe', 'john.doe@email.com', '555-0101', '123 Main St, New York, NY 10001'],
            ['jane_smith', 'Jane', 'Smith', 'jane.smith@email.com', '555-0102', '456 Oak Ave, Los Angeles, CA 90001'],
            ['bob_johnson', 'Bob', 'Johnson', 'bob.johnson@email.com', '555-0103', '789 Pine Rd, Chicago, IL 60601'],
            ['alice_williams', 'Alice', 'Williams', 'alice.williams@email.com', '555-0104', '321 Elm St, Houston, TX 77001'],
            ['charlie_brown', 'Charlie', 'Brown', 'charlie.brown@email.com', '555-0105', '654 Maple Dr, Phoenix, AZ 85001'],
            ['diana_davis', 'Diana', 'Davis', 'diana.davis@email.com', '555-0106', '987 Cedar Ln, Philadelphia, PA 19019'],
            ['edward_miller', 'Edward', 'Miller', 'edward.miller@email.com', '555-0107', '147 Birch Ct, San Antonio, TX 78201'],
            ['fiona_wilson', 'Fiona', 'Wilson', 'fiona.wilson@email.com', '555-0108', '258 Spruce Way, San Diego, CA 92101'],
            ['george_moore', 'George', 'Moore', 'george.moore@email.com', '555-0109', '369 Ash Blvd, Dallas, TX 75201'],
            ['hannah_taylor', 'Hannah', 'Taylor', 'hannah.taylor@email.com', '555-0110', '741 Willow Path, San Jose, CA 95101']
        ];

        foreach ($customers as $customer) {
            DB::insert("INSERT INTO CUSTOMER (Username, Password, FirstName, LastName, Email, PhoneNumber, ShippingAddress) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$customer[0], Hash::make('password123'), $customer[1], $customer[2], $customer[3], $customer[4], $customer[5]]
            );
        }

        // Get customer IDs
        $customerIds = DB::select("SELECT CustomerID FROM CUSTOMER");
        $customerIds = array_map(fn($c) => $c->CustomerID, $customerIds);

        // Get book ISBNs
        $bookIsbns = DB::select("SELECT ISBN FROM BOOK LIMIT 20");
        $bookIsbns = array_map(fn($b) => $b->ISBN, $bookIsbns);

        $orderDates = [
            // 4 months ago
            date('Y-m-d H:i:s', strtotime('-120 days')),
            date('Y-m-d H:i:s', strtotime('-115 days')),
            date('Y-m-d H:i:s', strtotime('-110 days')),
            // 3 months ago
            date('Y-m-d H:i:s', strtotime('-90 days')),
            date('Y-m-d H:i:s', strtotime('-85 days')),
            date('Y-m-d H:i:s', strtotime('-80 days')),
            // 2 months ago
            date('Y-m-d H:i:s', strtotime('-60 days')),
            date('Y-m-d H:i:s', strtotime('-55 days')),
            date('Y-m-d H:i:s', strtotime('-50 days')),
            // Last month
            date('Y-m-d H:i:s', strtotime('-35 days')),
            date('Y-m-d H:i:s', strtotime('-30 days')),
            date('Y-m-d H:i:s', strtotime('-25 days')),
            // This month
            date('Y-m-d H:i:s', strtotime('-15 days')),
            date('Y-m-d H:i:s', strtotime('-10 days')),
            date('Y-m-d H:i:s', strtotime('-5 days')),
            date('Y-m-d H:i:s', strtotime('-2 days')),
            date('Y-m-d H:i:s', strtotime('-1 days')),
            // Today
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ];

        $orderCounter = 1;
        foreach ($orderDates as $orderDate) {
            $customerId = $customerIds[array_rand($customerIds)];
            $totalPrice = rand(50, 300) + (rand(0, 99) / 100);
            $creditCard = '4' . str_pad(rand(0, 999999999999999), 15, '0', STR_PAD_LEFT);
            $expiryDate = date('Y-m-d', strtotime('+' . rand(1, 5) . ' years'));

            DB::insert("INSERT INTO CUSTOMER_ORDER (CustomerID, OrderDate, TotalPrice, CreditCardNumber, ExpiryDate) 
                       VALUES (?, ?, ?, ?, ?)",
                [$customerId, $orderDate, $totalPrice, $creditCard, $expiryDate]
            );

            $orderId = DB::getPdo()->lastInsertId();

            // Add 1-4 items to each order
            $numItems = rand(1, 4);
            $orderTotal = 0;

            for ($i = 0; $i < $numItems; $i++) {
                $isbn = $bookIsbns[array_rand($bookIsbns)];
                $quantity = rand(1, 3);

                // Check if this ISBN already in this order
                $existing = DB::select("SELECT * FROM ORDER_ITEM WHERE OrderID = ? AND ISBN = ?", [$orderId, $isbn]);
                if (empty($existing)) {
                    DB::insert(
                        "INSERT INTO ORDER_ITEM (OrderID, ISBN, Quantity) VALUES (?, ?, ?)",
                        [$orderId, $isbn, $quantity]
                    );
                }
            }

            $orderCounter++;
        }

        for ($i = 0; $i < 3; $i++) {
            $customerId = $customerIds[$i];

            DB::insert("INSERT INTO SHOPPING_CART (CustomerID, Date) VALUES (?, NOW())", [$customerId]);
            $cartId = DB::getPdo()->lastInsertId();

            // Add 1-3 items to cart
            $numItems = rand(1, 3);
            for ($j = 0; $j < $numItems; $j++) {
                $isbn = $bookIsbns[array_rand($bookIsbns)];
                $quantity = rand(1, 2);

                // Check if this ISBN already in this cart
                $existing = DB::select("SELECT * FROM CART_ITEM WHERE CartID = ? AND ISBN = ?", [$cartId, $isbn]);
                if (empty($existing)) {
                    DB::insert(
                        "INSERT INTO CART_ITEM (CartID, ISBN, Quantity) VALUES (?, ?, ?)",
                        [$cartId, $isbn, $quantity]
                    );
                }
            }
        }

        $replenishmentOrders = [
            [$bookIsbns[0], $publisherIds[0], date('Y-m-d H:i:s', strtotime('-10 days')), 50, 'Confirmed'],
            [$bookIsbns[1], $publisherIds[1], date('Y-m-d H:i:s', strtotime('-8 days')), 50, 'Confirmed'],
            [$bookIsbns[2], $publisherIds[2], date('Y-m-d H:i:s', strtotime('-5 days')), 50, 'Pending'],
            [$bookIsbns[3], $publisherIds[0], date('Y-m-d H:i:s', strtotime('-3 days')), 50, 'Pending'],
            [$bookIsbns[4], $publisherIds[1], date('Y-m-d H:i:s', strtotime('-1 days')), 50, 'Pending'],
        ];

        foreach ($replenishmentOrders as $order) {
            DB::insert("INSERT INTO REPLENISHMENT_ORDER (ISBN, PublisherID, OrderDate, Quantity, Status) 
                       VALUES (?, ?, ?, ?, ?)",
                $order
            );
        }

        echo "✓ Seeded " . count($replenishmentOrders) . " Replenishment Orders\n";

        echo "\n=== SEEDING COMPLETED SUCCESSFULLY ===\n";
        echo "Total records created:\n";
        echo "- Admins: 2\n";
        echo "- Publishers: 7\n";
        echo "- Authors: " . count($authors) . "\n";
        echo "- Books: " . count($books) . "\n";
        echo "- Customers: " . count($customers) . "\n";
        echo "- Customer Orders: " . count($orderDates) . "\n";
        echo "- Shopping Carts: 3\n";
        echo "- Replenishment Orders: " . count($replenishmentOrders) . "\n";
        echo "\nLogin credentials:\n";
        echo "Admin: admin1 / password123\n";
        echo "Customer: john_doe / password123\n";
    }
}