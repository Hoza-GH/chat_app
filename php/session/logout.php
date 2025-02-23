<?php
session_start();
include 'database.php'; // Connexion à la base de données

if (isset($_SESSION['user_id'])) {
    // Mise à jour de la date de dernière déconnexion
    $updateLastLogout = $conn->prepare("UPDATE users SET last_logout = NOW() WHERE id = ?");
    $updateLastLogout->execute(array($_SESSION['user_id']));

    // Mise à jour du statut de deconnexion (offline)
    $userId = $_SESSION['user_id'];
    $conn->prepare("UPDATE user_status SET is_online = 0, updated_at = NOW() WHERE user_id = ?")
        ->execute([$userId]);

    // Détruire la session
    session_unset();
    session_destroy();
}

// Rediriger vers la page de connexion
header('Location: ../../index.php');
exit;
?>