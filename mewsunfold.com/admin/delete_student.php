<?php
// delete_student.php

// Include database connection
include('includes/dbconnection.php'); // Adjust path if necessary

// Start session
session_start();

// Check if ID is passed in the URL
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Delete student from the database
    $sql = "DELETE FROM tbluser WHERE ID = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $studentId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Student deleted successfully!'); window.location.href='manage_students.php';</script>";
} else {
    echo "Invalid request!";
    exit;
}
?>

<?php
// Close connection
$dbh = null;
?>
