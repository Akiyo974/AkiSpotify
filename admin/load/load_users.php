<?php
    require '../../database.php';

    $nombreUtilisateursParPage = 5;

    $pageActuelle = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($pageActuelle - 1) * $nombreUtilisateursParPage;

    $sql = "SELECT * FROM utilisateurs LIMIT :offset, :limit";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $nombreUtilisateursParPage, PDO::PARAM_INT);
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT COUNT(*) FROM utilisateurs";
    $stmtTotal = $bdd->query($sqlTotal);
    $totalUtilisateurs = $stmtTotal->fetchColumn();

    echo json_encode([
        'total' => $totalUtilisateurs,
        'users' => $utilisateurs
    ]);
?>
