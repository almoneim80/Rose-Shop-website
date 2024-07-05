<?php
// Include database connection
require_once '../connection.php';

// Initialize variables to store user data
$name = $email = $password = '';

// Check if user ID is provided
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE ID = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    
    // Check if user exists
    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Populate form fields with user data
        $name = $user['Name'];
        $email = $user['Email'];
        // Password is not retrieved for security reasons
    } else {
        // User not found, handle accordingly
        echo "<script>alert('User not found.');</script>";
        header("Location: tables.php");
        exit; // Stop further execution
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input and check if data is different from existing data
        $newName = trim($_POST["name"]);
        $newEmail = trim($_POST["email"]);
        // Password should be hashed before storing in the database for security reasons
        $newPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

        // Update user data in the database
        $query = "UPDATE users SET Name = :name, Email = :email, Password = :password WHERE ID = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $newName);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':id', $userId);

        // Execute the query
        if ($stmt->execute()) {
            // Successful modification message
            echo "<script>alert('User modification successful.');</script>";
            header("Location: tables.php");
        } else {
            // Error message if modification fails
            echo "<script>alert('Failed to modify user.');</script>";
            header("Location: tables.php");
        }
    }
} else {
    // User ID not provided, handle accordingly
    echo "<script>alert('User ID not provided.');</script>";
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User</title>
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

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php"><i class="fas fa-home icon"></i> Home</a>
        <a href="tables.php"><i class="fas fa-table icon"></i> Tables</a>
        <a href="../index.php"><i class="fas fa-arrow-left icon"></i> Back to Home</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div class="container">
            <h2>Modify User</h2>
            <form method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>