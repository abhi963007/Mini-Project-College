<?php
session_start();
include('../includes/dbconnection.php');

// Ensure the teacher is logged in
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'teacher') {
    header('location:teacher_logout.php');
    exit();
}

$teacher_id = $_SESSION['ocasuid'];

// Fetch messages sent to the teacher, excluding messages that the teacher has marked as deleted
$sql = "SELECT m.id as message_id, m.conversation_id, m.message, m.sender_id, m.timestamp, s.FullName AS student_name 
        FROM messages m 
        JOIN tbluser s ON m.sender_id = s.ID 
        WHERE m.receiver_id = :teacher_id AND m.deleted_by_teacher = 0";
$query = $dbh->prepare($sql);
$query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle reply submission
if (isset($_POST['reply'])) {
    $message = $_POST['message'];
    $student_id = $_POST['student_id'];
    $conversation_id = $_POST['conversation_id'];

    // Insert the reply into the messages table
    $sql = "INSERT INTO messages (conversation_id, sender_id, receiver_id, message) 
            VALUES (:conversation_id, :sender_id, :receiver_id, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
    $query->bindParam(':sender_id', $teacher_id, PDO::PARAM_INT); // Teacher sending the message
    $query->bindParam(':receiver_id', $student_id, PDO::PARAM_INT); // Student receiving the reply
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Reply sent successfully!'); window.location.href='teacher_view_messages.php';</script>";
}

// Handle message deletion (soft delete for teachers)
if (isset($_GET['delete_id'])) {
    $message_id = $_GET['delete_id'];

    // Mark the message as deleted by the teacher
    $sql = "UPDATE messages SET deleted_by_teacher = 1 WHERE id = :message_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':message_id', $message_id, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Message deleted successfully!'); window.location.href='teacher_view_messages.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher View Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Messages from Students</h2>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Message</th>
                    <th>Date/Time</th>
                    <th>Reply</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) { ?>
                    <tr>
                        <td><?php echo $message['student_name']; ?></td>
                        <td><?php echo $message['message']; ?></td>
                        <td><?php echo $message['timestamp']; ?></td>
                        <td>
                            <!-- Reply Form -->
                            <form method="POST">
                                <textarea name="message" rows="2" placeholder="Enter your reply"></textarea>
                                <input type="hidden" name="student_id" value="<?php echo $message['sender_id']; ?>">
                                <input type="hidden" name="conversation_id" value="<?php echo $message['conversation_id']; ?>">
                                <button type="submit" name="reply">Send Reply</button>
                            </form>
                        </td>
                        <td>
                            <!-- Delete Button with Confirmation -->
                            <a href="teacher_view_messages.php?delete_id=<?php echo $message['message_id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this message?');">
                                <button class="delete-btn">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
