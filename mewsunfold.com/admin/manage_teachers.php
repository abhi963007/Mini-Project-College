<?php
// manage_teachers.php

// Include database connection
include('includes/dbconnection.php'); // Adjust path if necessary

// Start session or any other necessary initialization
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <!-- Inline CSS for the table styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            margin-top: 50px;
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
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Teachers</h1>

        <!-- Display teacher management options here -->
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
                // Fetch teachers from the database (only those with the 'teacher' role)
                $sql = "SELECT ID, FullName, Email, MobileNumber FROM tbluser WHERE Role = 'teacher'";
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
                                    <a href='edit_teacher.php?id=" . $row['ID'] . "'>Edit</a> |
                                    <a href='delete_teacher.php?id=" . $row['ID'] . "' onclick=\"return confirm('Are you sure you want to delete this teacher?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No teachers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Close the PDO connection (optional)
$dbh = null;
?>
