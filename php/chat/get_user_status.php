<?php
session_start();
require '../session/database.php';

$stmt = $conn->prepare("
    SELECT user_id, is_online FROM user_status
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
