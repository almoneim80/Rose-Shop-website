<?php
// Include database connection
require_once '../connection.php';

// Check if product ID is provided in the URL
if(isset($_GET['id'])) {
    $productId = $_GET['id'];
    
    // Fetch product data from the database
    $query = "SELECT * FROM products WHERE Id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    
    // Check if product exists
    if($stmt->rowCount() > 0) {
        // If product exists, proceed with deletion
        $query_delete = "DELETE FROM products WHERE Id = :id";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bindParam(':id', $productId);
        
        // Execute the deletion query
        if ($stmt_delete->execute()) {
            // Deletion successful, redirect back to the previous page
            header("Location: tables.php");
            exit;
        } else {
            // Deletion failed, handle accordingly
            echo "<script>alert('Failed to delete product.');</script>";
            header("Location: tables.php");
            exit; // Stop further execution
        }
    } else {
        // Product not found, handle accordingly
        echo "<script>alert('Product not found.');</script>";
        header("Location: tables.php");
        exit; // Stop further execution
    }
} else {
    // Product ID not provided, handle accordingly
    echo "<script>alert('Product ID not provided.');</script>";
    header("Location: tables.php");
    exit; // Stop further execution
}
?>