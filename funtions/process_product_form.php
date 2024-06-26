<?php
// Include your database connection file
include_once("./connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $productName = $_POST["productName"];
    $productExpDate = $_POST["productExpDate"];
    $productMnuDate = $_POST["productMnuDate"];
    $productPrice = $_POST["productPrice"];
    $productQuantity = $_POST["productQuantity"];
    $categoryID = $_POST["categoryID"];
    $Availability = $_POST["Availability"];

    // Add additional form fields as needed

    // Implement your database logic here (insert/update operation)
    // For example, you can use prepared statements to prevent SQL injection

    // For demonstration purposes, let's assume you have a "products" table
    $sql = "INSERT INTO products (ProductName, ProductExpDate, ProductMnuDate, ProductPrice, ProductQuantity, CategoryID, Availability)
            VALUES ('$productName', '$productExpDate', '$productMnuDate', '$productPrice', '$productQuantity', '$categoryID', '$Availability')";

    if ($conn->query($sql) === TRUE) {
        // Send a success response
        echo "Form submitted successfully!";
    } else {
        // Send an error response
        echo "Error submitting form: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted";
}
?>
