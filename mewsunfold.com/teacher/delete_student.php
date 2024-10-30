<?php
// delete_student.php

// Include database connection
include('../includes/dbconnection.php');

// Start session
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'teacher') {
    header('location:teacher_logout.php');
    exit();
}

// Check if the student ID is passed in the URL
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Delete the student from the database
    $sql = "DELETE FROM tbluser WHERE ID = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $studentId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Student deleted successfully!'); window.location.href='teacher_manage_students.php';</script>";
} else {
    echo "Invalid request!";
    exit();
}
?>

<?php
// Close connection
$dbh = null;
?>
