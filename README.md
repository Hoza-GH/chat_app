# 💬 Chat App

Une application de messagerie locale en PHP avec gestion des utilisateurs et envoi de messages.

---

## 🚀 Fonctionnalités principales

- Inscription / Connexion
- Chat en temps réel 


## 🖥️ Installation locale avec WAMP

1. Installez [WAMP Server](https://www.wampserver.com/)
2. Placez ce dossier dans `C:\wamp64\www\chat_app`
3. Lancez WAMP et accédez à [http://localhost/chat_app](http://localhost/chat_app)
4. Créez une base de données `chat_app` via phpMyAdmin
5. Importez le fichier SQL situé dans le dossier `sql/`
6. Vérifiez les identifiants MySQL dans `php/config.php` (utilisateur `root`, mot de passe vide par défaut)

---

## 🔄 Tester à 2 utilisateurs (en local)

Comme il s'agit d'une application locale, les sessions sont partagées entre les onglets d’un même navigateur.

➡️ **Pour simuler une conversation entre deux comptes :**
- Connectez-vous avec un premier compte dans un onglet normal
- Ouvrez une fenêtre **en navigation privée** pour vous connecter avec un autre compte

Sinon, les deux fenêtres resteront connectées au **même compte**.

---