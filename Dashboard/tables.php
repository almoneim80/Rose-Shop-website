<?php
// Include database connection
require_once '../connection.php';

// Initialize variables
$users = [];
$products = [];

// Query to get the total number of users
$query_users = "SELECT * FROM users"; // Modify this query according to your database schema
$stmt_users = $conn->query($query_users);

// Check if the query executed successfully
if ($stmt_users) {
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Handle the case when the query fails
    // You can display an error message or log the error
    echo "Error fetching users: " . $conn->errorInfo();
}

// Query to get the total number of products
$query_products = "SELECT * FROM products"; // Modify this query according to your database schema
$stmt_products = $conn->query($query_products);

// Check if the query executed successfully
if ($stmt_products) {
    $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Handle the case when the query fails
    // You can display an error message or log the error
    echo "Error fetching products: " . $conn->errorInfo();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom CSS styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background color */
            padding-top: 50px;
            color: #fff; /* Text color */
        }

        .sidebar a {
            padding: 10px 15px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057; /* Darker background color on hover */
        }

        .sidebar .active {
            background-color: #007bff; /* Active link background color */
        }

        .sidebar .active:hover {
            background-color: #007bff; /* Active link darker background color on hover */
        }

        .sidebar .icon {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .counter {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php" class="active"><i class="fas fa-home icon"></i> Home</a>
        <a href="tables.php"><i class="fas fa-table icon"></i> Tables</a>
        <a href="../index.php"><i class="fas fa-arrow-left icon"></i> Back to Home</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Users Table</h3>
                        <p class="text-muted"><a href="../NewAccount.php" class="btn btn-primary">Add User</a></p>
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Email</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>
                                            <td><?php echo $user['Id']; ?></td>
                                            <td><?php echo $user['Name']; ?></td>
                                            <td><?php echo $user['Email']; ?></td>
                                            <td>
                                            <a href="UpdateUser.php?id=<?php echo $user['Id']; ?>" class="btn btn-primary">Update</a>
                                                <a href="DeleteUser.php?id=<?php echo $user['Id']; ?>" class="btn btn-danger">Delete</a>
                                                <!-- Add the Details button to redirect to userDetails.php -->
                                                <a href="userDetails.php?id=<?php echo $user['Id']; ?>" class="btn btn-info">Details</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Products Table</h3>
                        <p class="text-muted"><a href="AddProduct.php" class="btn btn-primary">Add Product</a></p>
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Price</th>
                                        <th class="border-top-0">Images</th>
                                        <th class="border-top-0">IsNew</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td><?php echo $product['Id']; ?></td>
                                            <td><?php echo $product['Name']; ?></td>
                                            <td><?php echo $product['Price']; ?></td>
                                            <td><?php echo $product['Image']; ?></td>
                                            <td><?php
                                                if ($product['IsNew'] == 1)
                                                    echo "Yes";
                                                else
                                                    echo "No";
                                                ?></td>
                                            <td>
                                                <a href="Update.php?id=<?php echo $product['Id']; ?>" class="btn btn-primary">Update</a>
                                                <a href="DeleteProduct.php?id=<?php echo $product['Id']; ?>" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include any additional scripts for charts or other functionality -->
</body>

</html>
