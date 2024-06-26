<?php
// Include your database connection logic
include('./connect.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data sent from the client
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from the decoded JSON
    $productID = $data['productID'];
    $productName = $data['productName'];
    $productExpDate = $data['productExpDate'];
    $productMnuDate = $data['productMnuDate'];
    $productPrice = $data['productPrice'];
    $categoryID = $data['categoryID'];
    $productQuantity = $data['productQuantity'];
    $productAvailability = $data['productAvailability'];

    // Perform the database update
    $updateQuery = "UPDATE Product SET
                    ProductName = '$productName',
                    ProductExpDate = '$productExpDate',
                    ProductMnuDate = '$productMnuDate',
                    ProductPrice = '$productPrice',
                    CategoryID = '$categoryID',
                    ProductQuantity = '$productQuantity',
                    Availability = '$productAvailability'
                    WHERE ProductID = '$productID'";

    $result = mysqli_query($conn, $updateQuery);

    // Check if the update was successful
    if ($result) {
        // Send a success response to the client
        http_response_code(200);
        echo json_encode(['message' => 'Product updated successfully']);
    } else {
        // Send an error response to the client
        http_response_code(500);
        echo json_encode(['error' => 'Error updating product']);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Send an error response for invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
