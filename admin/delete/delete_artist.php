<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_artiste = $_POST['id_artiste'];

        $bdd->beginTransaction();

        try {
            $sql = "DELETE FROM albums WHERE id_artiste = :id_artiste";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':id_artiste', $id_artiste, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "DELETE FROM artistes WHERE id_artiste = :id_artiste";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':id_artiste', $id_artiste, PDO::PARAM_INT);
            $stmt->execute();

            $bdd->commit();

            header('Location: ../admin.php?message=Artiste supprimé avec succès');
        } catch (Exception $e) {
            $bdd->rollBack();
            die('Erreur lors de la suppression de l\'artiste : ' . $e->getMessage());
        }
    }
?>
