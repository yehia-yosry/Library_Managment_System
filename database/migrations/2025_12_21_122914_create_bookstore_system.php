<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("CREATE TABLE CUSTOMER (CustomerID INT AUTO_INCREMENT PRIMARY KEY, Username VARCHAR(50) NOT NULL UNIQUE, Password VARCHAR(255) NOT NULL, FirstName VARCHAR(100), LastName VARCHAR(100), Email VARCHAR(255) UNIQUE, PhoneNumber VARCHAR(20), ShippingAddress VARCHAR(500))");
        DB::statement("CREATE TABLE ADMIN (AdminID INT AUTO_INCREMENT PRIMARY KEY, Username VARCHAR(50) NOT NULL UNIQUE, Password VARCHAR(255) NOT NULL, Email VARCHAR(255) UNIQUE)");
        DB::statement("CREATE TABLE CATEGORY (CategoryID INT AUTO_INCREMENT PRIMARY KEY, CategoryName ENUM('Science', 'Art', 'Religion', 'History', 'Geography') NOT NULL)");
        DB::statement("CREATE TABLE PUBLISHER (PublisherID INT AUTO_INCREMENT PRIMARY KEY, Name VARCHAR(255) NOT NULL, Address VARCHAR(255), PhoneNumber VARCHAR(20))");
        DB::statement("CREATE TABLE AUTHOR (AuthorID INT AUTO_INCREMENT PRIMARY KEY, AuthorName VARCHAR(255) NOT NULL)");

        DB::statement("CREATE TABLE BOOK (ISBN VARCHAR(13) PRIMARY KEY, Title VARCHAR(255) NOT NULL, PublicationYear INT, Price DECIMAL(10, 2), Quantity INT DEFAULT 0, Threshold INT DEFAULT 5, CategoryID INT, PublisherID INT, FOREIGN KEY (CategoryID) REFERENCES CATEGORY(CategoryID), FOREIGN KEY (PublisherID) REFERENCES PUBLISHER(PublisherID))");
        DB::statement("CREATE TABLE SHOPPING_CART (CartID INT AUTO_INCREMENT PRIMARY KEY, CustomerID INT, Date DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (CustomerID) REFERENCES CUSTOMER(CustomerID) ON DELETE CASCADE)");
        DB::statement("CREATE TABLE CUSTOMER_ORDER (OrderID INT AUTO_INCREMENT PRIMARY KEY, CustomerID INT, OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP, TotalPrice DECIMAL(10, 2), CreditCardNumber VARCHAR(16), ExpiryDate DATE, FOREIGN KEY (CustomerID) REFERENCES CUSTOMER(CustomerID))");

        DB::statement("CREATE TABLE CART_ITEM (CartID INT, ISBN VARCHAR(13), Quantity INT, PRIMARY KEY (CartID, ISBN), FOREIGN KEY (CartID) REFERENCES SHOPPING_CART(CartID) ON DELETE CASCADE, FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN))");
        DB::statement("CREATE TABLE ORDER_ITEM (OrderID INT, ISBN VARCHAR(13), Quantity INT, PRIMARY KEY (OrderID, ISBN), FOREIGN KEY (OrderID) REFERENCES CUSTOMER_ORDER(OrderID), FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN))");
        DB::statement("CREATE TABLE BOOK_AUTHOR (ISBN VARCHAR(13), AuthorID INT, PRIMARY KEY (ISBN, AuthorID), FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN), FOREIGN KEY (AuthorID) REFERENCES AUTHOR(AuthorID))");
        DB::statement("CREATE TABLE REPLENISHMENT_ORDER (ReplenishmentOrderID INT AUTO_INCREMENT PRIMARY KEY, ISBN VARCHAR(13), PublisherID INT, OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP, Quantity INT, Status ENUM('Pending', 'Confirmed') DEFAULT 'Pending', FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN), FOREIGN KEY (PublisherID) REFERENCES PUBLISHER(PublisherID))");

        // Prevent negative stock
        DB::unprepared("CREATE TRIGGER before_book_update BEFORE UPDATE ON BOOK FOR EACH ROW BEGIN IF NEW.Quantity < 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Update failed: Stock cannot be negative'; END IF; END");

        // Auto-order when below threshold
        DB::unprepared("CREATE TRIGGER after_book_update AFTER UPDATE ON BOOK FOR EACH ROW BEGIN IF OLD.Quantity >= NEW.Threshold AND NEW.Quantity < NEW.Threshold THEN INSERT INTO REPLENISHMENT_ORDER (ISBN, PublisherID, Quantity, Status) VALUES (NEW.ISBN, NEW.PublisherID, 50, 'Pending'); END IF; END");
    }

    public function down(): void
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        $tables = ['BOOK_AUTHOR', 'REPLENISHMENT_ORDER', 'ORDER_ITEM', 'CART_ITEM', 'CUSTOMER_ORDER', 'SHOPPING_CART', 'BOOK', 'AUTHOR', 'PUBLISHER', 'CATEGORY', 'ADMIN', 'CUSTOMER'];
        foreach ($tables as $table) {
            DB::statement("DROP TABLE IF EXISTS $table");
        }
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
    }
};