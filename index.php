<?php
    session_start();

    $_SESSION["offset"] = 0;

    if (!isset($_SESSION["id_utilisateur"])) {
        header("Location: connexion.php");
        exit;
    }

    require 'database.php';
    $chansonsAimees = [];
    if (isset($_SESSION["id_utilisateur"])) {
        $idUtilisateur = $_SESSION["id_utilisateur"];
        $sqlAimees = "SELECT chansons.*, albums.titre AS titre_album, albums.image_couverture, artistes.nom AS nom_artiste 
                    FROM chansons_aimees 
                    JOIN chansons ON chansons_aimees.id_chanson = chansons.id_chanson 
                    JOIN albums ON chansons.id_album = albums.id_album 
                    JOIN artistes ON albums.id_artiste = artistes.id_artiste 
                    WHERE chansons_aimees.id_utilisateur = ?";
        $stmt = $bdd->prepare($sqlAimees);
        $stmt->execute([$idUtilisateur]);
        $chansonsAimees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AkiSpotify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container-principale">
        <div id="sidebar">
            <div id="navigation">
                <a href="index.php">Accueil</a>
                <a href="deconnexion.php">Deconnexion</a>
            </div>
            <div id="playlists">
                <h3>Chansons Aimées</h3>
                <div id="playlists-container">
                    <?php foreach ($chansonsAimees as $chansonAimee) : ?>
                        <div class='chanson-aimee'>
                            <div class="chanson-image">
                                <img src='<?php echo $chansonAimee['image_couverture']; ?>' alt='Couverture'>
                            </div>
                            <div class="chanson-titre-album">
                                <div class="titre"><?php echo $chansonAimee['titre']; ?></div>
                                <div class="album"><?php echo $chansonAimee['titre_album']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div id="main-content">
            <h2>Chansons Populaires</h2>
            <div id="chansons-container">
                <?php
                    $idsChansonsAimees = [];
                    if (isset($_SESSION["id_utilisateur"])) {
                        $idUtilisateur = $_SESSION["id_utilisateur"];
                        $sqlAimees = "SELECT id_chanson FROM chansons_aimees WHERE id_utilisateur = ?";
                        $stmt = $bdd->prepare($sqlAimees);
                        $stmt->execute([$idUtilisateur]);
                        $chansonsAimees = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $idsChansonsAimees = array_column($chansonsAimees, 'id_chanson');
                    }
                    $sql = "SELECT chansons.*, albums.titre AS titre_album, albums.image_couverture, artistes.nom AS nom_artiste, artistes.bio AS bio_artiste FROM chansons JOIN albums ON chansons.id_album = albums.id_album JOIN artistes ON albums.id_artiste = artistes.id_artiste ORDER BY RAND() LIMIT 8";
                    $chansonsPopulaires = $bdd->query($sql);

                    while ($chanson = $chansonsPopulaires->fetch(PDO::FETCH_ASSOC)) {
                        $estAimee = in_array($chanson['id_chanson'], $idsChansonsAimees);
                        echo "<div class='chanson'
                                onclick='playSong(this)'
                                data-audio-source='{$chanson['chemin_audio']}' 
                                data-titre-chanson='{$chanson['titre']}'
                                data-nom-artiste='{$chanson['nom_artiste']}'
                                data-bio-artiste='{$chanson['bio_artiste']}'  
                                data-image-album='{$chanson['image_couverture']}'>
                            <img src='{$chanson['image_couverture']}' alt='Couverture'>
                            <h3>{$chanson['titre']}</h3>
                            <p>Album: {$chanson['titre_album']}</p>
                            <p>Artiste: {$chanson['nom_artiste']}</p>";
                        
                        if ($estAimee) {
                            echo "<button class='btn-ne-plus-aimer' data-chanson-id='{$chanson['id_chanson']}'>Ne plus aimer</button>";
                        } else {
                            echo "<button class='btn-aimer' data-chanson-id='{$chanson['id_chanson']}'>Aimer</button>";
                        }

                        echo "</div>";
                    }
                ?>
            </div>
            <div id="plus-de-chansons">
                <button id='btn-afficher-plus'>Afficher plus</button>
            </div>
        </div>
        <div id="sidebar-right">
            <div id="song-details">
                <img id="song-cover" src="chemin/vers/la/couverture.jpg" alt="Couverture">
                <h3 id="song-title">Titre de la chanson</h3>
                <p>Artiste: <span id="song-artist">Nom de l'artiste</span></p>
                <p id="song-bio">Biographie de l'artiste</p>
            </div>
        </div>
        <div id="music-preview">
            <h3>En train de jouer</h3>
            <audio id="audio-player" controls>
                <source src="chemin/vers/le/fichier.mp3" type="audio/mpeg">
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
