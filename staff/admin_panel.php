<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/staff-header.php');?>

<?php

// Check if the user is logged in and is of type 'admin'
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
    
    // Display the accountant's information
    echo '<div class="container-fluid nav-sfatt-custom-main">';
    echo    '<div class="row">';
    echo       '<div class="col-md-8">';
    echo           '<h1>Admin Dashboard </h1>';
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
                        <a class="nav-link" id="UserAccountHandlingTab" data-toggle="pill" href="#UserAccountHandling">User Account Handling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ProductHandlingTab" data-toggle="pill" href="#ProductHandling">Product Handling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="MonthlyIncomeReportTab" data-toggle="pill" href="#MonthlyIncomeReport">Monthly Income Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="OrdersTab" data-toggle="pill" href="#Orders">Orders</a>
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

                    <!-- UserAccountHandling-->
                    <div id="UserAccountHandling" class="tab-pane fade" style="max-height: 600px; overflow:scroll;">

                        <!-- Display Sales Report Content Here -->
                        <h2>User Account Handling</h2>

                        <div class="row">
                            <div class="col-6">
                                <form action="process_user_handling.php" method="post">
                                    <!-- Add your form fields here (e.g., Username, Password, Email) -->
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <!-- Buttons for Insert, Update, Delete, and Clear -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Insert</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="reset" class="btn btn-secondary">Clear</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-6">
                                <?php
                                    // Function to fetch all users
                                    function getAllUsers($conn) {
                                        $users = array();
                                        // Query to select all users from the User table
                                        $query = "SELECT * FROM User";
                                        // Execute the query
                                        $result = mysqli_query($conn, $query);
                                        // Check if the query was successful
                                        if ($result) {
                                            // Fetch each row and store it in the $users array
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $users[] = $row;
                                            }
                                            // Free the result set
                                            mysqli_free_result($result);
                                        }
                                        return $users;
                                    }
                                    // Fetch all users
                                    $users = getAllUsers($conn);
                                ?>

                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PHP code to fetch and display users goes here -->
                                        <?php
                                        foreach ($users as $user) {
                                            echo "<tr>";
                                            echo "<td>{$user['UserID']}</td>";
                                            echo "<td>{$user['UserEmail']}</td>";
                                            echo "<td>{$user['UserPassword']}</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- UserAccountHandling-->
                    <div id="ProductHandling" class="tab-pane fade" style="max-height: 600px; overflow:scroll;">
                        <!-- Display Sales Report Content Here -->
                        <h2>Product Handling</h2>

                        <!-- Product Form -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Product Form -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <form id="productForm">
                                            <div class="form-group">
                                                <label for="productID">Product ID:</label>
                                                <input type="text" class="form-control" id="productID" name="productID" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="productName">Product Name:</label>
                                                <input type="text" class="form-control" id="productName" name="productName" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="productExpDate">Expiration Date:</label>
                                                <input type="date" class="form-control" id="productExpDate" name="productExpDate" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="productMnuDate">Manufacture Date:</label>
                                                <input type="date" class="form-control" id="productMnuDate" name="productMnuDate" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="productPrice">Product Price:</label>
                                                <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="productQuantity">Product Quantity:</label>
                                                <input type="number" class="form-control" id="productQuantity" name="productQuantity" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoryID">Category ID:</label>
                                                <input type="number" class="form-control" id="categoryID" name="categoryID" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="productAvailability">Availability:</label>
                                                <select class="form-control" id="Availability" name="productAvailability" required>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="productImage">Product Image:</label>
                                                <input type="file" class="form-control" id="productImage" name="productImage">
                                            </div>

                                            <!-- Additional Buttons -->
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success" onclick="insertProduct()">Insert</button>
                                                <button type="button" class="btn btn-warning" onclick="updateProduct()">Update</button>
                                                <button type="button" class="btn btn-danger" onclick="deleteProduct()">Delete</button>
                                                <button type="button" class="btn btn-info" onclick="searchProduct()">Search</button>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="form-group">
                                                <button type="button" class="btn btn-secondary" onclick="clearProductForm()">Clear</button>
                                            </div>
                                        </form>

                                        <script>
                                            // JavaScript functions for handling product form and table
                                            function submitProductForm() {
                                                // Implement logic to submit the product form data (insert/update)
                                                // Get form data
                                                var formData = new FormData($("#productForm")[0]);

                                                // Implement AJAX logic
                                                $.ajax({
                                                    url: "/Bahuniya%20%5b%20PJ%20%5d/funtions/process_product_form.php", // Replace with the actual server-side script URL
                                                    type: "POST",
                                                    data: formData,
                                                    contentType: false,
                                                    processData: false,
                                                    success: function (response) {
                                                        // Handle the success response
                                                        console.log("Form submitted successfully");
                                                        // Reload or update the product table after submission
                                                        // Implement this part based on your specific requirements
                                                    },
                                                    error: function (error) {
                                                        // Handle the error response
                                                        console.error("Error submitting form", error);
                                                    }
                                                });
                                            }

                                            function clearProductForm() {
                                                // Clear the values of the product form fields
                                                document.getElementById('productID').value = '';
                                                document.getElementById('productName').value = '';
                                                document.getElementById('productExpDate').value = '';
                                                document.getElementById('productMnuDate').value = '';
                                                document.getElementById('productPrice').value = '';
                                                document.getElementById('productQuantity').value = '';
                                                document.getElementById('categoryID').value = '';
                                                document.getElementById('productImage').value = ''; 
                                                document.getElementById('productAvailability').value = 'In Stock';
                                            }

                                            function insertProduct() {
                                                    // Get form data
                                                var formData = {
                                                    productExpDate: $('#productExpDate').val(),
                                                    productMnuDate: $('#productMnuDate').val(),
                                                    productPrice: $('#productPrice').val(),
                                                    productName: $('#productName').val(),
                                                    categoryID: $('#categoryID').val(),
                                                    productQuantity: $('#productQuantity').val(),
                                                    availability: $('#productAvailability').val(),
                                                };

                                                // Send data to the server using AJAX
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '/Bahuniya%20%5b%20PJ%20%5d/funtions/insert_product.php', 
                                                    data: formData,
                                                    dataType: 'json',
                                                    success: function (response) {
                                                        // Handle the response from the server
                                                        if (response.success) {
                                                            // Example: Reload the page
                                                            location.reload();
                                                        } else {

                                                            console.error('Insertion failed:', response.error);
                                                        }
                                                    },
                                                    error: function (xhr, status, error) {
                                                        // Handle AJAX error
                                                        console.error('AJAX error:', error);
                                                    }
                                                });
                                            }

                                            function updateProduct() {
                                                // Implement logic to update an existing product
                                                // Gather data from form fields
                                                var productID = document.getElementById('productID').value;
                                                var productName = document.getElementById('productName').value;
                                                var productExpDate = document.getElementById('productExpDate').value;
                                                var productMnuDate = document.getElementById('productMnuDate').value;
                                                var productPrice = document.getElementById('productPrice').value;
                                                var categoryID = document.getElementById('categoryID').value;
                                                var productQuantity = document.getElementById('productQuantity').value;
                                                var productAvailability = document.getElementById('productAvailability').value;

                                                // Use AJAX to send the data to the server
                                                var xhr = new XMLHttpRequest();
                                                xhr.open('POST', '/Bahuniya%20%5b%20PJ%20%5d/funtions/update_product.php', true);
                                                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                                                // Send the data as a JSON object
                                                var data = {
                                                    productID: productID,
                                                    productName: productName,
                                                    productExpDate: productExpDate,
                                                    productMnuDate: productMnuDate,
                                                    productPrice: productPrice,
                                                    categoryID: categoryID,
                                                    productQuantity: productQuantity,
                                                    productAvailability: productAvailability
                                                };

                                                xhr.send(JSON.stringify(data));

                                                // Reload or update the product table after update
                                                xhr.onload = function () {
                                                    // Check if the update was successful
                                                    if (xhr.status === 200) {
                                                        // Reload or update the product table
                                                        // You can implement this based on your application's needs
                                                        console.log('Product updated successfully');
                                                    } else {
                                                        console.error('Error updating product');
                                                    }
                                                };
                                            }

                                            function deleteProduct() {
                                                // Get the ProductID from the form
                                                var productID = $("#productID").val();

                                                // Confirm with the user before proceeding with deletion
                                                var confirmDelete = confirm("Are you sure you want to delete this product?");
                                                
                                                if (confirmDelete) {
                                                    // Send AJAX request to delete the product
                                                    $.ajax({
                                                        url: "/Bahuniya%20%5b%20PJ%20%5d/funtions/delete_product.php",
                                                        method: "POST",
                                                        data: { productID: productID },
                                                        success: function(response) {
                                                            // Handle the server response, update the UI or reload the product table
                                                            console.log(response);

                                                            // Reload or update the product table after deletion
                                                            // For example, you can call a function to fetch and display the updated product list
                                                            // fetchAndDisplayProductList();
                                                        },
                                                        error: function(error) {
                                                            // Handle any errors that occur during the AJAX request
                                                            console.error("Error deleting product:", error);
                                                        }
                                                    });
                                                }
                                            }

                                            function searchProduct() {
                                                var productID = document.getElementById('productID').value;

                                                // Check if the Product ID is not empty
                                                if (productID.trim() !== '') {
                                                    // Use AJAX to send the search criteria to the server
                                                    var xhr = new XMLHttpRequest();
                                                    xhr.onreadystatechange = function () {
                                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                                            // Parse the JSON response from the server
                                                            var productData = JSON.parse(xhr.responseText);

                                                            // Check if the product was found
                                                            if (productData) {
                                                                // Populate the form fields with the retrieved data
                                                                document.getElementById('productName').value = productData.ProductName;
                                                                document.getElementById('productExpDate').value = productData.ProductExpDate;
                                                                document.getElementById('productMnuDate').value = productData.ProductMnuDate;
                                                                document.getElementById('productPrice').value = productData.ProductPrice;
                                                                document.getElementById('categoryID').value = productData.CategoryID;
                                                                document.getElementById('productQuantity').value = productData.ProductQuantity;
                                                                document.getElementById('productAvailability').value = productData.Availability;
                                                                // Additional fields to be populated based on your actual product table structure

                                                            } else {
                                                                // Handle the case where the product was not found
                                                                alert('Product not found.');
                                                            }
                                                        }
                                                    };

                                                    // Specify the AJAX request details
                                                    xhr.open('GET', '/Bahuniya%20%5b%20PJ%20%5d/funtions/search_product.php?productID=' + productID, true);
                                                    xhr.send();
                                                } else {
                                                    // Display an error if Product ID is empty
                                                    alert('Please enter a Product ID to search.');
                                                }
                                            }

                                        </script>

                                    </div>

                                    <div class="col-md-6">

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

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- UserAccountHandling-->
                    <div id="Orders" class="tab-pane fade">
                        <!-- Display Sales Report Content Here -->
                        <h2>Orders</h2>
                        
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

                    <!-- UserAccountHandling-->
                    <div id="MonthlyIncomeReport" class="tab-pane fade">
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