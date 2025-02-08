<?php 

$servername = 'localhost';
$username = 'root';
$password= '';
$dbname = "chat_app";

//On établi la connexion
try{
    $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);

    // On définit le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "connexion résussie";
}

//On capture les exceptions si une exception est lancée et on affiche
             
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
    }

    
?>