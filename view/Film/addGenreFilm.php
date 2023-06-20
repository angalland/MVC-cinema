<?php
ob_start();
require ("model/db-function.php");?>
<div class="formAddPersonne">
<!-- formulaire pour ajouter un genre a un film -->
<form class="formPersonne" action='index.php?action=addGenreFilm' method='post'>
    <div>
        <label for='film'>Film :</label>
        <select name='film' id='film'>
            <option value="">film</option>
            <?php
            // recupere les films
                $films = listFilm();
                // boucle pour afficher le titre et envoyé en value l'id_film
                foreach ($films as $film){
                    echo "<option value='".$film['id_film']."'>".$film['titre']."</option>";
                }
            ?>
        </select>
    </div>
    <div>
        <label for='genre'>genre :</label>
        <select name='genre' id='genre'>
            <option value="">genre</option>
            <?php
            // recupere les genres
                $genres= listGenre();
                // boucle pour afficher le nom_genre et envoyer en value id_genre
                foreach ($genres as $genre){
                    echo "<option value='".$genre['id_genre']."'>".$genre['nom_genre']."</option>";
                }
            ?>
        </select>
    </div>
    <div class="inputCasting">
    <input type='submit' name='submitGenreFilm' value='Ajouter'>
    </div>
</form>
</div>

<?php
// affiche un message succes si il y en a un
if (isset($_SESSION['messageSucces'])) {?>
        <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
        unset($_SESSION['messageSucces']);
    };
// affiche un message d'erreure si il y en a un 
if (isset($_SESSION['messageAlerte'])) {
    foreach ($_SESSION['messageAlerte'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlerte']);
    }
};
?>

<?php
$titre = "Genre-Film";
$titre_secondaire = "Ajouter un genre a un film";
$contenu = ob_get_clean();
require "view/template.php";