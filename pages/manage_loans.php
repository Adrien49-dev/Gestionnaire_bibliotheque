<?php


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur
$user_id = $_SESSION['user_id'];

// Récupérer les livres empruntés par l'utilisateur
$stmt = $pdo->prepare("
    SELECT b.title, b.author, l.borrow_date, l.book_id
    FROM loans l
    JOIN books b ON l.book_id = b.id
    WHERE l.user_id = :user_id AND l.return_date IS NULL
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$borrowed_books = $stmt->fetchAll();

// Gérer la logique de rendre un livre
if (isset($_GET['return_book_id'])) {
    $book_id_to_return = $_GET['return_book_id'];

    // Retourner le livre : met à jour la date de retour dans la table loans
    $stmt_return = $pdo->prepare("UPDATE loans SET return_date = NOW() WHERE user_id = :user_id AND book_id = :book_id AND return_date IS NULL");
    $stmt_return->bindParam(':user_id', $user_id);
    $stmt_return->bindParam(':book_id', $book_id_to_return);
    $stmt_return->execute();

    // Mettre à jour le statut du livre dans la table books pour le rendre disponible
    $stmt_update_book = $pdo->prepare("UPDATE books SET isBorrowed = 0 WHERE id = :book_id");
    $stmt_update_book->bindParam(':book_id', $book_id_to_return);
    $stmt_update_book->execute();

    // Rediriger après avoir retourné le livre
    header("Location: index.php?action=manage_loans");
    exit();
}

?>

<main>
    <h2>Mes Livres Empruntés</h2>

    <?php if ($borrowed_books): ?>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date d'Emprunt</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowed_books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= date("d/m/Y", strtotime($book['borrow_date'])) ?></td>
                        <td>
                            <!-- Bouton pour rendre le livre -->
                            <a href="index.php?action=manage_loans&return_book_id=<?= $book['book_id'] ?>" class="btn btn-return">Rendre</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Vous n'avez actuellement aucun livre emprunté.</p>
    <?php endif; ?>
</main>
