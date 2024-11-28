<?php
// Inclure le fichier de connexion à la base de données
include('../connect.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];

    // Vérifier si tous les champs sont remplis
    if (!empty($title) && !empty($author) && !empty($year) && !empty($genre)) {
        // Préparer la requête SQL pour insérer les données dans la table books
        $stmt = $pdo->prepare("INSERT INTO books (title, author, year, genre, isBorrowed) 
                               VALUES (:title, :author, :year, :genre, 0)");

        // Lier les paramètres à la requête
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':genre', $genre);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Rediriger vers la page d'accueil après ajout réussi
            header("Location: ../index.php?action=list_books");
            exit();
        } else {
            echo "<p>Une erreur est survenue lors de l'ajout du livre.</p>";
        }
    } else {
        echo "<p>Tous les champs sont requis.</p>";
    }
}
?>

<main>
    <h2>Ajouter un Nouveau Livre</h2>

    <!-- Formulaire d'ajout de livre -->
    <form action="add_book.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Auteur :</label>
        <input type="text" id="author" name="author" required>

        <label for="year">Année de publication :</label>
        <input type="number" id="year" name="year" required>

        <label for="genre">Genre :</label>
        <input type="text" id="genre" name="genre" required>

        <button type="submit">Ajouter le Livre</button>
    </form>

    <!-- Bouton pour revenir à la liste des livres -->
    <a href="index.php?action=list_books">
        <button type="button">Revenir à la liste des livres</button>
    </a>
</main>