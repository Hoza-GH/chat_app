<?php
session_start();
include 'php/session/database.php'; // Connexion à la base de données

$valid = true;
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
    $strUsername = htmlentities(trim($_POST['username']));
    $strPassword = htmlentities(trim($_POST['password']));

    // Vérification des champs vides
    if (empty($strUsername)) {
        $valid = false;
        $err_username = "Le nom d'utilisateur ne peut pas être vide";
    }
    if (empty($strPassword)) {
        $valid = false;
        $err_password = "Le mot de passe ne peut pas être vide";
    }

    if ($valid) {
        // Vérifier si l'utilisateur existe
        $req = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $req->execute(array($strUsername));
        $user = $req->fetch();

        if ($user && password_verify($strPassword, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

        // Mise à jour de la date de dernière connexion
        $updateLastLogin = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateLastLogin->execute(array($user['id']));
        
        // Mise à jour du statut de connexion (online)
        $userId = $_SESSION['user_id']; // ID de l'utilisateur connecté
        $conn->prepare("INSERT INTO  user_status(user_id, is_online) VALUES(?, 1) ON DUPLICATE KEY UPDATE is_online = 1, updated_at = NOW()")
                ->execute([$userId]);

            header('Location: php/chat/chat.php'); // Redirige vers l'application
            exit;
        } else {
            $erreur = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Connexion</title>
</head>
<body>
    <h1>Se connecter</h1>

    <?php if (!empty($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>

    <form id="login-form" class="form-container" method="post">
        <label for="login-username">Nom d'utilisateur:</label>
        <input type="text" id="login-username" name="username" required>
        <?php if (isset($err_username)) echo "<p style='color:red;'>$err_username</p>"; ?>

        <label for="login-password">Mot de passe:</label>
        <input type="password" id="login-password" name="password" required>
        <?php if (isset($err_password)) echo "<p style='color:red;'>$err_password</p>"; ?>

        <div class="button-group">
            <button type="submit" class="btn" name="connexion">Se connecter</button>
            <button type="button" class="btn" onclick="window.location.href='php/session/register.php'">S'inscrire</button>
        </div>
    </form>
</body>
</html>