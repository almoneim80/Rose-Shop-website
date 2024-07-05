<?php
// Include database connection
require_once '../connection.php';

// Query to get the total number of users
$query_users = "SELECT COUNT(*) AS total_users FROM users";
$stmt_users = $conn->query($query_users);
$total_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['total_users'];

// Query to get the total number of products
$query_products = "SELECT COUNT(*) AS total_products FROM products";
$stmt_products = $conn->query($query_products);
$total_products = $stmt_products->fetch(PDO::FETCH_ASSOC)['total_products'];
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
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Total Users</h3>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <canvas id="sparklinedash1" width="67" height="30"></canvas>
                                </div>
                                <div class="counter text-success"><?php echo $total_users; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Total Products</h3>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <canvas id="sparklinedash2" width="67" height="30"></canvas>
                                </div>
                                <div class="counter text-purple"><?php echo $total_products; ?></div>
                            </div>
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