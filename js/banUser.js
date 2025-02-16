function banUser(username) {
    if (confirm("Êtes-vous sûr de vouloir bannir " + username + " ?")) {
        // Envoyer une requête pour bannir l'utilisateur
        fetch('../session/ban_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username }) // Envoyer le nom d'utilisateur à bannir
        })
        .then(response => {
            if (response.ok) {
                alert(username + " a été banni.");
                location.reload(); // Recharger la page pour mettre à jour la liste des utilisateurs
            } else {
                alert("Erreur lors du bannissement de l'utilisateur.");
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
}