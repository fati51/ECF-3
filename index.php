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

$allLive = $bdd->query('SELECT * FROM live ORDER BY id DESC');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Document</title>
    
    

</head>

<body>
<?php include 'header.php';?>
</br></br>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <p>L’événement rassemble 45 streamers qui vont se filmer en jouant à un jeu vidéo retransmis en direct sur des plateformes vidéo. Le but est de récolter des dons afin de soutenir des associations ayant une finalité en lien avec les valeurs du Z-Event.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <?php while ($InfoLive = $allLive->fetch()) { ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?=$InfoLive['nom_streamer']?></h5>
                        <p class="card-text"><?=$InfoLive['date_debut']?></p>
                        <a href="detaille_live.php?id=<?=$InfoLive['id']?>" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>






</body>
</html>