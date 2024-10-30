<?php
session_start();
include('../includes/dbconnection.php');

if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'user') {
    header('location:logout.php');
    exit();
}

$uid = $_SESSION['ocasuid'];

// Fetch current user details
$sql = "SELECT * FROM tbluser WHERE ID = :uid";
$query = $dbh->prepare($sql);
$query->bindParam(':uid', $uid, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch(PDO::FETCH_OBJ);

// Update logic
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $mobno = $_POST['mobno'];
    // Add more fields as necessary
    $sqlUpdate = "UPDATE tbluser SET FullName = :fname, MobileNumber = :mobno WHERE ID = :uid";
    $queryUpdate = $dbh->prepare($sqlUpdate);
    $queryUpdate->bindParam(':fname', $fname, PDO::PARAM_STR);
    $queryUpdate->bindParam(':mobno', $mobno, PDO::PARAM_INT);
    $queryUpdate->bindParam(':uid', $uid, PDO::PARAM_INT);
    $queryUpdate->execute();
    echo "<script>alert('Profile updated successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Adjust path -->
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="">
        <label for="fname">Full Name:</label>
        <input type="text" name="fname" value="<?php echo htmlentities($user->FullName); ?>" required>
        
        <label for="mobno">Mobile Number:</label>
        <input type="text" name="mobno" value="<?php echo htmlentities($user->MobileNumber); ?>" required pattern="[0-9]{10}" maxlength="10">
        
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
