<?php
session_start();
include 'utilisateurs.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['content']) && isset($data['sender_id'])) {
    $content = $data['content'];
    $sender_id = $data['sender_id'];

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO messages (content, sender_id, timestamp) VALUES (:content, :sender_id, NOW())");

    // Lier les paramètres
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':sender_id', $sender_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Échec de l\'insertion dans la base de données.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données manquantes.']);
}
?>