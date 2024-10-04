<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'admin@admin.com') {
        header('Location: admin_connexion.php');
        exit;
    }

    require '../database.php';

    $sql = "SELECT * FROM utilisateurs LIMIT 5";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();

    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM artistes";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();

    $artistes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin - AkiSpotify</title>
    <link rel="stylesheet" href="style_admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Tableau de Bord de l'Administration</h2>

        <?php include 'gestion/gestion_user.php'; ?>

        <?php include 'gestion/gestion_artists.php'; ?>

        <?php include 'gestion/gestion_albums.php'; ?>

        <section class="admin-section">
            <h3>Gestion des Chansons</h3>
        </section>

        <a href="../deconnexion.php" class="logout-button">Déconnexion</a>
    </div>
    <script>

    let currentPageUsers = 1;
    let totalUsers = 0;

    function carouselPrev() {
        if (currentPageUsers > 1) {
            currentPageUsers--;
            fetchUsers('prev');
        }
    }

    function carouselNext() {
        if (currentPageUsers * 5 < totalUsers) { 
            currentPageUsers++;
            fetchUsers('next');
        }
    }

    function fetchUsers(direction) {
        fetch(`load/load_users.php?direction=${direction}&page=${currentPageUsers}`)
            .then(response => response.json())
            .then(data => {
                totalUsers = data.total;
                updateCarousel(data.users);
                updateButtonStatesUsers();
            })
            .catch(error => console.error('Erreur:', error));
    }

    function updateCarousel(users) {
        const carousel = document.querySelector('.user-carousel');
        carousel.innerHTML = ''; 
        users.forEach(user => {
            const userDiv = document.createElement('div');
            userDiv.className = 'user';
            userDiv.innerHTML = `
                <form class="user-form" action="update/update_user.php" method="post">
                    <input type="hidden" name="id_utilisateur" value="${user.id_utilisateur}">
                    <div class="user">
                        <label>Nom:</label>
                        <input type="text" name="nom" value="${user.nom}">
                        <label>Email:</label>
                        <input type="email" name="email" value="${user.email}">
                    </div>
                    <input type="submit" value="Mettre à jour">
                </form>
            `;
            carousel.appendChild(userDiv);
        });
    }

    function updateButtonStatesUsers() {
        const nextButton = document.querySelector('.users-next');
        const prevButton = document.querySelector('.users-prev');

        prevButton.disabled = currentPageUsers <= 1;
        nextButton.disabled = currentPageUsers * 5 >= totalUsers;
    }

    fetchUsers('init');


        let currentPageArtists = 1;
        let totalArtists = 0;

        function carouselPrevArtists() {
            if (currentPageArtists > 1) {
                currentPageArtists--;
                fetchArtists('prev');
            }
        }

        function carouselNextArtists() {
            currentPageArtists++;
            fetchArtists('next');
        }

        function fetchArtists(direction) {
            fetch(`load/load_artists.php?direction=${direction}&page=${currentPageArtists}`)
                .then(response => response.json())
                .then(data => {
                    totalArtists = data.total;
                    updateCarouselArtists(data.artistes);
                    updateButtonStates();
                })
                .catch(error => console.error('Erreur:', error));
        }

        function updateCarouselArtists(artists) {
            const carousel = document.querySelector('.artists-carousel');
            carousel.innerHTML = ''; 
            artists.forEach(artist => {
                const artistDiv = document.createElement('div');
                artistDiv.className = 'artist';
                artistDiv.innerHTML = `
                    <form action="update/update_artist.php" method="post">
                        <input type="hidden" name="id_artiste" value="${artist.id_artiste}">
                        <input type="text" name="nom" value="${artist.nom}">
                        <textarea name="bio">${artist.bio}</textarea>
                        <input type="text" name="pays" value="${artist.pays}">
                        <input type="submit" value="Mettre à jour">
                    </form>
                    <form action="delete/delete_artist.php" method="post">
                        <input type="hidden" name="id_artiste" value="${artist.id_artiste}">
                        <input type="submit" value="Supprimer">
                    </form>
                `;
                carousel.appendChild(artistDiv);
            });
        }

        function updateButtonStates() {
            const nextButton = document.querySelector('.artists-next');
            const prevButton = document.querySelector('.artists-prev');

            prevButton.disabled = currentPageArtists <= 1;
            nextButton.disabled = currentPageArtists * 3 >= totalArtists;
        }

        fetchArtists('init');

        let currentPageAlbums = 1;
        let totalAlbums = 0;

        function carouselPrevAlbums() {
            if (currentPageAlbums > 1) {
                currentPageAlbums--;
                fetchAlbums('prev');
            }
        }

        function carouselNextAlbums() {
            currentPageAlbums++;
            fetchAlbums('next');
        }

        function fetchAlbums(direction) {
            fetch(`load/load_albums.php?direction=${direction}&page=${currentPageAlbums}`)
                .then(response => response.json())
                .then(data => {
                    totalAlbums = data.total;
                    updateCarouselAlbums(data.albums);
                    updateButtonStatesAlbums();
                })
                .catch(error => console.error('Erreur:', error));
        }

        function updateCarouselAlbums(albums) {
            const carousel = document.querySelector('.albums-carousel');
            carousel.innerHTML = ''; 
            albums.forEach(album => {
                const albumDiv = document.createElement('div');
                albumDiv.className = 'album';
                albumDiv.innerHTML = `
                    <form action="update/update_album.php" method="post">
                        <input type="hidden" name="id_album" value="${album.id_album}">
                        <input type="text" name="titre" value="${album.titre}">
                        <input type="date" name="date_sortie" value="${album.date_sortie}">
                        <img src="${album.image_couverture}" alt="Image de l'album" class="album-image">
                        <input type="text" name="image_couverture" value="${album.image_couverture}">
                        <input type="submit" value="Mettre à jour">
                    </form>
                    <form action="delete/delete_album.php" method="post">
                        <input type="hidden" name="id_album" value="${album.id_album}">
                        <input type="submit" value="Supprimer">
                    </form>
                `;
                carousel.appendChild(albumDiv);
            });
        }

        function updateButtonStatesAlbums() {
            const nextButton = document.querySelector('.albums-next');
            const prevButton = document.querySelector('.albums-prev');

            prevButton.disabled = currentPageAlbums <= 1;
            nextButton.disabled = currentPageAlbums * 3 >= totalAlbums;
        }

        fetchAlbums('init');

    </script>
</body>
</html>
