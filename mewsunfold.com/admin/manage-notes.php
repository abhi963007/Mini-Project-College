<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ocasuid'] == 0)) {
    header('location:logout.php');
} else {
    // Delete functionality
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblnotes WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Note deleted successfully');</script>"; 
        echo "<script>window.location.href = 'manage-notes.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Manage Notes</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
        <?php include_once('includes/sidebar.php'); ?>
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php'); ?>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Manage Notes</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">#</th>
                                    <th scope="col">Teacher/Admin Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Notes Title</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    // Fetch all notes with the admin uploads first, then teachers, and order by creation date
                                    $sql = "SELECT tblnotes.*, tbluser.FullName, tbluser.Role 
                                            FROM tblnotes 
                                            JOIN tbluser ON tblnotes.UserID = tbluser.ID
                                            ORDER BY tbluser.Role = 'admin' DESC, tblnotes.CreationDate DESC";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($row->FullName); ?></td>
                                    <td><?php echo htmlentities($row->Role); ?></td>
                                    <td><?php echo htmlentities($row->Subject); ?></td>
                                    <td><?php echo htmlentities($row->NotesTitle); ?></td>
                                    <td><?php echo htmlentities($row->CreationDate); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="edit-notes.php?editid=<?php echo htmlentities($row->ID); ?>">Edit</a>
                                        <a class="btn btn-sm btn-danger" href="manage-notes.php?delid=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('Do you really want to delete this note?');">Delete</a>
                                    </td>
                                </tr>
                                <?php 
                                    $cnt = $cnt + 1;
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No notes found.</td></tr>";
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php'); ?>
        </div>
        <!-- Content End -->
        <?php include_once('includes/back-totop.php'); ?>
    </div>

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php } ?>
