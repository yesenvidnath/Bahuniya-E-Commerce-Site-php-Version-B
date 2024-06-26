<!-- Include glogal heder -->
<?php include('template_parts/header_footer/header.php');?>

<?php

// Check if the user is logged in
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer') {
    $customerID = $_SESSION['customer_id'];
}

// Fetch user's cart items
$cartQuery = "SELECT Cart.*, Product.ProductName, Product.ProductPrice
              FROM Cart
              INNER JOIN Product ON Cart.ProductID = Product.ProductID
              WHERE Cart.CustomerID = '$customerID'";
$cartResult = mysqli_query($conn, $cartQuery);

// Fetch user's orders
$ordersQuery = "SELECT OrderTable.*, OrderItems.ProductID, OrderItems.ItemsCount, Product.ProductName
                FROM OrderTable
                LEFT JOIN OrderItems ON OrderTable.OrderID = OrderItems.OrderID
                LEFT JOIN Product ON OrderItems.ProductID = Product.ProductID
                WHERE OrderTable.CustomerID = '$customerID'";
$ordersResult = mysqli_query($conn, $ordersQuery);


// Fetch user's account information
$userQuery = "SELECT * FROM Customer WHERE CustomerID = '$customerID'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);


?>



    <div class="container mt-4 cart-item-cont-custom">
        <h2>Welcome to My Account</h2>

        <!-- Create Bootstrap tabs -->
        <ul class="nav nav-tabs" id="myAccountTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="cart-tab" data-toggle="tab" href="#cart" role="tab" aria-controls="cart" aria-selected="true">Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">Account Information</a>
            </li>
        </ul>

        <!-- Create tab content -->
        <div class="tab-content mt-2">
            <!-- Cart Tab Content -->
            <div class="tab-pane fade show active" id="cart" role="tabpanel" aria-labelledby="cart-tab">
                <h3>My Cart</h3>
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
            </div>

            <!-- Orders Tab Content -->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h3>My Orders</h3>
                <?php
    if (mysqli_num_rows($ordersResult) > 0) {
        while ($order = mysqli_fetch_assoc($ordersResult)) {
            echo '<div class="card mb-3">
                    <div class="card-header">
                        Order ID: ' . $order['OrderID'] . '
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Order Details</h5>';
            if (!empty($order['ProductID'])) {
                echo '<ul class="list-group">';
                do {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>' . $order['ProductName'] . '</strong>
                            <span class="badge badge-primary badge-pill">' . $order['ItemsCount'] . '</span>
                          </li>';
                } while (($order = mysqli_fetch_assoc($ordersResult)) && $order['OrderID'] === $order['OrderID']);
                echo '</ul>';
            } else {
                echo '<p>No items in this order.</p>';
            }
            echo '</div>
                  </div>';
        }
    } else {
        echo '<p>You have no orders.</p>';
    }
    ?>
        
            </div>

            <!-- Account Information Tab Content -->
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                <h3>My Account Information</h3>
                <?php
                    // Fetch customer's account information along with associated user information
                    $accountInfoQuery = "SELECT Customer.*, User.UserEmail
                                        FROM Customer
                                        LEFT JOIN User ON Customer.UserID = User.UserID
                                        WHERE Customer.CustomerID = '$customerID'";
                    $accountInfoResult = mysqli_query($conn, $accountInfoQuery);

                    // Check if the query was successful
                    if ($accountInfoResult) {
                        // Fetch the customer's account information along with associated user information as an associative array
                        $accountInfo = mysqli_fetch_assoc($accountInfoResult);

                        // Check if $accountInfo is not null
                        if ($accountInfo) {
                            // Display customer's information
                            echo '<h5>Customer Information</h5>';
                            echo '<p>Name: ' . $accountInfo['CustomerName'] . '</p>';
                            echo '<p>Email: ' . $accountInfo['UserEmail'] . '</p>';
                            echo '<p>Mobile Number 01: ' . $accountInfo['CustomerTPNo'] . '</p>';
                            echo '<p>Address: ' . $accountInfo['CustomerAddHouseNo'] . ', ' . $accountInfo['CustomerAddStreetNo'] . ', ' . $accountInfo['CustomerAddCity'] . '</p>';

                            // Display user's information
                            echo '<h5>User Information</h5>';
                            echo '<p>Email: ' . $accountInfo['UserEmail'] . '</p>';
                        } else {
                            // Handle the case where $accountInfo is null
                            echo '<p>No account information available.</p>';
                        }
                    } else {
                        // Handle the case where the query failed
                        echo '<p>Error fetching account information.</p>';
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Include necessary scripts and closing body/html tags -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include glogal heder -->
<?php include('template_parts/header_footer/footer.php');?>