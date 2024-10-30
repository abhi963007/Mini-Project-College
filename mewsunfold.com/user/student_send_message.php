<?php
session_start();
include('../includes/dbconnection.php');

// Ensure the student (user) is logged in
if (!isset($_SESSION['ocasuid']) || $_SESSION['role'] !== 'user') {
    header('location:student_logout.php');
    exit();
}

// Handle form submission for sending a message
if (isset($_POST['send_message'])) {
    $teacher_id = $_POST['teacher_id'];
    $message = $_POST['message'];
    $student_id = $_SESSION['ocasuid'];

    // Insert the message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':sender_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':receiver_id', $teacher_id, PDO::PARAM_INT);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->execute();

    // Redirect to the student dashboard after successful message send
    echo "<script>alert('Message sent successfully!'); window.location.href='dashboard.php';</script>";
}

// Fetch all teachers from tbluser (Role = 'teacher')
$sql = "SELECT ID, FullName FROM tbluser WHERE Role = 'teacher'";
$query = $dbh->prepare($sql);
$query->execute();
$teachers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message to Teacher</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            font-size: 16px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }
        select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            resize: none;
            height: 120px;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #2980b9;
        }
        .alert {
            color: green;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 30px auto;
            }
            h2 {
                font-size: 20px;
            }
            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Send Message to Teacher</h2>

        <form method="POST">
            <label for="teacher_id">Select Teacher:</label>
            <select name="teacher_id" required>
                <option value="">Choose a teacher</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher['ID']; ?>"><?php echo $teacher['FullName']; ?></option>
                <?php } ?>
            </select>

            <label for="message">Your Message:</label>
            <textarea name="message" placeholder="Write your message here..." required></textarea>

            <button type="submit" name="send_message">Send Message</button>
        </form>
    </div>

</body>
</html>
