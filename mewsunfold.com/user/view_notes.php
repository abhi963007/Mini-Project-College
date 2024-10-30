<?php
session_start();
include('../includes/dbconnection.php');

if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'user') {
    header('location:logout.php');
    exit();
}

// Fetch user notes
$uid = $_SESSION['ocasuid'];
$sql = "SELECT * FROM tblnotes WHERE UserID = :uid";
$query = $dbh->prepare($sql);
$query->bindParam(':uid', $uid, PDO::PARAM_INT);
$query->execute();
$notes = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Notes</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Adjust path -->
</head>
<body>
    <h1>Your Notes</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Subject</th>
            <th>Action</th>
        </tr>
        <?php foreach ($notes as $note) { ?>
        <tr>
            <td><?php echo htmlentities($note->NotesTitle); ?></td>
            <td><?php echo htmlentities($note->Subject); ?></td>
            <td><a href="edit_note.php?id=<?php echo $note->ID; ?>">Edit</a> | <a href="delete_note.php?id=<?php echo $note->ID; ?>">Delete</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
