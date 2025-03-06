<?php
include '../session/database.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: ../../index.php');
    exit;
}

// Mise à jour du statut de connexion de l'utilisateur connecté
$conn->prepare("
    INSERT INTO user_status(user_id, is_online) 
    VALUES(?, 1) 
    ON DUPLICATE KEY UPDATE is_online = 1, updated_at = NOW()
")->execute([$_SESSION['user_id']]);

// Récupérer tous les utilisateurs avec leur statut is_online
$stmt = $conn->prepare("
    SELECT users.id, users.username, users.profile_picture, user_status.is_online 
    FROM users 
    LEFT JOIN user_status ON users.id = user_status.user_id
    WHERE users.username <> ?
");
$stmt->execute([$_SESSION['username']]);
$afficher_profil = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
