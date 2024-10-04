<?php
    session_start();
    require 'database.php';

    if (isset($_POST['id_chanson']) && isset($_SESSION['id_utilisateur'])) {
        $idChanson = $_POST['id_chanson'];
        $idUtilisateur = $_SESSION['id_utilisateur'];

        $stmt = $bdd->prepare("SELECT * FROM chansons_aimees WHERE id_utilisateur = ? AND id_chanson = ?");
        $stmt->execute([$idUtilisateur, $idChanson]);
        if ($stmt->rowCount() == 0) {
            $stmt = $bdd->prepare("INSERT INTO chansons_aimees (id_utilisateur, id_chanson) VALUES (?, ?)");
            $stmt->execute([$idUtilisateur, $idChanson]);
            echo "Chanson aimée ajoutée";
        } else {
            echo "Chanson déjà aimée";
        }
    } else {
        echo "Erreur : données manquantes";
    }
?>
