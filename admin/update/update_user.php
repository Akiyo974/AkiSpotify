<?php
    require '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_utilisateur = $_POST['id_utilisateur'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];

        $sql = "UPDATE utilisateurs SET nom = ?, email = ? WHERE id_utilisateur = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$nom, $email, $id_utilisateur]);

        header('Location: ../admin.php'); 
    }
?>
