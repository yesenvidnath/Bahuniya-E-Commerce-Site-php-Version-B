<?php
// Include your database connection file
include_once("./connect.php");

// Check if the productID is provided in the POST request
if(isset($_POST['productID'])) {
    // Sanitize the input to prevent SQL injection
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);

    // SQL query to delete the product
    $deleteQuery = "DELETE FROM Product WHERE ProductID = '$productID'";

    // Execute the query
    $result = mysqli_query($conn, $deleteQuery);

    if($result) {
        // Product deletion successful
        echo "Product deleted successfully!";
    } else {
        // Product deletion failed
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    // ProductID not provided in the POST request
    echo "ProductID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>
