<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/staff-header.php');?>

<?php

// Check if the user is logged in and is of type 'Production Manager'
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Production Manager' || 'Manager') {
    
    // Display the accountant's information
    echo '<div class="container-fluid nav-sfatt-custom-main">';
    echo    '<div class="row">';
    echo       '<div class="col-md-8">';
    echo           '<h1>Manager Dashboard </h1>';
    echo           '<h5>Welcome, ' . $_SESSION['staff_name'] . '!</h5>';
    echo       '</div>';
    echo       '<div class="col-md-4 d-flex justify-content-end">';
    echo           '<a class="nav-link" href="/Bahuniya%20%5b%20PJ%20%5d/logout.php"> <i class="fas fa-sign-out-alt"></i> Logout </a>';
    echo       '</div>';
    echo    '</div>';
    echo '</div>';

    // Here you can include the rest of your accountant dashboard content
} else {
    // Redirect to the login page if the user is not logged in as the chief accountant
    header("Location: login.php");
    exit();
} 

?>

    <div class="container ">
        <br>
        <br>
        <br>
        <br>
        <div class="row cart-item-cont-custom">

            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account Info</a>
                    <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Orders Report</a>
                    <a class="nav-link" id="v-pills-products-tab" data-toggle="pill" href="#v-pills-products" role="tab" aria-controls="v-pills-products" aria-selected="false">Product Availability</a>
                </div>
            </div>
            <div class="col-md-9 ">
                <div class="tab-content" id="v-pills-tabContent">

                    <!-- Tab 1: Account Info -->
                    <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                        <!-- Display Account Information -->
                        <h3>Account Information</h3>
                        <!-- Fetch and display non-sensitive user information -->

                        <?php
                            $userID = $_SESSION['staff_id']; // Assuming StaffID is the same as UserID
                            $userQuery = "SELECT * FROM User WHERE UserID = '$userID'";
                            $userResult = mysqli_query($conn, $userQuery);

                            if ($userResult && mysqli_num_rows($userResult) == 1) {
                                $userRow = mysqli_fetch_assoc($userResult);
                                echo '<p>User ID: ' . $userRow['UserID'] . '</p>';
                                echo '<p>Email: ' . $userRow['UserEmail'] . '</p>';
                                echo '<p>Password: ' . $userRow['UserPassword'] . '</p>';
                                // Add more non-sensitive user information as needed
                            }
                        ?>

                        <hr>

                        <!-- Fetch and display non-sensitive staff information -->
                        <?php
                            $staffQuery = "SELECT * FROM Staff WHERE StaffID = '$userID'";
                            $staffResult = mysqli_query($conn, $staffQuery);

                            if ($staffResult && mysqli_num_rows($staffResult) == 1) {
                                $staffRow = mysqli_fetch_assoc($staffResult);
                                echo '<p>Staff ID: ' . $staffRow['StaffID'] . '</p>';
                                echo '<p>Staff Type: ' . $staffRow['StaffType'] . '</p>';
                                echo '<p>Staff Name: ' . $staffRow['StaffName'] . '</p>';
                                // Add more non-sensitive staff information as needed
                            }
                        ?>
                    </div>

                    <!-- Tab 2: Orders Report -->
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">

                        <!-- Display Orders Report -->
                        <h3>Orders Report</h3>
                        
                        <?php
                            // Fetch and display orders report from the database
                            $ordersQuery = "SELECT * FROM OrderTable";
                            $ordersResult = mysqli_query($conn, $ordersQuery);

                            if ($ordersResult && mysqli_num_rows($ordersResult) > 0) {
                                echo '
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';

                                while ($orderRow = mysqli_fetch_assoc($ordersResult)) {
                                    echo '
                                    <tr>
                                        <td>' . $orderRow['OrderID'] . '</td>
                                        <td>' . $orderRow['OrderDate'] . '</td>
                                        <td>' . $orderRow['DeliveryLocation'] . '</td>
                                    </tr>
                                    ';
                                }

                                echo '
                                    </tbody>
                                </table>
                                ';
                            } else {
                                echo '<p>No orders available.</p>';
                            }
                        ?>
                        
                        <button class="btn btn-primary">Generate Report</button>

                    </div>

                    <!-- Tab 3: Product Availability -->
                    <div class="tab-pane fade" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-products-tab" style="max-height: 600px; overflow:scroll;">
                        <!-- Display Product Availability -->
                        <h3>Product Availability</h3>
                        
                        <?php
                            // Fetch product data from the database where Availability is 'Available'
                            $productQuery = "SELECT * FROM Product WHERE Availability = 'Available'";
                            $productResult = mysqli_query($conn, $productQuery);

                            if ($productResult && mysqli_num_rows($productResult) > 0) {
                                // Display a table with product information
                                echo '
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product ID</th>
                                            <th scope="col">Product Image</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';

                                // Loop through the fetched product data and display it in the table
                                while ($productRow = mysqli_fetch_assoc($productResult)) {
                                    echo '
                                    <tr>
                                        <th scope="row">' . $productRow['ProductID'] . '</th>
                                        <td><img src="' . $productRow['ProductImage'] . '" alt="Product Image" style="max-width: 100px;"></td>
                                        <td>' . $productRow['ProductName'] . '</td>
                                        <td>' . $productRow['Availability'] . '</td>
                                    </tr>
                                    ';
                                }

                                echo '
                                    </tbody>
                                </table>
                                ';
                            } else {
                                // Display a message if no available products are found
                                echo '<p>No available products found.</p>';
                            }
                        ?>

                        <!-- Add Bootstrap table for better formatting -->
                        <button class="btn btn-primary">Generate Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/footer.php');?>