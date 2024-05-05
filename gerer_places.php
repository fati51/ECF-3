<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zevent', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Veuillez vérifier votre base de données');
}



// Traitement pour ajouter une nouvelle place
if (isset($_POST['ajouter_place'])) {
    $libelle = $_POST['libelle'];
    $nombre_places = $_POST['nombre_places'];

    $insert_place = $bdd->prepare('INSERT INTO places_disponibles (libelle, nombre_places) VALUES (?, ?)');
    $insert_place->execute([$libelle, $nombre_places]);

    echo 'Place ajoutée avec succès !';
}

// Récupérer toutes les places disponibles actuelles
$places_query = $bdd->query('SELECT * FROM places_disponibles');
$places = $places_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Places Disponibles</title>
</head>
<body>
    <h2>Gérer les Places Disponibles</h2>

    <!-- Formulaire pour ajouter une nouvelle place -->
    <form method="post">
        <label for="libelle">Libellé de la place :</label>
        <input type="text" id="libelle" name="libelle" required>
        <label for="nombre_places">Nombre de places :</label>
        <input type="number" id="nombre_places" name="nombre_places" required>
        <button type="submit" name="ajouter_place">Ajouter Place</button>
    </form>

    <hr>

    <!-- Afficher la liste des places disponibles -->
    <h3>Liste des Places Disponibles</h3>
    <ul>
        <?php foreach ($places as $place) : ?>
            <li><?= $place['libelle'] ?> (<?= $place['nombre_places'] ?> places)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
