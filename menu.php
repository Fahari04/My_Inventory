<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="home.jpeg" type="image/x-icon">
    <title>My Inventory Tables</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php
    $tables = array("Customer", "Employee", "Supplier", "Category", "Inventory_Transaction", "Inventory");

    foreach ($tables as $table) {
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error executing query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                echo "<h2>$table Table:</h2>";
                echo "<table>
                        <tr>";

                $headerPrinted = false;
                while ($row = $result->fetch_assoc()) {
                    if (!$headerPrinted) {
                        foreach ($row as $key => $value) {
                            echo "<th>$key</th>";
                        }
                        echo "</tr>";
                        $headerPrinted = true;
                    }

                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found for $table table.</p>";
            }
        }
    }
    ?>
</body>

</html>

<?php
$conn->close();
?>
