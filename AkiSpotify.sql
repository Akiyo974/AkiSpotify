-- Utilisation de la base de données
CREATE DATABASE IF NOT EXISTS AkiSpotify;
USE AkiSpotify;

-- Création de la table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des artistes
CREATE TABLE IF NOT EXISTS artistes (
    id_artiste INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    bio TEXT,
    pays VARCHAR(100)
);

-- Création de la table des albums
CREATE TABLE IF NOT EXISTS albums (
    id_album INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    date_sortie DATE,
    image_couverture VARCHAR(255),
    id_artiste INT,
    FOREIGN KEY (id_artiste) REFERENCES artistes(id_artiste)
);

-- Création de la table des chansons
CREATE TABLE IF NOT EXISTS chansons (
    id_chanson INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    duree TIME NOT NULL,
    id_album INT,
    FOREIGN KEY (id_album) REFERENCES albums(id_album)
);

-- Création de la table des playlists
CREATE TABLE IF NOT EXISTS playlists (
    id_playlist INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Création de la table de relation entre playlists et chansons (une playlist peut avoir plusieurs chansons)
CREATE TABLE IF NOT EXISTS playlists_chansons (
    id_playlist INT,
    id_chanson INT,
    PRIMARY KEY (id_playlist, id_chanson),
    FOREIGN KEY (id_playlist) REFERENCES playlists(id_playlist),
    FOREIGN KEY (id_chanson) REFERENCES chansons(id_chanson)
);

CREATE TABLE IF NOT EXISTS chansons_aimees (
    id_utilisateur INT,
    id_chanson INT,
    PRIMARY KEY (id_utilisateur, id_chanson),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
    FOREIGN KEY (id_chanson) REFERENCES chansons(id_chanson)
);



ALTER TABLE chansons ADD COLUMN chemin_audio VARCHAR(255);

INSERT INTO utilisateurs (nom, email, mot_de_passe)
VALUES ('admin', 'admin@admin.com', 'admin');

-- Insertion du premier artiste BLEO
INSERT INTO artistes (nom, bio, pays) VALUES 
('BLEO', 'B.Leo makes textural funk.', 'inconnu');

-- Insertion de l'album DUET de BLEO
INSERT INTO albums (titre, date_sortie, image_couverture, id_artiste) VALUES 
('DUET', '2013-05-21', 'https://freemusicarchive.org/image/?file=images%2Ftracks%2FTrack_-_20130520152653473&width=290&height=290&type=track', 1);

-- Insertion des chansons de l'album DUET
INSERT INTO chansons (titre, duree, id_album, chemin_audio) VALUES 
('Death Destroyer (Radio Edit) feat. Rhinostrich', '00:04:05', 1, 'audio/duet/death.mp3'),
('Tart (Pts 1 & 2) feat. KeFF', '00:06:17', 1, 'audio/duet/tart.mp3'),
('m00m4m4 feat. Ovenrake', '00:04:26', 1, 'audio/duet/moom.mp3'),
('A_Merican_Skweeez feat. STARPAUSE', '00:06:11', 1, 'audio/duet/american.mp3');

-- Insertion du deuxième artiste Julian Winter
INSERT INTO artistes (nom, bio, pays) VALUES 
('Julian Winter', 'Julian Winter est un musicien indépendant allemand. Très jeune, il a appris que la musique peut parfois évoquer des images arbitraires dans l’esprit, et que c’est à ce moment-là que la musique devient très émotive. Sa musique contient de nombreux enregistrements ambiants de son environnement, et s’il trouve quelque chose d’intéressant, il est sûr de l’enregistrer et de l’expérimenter sur son DAW.', 'Allemagne');

-- Insertion de l'album Brothers de Julian Winter
INSERT INTO albums (titre, date_sortie, image_couverture, id_artiste) VALUES 
('Brothers', '2023-07-21', 'https://freemusicarchive.org/image/?file=album_image%2F7veu4EMAzzc2rApaa0IlZQAOvkuJVUkM4qXz308p.jpg&width=290&height=290&type=album', 2);

-- Insertion des chansons de l'album Brothers
INSERT INTO chansons (titre, duree, id_album, chemin_audio) VALUES 
('Fresh Evidence', '00:02:09', 2, 'audio/brothers/fresh.mp3'),
('Brothers', '00:03:15', 2, 'audio/brothers/brothers.mp3'),
('Judaean Hills', '00:02:42', 2, 'audio/brothers/judaean.mp3'),
('In The Garden', '00:03:08', 2, 'audio/brothers/garden.mp3'),
('Test Tempest', '00:04:46', 2, 'audio/brothers/tempest.mp3');

INSERT INTO artistes (nom, bio, pays) VALUES 
('John Lopker', "Mes journées sont remplies de moments précieux où je me sens très reconnaissant pour toutes les bénédictions de ma vie. Si vous recherchez des chansons avec des paroles, vous trouverez peut-être la chanson parfaite ici. Chansons sur les événements actuels/historiques, les valeurs/faiblesses humaines, les héros/canailles et parfois l'amour.", 'États-Unis');

INSERT INTO albums (titre, date_sortie, image_couverture, id_artiste) VALUES 
('Christmas Songs for Spaceship Earth', '2023-07-21', 'URL_IMAGE_COVER', 3);

INSERT INTO chansons (titre, duree, id_album, chemin_audio) VALUES 
('Away Manger | Sweet Christmas Baby Asleep', '00:01:53', 3, 'audio/christmas/awaymanger.mp3'),
('Silent Night | Love Heavenly Peace', '00:02:30', 3, 'audio/christmas/silentnight.mp3'),
('Jingle Night | Christmas Song', '00:02:00', 3, 'audio/christmas/jinglenight.mp3'),
('Groovy Christmas | Trance Techno Hip Hop', '00:02:05', 3, 'audio/christmas/groovychristmas.mp3'),
('Alien Christmas Chant | Recorded Live in Space', '00:03:01', 3, 'audio/christmas/alienchristmaschant.mp3'),
('Jailbreak Joy HS23 | Christmas Hanukkah Kwanzaa Holiday Song', '00:02:11', 3, 'audio/christmas/jailbreakjoy.mp3');