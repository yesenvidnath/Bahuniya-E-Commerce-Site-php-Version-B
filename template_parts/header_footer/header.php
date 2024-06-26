<?php

session_start();
include 'connect.php';

// Check if the user is logged in
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer') {
    $customerID = $_SESSION['customer_id'];
    $customerName = $_SESSION['customer_name'];
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Perform a query to get the total count of cart items for the specific customer
$cartCountQuery = "SELECT COUNT(*) AS totalCartItems FROM Cart WHERE CustomerID = '$customerID'";
$cartCountResult = mysqli_query($conn, $cartCountQuery);

// Check if the query was successful
if ($cartCountResult) {
    // Fetch the result as an associative array
    $cartCountRow = mysqli_fetch_assoc($cartCountResult);
    
    // Get the total count of cart items
    $totalCartItems = $cartCountRow['totalCartItems'];
} else {
    // Handle the query error if needed
    $totalCartItems = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Bahuniya</title>
</head>
<body>

<section class="nav-bar-section">
    <nav class="navbar navbar-expand-lg navbar-black bg-black">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">Bahuniya</a>

            <!-- Navigation Links -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Shop</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="my_account.php">My Account</a>
                    </li>
                </ul>
            </div>
            
            <!-- Shopping Cart Icon -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge-custo"><?php echo $totalCartItems; ?></span>
                    </a>
                </li>

                <!-- Check if the user is logged in -->
                <?php
                    // Assuming you have a session variable 'user_type' set during login
                    if (isset($_SESSION['user_type'])) {
                        // User is logged in, display logout link
                        echo '<li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>';
                    } else {
                        // User is not logged in, display login link
                        echo '<li class="nav-item">
                                <a class="nav-link" href="login.php">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>';
                    }
                ?>
            </ul>
        </div>
    </nav>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-6 text-center d-flex align-items-center offset-md-3"><h2>Welcome, <?php echo $customerName; ?>!</h2></div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</section>
