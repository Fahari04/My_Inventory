CREATE DATABASE my_inventory;
USE my_Inventory;
CREATE TABLE Category (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryName VARCHAR(50)
);


INSERT INTO Category (CategoryName) VALUES ('Electronics');
INSERT INTO Category (CategoryName) VALUES ('Clothing');
INSERT INTO Category (CategoryName) VALUES ('Books');
INSERT INTO Category (CategoryName) VALUES ('Home Decor');
INSERT INTO Category (CategoryName) VALUES ('Sports Equipment');
INSERT INTO Category (CategoryName) VALUES ('Kitchen Appliances');
INSERT INTO Category (CategoryName) VALUES ('Furniture');
INSERT INTO Category (CategoryName) VALUES ('Toys');
INSERT INTO Category (CategoryName) VALUES ('Beauty Products');
INSERT INTO Category (CategoryName) VALUES ('Automotive');


CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerName VARCHAR(50),
    ContactInfo VARCHAR(50),
    CustomerAddress VARCHAR(100)
);
INSERT INTO Customer (CustomerName, ContactInfo, CustomerAddress)
VALUES ('John Doe', '555-1234', '123 Main St'),
    ('Jane Smith', '555-5678', '456 Elm St'),
    ('Robert Johnson', '555-9876', '789 Broadway'),
    ('Emily White', '555-4321', '567 Oak Stt'),
    ('Michael Brown', '555-8765', '890 Pine St'),
    ('Emma Davis', '555-3456', '234 Maple Ave'),
    ('William Lee', '555-6543', '678 Cedar Rd'),
    ('Olivia Martin', '555-2345', '901 Pine St'),
    ('James Wilson', '555-8765', '345 Birch Ln'),
    ('Sophia Anderson', '555-3456', '567 Spruce Dr');

USE my_inventory;
SHOW * FROM Supplier;
CREATE TABLE Supplier (
    SupplierID INT PRIMARY KEY AUTO_INCREMENT,
    SupplierName VARCHAR(50),
    PaymentTerms VARCHAR(50),
    PhoneNumber VARCHAR(15),
    CategoryID INT,
    CategoryName VARCHAR(50),
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- Inserting sample data
INSERT INTO Supplier (SupplierName, PaymentTerms, PhoneNumber, CategoryID, CategoryName)
VALUES 
    ('Supplier1', 'Net 30', '123-456-7890', 1, 'Electronics'),
    ('Supplier2', 'Net 45', '987-654-3210', 2, 'Clothing'),
    ('Supplier3', 'Net 60', '555-123-4567', 3, 'Books'),
    ('Supplier4', 'Net 30', '789-456-1230', 1, 'Electronics'),
    ('Supplier5', 'Net 60', '555-789-1234', 2, 'Clothing');

USE my_inventory;
SHOW * FROM Inventory;
CREATE TABLE Inventory (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(100),
    ProductPrice DECIMAL(10, 2),
    CategoryID INT,
    StockQuantity INT,
    ReorderLevel INT,
    ShelfLocation VARCHAR(50),
    LastRestockDate DATE,
    ExpiryDate DATE,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

INSERT INTO Inventory (ProductName, ProductPrice, CategoryID, StockQuantity, ReorderLevel, ShelfLocation, LastRestockDate, ExpiryDate) 
VALUES 
    ('Laptop', 1200.00, 1, 50, 10, 'A1', '2023-01-15', '2024-12-31'),
    ('T-shirt', 19.99, 2, 100, 20, 'B2', '2023-02-20', '2023-12-31'),
    ('Book', 15.50, 3, 75, 15, 'C3', '2022-12-10', '2024-06-30'),
    ('Coffee Maker', 49.99, 6, 30, 5, 'D4', '2023-03-05', '2024-09-30'),
    ('Sofa', 499.99, 7, 10, 2, 'E5', '2023-01-25', '2025-01-31');















