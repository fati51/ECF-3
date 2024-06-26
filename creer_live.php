<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zevent', 'root', 'root');
} catch (Exception $e) {
    die('Veuillez vérifier votre base de données');
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['libelle']) && !empty($_POST['nom_streamer']) && !empty($_POST['thematique']) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['pegi']) && !empty($_POST['liste_materiel'])) {
        $libelle = htmlspecialchars($_POST['libelle']);
        $nom_streamer = $_SESSION['nom'];
        $thematique = $_POST['thematique'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $pegi = $_POST['pegi'];
        $liste_materiel = $_POST['liste_materiel'];
        $id_streamer = $_SESSION['id'];

        $insert_live = $bdd->prepare('INSERT INTO live (libelle, nom_streamer, thematique, date_debut, date_fin, pegi, liste_materiel, id_streamer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $insert_live->execute(array($libelle, $nom_streamer, $thematique, $date_debut, $date_fin, $pegi, implode("-" ,$liste_materiel), $id_streamer));
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Création d'un live</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c3e6cb;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Z-Event</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="espace_streamer.php">Page d’accueil</a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link" href="#">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2>Création d'un live</h2>
  <form method="POST">
    <div class="mb-3">
      <label for="libelle" class="form-label">Libellé</label>
      <textarea class="form-control" id="libelle" name="libelle" placeholder="Saisir le libellé du live"></textarea>
    </div>
    <div class="mb-3">
      <label for="nom_streamer" class="form-label">Nom du streamer</label>
      <input type="text" class="form-control" id="nom_streamer" name="nom_streamer" >

    </div>
    <div class="mb-3">
      <label for="thematique" class="form-label">Thématique</label>
      <select class="form-select" id="thematique" name="thematique">
        <option selected>Choisir une thématique</option>
        <option value="RPG">RPG</option>
        <option value="MMO">MMO</option>
        <option value="Action">Action</option>
        <option value="Aventure">Aventure</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="date_debut" class="form-label">Date de début</label>
      <input type="date" class="form-control" id="date_debut" name="date_debut">
    </div>
    <div class="mb-3">
      <label for="date_fin" class="form-label">Date de fin</label>
      <input type="date" class="form-control" id="date_fin" name="date_fin">
    </div>
    <div class="mb-3">
      <label for="pegi" class="form-label">Ce jeu est violent :</label>
      <select class="form-select" id="pegi" name="pegi">
        <option value="oui">Oui</option>
        <option value="non">Non</option>
      </select>
    </div>
    <label for="liste_materiel" class="form-label">Liste de matériel</label><br>
            <div class="form-check"  >
                <input class="form-check-input" type="checkbox" name="liste_materiel[]" value="micro" >
                <label class="form-check-label">Micro</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="liste_materiel[]" value="casque">
                <label class="form-check-label">Casque</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="liste_materiel[]" value="ecran" >
                <label class="form-check-label">Écran</label>
            </div>
    </div>
    <button type="submit" class="btn btn-primary" name="valider">Créer un live</button>
  </form>
</div>

</body>
</html>
