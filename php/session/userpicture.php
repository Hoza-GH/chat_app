<?php  

require_once 'database.php'; // Ajuste le chemin si besoin


// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Récupérer l'image de profil
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si une image est trouvée, sinon utilise une image par défaut
    $profileImage = !empty($user['profile_picture']) ? $user['profile_picture'] : '../../uploads/default.png';
} else {
    $profileImage = '../../uploads/default.png';
}
?>