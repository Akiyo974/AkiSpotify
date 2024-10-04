<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_artiste = $_POST['id_artiste'];
        $nom = $_POST['nom'];
        $bio = $_POST['bio'];
        $pays = $_POST['pays'];

        $sql = "UPDATE artistes SET nom = :nom, bio = :bio, pays = :pays WHERE id_artiste = :id_artiste";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':pays', $pays);
        $stmt->bindParam(':id_artiste', $id_artiste);

        if ($stmt->execute()) {
            header('Location: ../admin.php?message=Artiste mis à jour avec succès');
        } else {
            die('Erreur lors de la mise à jour de l\'artiste');
        }
    }
?>
