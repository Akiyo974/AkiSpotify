<?php
    session_start();
    require 'database.php';

    $limit = 8;

    if (!isset($_SESSION["offset"])) {
        $_SESSION["offset"] = 8;
    } else {
        $_SESSION["offset"] += 8;
    }

    $sqlCount = "SELECT COUNT(*) AS total FROM chansons";
    $stmtCount = $bdd->query($sqlCount);
    $totalChansons = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

    if ($_SESSION["offset"] >= $totalChansons) {
        echo 'Fin des chansons';
        exit;
    }

    $sql = "SELECT chansons.*, albums.titre AS titre_album, albums.image_couverture, artistes.nom AS nom_artiste, artistes.bio AS bio_artiste FROM chansons JOIN albums ON chansons.id_album = albums.id_album JOIN artistes ON albums.id_artiste = artistes.id_artiste ORDER BY RAND() LIMIT $limit OFFSET {$_SESSION['offset']}";
    $result = $bdd->query($sql);

    while ($chanson = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='chanson'>
                <img src='{$chanson['image_couverture']}' alt='Couverture'>
                <h3>{$chanson['titre']}</h3>
                <p>Album: {$chanson['titre_album']}</p>
                <p>Artiste: {$chanson['nom_artiste']}</p>
            </div>";
    }
?>
