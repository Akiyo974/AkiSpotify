<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $titre = $_POST['titre'];
        $date_sortie = $_POST['date_sortie'];
        $image_couverture = $_POST['image_couverture'];
        $id_artiste = $_POST['id_artiste'];

        $sql = "INSERT INTO albums (titre, date_sortie, image_couverture, id_artiste) VALUES (:titre, :date_sortie, :image_couverture, :id_artiste)";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':date_sortie', $date_sortie);
        $stmt->bindParam(':image_couverture', $image_couverture);
        $stmt->bindParam(':id_artiste', $id_artiste);

        if ($stmt->execute()) {
            header('Location: ../admin.php?message=Album ajouté avec succès');
        } else {
            die('Erreur lors de l\'ajout de l\'album');
        }
    }
?>
