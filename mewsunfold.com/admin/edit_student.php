<?php
// edit_student.php

// Include database connection
include('includes/dbconnection.php'); // Adjust path if necessary

// Start session
session_start();

// Check if ID is passed in the URL
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Fetch student details from the database
    $sql = "SELECT * FROM tbluser WHERE ID = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $studentId, PDO::PARAM_INT);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_ASSOC);

    // If form is submitted, update student details
    if (isset($_POST['update'])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $mobileNumber = $_POST['mobileNumber'];

        // Update student details in the database
        $updateSql = "UPDATE tbluser SET FullName = :fullName, Email = :email, MobileNumber = :mobileNumber WHERE ID = :id";
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $updateQuery->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $updateQuery->bindParam(':id', $studentId, PDO::PARAM_INT);
        $updateQuery->execute();

        echo "<script>alert('Student details updated successfully!'); window.location.href='manage_students.php';</script>";
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
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }
        button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Student</h1>

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
