<?php
// delete_teacher.php

// Include database connection
include('includes/dbconnection.php'); // Adjust path if necessary

// Start session
session_start();

// Check if ID is passed in the URL
if (isset($_GET['id'])) {
    $teacherId = $_GET['id'];

    // Delete teacher from the database
    $sql = "DELETE FROM tbluser WHERE ID = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $teacherId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Teacher deleted successfully!'); window.location.href='manage_teachers.php';</script>";
} else {
    echo "Invalid request!";
    exit;
}
?>

<?php
// Close connection
$dbh = null;
?>
