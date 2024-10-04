<?php
    session_start();

    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require 'database.php';

        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";

        try {
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: connexion.php");
                exit;
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de base de données : " . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Veuillez vous inscrire</h1>
    </header>
    <form action="inscription.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>
        <label for="email">Email :</label>
        <input type="email" name="email" required>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>
        <button type="submit">Inscription</button>
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous</a>.</p>
    <?php if (!empty($error)) echo "<div class='error-container'><p class='error'>$error</p></div>"; ?>
    <?php include 'footer.php'; ?>
</body>
</html>
