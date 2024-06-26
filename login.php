<?php
session_start();

include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials in the User table
    $loginQuery = "SELECT * FROM User WHERE UserEmail = '$email' AND UserPassword = '$password'";
    $loginResult = mysqli_query($conn, $loginQuery);

    if ($loginResult && mysqli_num_rows($loginResult) == 1) {
        $userRow = mysqli_fetch_assoc($loginResult);
        $userID = $userRow['UserID'];

        // Check if the user is a customer
        $customerQuery = "SELECT CustomerID, CustomerName FROM Customer WHERE UserID = '$userID'";
        $customerResult = mysqli_query($conn, $customerQuery);

        if ($customerResult && mysqli_num_rows($customerResult) == 1) {
            // User is a customer, fetch customer information
            $customerRow = mysqli_fetch_assoc($customerResult);

            // Store customer information in session variables
            $_SESSION['user_type'] = 'customer';
            $_SESSION['customer_id'] = $customerRow['CustomerID'];
            $_SESSION['customer_name'] = $customerRow['CustomerName'];

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // Fetch user information
            $userQuery = "SELECT * FROM User WHERE UserID = '$userID'";
            $userResult = mysqli_query($conn, $userQuery);

            if ($userResult && mysqli_num_rows($userResult) == 1) {

                // User exists, fetch user information
                $userRow = mysqli_fetch_assoc($userResult);


                // Check if the user is a staff
                $staffQuery = "SELECT * FROM Staff WHERE UserID = '$userID'";
                $staffResult = mysqli_query($conn, $staffQuery);


                if ($staffResult && mysqli_num_rows($staffResult) == 1) {
                    // User is staff, fetch staff information
                    $staffRow = mysqli_fetch_assoc($staffResult);

                    // Check the staff type and redirect accordingly
                    switch ($staffRow['StaffType']) {
                        case 'Admin':
                            // Store Admin information in session variables
                            $_SESSION['user_type'] = 'admin';
                            $_SESSION['staff_id'] = $staffRow['StaffID'];
                            $_SESSION['staff_name'] = $staffRow['StaffName'];

                            // Redirect to the Admin panel
                            header("Location: staff/admin_panel.php");
                            exit();
                            break;

                        case 'Production Manager':
                            // Store Production Manager information in session variables
                            $_SESSION['user_type'] = 'production_manager';
                            $_SESSION['staff_id'] = $staffRow['StaffID'];
                            $_SESSION['staff_name'] = $staffRow['StaffName'];

                            // Redirect to the Production Manager dashboard
                            header("Location: staff/manager_dashboard.php");
                            exit();
                            break;

                        case 'Chief Accountant':
                            // Store Chief Accountant information in session variables
                            $_SESSION['user_type'] = 'chief_accountant';
                            $_SESSION['staff_id'] = $staffRow['StaffID'];
                            $_SESSION['staff_name'] = $staffRow['StaffName'];

                            // Redirect to the Chief Accountant dashboard
                            header("Location: staff/accountant_dashboard.php");
                            exit();
                            break;

                        case 'Inventory Handling Clerk':
                            // Store Inventory Handling Clerk information in session variables
                            $_SESSION['user_type'] = 'inventory_handling_clerk';
                            $_SESSION['staff_id'] = $staffRow['StaffID'];
                            $_SESSION['staff_name'] = $staffRow['StaffName'];
                    
                            // Debugging output
                            echo "Redirecting to Inventory Handling Clerk dashboard.";
                            header("Location: staff/inventory_handling_clerk_dashboard.php");
                            exit();
                            break;
                            
                        // Add more cases if needed for other staff types
                        default:
                            // Redirect to a default page if the staff type is not recognized
                            header("Location: default_dashboard.php");
                            exit();
                            break;
                    }
                } else {
                    // Handle the case where the user is not a staff member
                    header("Location: default_dashboard.php");
                    exit();
                }
            } else {
                // Handle the case where the user does not exist
                echo "User not found.";
            }
        }
    }

    // If login fails, you can handle it accordingly (display an error message, redirect to login page, etc.)
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body>

    <div class="container mt-4">
        <div class="row">

            <div class="col-md-6 ">
                <h2 class="mb-4">Login</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>

            <div class="col-md-6 ">
                <h2 class="mb-4">Registration</h2>
                <form method="post" action="registration.php">
                    <!-- User Registration Fields -->
                    <div class="form-group">
                        <label for="user_email">Email:</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" required>
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password:</label>
                        <input type="password" class="form-control" id="user_password" name="user_password" required>
                    </div>

                    <!-- Customer Registration Fields -->
                    <div class="form-group">
                        <label for="customer_name">Name:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_tp_no">Telephone Number:</label>
                        <input type="text" class="form-control" id="customer_tp_no" name="customer_tp_no" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_add_house_no">Address House No:</label>
                        <input type="text" class="form-control" id="customer_add_house_no" name="customer_add_house_no" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_add_street_no">Address Street No:</label>
                        <input type="text" class="form-control" id="customer_add_street_no" name="customer_add_street_no" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_add_city">Address City:</label>
                        <input type="text" class="form-control" id="customer_add_city" name="customer_add_city" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="customer_dob" name="customer_dob" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                </form>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
