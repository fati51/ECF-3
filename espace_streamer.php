<?php 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


try{
    $bdd = new PDO('mysql:host=localhost;dbname=zevent','root','root');
}catch(Exception $e){ 
    die('vous verfiee votre base de donne');
}

$allLive = $bdd->prepare('SELECT * FROM live  WHERE id_streamer = ? ORDER BY id  DESC ');
$allLive->execute(array($_SESSION['id']));


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
  <title>Document</title>
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
          <a class="nav-link" href="creer_live.php">Formulair de creation de live</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Inscription utlisateurs</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">statistique</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Deconnexion</a>
        </li>
</ul>    
</nav> 

<br><br>
<?php  while($liveInfo = $allLive->fetch()) {
?>
<div class="card">
    <h5 class="card-header">Nom streamer <?= $liveInfo['nom_streamer'] ?></h5>
    <div class="card-body">
        <div class="mb-3">
            <p class="card-text">Libellé <?= $liveInfo['libelle'] ?></p>
            <small>Date de début <?= $liveInfo['date_debut'] ?></small>
        </div>
        <div class="my-3">
            <small>Date de fin <?= $liveInfo['date_fin'] ?></small>
        </div>
        <div class="my-3">
            <a href="#" class="btn btn-primary me-3">Accéder au live</a>
            <a href="modifie_live.php?id=<?= $liveInfo['id'] ?>" class="btn btn-warning me-3">Modifier ce live</a>
            <a href="supprime_live.php?id=<?= $liveInfo['id'] ?>" class="btn btn-danger">Supprimer ce live</a>
        </div>
    </div>
</div>

<?php
}  ?>

</body>
</html>
