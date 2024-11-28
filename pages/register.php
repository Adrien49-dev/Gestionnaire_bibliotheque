<h2>CREATION DE MON COMPTE</h2>

<form action="" method="post">
    <label for="">Email</label>
    <input type="text" name="email" placeholder="Votre email" required><br>
    <label for="">Mot de passe</label>
    <input type="password" name="password" placeholder="Mot de passe" required><br>

    </select> <br><br>

    <button type="submit">Je crée mon compte</button>


</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$requete = "INSERT INTO users(email, password) 
VALUES ('$email', '$password')";
$pdo->exec($requete);

echo "Bienvenue au club!";
header('Location: index.php?action=login');
