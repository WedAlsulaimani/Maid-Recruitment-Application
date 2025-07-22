<?php
$conn = new mysqli("localhost", "root", "", "info");

$id = intval($_GET['id']);
$result = $conn->query("SELECT status FROM user_info WHERE id = $id");
$row = $result->fetch_assoc();
$newStatus = $row['status'] == 1 ? 0 : 1;

$conn->query("UPDATE user_info SET status = $newStatus WHERE id = $id");
echo $newStatus;
