<?php
    require '../../database.php';

    $nombreArtistesParPage = 3;

    $direction = $_GET['direction'];
    $pageActuelle = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($direction === 'next') {
        $offset = ($pageActuelle - 1) * $nombreArtistesParPage;
    } else if ($direction === 'prev') {
        $offset = max(0, ($pageActuelle - 2) * $nombreArtistesParPage);
    } else {
        $offset = 0;
    }

    $sql = "SELECT * FROM artistes LIMIT :offset, :limit";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $nombreArtistesParPage, PDO::PARAM_INT);
    $stmt->execute();

    $artistes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT COUNT(*) FROM artistes";
    $stmtTotal = $bdd->query($sqlTotal);
    $totalArtistes = $stmtTotal->fetchColumn();

    echo json_encode(['artistes' => $artistes, 'total' => $totalArtistes]);
?>