<?php
session_start();
include('../includes/dbconnection.php');

// Check if the user is logged in (student or teacher)
if (!isset($_SESSION['ocasuid'])) {
    header('location:logout.php');
    exit();
}

// Check if conversation_id is passed in the URL
if (!isset($_GET['conversation_id'])) {
    echo "No conversation selected!";
    exit();
}

$conversation_id = $_GET['conversation_id']; // Get the conversation ID from the URL

// Fetch all messages in the conversation
$sql = "SELECT m.message, m.timestamp, s.FullName AS sender_name, s.Role AS sender_role
        FROM messages m 
        JOIN tbluser s ON m.sender_id = s.ID 
        WHERE m.conversation_id = :conversation_id
        ORDER BY m.timestamp ASC";
$query = $dbh->prepare($sql);
$query->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation Thread</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        }
        .message-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .message-box .sender-name {
            font-weight: bold;
            color: #3498db;
        }
        .message-box .timestamp {
            font-size: 12px;
            color: #777;
        }
        .message-box .message {
            margin-top: 10px;
            color: #333;
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
    </style>
</head>
<body>

    <div class="container">
        <h2>Conversation Thread</h2>

        <?php if (count($messages) > 0) { ?>
            <?php foreach ($messages as $message) { ?>
                <div class="message-box">
                    <span class="sender-name">
                        <?php echo ($message['sender_role'] == 'teacher') ? "Teacher: " : "Student: "; ?>
                        <?php echo $message['sender_name']; ?>
                    </span>
                    <span class="timestamp">
                        (<?php echo date('Y-m-d H:i:s', strtotime($message['timestamp'])); ?>)
                    </span>
                    <div class="message">
                        <?php echo $message['message']; ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No messages found in this conversation.</p>
        <?php } ?>

        <!-- Optional: Add a reply button or a back to messages button -->
        <a href="javascript:history.back()"><button>Back to Messages</button></a>
    </div>

</body>
</html>

<?php
// Close the connection
$dbh = null;
?>
