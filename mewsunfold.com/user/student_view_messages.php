<?php
session_start();
include('../includes/dbconnection.php');

// Ensure the student is logged in
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'user') {
    header('location:student_logout.php');
    exit();
}

$student_id = $_SESSION['ocasuid'];

// Fetch the student's question and teacher's reply, excluding deleted messages and without causing duplicates
$sql = "SELECT m.id as message_id, m.message, m.timestamp, 
               CASE 
                   WHEN m.sender_id = :student_id THEN 'student' 
                   WHEN m.sender_id != :student_id AND t.Role = 'teacher' THEN 'teacher' 
               END as sender_role, 
               t.FullName AS teacher_name 
        FROM messages m 
        JOIN tbluser t ON (m.sender_id = t.ID OR m.receiver_id = t.ID)
        WHERE (m.sender_id = :student_id OR m.receiver_id = :student_id)
          AND m.deleted_by_teacher = 0 AND m.deleted_by_student = 0
          AND t.Role = 'teacher'
        GROUP BY m.id
        ORDER BY m.timestamp ASC";
$query = $dbh->prepare($sql);
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle message deletion (soft delete for students)
if (isset($_GET['delete_id'])) {
    $message_id = $_GET['delete_id'];

    // Mark the message as deleted by the student
    $sql = "UPDATE messages SET deleted_by_student = 1 WHERE id = :message_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':message_id', $message_id, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Message deleted successfully!'); window.location.href='student_view_messages.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
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
        .message-box {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .student-message {
            color: #3498db;
        }
        .teacher-reply {
            color: #27ae60;
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
        <h2>Your Conversations</h2>

        <?php if (count($messages) > 0) { ?>
            <?php foreach ($messages as $message) { ?>
                <div class="message-box">
                    <?php if ($message['sender_role'] === 'student') { ?>
                        <!-- Display student's question -->
                        <p class="student-message"><strong>You (Student):</strong> <?php echo $message['message']; ?></p>
                    <?php } else { ?>
                        <!-- Display teacher's reply -->
                        <p class="teacher-reply"><strong><?php echo $message['teacher_name']; ?> (Teacher):</strong> <?php echo $message['message']; ?></p>
                    <?php } ?>
                    <p><small><em><?php echo date('Y-m-d H:i:s', strtotime($message['timestamp'])); ?></em></small></p>
                    <a href="student_view_messages.php?delete_id=<?php echo $message['message_id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this message?');">
                        <button class="delete-btn">Delete</button>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No messages found in this conversation.</p>
        <?php } ?>
    </div>
</body>
</html>
