<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Inclure la bibliothèque PHPMailer
require 'PHPMailer/PHPMailer/PHPMailerAutoload.php';

if (isset($_POST['envoyer_email'])) {
    // Récupérer l'adresse e-mail du destinataire depuis le formulaire
    $emailDestinataire = $_POST['email_destinataire'];

    // Créer une instance de PHPMailer
    $mail = new PHPMailer();

    // Paramètres de configuration SMTP
    $mail->IsSMTP();
    $mail->SMTPDebug = 0; // Active le débogage SMTP (peut être 0 pour désactiver)
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'dahoufatma@gmail.com'; // Mettez votre adresse e-mail Gmail
    $mail->Password = 'udedpxxhnxcotsxe'; // Mettez votre mot de passe Gmail
    $mail->IsHTML(true);

    // Paramètres du message
    $mail->SetFrom('dahoufatma@gmail.com', 'Dahou'); // Mettez votre adresse e-mail Gmail
    $mail->AddAddress($emailDestinataire); // Adresse e-mail du destinataire
    $mail->Subject = 'email ';
    $mail->Body = 'Bonjour, merci de <a href="http://example.com/votre_lien">cliquer ici</a> pour contacter le service après-vente et modifier votre <b>informations</b>.';

    // Essayer d'envoyer l'e-mail
    if ($mail->Send()) {
        echo 'L\'e-mail a été envoyé avec succès !';
    } else {
        echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi d'e-mail</title>
</head>
<body>
    <form method="POST" action=""> <!-- Laissez l'action vide pour soumettre le formulaire vers la même page -->
        <input type="email" name="email_destinataire" placeholder="Adresse e-mail du destinataire">
        <br>
        <input type="submit" name="envoyer_email" value="Envoyer l'e-mail">
    </form>
</body>
</html>
