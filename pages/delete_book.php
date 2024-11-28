<?php
// Inclure le fichier de connexion à la base de données
include('../connect.php');

// Vérifier si l'ID du livre est passé en paramètre dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookId = $_GET['id'];

    // Préparer la requête SQL pour supprimer le livre
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger vers la page list_books après suppression
        //  header("Location: index.php?page=list_books"); 
        echo "Le livre a été supprimé";
        //exit();
    } else {
        echo "<p>Une erreur est survenue lors de la suppression du livre.</p>";
    }
} else {
    echo "<p>ID du livre invalide.</p>";
}
