<?php
require '../../database.php';

$nombreAlbumsParPage = 3;
$direction = $_GET['direction'];
$pageActuelle = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($direction === 'next') {
    $offset = ($pageActuelle - 1) * $nombreAlbumsParPage;
} else if ($direction === 'prev') {
    $offset = max(0, ($pageActuelle - 2) * $nombreAlbumsParPage);
} else {
    $offset = 0;
}

$sql = "SELECT * FROM albums LIMIT :offset, :limit";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $nombreAlbumsParPage, PDO::PARAM_INT);
$stmt->execute();

$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlTotal = "SELECT COUNT(*) FROM albums";
$stmtTotal = $bdd->query($sqlTotal);
$totalAlbums = $stmtTotal->fetchColumn();

echo json_encode(['albums' => $albums, 'total' => $totalAlbums]);
?>
