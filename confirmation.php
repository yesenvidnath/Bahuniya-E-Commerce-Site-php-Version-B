
<?php
session_start();
include 'connect.php'; 
// Check if the necessary session variables are set
if (isset($_SESSION['confirmationData'])) {
    $confirmationData = $_SESSION['confirmationData'];
} else {
    // Redirect to the checkout page if session data is not set
    header("Location: checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary meta tags, CSS, and other head elements -->
    <title>Order Confirmation</title>
</head>

<body>

    <div class="container mt-4">
        <h2>Order Confirmation</h2>

        <!-- Display user information -->
        <p>Name: <?php echo htmlspecialchars($confirmationData['customerName']); ?></p>
        <p>Delivery Address: <?php echo htmlspecialchars($confirmationData['completeAddress']); ?></p>
        <p>Email Address: <?php echo htmlspecialchars($confirmationData['userEmail']); ?></p>
        <p>Contact Numbers: <?php echo htmlspecialchars($confirmationData['mobileNumber01'] . ', ' . $confirmationData['mobileNumber02']); ?></p>

        <!-- Add a confirmation button -->
        <form method="post" action="place_order.php">
            <button type="submit" class="btn btn-primary" name="confirm_order">Confirm Order</button>
        </form>
    </div>

    <!-- Include necessary scripts and closing body/html tags -->

</body>

</html>
