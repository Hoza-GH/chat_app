<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/chat.css">
    <title>Chat</title>
</head>
<body>

    <div class="sidebar">
        <h2><strong><?php echo ucfirst($_SESSION['username']); ?></strong></h2>
        <div class="channel">Général</div>
        <div class="channel">Gaming</div>
        <div class="channel">Programmation</div>
        <div class="channel">Détente</div>
    </div>

    <div class="chat-container">
        <div class="chat-box" id="chat-box">
            <div class="message"><strong>Admin:</strong> Bienvenue sur le chat !</div>
        </div>

        <div class="chat-input">
            <input type="text" id="message-input" placeholder="Écrire un message..." required>
            <button onclick="sendMessage()">Envoyer</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            const input = document.getElementById('message-input');
            const chatBox = document.getElementById('chat-box');

            if (input.value.trim() === "") return;

            // Création du message
            const message = document.createElement('div');
            message.classList.add('message', 'me');
            message.innerHTML = `<strong><?php echo ucfirst($_SESSION['username']); ?>:</strong> ` + input.value;

            // Ajout au chat
            chatBox.appendChild(message);
            chatBox.scrollTop = chatBox.scrollHeight;

            // Vider l'input
            input.value = "";
        }
    </script>

</body>
</html>
