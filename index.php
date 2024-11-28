<?php
// Démarrer la session
session_start();

// Connexion à la base de données
require_once 'connect.php';
require_once 'classes/Library.php';
require_once 'classes/Book.php';
require_once 'classes/User.php';

// Vérification si l'utilisateur est connecté (c'est-à-dire s'il existe une session active)
// if (!isset($_SESSION['user_id']) && $action != 'login') {
//     // Si l'utilisateur n'est pas connecté et essaie d'accéder à une page protégée, redirige vers la page de login
//     header("Location: index.php?action=login");
//     exit();
// }

// Définir une action par défaut si aucune n'est donnée dans l'URL
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Inclure le header
include 'includes/header.php';

// Rendre la page correspondant à l'action
switch ($action) {
    case 'home':
        include 'pages/home.php';
        break;

    case 'list_books':
        include 'pages/list_books.php';
        break;

    case 'list_users':
        include 'pages/list_users.php';
        break;

    case 'manage_loans':
        include 'pages/manage_loans.php';
        break;

    case 'add_book':
        include 'pages/add_book.php';
        break;

    case 'add_user':
        include 'pages/add_user.php';
        break;

    case 'borrow_book':
        include 'pages/borrow_book.php';
        break;

    case 'return_book':
        include 'pages/return_book.php';
        break;

        // Page de login
    case 'login':
        include 'pages/login.php';
        break;

    case 'logout':
        include 'pages/logout.php';
        break;

    case 'register':
        include 'pages/register.php';
        break;

    default:
        echo '<p>Page introuvable.</p>';
        break;
}

// Inclure le footer
include 'includes/footer.php';
