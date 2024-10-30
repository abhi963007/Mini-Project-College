<?php
// Include the database connection file with the correct path
include('../includes/dbconnection.php'); // Adjusted path to include dbconnection.php

try {
    // Test a simple query
    $query = $dbh->query("SELECT COUNT(*) FROM tbluser"); // Replace with your actual table name
    $count = $query->fetchColumn();
    echo "Connected successfully. Total users in the database: " . $count;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
