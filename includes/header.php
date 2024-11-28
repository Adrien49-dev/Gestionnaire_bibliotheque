<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <!-- Inclusion du CSS à la racine -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    // Déterminer l'action actuelle pour gérer l'affichage de la navigation
    $current_action = isset($_GET['action']) ? $_GET['action'] : 'home';
    ?>

    <header>
        <h1>Gestion de Bibliothèque</h1>

        <!-- Navigation -->
        <?php if ($current_action !== 'login'): ?>
            <nav>

                <a href="index.php?action=home">Accueil</a>
                <a href="index.php?action=list_books">Livres</a>
                <a href="index.php?action=list_users">Utilisateurs</a>
                <a href="index.php?action=manage_loans">Mes Emprunts</a>
                <a href="index.php?action=logout " id="logout">Déconnexion</a>

            </nav>
        <?php endif; ?>
    </header>


    <main>