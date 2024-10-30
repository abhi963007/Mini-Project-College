<?php
include('config.php');

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

echo "<table>";
echo "<tr><th>Username</th><th>Email</th><th>Actions</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['username']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td><a href='edit_user.php?id=".$row['id']."'>Edit</a> | <a href='delete_user.php?id=".$row['id']."'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
