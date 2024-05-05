
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require 'PHPMailer/PHPMailerAutoload.php'; // Inclure la bibliothèque PHPMailer

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=zevent', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        // Vérifier si l'utilisateur existe dans la base de données
        $userExists = $bdd->prepare('SELECT * FROM streamer WHERE email = ?');
        $userExists->execute(array($email));

        if ($userExists->rowCount() > 0) {
            $userInfo = $userExists->fetch();
            if (password_verify($password, $userInfo['mot_de_passe'])) {
                // Mot de passe correct, connectez l'utilisateur
                $_SESSION['auth'] = true;
                $_SESSION['nom'] = $userInfo['nom'];
                $_SESSION['prenom'] = $userInfo['prenom'];
                $_SESSION['id'] = $userInfo['id'];

                header('Location: select_place.php');
                exit;
            } else {
                echo 'Mot de passe incorrect.';
            }
        } else {
            echo 'Utilisateur non trouvé.';
        }
    } else {
        echo 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Streamer</title>
</head>
<body>
    <form method="POST" class="container">
        <div>
            <label>Email</label>
            <input type="text" class="form-control" name="email">
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="valider">Se connecter</button>
    </form>
</body>
</html>



