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
            <ul class="user-list">
                <?php foreach ($afficher_profil as $ap): ?>
                    <li class="user-item" style="position: relative;">
                        <div style="position: relative; display: inline-block;">
                            <img class="listImg" src="<?= htmlspecialchars($ap['profile_picture']) ?>" alt="Photo de profil" width="30" height="30">
                            
                            <!-- Pastille de statut -->
                            <span class="status-list <?= $ap['is_online'] ? 'online' : 'offline' ?>" data-user-id="<?= $ap['user_id'] ?>"></span>
                        </div>

                        <?= ucfirst(htmlspecialchars($ap['username'])) ?>

                        <?php if ($isAdmin): ?>
                            <span class="option-user" onclick="banUser('<?= htmlspecialchars($ap['username']) ?>')">x</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
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
        chatBox.scrollTop = chatBox.scrollHeight
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



    // Update le status des profils connectés
    function updateUserStatus() {
    fetch('get_user_status.php')
        .then(response => response.json())
        .then(users => {
            users.forEach(user => {
                // Sélectionner la pastille de statut correspondant à l'utilisateur
                let statusElement = document.querySelector(`.status-list[data-user-id="${user.user_id}"]`);
                
                if (statusElement) {
                    // Supprimer les classes 'online' et 'offline'
                    statusElement.classList.remove("online", "offline");

                    // Ajouter la classe appropriée selon le statut de l'utilisateur
                    statusElement.classList.add(user.is_online ? "online" : "offline");
                }
            });
        })
        .catch(error => console.error('Erreur lors de la mise à jour des statuts:', error));
}

// Rafraîchir toutes les 5 secondes
setInterval(updateUserStatus, 5000);
updateUserStatus();
</script>

</body>
</html>
