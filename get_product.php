<?php
include 'config.php';

if (isset($_GET['productName'])) {
    $productName = $conn->real_escape_string($_GET['productName']);

    // Query to fetch product details
    $query = "SELECT ProductPrice, StockQuantity FROM Inventory WHERE ProductName = '$productName'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            'unitPrice' => $row['ProductPrice'],
            'totalQuantity' => $row['StockQuantity']
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Product details not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
