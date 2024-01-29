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
CREATE TABLE Inventory (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(50),
    ProductPrice DECIMAL(10, 2),
    CategoryID INT,
    CategoryName VARCHAR(50),
    SupplierID INT,
    SupplierName VARCHAR(50),
    StockQuantity INT,
    ReorderLevel INT,
    ShelfLocation VARCHAR(50),
    LastRestockDate DATE,
    ExpiryDate DATE,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- Insert 10 sample data into the Inventory table
USE my_inventory;
INSERT INTO Inventory (ProductName, ProductPrice, CategoryID, CategoryName, SupplierID, SupplierName, StockQuantity, ReorderLevel, ShelfLocation, LastRestockDate, ExpiryDate)
VALUES
    ('Product1', 19.99, 1, 'Electronics', 1, 'Supplier1', 100, 20, 'A1', '2022-01-01', '2023-01-01'),
    ('Product2', 29.99, 2, 'Clothing', 2, 'Supplier2', 150, 30, 'B2', '2022-02-01', '2023-02-01'),
    ('Product3', 9.99, 3, 'Books', 3, 'Supplier3', 200, 40, 'C3', '2022-03-01', '2023-03-01'),
    ('Product4', 39.99, 1, 'Electronics', 1, 'Supplier1', 120, 25, 'A4', '2022-04-01', '2023-04-01'),
    ('Product5', 49.99, 2, 'Clothing', 2, 'Supplier2', 180, 35, 'B5', '2022-05-01', '2023-05-01'),
    ('Product6', 14.99, 3, 'Books', 3, 'Supplier3', 220, 45, 'C6', '2022-06-01', '2023-06-01'),
    ('Product7', 59.99, 1, 'Electronics', 1, 'Supplier1', 80, 15, 'A7', '2022-07-01', '2023-07-01'),
    ('Product8', 24.99, 2, 'Clothing', 2, 'Supplier2', 130, 28, 'B8', '2022-08-01', '2023-08-01'),
    ('Product9', 11.99, 3, 'Books', 3, 'Supplier3', 190, 38, 'C9', '2022-09-01', '2023-09-01'),
    ('Product10', 34.99, 1, 'Electronics', 1, 'Supplier1', 160, 30, 'A10', '2022-10-01', '2023-10-01');
    

-- View the Inventory table
USE my_inventory;

CREATE TABLE Employee (
    EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
    EmployeeName VARCHAR(50),
    Position VARCHAR(50),
    ContactInfo VARCHAR(50)
);

INSERT INTO Employee (EmployeeName, Position, ContactInfo)
VALUES 
    ('John Doe', 'Manager', '555-1234'),
    ('Jane Smith', 'Sales Associate', '555-5678'),
    ('Robert Johnson', 'Accountant', '555-9876'),
    ('Emily White', 'Marketing Specialist', '555-4321'),
    ('Michael Brown', 'IT Technician', '555-8765'),
    ('Emma Davis', 'Customer Service Representative', '555-3456'),
    ('William Lee', 'HR Coordinator', '555-6543'),
    ('Olivia Martin', 'Warehouse Supervisor', '555-2345'),
    ('James Wilson', 'Financial Analyst', '555-8765'),
    ('Sophia Anderson', 'Research and Development Scientist', '555-3456');

USE my_inventory;
SELECT * FROM Employee;

USE my_inventory;

CREATE TABLE Transaction (
    TransactionID INT PRIMARY KEY AUTO_INCREMENT,
    TransactionType VARCHAR(50),
    TransactionDate DATE,
    TransactionAmount VARCHAR(50),
    TotalQuantity VARCHAR(50)
);
USE my_inventory;
INSERT INTO Transaction (TransactionType, TransactionDate, TransactionAmount, TotalQuantity)
VALUES
    ('Sale', '2024-01-25', 100.50, 5),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-25', 100.50, 5),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-25', 100.50, 5),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3),
    ('Purchase', '2024-01-26', 75.25, 3),
    ('Sale', '2024-01-26', 75.25, 3);



















