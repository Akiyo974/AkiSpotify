<?php
require '../../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = $_POST['nom'];
    $bio = $_POST['bio'];
    $pays = $_POST['pays'];

    $sql = "INSERT INTO artistes (nom, bio, pays) VALUES (:nom, :bio, :pays)";
    $stmt = $bdd->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':pays', $pays);

    if ($stmt->execute()) {
        header('Location: ../admin.php?message=Artiste ajouté avec succès');
    } else {
        die('Erreur lors de l\'ajout de l\'artiste');
    }
}
?>
