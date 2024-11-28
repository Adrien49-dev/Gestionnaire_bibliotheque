<?php
// Connexion à la base de données
include('connect.php');

// Vérifier si un utilisateur est connecté (si ce n'est pas le cas, rediriger vers la page de connexion)

// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php?page=login");
//     exit();
// }

// Récupérer la liste des livres
$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll();

// Vérifier combien de livres l'utilisateur a déjà empruntés
$user_id = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT COUNT(*) FROM loans WHERE user_id = :user_id AND return_date IS NULL");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$borrowed_count = $stmt->fetchColumn();
?>

<main>
    <h2>Liste des Livres</h2>

    <!-- Affichage de la liste des livres -->
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Genre</th>
                <th>Emprunter</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr style="background-color: <?= $book['isBorrowed'] == 1 ? 'red' : '' ?>;">
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['year']) ?></td>
                    <td><?= htmlspecialchars($book['genre']) ?></td>
                    <td>
                        <?php if ($book['isBorrowed'] == 0): ?>
                            <!-- Lien pour emprunter un livre, si l'utilisateur n'a pas encore atteint la limite de 3 livres empruntés -->
                            <?php if ($borrowed_count < 3): ?>
                                <a href="index.php?action=borrow_book&book_id=<?= $book['id'] ?>&user_id=<?= $user_id ?>">Emprunter</a>
                            <?php else: ?>
                                <!-- Si l'utilisateur a déjà emprunté 3 livres, afficher un message informatif -->
                                <button id="disabled" disabled>Emprunter</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Si le livre est emprunté, afficher un bouton désactivé -->
                            <button disabled>Déjà Emprunté</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bouton pour ajouter un nouveau livre -->
    <a href="index.php?action=add_book">
        <button type="button">Ajouter un Livre</button>
    </a>



    <!-- Pagination (si nécessaire) -->
    <div class="pagination">
        <!-- Code de pagination ici -->
    </div>
</main>