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

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getid = $_GET['id'];

    $cherche_live = $bdd->prepare('SELECT * FROM live WHERE id = ?');
    $cherche_live->execute(array($getid));

    if($cherche_live->rowCount() > 0){
        $liveInfo = $cherche_live->fetch();
       if($liveInfo['id_streamer']== $_SESSION['id']) { 
        $libelle = $liveInfo['libelle'];
        $thematique = $liveInfo['thematique'];
        $date_debut = $liveInfo['date_debut'];
        $date_fin = $liveInfo['date_fin'];
        $pegi = $liveInfo['pegi'];
        $liste_materiel = $liveInfo['liste_materiel'];
        $nom_streamer = $liveInfo['nom_streamer'];
       


        }else{
            echo "vous êtes pas l auteur de ce live";
        }


    }else{
    echo "vous avez aucune live";
}




}else{
    echo "vous avez aucune live";
}


if (isset($_POST['valider'])) {
    if (!empty($_POST['libelle']) && !empty($_POST['nom_streamer']) && !empty($_POST['thematique']) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['pegi']) && !empty($_POST['liste_materiel'])) {
        $libelle = htmlspecialchars($_POST['libelle']);
        $thematique = $_POST['thematique'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $pegi = $_POST['pegi'];
        $liste_materiel = $_POST['liste_materiel'];

        $date_debut_modifiee = date('Y-m-d H:i:s', strtotime($date_debut . ' +1 day'));
        $date_fin_modifiee = date('Y-m-d H:i:s', strtotime($date_fin . ' +1 day'));

       

        $modifie_live = $bdd->prepare('UPDATE live SET libelle = ?, thematique = ?, date_debut = ?, date_fin = ?, pegi = ?, liste_materiel = ? WHERE id = ? ');
        $modifie_live->execute(array($libelle,$thematique,$date_debut,$date_fin,$pegi,implode("-" ,$liste_materiel),$getid));
        

                 }

                  }

          ?>

       <!DOCTYPE html>
       <html lang="en">
       <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
          <a class="nav-link" href="#">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
                </nav>



           <div class="container mt-5">
        <?php if(isset($liste_materiel)){
           ?>
             <form method="POST">
    <div class="mb-3">
      <label for="libelle" class="form-label">Libellé</label>
      <textarea class="form-control" id="libelle" name="libelle" placeholder="Saisir le libellé du live"><?=$libelle;?></textarea>
    </div>
    <div class="mb-3">
      <label for="nom_streamer" class="form-label" >Nom du streamer</label>
      <input type="text" class="form-control" id="nom_streamer" name="nom_streamer" value="<?=$nom_streamer;?>" >

    </div>
    <div class="mb-3">
      <label for="thematique" class="form-label" >Thématique</label>
      <select class="form-select" id="thematique" name="thematique" aria-selected="<?=$thematique ;?>">
        <option selected>Choisir une thématique</option>
        <option value="RPG">RPG</option>
        <option value="MMO">MMO</option>
        <option value="Action">Action</option>
        <option value="Aventure">Aventure</option>
      </select>
    </div>
    <div class="mb-3">
    <label for="date_debut">Date de début :</label>
    <input type="datetime-local" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($date_debut); ?>"><br><br>

    <label for="date_fin">Date de fin :</label>
    <input type="datetime-local" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($date_fin); ?>"><br><br>

    <div class="mb-3">
      <label for="pegi" class="form-label">Ce jeu est violent :</label>
      <select class="form-select" id="pegi" name="pegi"  aria-valuetext="<?=$pegi ;?>" >
        <option value="oui">Oui</option>
        <option value="non">Non</option>
      </select>
    </div>
    <label for="liste_materiel" class="form-label">Liste de matériel</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="liste_materiel[]" value="micro"  >
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
    <br>
    <button type="submit" class="btn btn-primary" name="valider">Modifier ce live</button>
  </form>
</div>
</div>


          <?php

        }?>
       </body>
       </html>   
          