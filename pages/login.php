<?php


// Vérifier si l'utilisateur est déjà connecté
// if (isset($_SESSION['user_id'])) {
//     // Si l'utilisateur est déjà connecté, rediriger vers la page d'accueil ou une autre page protégée
//     // header("Location: ../index.php?action=list_books");
//     // exit(); 
//     echo "deja co";
// }

// Gérer le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'email et le mot de passe sont remplis
    if (!empty($email) && !empty($password)) {
        // Préparer la requête SQL pour récupérer l'utilisateur avec l'email fourni
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Vérifier si un utilisateur avec cet email et mot de passe existe
        $user = $stmt->fetch();

        if ($user) {
            // Si l'utilisateur est trouvé, créer une session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // Rediriger vers la page des livres ou une autre page protégée
            header("Location: index.php?action=list_books");
            exit();
        } else {
            // Si aucun utilisateur trouvé avec les identifiants fournis
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>

<main>
    <h2>Se Connecter</h2>

    <?php if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    } ?>

    <!-- Formulaire de connexion -->
    <form action="index.php?action=login" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore inscrit ? <a href="index.php?action=register">S'inscrire</a></p>
</main>