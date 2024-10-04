<?php
    session_start();
    session_destroy();
    session_start();

    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($email == 'admin@admin.com' && $password == 'admin') {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $email;
            header("Location: admin.php");
            exit;
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - AkiSpotify</title>
    <link rel="stylesheet" href="style_admin.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion Admin</h2>
        <form action="" method="post">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Connexion">
            </div>
        </form>
        <?php if ($error != '') { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </div>
</body>
</html>
