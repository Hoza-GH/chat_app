<?php
include 'database.php'; // Inclure le fichier de connexion à la base de données


$valid = true; // Initialiser la variable $valid a vraie
$errors = []; // Tableau pour stocker les messages d'erreur

    if (isset($_POST['creer'])){
        $strUsername = htmlentities(trim($_POST['username'])); // On récupère le username
        $strPassword = htmlentities(trim($_POST['password'])); // On récupère le mdp
        $strConfirm = htmlentities(trim($_POST['confirm-password']));

        //verification du username
        if(empty($strUsername)){
            $valid = false;
            $errors[] = "Le nom d'utilisateur ne peut pas être vide";
        }
        
        //verification du mdp
        if(empty($strPassword)){
            $valid = false;
            $errors[] = "Le mot de passe ne peut pas être vide";
        }
        //verification de confirmation
        if(empty($strConfirm)){
            $valid = false;
            $errors[] = "La confirmation du mot de passe n'est pas valide";
        }elseif(!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $strUsername)) { //On verifie si le ne mets pas de chiffre au début
            $valid = false;
            $errors[] = "Le nom d'utilisateur doit commencer par une lettre.";
        }else{
            //On verifie si le nom d'utilisateur est disponible
            $req_user = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $req_user->execute(array($strUsername));
            $req_user = $req_user->fetch();

            if ($req_user['username'] <> ""){
                $valid = false;
                $errors[] = "Ce nom d'utilisateur n'est pas disponible";
            }
        }

        // Vérification du mot de passe
        if($strPassword != $strConfirm){
            $valid = false;
            $errors[] = "La confirmation du mot de passe ne correspond pas";
        }

        //Si toutes  les conditions sont remplies alors on créer le compte
        if ($valid){
            $hashedPassword = password_hash($strPassword,PASSWORD_DEFAULT); //On hash le mdp

            $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)")->execute(array($strUsername, $hashedPassword));

            header('Location: ../../index.php');
            exit;
        }else{
            $erreur = implode("<br>", $errors); // Concatène les erreurs pour affichage
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Créer un compte</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <?php if (!empty($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form id="signup-form" class="form-container" method="POST">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm-password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        
        <button type="submit" name = "creer" class="btn">Confirmer</button>
    </form>
</body>
</html>
