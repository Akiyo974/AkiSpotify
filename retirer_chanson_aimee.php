<?php
    session_start();
    require 'database.php';

    if (isset($_POST['id_chanson']) && isset($_SESSION['id_utilisateur'])) {
        $idChanson = $_POST['id_chanson'];
        $idUtilisateur = $_SESSION['id_utilisateur'];

        $stmt = $bdd->prepare("DELETE FROM chansons_aimees WHERE id_utilisateur = ? AND id_chanson = ?");
        $stmt->execute([$idUtilisateur, $idChanson]);
        echo "Chanson retirée des aimées";
    } else {
        echo "Erreur : données manquantes";
    }
?>
