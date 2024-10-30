<?php
// edit_student.php

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

    // Fetch the current student details
    $sql = "SELECT * FROM tbluser WHERE ID = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $studentId, PDO::PARAM_INT);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_ASSOC);

    // If the form is submitted, update the student details
    if (isset($_POST['update'])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $mobileNumber = $_POST['mobileNumber'];

        // Update query
        $updateSql = "UPDATE tbluser SET FullName = :fullName, Email = :email, MobileNumber = :mobileNumber WHERE ID = :id";
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $updateQuery->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $updateQuery->bindParam(':id', $studentId, PDO::PARAM_INT);
        $updateQuery->execute();

        echo "<script>alert('Student details updated successfully!'); window.location.href='teacher_manage_students.php';</script>";
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Student</h2>
        <form method="POST">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo $student['FullName']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $student['Email']; ?>" required>

            <label for="mobileNumber">Mobile Number:</label>
            <input type="text" id="mobileNumber" name="mobileNumber" value="<?php echo $student['MobileNumber']; ?>" required>

            <button type="submit" name="update">Update</button>
        </form>
    </div>

</body>
</html>

<?php
// Close connection
$dbh = null;
?>
