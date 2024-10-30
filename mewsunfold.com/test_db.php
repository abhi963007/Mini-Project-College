<?php
include('admin/includes/dbconnection.php'); // Include the PDO connection

// Test if the connection is successful
if ($dbh) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
}

// Close the connection (optional, PDO will handle it automatically)
$dbh = null;
?>
