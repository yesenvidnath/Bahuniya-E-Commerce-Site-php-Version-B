<?php
session_start();
include 'connect.php'; 
$customerID = $_SESSION['customer_id'];

// Query to fetch the customer's most recent order ID
$recentOrderQuery = "SELECT OrderID
                     FROM OrderTable
                     WHERE CustomerID = '$customerID'
                     ORDER BY OrderDate DESC, OrderTime DESC
                     LIMIT 1";

// Execute the query
$recentOrderResult = mysqli_query($conn, $recentOrderQuery);

// Check if the query was successful
if ($recentOrderResult && mysqli_num_rows($recentOrderResult) > 0) {
    // Fetch the recent order ID from the result
    $recentOrderRow = mysqli_fetch_assoc($recentOrderResult);
    $recentOrderID = $recentOrderRow['OrderID'];

    // Now $recentOrderID contains the customer's most recent order ID
} else {
    // Handle the case where the query failed or no recent order was found
    $recentOrderID = "N/A";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thank You - Bahuniya</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Thank You!</h1>
            <p class="lead">Your order (ID: <?php echo $recentOrderID; ?>) has been placed successfully.</p>
            <hr class="my-4">
            <p>We appreciate your business with Bahuniya.</p>
            <a class="btn btn-primary btn-lg" href="index.php" role="button">Back to Home</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
