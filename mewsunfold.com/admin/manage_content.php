<?php 
// manage_content.php

// Include database connection
include('../includes/dbconnection.php');

// Check if form is submitted
if (isset($_POST['upload'])) {
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    
    // File upload logic
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only certain file formats
    $allowedTypes = array('pdf', 'ppt', 'doc', 'docx');
    if (in_array($fileType, $allowedTypes)) {
        // Upload file to the server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert file info into database using PDO
            $sql = "INSERT INTO content (semester, subject, file) VALUES (:semester, :subject, :file)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':semester', $semester);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':file', $fileName);
            
            if ($stmt->execute()) {
                echo "<p>Content uploaded successfully!</p>";
            } else {
                echo "<p>Database error: " . $stmt->errorInfo()[2] . "</p>";
            }
        } else {
            echo "<p>Error uploading file.</p>";
        }
    } else {
        echo "<p>Only PDF, PPT, DOC, and DOCX files are allowed.</p>";
    }
}

// Fetch existing content from the database
$query = "SELECT * FROM content";
$stmt = $dbh->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML Form for uploading content -->
<h2>Upload Content</h2>
<form action="manage_content.php" method="post" enctype="multipart/form-data">
    <label for="semester">Semester:</label>
    <input type="text" name="semester" required><br><br>
    
    <label for="subject">Subject:</label>
    <input type="text" name="subject" required><br><br>
    
    <label for="file">Select File:</label>
    <input type="file" name="file" required><br><br>
    
    <input type="submit" name="upload" value="Upload">
</form>

<!-- Displaying uploaded content -->
<h2>Uploaded Content</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Semester</th>
        <th>Subject</th>
        <th>File</th>
    </tr>
    <?php
    if ($results) {
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['semester'] . "</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "<td><a href='../uploads/" . $row['file'] . "' target='_blank'>" . $row['file'] . "</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No content uploaded yet.</td></tr>";
    }
    ?>
</table>

<?php
// No need to close the connection as PDO handles it automatically
?>
