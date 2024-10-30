<?php
// teacher_manage_students.php

// Include database connection
include('../includes/dbconnection.php'); // Adjust the path if necessary

// Start session
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'teacher') {
    header('location:teacher_logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <!-- Inline CSS for the table styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Students</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch students from the database
                $sql = "SELECT ID, FullName, Email, MobileNumber FROM tbluser WHERE Role = 'user'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                        echo "<tr>
                                <td>" . $row['ID'] . "</td>
                                <td>" . $row['FullName'] . "</td>
                                <td>" . $row['Email'] . "</td>
                                <td>" . $row['MobileNumber'] . "</td>
                                <td>
                                    <a href='edit_student.php?id=" . $row['ID'] . "'>Edit</a> |
                                    <a href='delete_student.php?id=" . $row['ID'] . "' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Close the PDO connection
$dbh = null;
?>
