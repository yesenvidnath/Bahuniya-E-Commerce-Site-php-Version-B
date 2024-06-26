<!-- Include glogal heder -->
<?php include('template_parts/header_footer/header.php');?>

<?php
include 'connect.php'; // Assuming your connection variable is $conn

// Check if the user is logged in and is a customer
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer') {
    $customerID = $_SESSION['customer_id'];

    // Retrieve cart items for the customer
    $cartQuery = "SELECT Cart.*, Product.ProductName, Product.ProductPrice
                  FROM Cart
                  INNER JOIN Product ON Cart.ProductID = Product.ProductID
                  WHERE Cart.CustomerID = '$customerID'";
    $cartResult = mysqli_query($conn, $cartQuery);
} else {
    // Redirect to login page if not logged in or not a customer
    header("Location: login.php");
    exit();
}

// Handle remove item action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $itemID = $_POST['item_id'];

    // Perform the SQL query to remove the item from the Cart table
    $removeItemQuery = "DELETE FROM Cart WHERE CartID = '$itemID' AND CustomerID = '$customerID'";
    mysqli_query($conn, $removeItemQuery);

    // Redirect to the same page to refresh the cart display
    header("Location: cart.php");
    exit();
}
?>

    <div class="container mt-4 cart-item-cont-custom">
        <h2>Your Cart</h2>
        <?php
        if (mysqli_num_rows($cartResult) > 0) {
            echo '<ul class="list-group">';
            while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>' . $cartItem['ProductName'] . '</strong>
                        <span class="badge badge-primary badge-pill">' . $cartItem['ItemQuantity'] . '</span>
                        <span class="badge badge-success badge-pill">$' . $cartItem['ProductPrice'] . '</span>
                        <form method="post" class="ml-2">
                            <input type="hidden" name="item_id" value="' . $cartItem['CartID'] . '">
                            <button type="submit" class="btn btn-danger btn-sm" name="remove_item">Remove</button>
                        </form>
                      </li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
        <br>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <a href="checkout.php" class="btn btn-primary" style="width: 100%;"> Order My Items Now </a>
            </div>
        </div>
        
    </div>


<!-- Include glogal heder -->
<?php include('template_parts/header_footer/footer.php');?>
