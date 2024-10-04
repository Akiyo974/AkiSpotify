<?php
session_start();

if (isset($_SESSION["id_utilisateur"])) {
    header("Location: accueil.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'database.php';

    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $sql = "SELECT id_utilisateur, nom, mot_de_passe FROM utilisateurs WHERE email = :email";

    try {
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                $_SESSION["id_utilisateur"] = $utilisateur['id_utilisateur'];
                $_SESSION["nom"] = $utilisateur['nom'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Aucun compte trouvé avec cet e-mail.";
        }
    } catch (PDOException $e) {
        $error = "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Veuillez vous connecter</h1>
    </header>
    <form action="connexion.php" method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" required>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>
        <button type="submit">Connexion</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    <?php if (!empty($error)) echo "<div class='error-container'><p class='error'>$error</p></div>"; ?>
    <?php include 'footer.php'; ?>
</body>
</html>
