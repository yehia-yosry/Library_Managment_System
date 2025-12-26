<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookstoreSeeder extends Seeder {
    public function run(): void {
        DB::statement("INSERT INTO CATEGORY (CategoryName) VALUES ('Science'), ('Art'), ('Religion'), ('History'), ('Geography')");

        DB::statement("INSERT INTO PUBLISHER (Name, Address, PhoneNumber) VALUES ('Oxford Press', 'UK', '0123'), ('O-Reilly', 'USA', '4567')");
        DB::statement("INSERT INTO AUTHOR (AuthorName) VALUES ('Robert Martin'), ('Yuval Harari'), ('Stephen King')");

        $books = [
            ['9780132350884', 'Clean Code', 2008, 45.00, 50, 5, 1, 2],
            ['9780062316097', 'Sapiens', 2011, 22.00, 10, 15, 4, 1],   
            ['9780140440300', 'The Republic', 2000, 12.00, 30, 5, 2, 1] 
        ];
        foreach ($books as $b) {
            DB::statement("INSERT INTO BOOK (ISBN, Title, PublicationYear, Price, Quantity, Threshold, CategoryID, PublisherID) VALUES (?,?,?,?,?,?,?,?)", $b);
        }

        $p = Hash::make('password123');
        DB::statement("INSERT INTO ADMIN (Username, Password, Email) VALUES ('admin_yehia', '$p', 'admin@alexu.edu.eg')");
        DB::statement("INSERT INTO CUSTOMER (Username, Password, FirstName, LastName, Email, ShippingAddress) VALUES ('customer1', '$p', 'Ahmed', 'Ali', 'ahmed@test.com', 'Alexandria, Egypt')");

        DB::statement("INSERT INTO BOOK_AUTHOR (ISBN, AuthorID) VALUES ('9780132350884', 1)");
    }
}