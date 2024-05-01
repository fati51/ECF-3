<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "zevent";
try {
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $sql = "SELECT * FROM live WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nom_streamer = $row['nom_streamer'];
            $thematique = $row['thematique'];
            $dateDebut = $row['date_debut'];
            $dateFin = $row['date_fin'];
            $pegi = $row['pegi'];
            $liste_materiel = $row['$liste_materiel'];


            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Détails du live</title>
                <link rel="stylesheet" href="style.css">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>
            <body>
            <div class="container">
                <h1>Détails du live</h1>
                <div class="card">
                    
                    <div class="card-body">
                        
                        <p class="card-text">Nom streamer : <?php echo $nom_streamer; ?></p>
                        <p class="card-text">Thematique : <?php echo $thematique; ?></p>
                        <p class="card-text"> Date de debut: <?php echo $dateDebut; ?></p>
                        <p class="card-text">Date de fin  : <?php echo $dateFin; ?></p>
                        <p class="card-text">PEGI : <?php echo $pegi; ?></p>
                        <p class="card-text">Liste de materiel: <?php echo $liste_materiel; ?></p>
                       
                        <a href="index.php" class="btn btn-danger">Retour</a>
                    </div>
                </div>
            </div>

            </body>
            </html>
            <?php
        } else {
            echo "Live non trouvé.";
        }
    } else {
        echo "Live non trouve .";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>