<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['ocasuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['ocasuid'];
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        
        // Fetch the stored password from the database
        $sql = "SELECT ID, Password FROM tbluser WHERE ID=:uid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Check if the current password matches the stored hash
        if ($query->rowCount() > 0 && password_verify($currentpassword, $results[0]->Password)) {
            // Hash the new password securely
            $newpassword_hashed = password_hash($newpassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $con = "UPDATE tbluser SET Password=:newpassword WHERE ID=:uid";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':uid', $uid, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword_hashed, PDO::PARAM_STR);
            $chngpwd1->execute();

            // Redirect to admin_dashboard.php after success
            echo '<script>alert("Your password has been successfully changed")</script>';
            echo "<script>window.location.href ='admin_dashboard.php'</script>";
        } else {
            echo '<script>alert("Your current password is wrong")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Change Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript">
        function checkpass() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password field do not match');
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="content">
            <?php include_once('includes/header.php'); ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Change Password</h6>
                            <form method="post" name="changepassword" onsubmit="return checkpass();">
                                <div class="mb-3">
                                    <label for="currentpassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="currentpassword" id="currentpassword" required="true">
                                </div>
                                <div class="mb-3">
                                    <label for="newpassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="newpassword" required="true">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmpassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required="true">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
        <?php include_once('includes/back-totop.php'); ?>
    </div>
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
