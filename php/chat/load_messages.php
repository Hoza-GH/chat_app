<?php
// Démarre une nouvelle session
session_start();
// Inclut le fichier contenant la connexion à la base de données
include 'utilisateurs.php'; 

// Requête SQL pour sélectionner le contenu et le nom d'utilisateur de tous les messages, triés par horodatage
$query = "SELECT m.content, u.username FROM messages m JOIN users u ON m.sender_id = u.id ORDER BY m.timestamp ASC";
// Exécute la requête
$result = $conn->query($query);

// Initialise un tableau vide pour stocker les messages
$messages = [];
// Récupère chaque ligne du résultat et l'ajoute au tableau des messages
while ($row = $result->fetch(PDO::FETCH_ASSOC)) { 
    $messages[] = $row;
}

// Encode le tableau des messages en JSON et l'affiche
echo json_encode($messages);
?>