<?php

session_start();
include_once '../session/userpicture.php';
include 'utilisateurs.php';
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT is_online FROM user_status WHERE user_id = ?");
$stmt->execute([$userId]);
$status = $stmt->fetchColumn();

//Récupère le nom de la personne connecté
$username = $_SESSION['username'];
$isAdmin = $username === "admin"
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/chat.css">
    <script src="../../js/banUser.js"></script>
    <script src="../../js/status.js"></script>
    <title>Chat</title>
</head>
<body>

    <div class="sidebar">
        <!--Afficher le nom de l'utilisateur connecté-->
        <h2 class="profile">
            <div style="position: relative; display: inline-block;">
                <img class="uploadImg" src="<?php echo htmlspecialchars($profileImage); ?>" 
                    alt="Photo de profil" width="50" height="50" onclick="changeImg()">
                <span style="position: absolute;"class="status-profile <?= $status ? 'online' : 'offline'; ?>"></span>
            </div>
            <strong class="name-profile"><?php echo ucfirst($username); ?></strong>
        </h2>


        <div class="content">
            <h4 class = "userListHeader">
                Utilisateurs connectés
            </h4>
            <hr /> 
            <div class="user-container">
                <ul>
                <!--Afficher tous les utilisateurs ayant un compte-->
                <?php
                    foreach($afficher_profil as $ap) {
                        echo '<li class="user-item" style="position: relative;">';
                        echo '<div style="position: relative; display: inline-block;">';  // Conteneur pour l'image et la pastille
                            echo '<img class="listImg" src="'.htmlspecialchars($ap['profile_picture']).'" alt="Photo de profil" width="30" height="30">';
                            $isOnline = $ap['is_online'] ?? 0;  // Vérifier si l'utilisateur est en ligne
                            echo '<span class="status-list ' . ($isOnline ? 'online' : 'offline') . '"></span>';
                        echo '</div>';
                        echo ucfirst(htmlspecialchars($ap['username']));  // Afficher le nom d'utilisateur
                        // Afficher la croix si l'utilisateur est admin
                        if ($isAdmin) {
                            echo ' <span class="option-user" onclick="banUser(\'' . htmlspecialchars($ap['username']) . '\')">x</span>'; // Croix pour bannir
                        }
                        echo '</li>';
                        
                    }
                ?>
                </ul>
            </div>   
            

            
            
        </div>
        
        <form method="post" action="../session/logout.php">
            <button type="submit" class="btn-logout">Déconnexion</button>
        </form>
    </div>

    <div class="chat-container">
        <div class="chat-box" id="chat-box">
            
        </div>

        <div class="chat-input">
            <input type="text" id="message-input" placeholder="Écrire un message..." required>
            <button onclick="sendMessage()">Envoyer</button>
        </div>
    </div>

    <script>
    // Fonction pour envoyer un message
    function sendMessage() {
        // Récupérer l'élément d'entrée du message et la boîte de chat
        const input = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box');

        // Vérifier si l'entrée est vide, si oui, ne rien faire
        if (input.value.trim() === "") return;

        // Création d'un nouvel élément de message
        const message = document.createElement('div');
        message.classList.add('message', 'me'); // Ajouter des classes pour le style
        // Définir le contenu HTML du message avec le nom d'utilisateur et le texte du message
        message.innerHTML = `<strong><?php echo ucfirst($username); ?>:</strong> ` + input.value;

        // Ajouter le message à la boîte de chat
        chatBox.appendChild(message);
        ;

        // Envoi du message à la base de données via une requête fetch
        fetch('send_message.php', {
            method: 'POST', // Méthode HTTP utilisée pour la requête
            headers: {
                'Content-Type': 'application/json', // Indiquer que le corps de la requête est en JSON
            },
            // Corps de la requête contenant le contenu du message et l'ID de l'expéditeur
            body: JSON.stringify({
                content: input.value,
                sender_id: <?php echo $_SESSION['user_id']; ?>,
            })
        })
        
        // Vider l'input après l'envoi du message
        input.value = "";
    }

    // Fonction pour charger les messages depuis la base de données
    function loadMessage() {
    fetch('load_messages.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(messages => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            messages.forEach(msg => {
                const message = document.createElement('div');
                const userColor = getColorForUser(msg.username); // Obtenir la couleur pour l'utilisateur
                message.classList.add('message');
                message.style.backgroundColor = userColor; // Appliquer la couleur
                message.innerHTML = `<strong>${capitalizeFirstLetter(msg.username)} :</strong> ${msg.content}`;
                chatBox.appendChild(message);
                // Faire défiler la boîte de chat vers le bas pour afficher le dernier message
                chatBox.scrollTop = chatBox.scrollHeight
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

    function getColorForUser(username) {
    // Utiliser un hash simple pour générer une couleur à partir du nom d'utilisateur
    let hash = 0;
    for (let i = 0; i < username.length; i++) {
        hash = username.charCodeAt(i) + ((hash << 5) - hash);
    }
    const color = (hash & 0x00FFFFFF).toString(16).padStart(6, '0');
    return `#${color}`;
}

    // Lorsque le document est complètement chargé, charger les messages
    document.addEventListener('DOMContentLoaded', function() {
        loadMessage(); // Charger les messages au chargement de la page
    });

    // Charger les messages toutes les 5 secondes (5000 ms)
    setInterval(loadMessage, 1000);

    // Fonction pour mettre la première lettre dans le chat en majuscule
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

</script>

</body>
</html>
