<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Collect user registration data
    $userEmail = $_POST['user_email'];
    $userPassword = $_POST['user_password'];

    // Insert user data into User table
    $insertUserQuery = "INSERT INTO User (UserEmail, UserPassword) VALUES ('$userEmail', '$userPassword')";
    mysqli_query($conn, $insertUserQuery);

    // Get the auto-incremented User ID
    $userID = mysqli_insert_id($conn);

    // Collect customer registration data
    $customerName = $_POST['customer_name'];
    $customerTPNo = $_POST['customer_tp_no'];
    $customerAddHouseNo = $_POST['customer_add_house_no'];
    $customerAddStreetNo = $_POST['customer_add_street_no'];
    $customerAddCity = $_POST['customer_add_city'];
    $customerDOB = $_POST['customer_dob'];

    // Insert customer data into Customer table
    $insertCustomerQuery = "INSERT INTO Customer (CustomerName, CustomerTPNo, CustomerAddHouseNo, CustomerAddStreetNo, CustomerAddCity, CustomerDOB, UserID)
                            VALUES ('$customerName', '$customerTPNo', '$customerAddHouseNo', '$customerAddStreetNo', '$customerAddCity', '$customerDOB', '$userID')";
    mysqli_query($conn, $insertCustomerQuery);

    // Redirect to login page after registration
    header("Location: login.php");
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>