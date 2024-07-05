<?php

$dsn = 'mysql:host=localhost;dbname=rose_shop';
$username = 'root';
$password = '';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $conn = new PDO($dsn, $username, $password, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle the exception, for example:
    echo "Connection failed: " . $e->getMessage();
    // Or log the error to a file
    // error_log("Connection failed: " . $e->getMessage(), 3, "error.log");
}

?>