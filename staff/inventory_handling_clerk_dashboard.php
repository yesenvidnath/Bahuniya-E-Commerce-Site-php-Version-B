<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/staff-header.php');?>

<?php

// Check if the user is logged in and is of type 'Inventory Handling Clerk'
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'inventory_handling_clerk') {

    // Display the Inventory Handling Clerk's information
    echo '<div class="container-fluid nav-sfatt-custom-main">';
    echo    '<div class="row">';
    echo       '<div class="col-md-8">';
    echo           '<h1>Inventory Handling Dashboard</h1>';
    echo           '<h5>Welcome, ' . $_SESSION['staff_name'] . '!</h5>';
    echo       '</div>';
    echo       '<div class="col-md-4 d-flex justify-content-end">';
    echo           '<a class="nav-link" href="/Bahuniya%20%5b%20PJ%20%5d/logout.php"> <i class="fas fa-sign-out-alt"></i> Logout </a>';
    echo       '</div>';
    echo    '</div>';
    echo '</div>';

} else {
    // Redirect to the login page if the user is not logged in as an Inventory Handling Clerk
    header("Location: login.php");
    exit();
}

?>

<div class="container-fluid ">
        <br>
        <br>
        <br>
        <br>
        <div class="row cart-item-cont-custom">

            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account Info</a>
                    <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Product Report</a>
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
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab" style="max-height: 600px; overflow:scroll;">

                        <!-- Display Orders Report -->
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

                        <button class="btn btn-primary">Generate Report</button>
                    </div>

                    <!-- Tab 3: Product Availability -->
                    <div class="tab-pane fade" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-products-tab" style="max-height: 600px; overflow-x:scroll;">
                        <!-- Display Product Availability -->
                        <h2>Product Management</h2>

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
                </div>
            </div>
        </div>
    </div>

<!-- Include glogal heder -->
<?php include('../template_parts/header_footer/footer.php');?>