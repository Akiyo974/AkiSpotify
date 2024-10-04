<section class="admin-section">
    <h3>Gestion des Albums</h3>
    <div class="albums-container">
        <form action="add/add_album.php" method="post" class="album-form">
            <h4>Ajouter un Album</h4>
            <input type="text" name="titre" placeholder="Titre de l'album" required>
            <input type="date" name="date_sortie" placeholder="Date de sortie">
            <input type="text" name="image_couverture" placeholder="URL de l'image de couverture">
            <select name="id_artiste" required>
                <option value="">Sélectionner un artiste</option>
                <?php
                $sql = "SELECT id_artiste, nom FROM artistes";
                $stmt = $bdd->prepare($sql);
                $stmt->execute();
                $artistes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($artistes as $artiste) {
                    echo "<option value='{$artiste['id_artiste']}'>{$artiste['nom']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Ajouter">
        </form>
        <?php
        $sql = "SELECT * FROM albums LIMIT 3";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="albums-carousel">
            <?php foreach ($albums as $album): ?>
                <div class="album">
                    <form action="update/update_album.php" method="post">
                        <input type="hidden" name="id_album" value="<?php echo $album['id_album']; ?>">
                        <input type="text" name="titre" value="<?php echo $album['titre']; ?>">
                        <input type="date" name="date_sortie" value="<?php echo $album['date_sortie']; ?>">
                        <img src="<?php echo $album['image_couverture']; ?>" alt="Image de l'album" class="album-image">
                        <input type="text" name="image_couverture" value="<?php echo $album['image_couverture']; ?>">
                        <select name="id_artiste">
                            <?php foreach ($artistes as $artiste): ?>
                                <option value="<?php echo $artiste['id_artiste']; ?>" <?php echo $artiste['id_artiste'] == $album['id_artiste'] ? 'selected' : ''; ?>>
                                    <?php echo $artiste['nom']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="Mettre à jour">
                    </form>
                    <form action="delete/delete_album.php" method="post">
                        <input type="hidden" name="id_album" value="<?php echo $album['id_album']; ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="button">
            <button onclick="carouselPrevAlbums()" class="albums-prev">Précédent</button>
            <button onclick="carouselNextAlbums()" class="albums-next">Suivant</button>
        </div>
    </div>
</section>