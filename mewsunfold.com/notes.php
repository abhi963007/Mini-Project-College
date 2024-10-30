<?php
session_start();
include('user/includes/dbconnection.php');

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['ocasuid']) || strlen($_SESSION['ocasuid']) == 0) {
    header('location:logout.php');
}

// Get role of the logged-in user (admin/teacher)
$role = $_SESSION['role']; 

// Pagination setup
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$no_of_records_per_page = 10;
$offset = ($pageno - 1) * $no_of_records_per_page;

// Get the total number of notes
$ret = "SELECT ID FROM tblnotes";
$query1 = $dbh->prepare($ret);
$query1->execute();
$total_rows = $query1->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);

// Fetch notes and user details
$sql = "SELECT tblnotes.*, tbluser.FullName, tbluser.Role 
        FROM tblnotes 
        JOIN tbluser ON tblnotes.UserID = tbluser.ID 
        LIMIT $offset, $no_of_records_per_page";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="zxx">
<head>
    <title>Online Notes Sharing System | Notes</title>
    <!-- CSS links -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style2.css">
</head>
<body>

<!-- Include the header -->
<?php include_once('includes/header-notes.php'); ?>

<!-- Main content area -->
<main>
    <section class="slider-area slider-area2">
        <div class="slider-active">
            <div class="single-slider slider-height2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-11 col-md-12">
                            <div class="hero__caption hero__caption2">
                                <h1>Our Notes</h1>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Notes</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
        </div>
    </section>

    <div class="courses-area section-padding40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Our Featured Notes</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { 
                ?>
                <div class="col-lg-6">
                    <div class="properties properties2 mb-30">
                        <div class="properties__card">
                            <div class="properties__caption">
                                <p><?php echo htmlentities($row->Subject); ?></p>
                                <h3><?php echo htmlentities($row->NotesTitle); ?> by (<?php echo htmlentities($row->FullName); ?>)</h3>
                                <p><?php echo htmlentities($row->NotesDecription); ?></p>

                                <!-- Files Display with Download Option -->
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <table border="1">
                                        <tr>
                                            <th width="200"><strong>File 1</strong></th>
                                            <td colspan="3" style="text-align: center;">
                                                <a href="<?php echo ($row->Role == 'admin') ? 'admin/folder1/' : 'teacher/folder1/'; ?><?php echo $row->File1; ?>" target="_blank" class="btn btn-primary">Download File</a>
                                            </td>
                                        </tr>

                                        <!-- File 2 -->
                                        <?php if ($row->File2 == "") { ?>
                                        <tr>
                                            <th width="200"><strong>File 2</strong></th>
                                            <td colspan="3" style="text-align: center;"><strong style="color: red">File not available</strong></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <th width="200"><strong>File 2</strong></th>
                                            <td colspan="3" style="text-align: center;">
                                                <a href="<?php echo ($row->Role == 'admin') ? 'admin/folder2/' : 'teacher/folder2/'; ?><?php echo $row->File2; ?>" target="_blank" class="btn btn-primary">Download File</a>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                        <!-- File 3 -->
                                        <?php if ($row->File3 == "") { ?>
                                        <tr>
                                            <th width="200"><strong>File 3</strong></th>
                                            <td colspan="3" style="text-align: center;"><strong style="color: red">File not available</strong></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <th width="200"><strong>File 3</strong></th>
                                            <td colspan="3" style="text-align: center;">
                                                <a href="<?php echo ($row->Role == 'admin') ? 'admin/folder3/' : 'teacher/folder3/'; ?><?php echo $row->File3; ?>" target="_blank" class="btn btn-primary">Download File</a>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                        <!-- File 4 -->
                                        <?php if ($row->File4 == "") { ?>
                                        <tr>
                                            <th width="200"><strong>File 4</strong></th>
                                            <td colspan="3" style="text-align: center;"><strong style="color: red">File not available</strong></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <th width="200"><strong>File 4</strong></th>
                                            <td colspan="3" style="text-align: center;">
                                                <a href="<?php echo ($row->Role == 'admin') ? 'admin/folder4/' : 'teacher/folder4/'; ?><?php echo $row->File4; ?>" target="_blank" class="btn btn-primary">Download File</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } else { echo '<p>No notes found.</p>'; } ?>
            </div>

            <!-- Pagination -->
            <div align="left">
                <ul class="pagination">
                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                    <li class="<?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                        <a href="<?php if ($pageno > 1) { echo "?pageno=" . ($pageno - 1); } ?>"><strong>Prev</strong></a>
                    </li>
                    <li class="<?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                        <a href="<?php if ($pageno < $total_pages) { echo "?pageno=" . ($pageno + 1); } ?>"><strong>Next</strong></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong>Last</strong></a></li>
                </ul>
            </div>
        </div>
    </div>
</main>

<!-- Include the footer -->
<?php include_once('includes/footer.php'); ?>

<!-- JS scripts -->
<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
