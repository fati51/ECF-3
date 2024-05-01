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

if(isset($_POST['valider'])){
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['age']) AND !empty($_POST['nomDeChaine'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $age = htmlspecialchars($_POST['age']);
        $nom_chaine= htmlspecialchars($_POST['nomDeChaine']);

        $nomExcite = $bdd->prepare('SELECT * FROM streamer WHERE nom = ?');
        $nomExcite->execute(array($nom));

    if($nomExcite->rowCount() == 0){
        $insertStreamer = $bdd->prepare('INSERT INTO streamer(nom,prenom,email,age,nom_chaine) VALUES(?,?,?,?,?) ');
        $insertStreamer->execute(array($nom,$prenom,$email,$age,$nom_chaine));

        
        $addStreamer = $bdd->prepare('SELECT * FROM streamer WHERE nom = ? AND prenom = ?');
        $addStreamer->execute(array($nom,$prenom));
        $streamerInfo = $addStreamer->fetch();

        $_SESSION['auth'] = true;
        $_SESSION['id'] = $streamerInfo['id'];
        $_SESSION['nom'] = $streamerInfo['nom'];
        $_SESSION['prenom'] = $streamerInfo['prenom'];

        header('Location:creer_live.php');

        


    }else{
        $errorMsg = "le compte excite déja";
    }
        
    }

    


}else{
    $errorMsg = "Veuillez valide tous les champs......";
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
          <a class="nav-link active" aria-current="page" href="espace_admin.php">Page d’accueil</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="#">Deconnexion
            
          </a>
        </li>
</ul> 
      
</nav> 
    <br><br>
<form class="container" method="POST">

    <p>Création d'un Streamer</p>
  <div class="form-group">
    <label for="exampleInputEmail1">Nom</label>
    <input type="text" class="form-control" name="nom">
   
    <div class="form-group">
    <label for="exampleInputEmail1">Prénom</label>
    <input type="text" class="form-control" name="prenom">

    <div class="form-group">
    <label for="exampleInputEmail1">email</label>
    <input type="text" class="form-control" name="email">
   
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Age</label>
    <input type="text" class="form-control" name="age">
   
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Nom de la chaine</label>
    <input type="text" class="form-control" name="nomDeChaine">
   
  </div>
  <br></br>
  
  <button type="submit" class="btn btn-primary"name="valider">Inscription streamer</button>
  
 

</form>
    
</body>
</html>