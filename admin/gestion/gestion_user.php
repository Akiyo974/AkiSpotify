<section class="admin-section">
    <h3>Gestion des Utilisateurs</h3>
    <div class="user-carousel">
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <form class="user-form" action="update/update_user.php" method="post">
                <input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur['id_utilisateur']; ?>">
                <div class="user">
                    <label>Nom:</label>
                    <input type="text" name="nom" value="<?php echo $utilisateur['nom']; ?>">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo $utilisateur['email']; ?>">
                </div>
                <input type="submit" value="Mettre à jour">
            </form>
        <?php endforeach; ?>
    </div>
    <div class="button">
        <button onclick="carouselPrev()" class="users-prev">Précédent</button>
        <button onclick="carouselNext()" class="users-next">Suivant</button>
    </div>
</section>