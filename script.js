function playSong(element) {
    var audioSource = element.getAttribute('data-audio-source');
    var titreChanson = element.getAttribute('data-titre-chanson');
    var nomArtiste = element.getAttribute('data-nom-artiste');
    var bioArtiste = element.getAttribute('data-bio-artiste');
    var imageAlbum = element.getAttribute('data-image-album');

    var audioPlayer = document.getElementById('audio-player');
    var titreElement = document.getElementById('song-title');
    var artisteElement = document.getElementById('song-artist');
    var bioElement = document.getElementById('song-bio');
    var imageElement = document.getElementById('song-cover');

    audioPlayer.src = audioSource;
    titreElement.textContent = titreChanson;
    artisteElement.textContent = nomArtiste;
    bioElement.textContent = bioArtiste;
    imageElement.src = imageAlbum;

    audioPlayer.play();
}

document.querySelectorAll('.btn-aimer').forEach(button => {
    button.addEventListener('click', function() {
        var chansonId = this.getAttribute('data-chanson-id');
        aimerChanson(chansonId);
    });
});

function aimerChanson(chansonId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'aimer_chanson.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        console.log(this.responseText);
        window.location.reload();
    };
    xhr.send('id_chanson=' + chansonId);
}

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('btn-ne-plus-aimer')) {
        var chansonId = event.target.getAttribute('data-chanson-id');
        retirerChansonAimee(chansonId, event.target);
    }
});

function retirerChansonAimee(chansonId, button) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'retirer_chanson_aimee.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status === 200) {
            button.textContent = 'Aimer';
            button.classList.remove('btn-ne-plus-aimer');
            button.classList.add('btn-aimer');
            console.log(this.responseText);
            window.location.reload();
        }
    };
    xhr.send('id_chanson=' + chansonId);
}

document.getElementById('btn-afficher-plus').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'plus-de-chansons.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            var nouvellesChansons = this.responseText;
            document.getElementById('chansons-container').innerHTML += nouvellesChansons;
        }
    };
    xhr.send();
});

