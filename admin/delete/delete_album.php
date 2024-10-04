<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_album = $_POST['id_album'];

        $bdd->beginTransaction();

        try {
            $sql = "DELETE FROM albums WHERE id_album = :id_album";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':id_album', $id_album, PDO::PARAM_INT);
            $stmt->execute();

            $bdd->commit();

            header('Location: ../admin.php?message=Album supprimé avec succès');
        } catch (Exception $e) {
            $bdd->rollBack();
            die('Erreur lors de la suppression de l\'album : ' . $e->getMessage());
        }
    }
?>