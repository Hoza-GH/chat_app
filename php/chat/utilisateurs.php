<?php
include '../session/database.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: ../../index.php');
    exit;
}

// On récupère tous les utilisateurs sauf celui connecté 
$stmt = $conn->prepare("SELECT * FROM users WHERE username <> ?");
$stmt->execute([$_SESSION['username']]);
$afficher_profil = $stmt->fetchAll(); // Récupère tous les utilisateurs

$conn->prepare("INSERT INTO user_status(user_id, is_online) VALUES(?, 1) ON DUPLICATE KEY UPDATE is_online = 1, updated_at = NOW()")
    ->execute([$_SESSION['user_id']]);
?>