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

$allLive = $bdd->query('SELECT * FROM live ORDER BY id DESC ');

if(isset($_GET['search']) AND !empty($_GET['search'])){
    $search = $_GET['search'] ;

    $query = "SELECT * FROM live WHERE nom_streamer LIKE '%$search%' OR thematique LIKE '%$search%' OR date_debut LIKE '%$search%' ORDER BY id DESC";
    $allLive = $bdd->query($query);
}


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
          <a class="nav-link active" aria-current="page" href="#">Page d’accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Fil d’actualité</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tous les lives</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Mon espace</a>
        </li>
</ul> 

<form class="d-flex" role="search"  method="GET" >
        <input class="form-control me-2" type="search"  name="search" >
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      
</nav> 
<br>


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
        
    </div>
</div>
<br>
<?php
}  ?>
</body>
</html>

