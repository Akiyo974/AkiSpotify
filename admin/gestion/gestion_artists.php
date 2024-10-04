<section class="admin-section">
    <h3>Gestion des Artistes</h3>
    <div class="artists-container">
        <form action="add/add_artist.php" method="post" class="artist-form">
            <h4>Ajouter un Artiste</h4>
            <input type="text" name="nom" placeholder="Nom de l'artiste" required>
            <textarea name="bio" placeholder="Biographie"></textarea>
            <input type="text" name="pays" placeholder="Pays">
            <input type="submit" value="Ajouter">
        </form>
        <?php

        $sql = "SELECT * FROM artistes LIMIT 3";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        
        $artistes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <section class="admin-section">
            <div class="artists-carousel">
                <?php foreach ($artistes as $artiste): ?>
                    <div class="artist">
                        <form action="update/update_artist.php" method="post">
                            <input type="hidden" name="id_artiste" value="<?php echo $artiste['id_artiste']; ?>">
                            <input type="text" name="nom" value="<?php echo $artiste['nom']; ?>">
                            <textarea name="bio"><?php echo $artiste['bio']; ?></textarea>
                            <input type="text" name="pays" value="<?php echo $artiste['pays']; ?>">
                            <input type="submit" value="Mettre à jour">
                        </form>
                        <form action="delete/delete_artist.php" method="post">
                            <input type="hidden" name="id_artiste" value="<?php echo $artiste['id_artiste']; ?>">
                            <input type="submit" value="Supprimer">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="button">
                <button onclick="carouselPrevArtists()" class="artists-prev">Précédent</button>
                <button onclick="carouselNextArtists()" class="artists-next">Suivant</button>
            </div>
        </section>
    </div>
</section>