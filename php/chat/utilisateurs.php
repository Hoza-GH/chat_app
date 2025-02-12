<?php
include '../session/database.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: ../../index.php');
    exit;
}

// On récupère tous les utilisateurs sauf celui connecté 
$stmt = $conn->prepare("SELECT * FROM users WHERE username <> ?");
$stmt->execute([$_SESSION['username']]);
$afficher_profil = $stmt->fetchAll(); // fetchAll() permet de récupérer plusieurs enregistrements
?>