<?php
// Include database connection
require_once '../connection.php';

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE Id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    
    // Check if user exists
    if($stmt->rowCount() > 0) {
        // If user exists, proceed with deletion
        $query_delete = "DELETE FROM users WHERE Id = :id";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bindParam(':id', $userId);
        
        // Execute the deletion query
        if ($stmt_delete->execute()) {
            // Deletion successful, redirect back to the previous page
            header("Location: tables.php");
            exit;
        } else {
            // Deletion failed, handle accordingly
            echo "<script>alert('Failed to delete user.');</script>";
            header("Location: tables.php");
            exit; // Stop further execution
        }
    } else {
        // User not found, handle accordingly
        echo "<script>alert('User not found.');</script>";
        header("Location: tables.php");
        exit; // Stop further execution
    }
} else {
    // User ID not provided, handle accordingly
    echo "<script>alert('User ID not provided.');</script>";
    header("Location: tables.php");
    exit; // Stop further execution
}
?>