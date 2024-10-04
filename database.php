<?php
    $host = "localhost";
    $username = "dijch2030361_bdimm";
    $password = "*Pp.E;TxD^BZ";
    $dbname = "dijch2030361_AkiMusic";

    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
?>
