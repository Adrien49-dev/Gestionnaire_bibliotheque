<?php
// Connexion à la base de données
// include('../connect.php');

// Vérifier si un livre et un utilisateur sont spécifiés dans l'URL
if (isset($_GET['book_id']) && isset($_GET['user_id'])) {
    $book_id = (int)$_GET['book_id'];
    $user_id = (int)$_GET['user_id'];

    // Vérifier si l'utilisateur a déjà emprunté 3 livres
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM loans WHERE user_id = :user_id AND return_date IS NULL");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $borrowed_count = $stmt->fetchColumn();

    if ($borrowed_count < 3) {
        // Vérifier si le livre est déjà emprunté
        $stmt = $pdo->prepare("SELECT isBorrowed FROM books WHERE id = :book_id");
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        $book = $stmt->fetch();

        if ($book && $book['isBorrowed'] == 0) {
            // Marquer le livre comme emprunté (changer isBorrowed à 1)
            $stmt = $pdo->prepare("UPDATE books SET isBorrowed = 1 WHERE id = :book_id");
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();

            // Ajouter un enregistrement dans la table loans
            $borrow_date = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO loans (user_id, book_id, borrow_date) VALUES (:user_id, :book_id, :borrow_date)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->bindParam(':borrow_date', $borrow_date);
            $stmt->execute();

            // Rediriger vers la liste des livres

            header("Location: index.php?action=list_books");
            exit();
        } else {
            // Message si le livre est déjà emprunté
            echo "<p>Le livre est déjà emprunté par un autre utilisateur.</p>";
        }
    } else {
        // Message si l'utilisateur a déjà emprunté 3 livres
        echo "<p>Vous ne pouvez pas emprunter plus de 3 livres.</p>";
    }
} else {
    // Rediriger si les paramètres manquent
    echo "Param manquant";
    // header("Location: index.php?page=list_books");
    // exit();
}
