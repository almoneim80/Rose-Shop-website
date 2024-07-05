<?php
// Include database connection
require_once '../connection.php';

// Initialize variables to store product data
$name = $price = $is_new = $image = '';

// Check if product ID is provided
if(isset($_GET['id'])) {
    $productId = $_GET['id'];
    
    // Fetch product data from the database
    $query = "SELECT * FROM products WHERE Id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    
    // Check if product exists
    if($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Populate form fields with product data
        $name = $product['Name'];
        $price = $product['Price'];
        $is_new = $product['IsNew'];
        $image = $product['Image'];
    } else {
        // Product not found, handle accordingly
        echo "<script>alert('Product not found.');</script>";
        header("Location: tables.php");
        exit; // Stop further execution
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input and check if data is different from existing data
        $newName = trim($_POST["name"]);
        $newPrice = floatval($_POST["price"]);
        $newIsNew = isset($_POST["is_new"]) ? intval($_POST["is_new"]) : 0;
        $newImage = $image; // Initialize new image with the existing image by default

        // Check if a new image file has been uploaded
        if (!empty($_FILES['image']['name'])) {
            // Handle image upload only if a new file is provided
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = "uploads/" . $fileName;
            
            // Check if the new image file already exists in the "uploads" folder
            if (!file_exists($targetFilePath)) {
                // If the file doesn't exist, move the uploaded file to the "uploads" folder
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                    $newImage = $targetFilePath; // Set the new image path
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            } else {
                // If the file already exists, use its path without re-uploading
                $newImage = $targetFilePath;
            }
        }

        // Update product data in the database
        $query = "UPDATE products SET Name = :name, Price = :price, IsNew = :is_new, Image = :image WHERE Id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $newName);
        $stmt->bindParam(':price', $newPrice);
        $stmt->bindParam(':is_new', $newIsNew);
        $stmt->bindParam(':image', $fileName);
        $stmt->bindParam(':id', $productId);

        // Execute the query
        if ($stmt->execute()) {
            // Successful modification message
            echo "<script>alert('Product modification successful.');</script>";
            header("Location: tables.php");
        } else {
            // Error message if modification fails
            echo "<script>alert('Failed to modify product.');</script>";
            header("Location: tables.php");
        }
    }
} else {
    // Product ID not provided, handle accordingly
    echo "<script>alert('Product ID not provided.');</script>";
    exit; // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product</title>
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

        /* Custom style for file input */
        .custom-file-input {
            color: transparent;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Choose Image';
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 5px 10px;
            display: inline-block;
            cursor: pointer;
        }

        .custom-file-input:hover::before {
            background-color: #0056b3;
        }

        .custom-file-input:active::before {
            background-color: #003d7f;
        }

        /* Style for selected file name */
        .selected-file-name {
            margin-top: 5px;
            color: #495057;
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
            <h2>Modify Product</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Product Image:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                    <!-- Display just the file name, not the full path -->
                    <div class="selected-file-name"><?php echo pathinfo($image, PATHINFO_FILENAME); ?></div>
                </div>
                <div class="form-group">
                    <label for="is_new">Is New:</label>
                    <select class="form-control" id="is_new" name="is_new">
                        <option value="1" <?php if($is_new == 1) echo 'selected'; ?>>Yes</option>
                        <option value="0" <?php if($is_new == 0) echo 'selected'; ?>>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Update label text with selected file name
        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
</body>

</html>