<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require 'PHPMailer/PHPMailerAutoload.php'; // Inclure la bibliothèque PHPMailer

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zevent', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'dahoufatma@gmail.com';
    $mail->Password = 'bcvf kexf pwxz basf';

    $mail->setFrom('dahoufatma@gmail.com', 'DAHOU');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['age']) && !empty($_POST['nomDeChaine'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $age = htmlspecialchars($_POST['age']);
        $nom_chaine = htmlspecialchars($_POST['nomDeChaine']);
        $password = generateRandomPassword();

        $insertStreamer = $bdd->prepare('INSERT INTO streamer (nom, prenom, email, age, nom_chaine, mot_de_passe, active) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $insertStreamer->execute(array($nom, $prenom, $email, $age, $nom_chaine, password_hash($password, PASSWORD_DEFAULT), 1));

        $subject = 'Votre nouveau mot de passe';
        $body = 'Voici votre nouveau mot de passe : ' . $password;

        if (sendEmail($email, $subject, $body)) {
            echo 'Inscription réussie. Un email avec votre mot de passe a été envoyé.';
        } else {
            echo 'Erreur lors de l\'envoi de l\'email.';
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription Streamer</title>
</head>
<body>
  <form method="POST" class="container">
    <p>Création d'un Streamer</p>
    <div class="form-group">
      <label>Nom</label>
      <input type="text" class="form-control" name="nom">
    </div>
    <div class="form-group">
      <label>Prénom</label>
      <input type="text" class="form-control" name="prenom">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
      <label>Age</label>
      <input type="text" class="form-control" name="age">
    </div>
    <div class="form-group">
      <label>Nom de la chaine</label>
      <input type="text" class="form-control" name="nomDeChaine">
    </div>
    <button type="submit" class="btn btn-primary" name="valider">Inscription streamer</button>
  </form>
</body>
</html>
