<?php
// Include your database connection logic
include_once './connect.php';

// Retrieve form data
$productExpDate = $_POST['productExpDate'];
$productMnuDate = $_POST['productMnuDate'];
$productPrice = $_POST['productPrice'];
$productName = $_POST['productName'];
$categoryID = $_POST['categoryID'];
$productQuantity = $_POST['productQuantity'];
$availability = $_POST['availability'];
// Add other fields as needed


// SQL query to insert a new product
$insertQuery = "INSERT INTO Product (ProductExpDate, ProductMnuDate, ProductPrice, ProductName, CategoryID, ProductQuantity, Availability) VALUES ('$productExpDate', '$productMnuDate', '$productPrice', '$productName', '$categoryID', '$productQuantity', '$availability')";

// Execute the query
if (mysqli_query($conn, $insertQuery)) {
    $response['success'] = true;
    $response['message'] = 'Product inserted successfully';
} else {
    $response['success'] = false;
    $response['error'] = mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
