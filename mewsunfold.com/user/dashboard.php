<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/dbconnection.php');

// Check if the user is logged in
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'user') {
    header('location:logout.php');
    exit();
}

// Fetch user details
$uid = $_SESSION['ocasuid'];
$sql = "SELECT * FROM tbluser WHERE ID = :uid";
$query = $dbh->prepare($sql);
$query->bindParam(':uid', $uid, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch(PDO::FETCH_OBJ);

// Check if user details were fetched successfully
if (!$user) {
    echo "<script>alert('User details not found.'); window.location.href='logout.php';</script>";
    exit();
}

// Fetch total uploaded subject notes
$sqlNotes = "SELECT COUNT(*) as total_notes FROM tblnotes WHERE UserID = :uid";
$queryNotes = $dbh->prepare($sqlNotes);
$queryNotes->bindParam(':uid', $uid, PDO::PARAM_INT);
$queryNotes->execute();
$totalNotes = $queryNotes->fetch(PDO::FETCH_OBJ)->total_notes;

// Fetch total uploaded files
$sqlFiles = "SELECT 
    COUNT(IF(File1 != '', 1, NULL)) +
    COUNT(IF(File2 != '', 1, NULL)) +
    COUNT(IF(File3 != '', 1, NULL)) +
    COUNT(IF(File4 != '', 1, NULL)) as total_files
FROM tblnotes WHERE UserID = :uid";
$queryFiles = $dbh->prepare($sqlFiles);
$queryFiles->bindParam(':uid', $uid, PDO::PARAM_INT);
$queryFiles->execute();
$totalFiles = $queryFiles->fetch(PDO::FETCH_OBJ)->total_files;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include_once('includes/sidebar.php'); ?>
        
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php'); ?>

            <!-- User Greeting -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <h1>Hello, <?php echo htmlspecialchars($user->FullName); ?> <span></span></h1>
                </div>
            </div>

            <!-- Recent Activity Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-8">
                    <div class="col-sm-6 col-xl-4">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-file fa-6x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Uploaded Subject Notes</p>
                                <a href="../notes.php"><h5>View Details</h5></a>
                            </div>
                        </div>
                    </div>
            <!-- Recent Activity End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>