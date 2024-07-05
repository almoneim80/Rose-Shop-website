<?php
// Include database connection
require_once '../connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $name = trim($_POST["name"]);
    $price = floatval($_POST["price"]);
    $is_new = isset($_POST["is_new"]) ? intval($_POST["is_new"]) : 0;

    // Check if a file was uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Valid extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file extension is valid
        if (in_array($fileExtension, $allowedExtensions)) {
            // Set upload directory path
            $uploadDir = 'uploads/';
            // Set unique file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            // Set final file path
            $destFilePath = $uploadDir . $newFileName;

            // Upload the file to the specified path
            if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                // Insert product into the database
                $query = "INSERT INTO products (Name, Price, Image, IsNew) VALUES (:name, :price, :image, :is_new)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image', $newFileName); // Save the filename in the database
                $stmt->bindParam(':is_new', $is_new);

                // Execute the query
                if ($stmt->execute()) {
                    // Product added successfully
                    echo "<script>alert('Product added successfully.');</script>";
                } else {
                    // Failed to add product
                    echo "<script>alert('Failed to add product.');</script>";
                }
            } else {
                // Failed to move the uploaded file
                echo "<script>alert('Failed to move uploaded file.');</script>";
            }
        } else {
            // Invalid file extension
            echo "<script>alert('Invalid file extension.');</script>";
        }
    } else {
        // No file uploaded or an error occurred during file upload
        echo "<script>alert('No file uploaded or an error occurred during file upload.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            <h2>Add Product</h2>
            <form action="AddProduct.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="image">Product Image:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required>
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                    <div class="selected-file-name"></div> <!-- Placeholder for displaying selected file name -->
                </div>
                <div class="form-group">
                    <label for="is_new">Is New:</label>
                    <select class="form-control" id="is_new" name="is_new">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
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