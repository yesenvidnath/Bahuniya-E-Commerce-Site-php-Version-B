<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/staff-header.php');?>

<?php

// Check if the user is logged in and is of type 'chief_accountant'
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'chief_accountant') {
    
    // Display the accountant's information
    echo '<div class="container-fluid nav-sfatt-custom-main">';
    echo    '<div class="row">';
    echo       '<div class="col-md-8">';
    echo           '<h1>Accountant Dashboard </h1>';
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


    <div class="container-fluid cart-item-cont-custom">
        <div class="row">
            <!-- Left Sidebar with Tabs -->
            <div class="col-md-3">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" id="accountInfoTab" data-toggle="pill" href="#accountInfo">Account Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="salesReportTab" data-toggle="pill" href="#salesReport">Monthly Income Report</a>
                    </li>
                </ul>
            </div>
            
            <!-- Content Area -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Account Info Tab -->
                    <div id="accountInfo" class="tab-pane fade show active">
                        <!-- Display Account Info Content Here -->
                        <h1>Welcome, <?php echo $_SESSION['staff_name']; ?>!</h1>

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

                    <!-- Sales Report Tab -->
                    <div id="salesReport" class="tab-pane fade">
                        <!-- Display Sales Report Content Here -->
                        <h2>Monthly Income Report</h2>
                        <?php
                            // Assume $conn is your database connection
                            // Fetch all orders
                            $orderQuery = "SELECT * FROM OrderTable";
                            $orderResult = mysqli_query($conn, $orderQuery);
                            // Check if there are orders
                            if ($orderResult) {
                                // Display table header
                                echo '<table class="table">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Order ID</th>';
                                echo '<th>Order Total</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                // Display each order
                                $totalOrders = 0;
                                while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                                    echo '<tr>';
                                    echo '<td>' . $orderRow['OrderID'] . '</td>';
                                    echo '<td>$' . $orderRow['OrderTotal'] . '</td>';
                                    echo '</tr>';
                                    // Add the order total to the overall total
                                    $totalOrders += $orderRow['OrderTotal'];
                                }
                                // Display total of all orders
                                echo '</tbody>';
                                echo '<tfoot>';
                                echo '<tr>';
                                echo '<td colspan="2" class="text-right">Monthly Income: $' . $totalOrders . '</td>';
                                echo '</tr>';
                                echo '</tfoot>';
                                echo '</table>';
                            } else {
                                // Handle the case where there are no orders
                                echo '<p>No orders found.</p>';
                            }
                        ?>

                        <?php
                            echo '<form action="/Bahuniya%20%5b%20PJ%20%5d/report/monthly_income_report.php" method="post">';
                            echo '<button type="submit" class="btn btn-primary" name="generateReport">Generate Report</button>';
                            echo '</form>';
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/footer.php');?>