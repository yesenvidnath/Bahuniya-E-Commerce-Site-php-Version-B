<!-- Include glogal heder -->
<?php include('template_parts/header_footer/header.php');?>

<?php


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

// Handle the order form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    // Retrieve order details from the form
    $deliveryLocation = mysqli_real_escape_string($conn, $_POST['delivery_location']);


    // Set the order date and time based on the server's current date and time
    $orderDate = date("Y-m-d");
    $orderTime = date("H:i:s");

    // Calculate the total order amount based on cart items
    $totalAmount = 0;
    $orderItems = array();

    // Retrieve cart items and calculate the total amount
    $cartQuery = "SELECT Cart.*, Product.ProductName, Product.ProductPrice
                  FROM Cart
                  INNER JOIN Product ON Cart.ProductID = Product.ProductID
                  WHERE Cart.CustomerID = '$customerID'";
    $cartResult = mysqli_query($conn, $cartQuery);

    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
        $totalAmount += ($cartItem['ProductPrice'] * $cartItem['ItemQuantity']);
        $orderItems[] = array(
            'ProductID' => $cartItem['ProductID'],
            'ItemQuantity' => $cartItem['ItemQuantity']
        );
    }

    // Extract values from the form
    $deliveryLocation = mysqli_real_escape_string($conn, $_POST['delivery_location']);
    $mobileNumber01 = mysqli_real_escape_string($conn, $_POST['mobile_number_01']);
    $mobileNumber02 = mysqli_real_escape_string($conn, $_POST['mobile_number_02']);

    // Insert data into OrderTable
    $insertOrderQuery = "INSERT INTO OrderTable (DeliveryLocation, MobileNumber01, MobileNumber02, OrderTotal, CustomerID, OrderDate, OrderTime, OrderQuantity)
                        VALUES ('$deliveryLocation', '$mobileNumber01', '$mobileNumber02', '$totalAmount', '$customerID', CURDATE(), CURTIME(), '$orderQuantity')";

    // Execute the query
    $insertOrderResult = mysqli_query($conn, $insertOrderQuery);

    // Check if the query was successful
    if ($insertOrderResult) {
        // Get the generated OrderID
        $orderID = mysqli_insert_id($conn);

        // Loop through order items and insert into OrderItems table
        foreach ($orderItems as $item) {
            $productID = $item['ProductID'];
            $itemQuantity = $item['ItemQuantity'];

            // Insert order items into OrderItems table
            $insertOrderItemsQuery = "INSERT INTO OrderItems (ProductID, ItemsCount, OrderID)
                                      VALUES ('$productID', '$itemQuantity', '$orderID')";

            // Execute the query
            $insertOrderItemsResult = mysqli_query($conn, $insertOrderItemsQuery);

            // Check if the query was successful
            if (!$insertOrderItemsResult) {
                // Handle the case where inserting order items failed
                echo "Error inserting order items";
                // You might want to consider rolling back the order insertion in case of failure
                break;
            }
        }

        // Now you can proceed with any additional steps or redirects
        header("Location: thank_you.php");
        exit();
    } else {
        // Handle the case where the query failed
        echo "Error inserting order";
    }
}


// Query to calculate the total price of products in the cart for the specified customer
$totalPriceQuery = "SELECT SUM(Product.ProductPrice * Cart.ItemQuantity) AS TotalPrice
                    FROM Cart
                    INNER JOIN Product ON Cart.ProductID = Product.ProductID
                    WHERE Cart.CustomerID = '$customerID'";

// Execute the query
$totalPriceResult = mysqli_query($conn, $totalPriceQuery);


// Query to fetch the address of the specified customer
$addressQuery = "SELECT Customer.CustomerAddHouseNo, Customer.CustomerAddStreetNo, Customer.CustomerAddCity
                 FROM Customer
                 WHERE Customer.CustomerID = '$customerID'";

// Execute the query
$addressResult = mysqli_query($conn, $addressQuery);

// Check if the query was successful
if ($addressResult) {
    // Fetch the address from the result
    $addressRow = mysqli_fetch_assoc($addressResult);

    // Store address components in variables
    $houseNo = $addressRow['CustomerAddHouseNo'];
    $streetNo = $addressRow['CustomerAddStreetNo'];
    $city = $addressRow['CustomerAddCity'];

    // Now $houseNo, $streetNo, and $city contain the address components
    // You can concatenate them to create the complete address
    $completeAddress = "$houseNo, $streetNo, $city";
} else {
    // Handle the case where the query failed
    echo "Error fetching address";
}

?>



    <div class="container mt-4 cart-item-cont-custom">
        <h2>Checkout</h2>
        <?php
        if (mysqli_num_rows($cartResult) > 0) {
            echo '<ul class="list-group">';
            while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>' . $cartItem['ProductName'] . '</strong>
                        <span class="badge badge-primary badge-pill">' . $cartItem['ItemQuantity'] . '</span>
                        <span class="badge badge-success badge-pill">$' . $cartItem['ProductPrice'] . '</span>
                      </li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
        <br>
        <!-- Display total value at the bottom -->
        <div class="container">
            <div class="row">
                <div class="col-6 offset-md-3">
                    <h3>
                        
                        <?php 
                            // Check if the query was successful
                            if ($totalPriceResult) {
                                // Fetch the total price from the result
                                $totalPriceRow = mysqli_fetch_assoc($totalPriceResult);
                                $totalPrice = $totalPriceRow['TotalPrice'];

                                if($totalPrice > 0 ){
                                    // Now $totalPrice contains the calculated total price
                                    echo "<div class='alert alert-success'>Total Price $: $totalPrice<div>";

                                }else{
                                    echo "<div class='alert alert-warning'>Add some Items to the Cart<div>";
                                }

                            } else {
                                // Handle the case where the query failed
                                echo "Error fetching total price";
                            }
                        
                        ?>
                
                    </h3>
                </div>
            </div>
        </div>
        <br>
        <form method="post" class="mt-3">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="mobile_number_01">Mobile Number 01</label>
                        <input type="text" class="form-control" id="mobile_number_01" placeholder="Enter Mobile Number 01" name="mobile_number_01" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="mobile_number_02">Mobile Number 02</label>
                        <input type="text" class="form-control" id="mobile_number_02" placeholder="Enter Mobile Number 02" name="mobile_number_02" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="delivery_location">Delivery Location:</label>
                <input type="text" class="form-control" id="delivery_location" placeholder="Enter delivery location" name="delivery_location" value="<?php echo htmlspecialchars($completeAddress); ?>" required>

            </div>
            <!-- Order date and time will be set automatically on the server side -->
            <button type="submit" class="btn btn-primary" name="place_order">Place Order</button>
        </form>
    </div>


<!-- Include glogal heder -->
<?php include('template_parts/header_footer/footer.php');?>

