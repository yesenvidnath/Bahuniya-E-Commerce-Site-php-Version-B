<?php
// Include your database connection file (e.g., connect.php)
include './connect.php';

// Check if the product ID parameter is set
if (isset($_GET['productID'])) {
    // Get the product ID from the request
    $productID = $_GET['productID'];

    // Perform a query to retrieve product information based on the Product ID
    $query = "SELECT * FROM Product WHERE ProductID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product was found
    if ($result->num_rows > 0) {
        // Fetch product data as an associative array
        $productData = $result->fetch_assoc();

        // Return the product data in JSON format
        header('Content-Type: application/json');
        echo json_encode($productData);
    } else {
        // Return an empty JSON object if the product was not found
        echo json_encode(null);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Return an error message if the product ID parameter is not set
    echo 'Error: Product ID parameter not set.';
}
?>
