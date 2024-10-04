<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_album = $_POST['id_album'];
        $titre = $_POST['titre'];
        $date_sortie = $_POST['date_sortie'];
        $image_couverture = $_POST['image_couverture'];
        $id_artiste = $_POST['id_artiste'];

        $sql = "UPDATE albums SET titre = :titre, date_sortie = :date_sortie, image_couverture = :image_couverture, id_artiste = :id_artiste WHERE id_album = :id_album";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':date_sortie', $date_sortie);
        $stmt->bindParam(':image_couverture', $image_couverture);
        $stmt->bindParam(':id_artiste', $id_artiste);
        $stmt->bindParam(':id_album', $id_album);

        if ($stmt->execute()) {
            header('Location: ../admin.php?message=Album mis à jour avec succès');
        } else {
            die('Erreur lors de la mise à jour de l\'album');
        }
    }
?>
