<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; // Adresse du serveur de base de données
$dbname = 'bibliotheque'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL (par défaut 'root' sur XAMPP)
$password = ''; // Mot de passe MySQL (par défaut vide sur XAMPP)

// Essaie de se connecter à la base de données en utilisant PDO
try {
    // Crée une nouvelle instance PDO pour se connecter à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Définit le mode d'erreur de PDO pour lancer une exception en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la connexion réussit, un message sera affiché (en mode développement)
    // echo "Connexion réussie à la base de données";

} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
