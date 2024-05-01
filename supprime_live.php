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
       if($liveInfo['id_streamer'] == $_SESSION['id']){
       $delet_live = $bdd->prepare('DELETE  FROM live WHERE id = ?');
       $delet_live->execute(array($getid));




          }else{
            echo "Vous êtes pas l 'auteur de ce live";
          }
            }else{
                echo "Vous avez aucun live";
            }

              }else{
                echo "Vous avez aucun live";
              }