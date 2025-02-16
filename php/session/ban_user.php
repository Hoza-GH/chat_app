<?php
session_start();
include '../session/database.php'; // Inclure la connexion à la base de données

if (!isset($_SESSION['username']) || $_SESSION['username'] !== "admin") {
    http_response_code(403); // Interdire l'accès si ce n'est pas un admin
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$usernameToBan = $data['username'];

// Préparer la requête pour supprimer l'utilisateur de la base de données
$stmt = $conn->prepare("DELETE FROM users WHERE username = :username");
$stmt->bindParam(':username', $usernameToBan);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); // Erreur serveur
    echo json_encode(['success' => false, 'message' => 'Erreur lors du bannissement de l\'utilisateur.']);
}
?>