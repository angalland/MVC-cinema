<?php
ob_start();
require ("model/db-function.php");
?>
<div class="formDeleteStatut">
    <!-- supprime un genre d'un film sous la forme de liste deroulante pour le film et le genre -->
    <form class="formDeletePersonne" action='index.php?action=updateFilmGenre' method='post'>
        
        <h2>Choisissez le film dont vous voulez supprimer le genre</h2>
        <div>
            <label for='film'>film :</label>
            <select name='film' id='film'>
                <option value=""></option>
                <?php
                // recupere les donne de film
                    $films = listFilm();
                    // boucle pour afficher le titre et envoie en value id_film
                    foreach ($films as $film){
                        echo "<option value='".$film['id_film']."'>".$film['titre']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="inputCasting">
            <input type='submit' name='submitdeleteFilmGenre' value='Choisir'>
        </div>
    </form>
</div>
<?php

// fonction affiche les genres d'un film sous forme d'un formulaire d'une liste déroulantes  
function listGenreByFilm($id_film){?>
<div class='functionDiv'>
    <div class="formUpdate">
<!-- formulaire des genres du film  -->
        <form class="formDeletePersonne" action='index.php?action=deleteFilmGenreId&id=<?=$id_film?>' method='post'>
        
            <h2>Choisissez le genre dont vous voulez supprimer du film</h2>
            <div>
                <label for='id_genre'>genre :</label>
                <select name='id_genre'>
                    <option value=""></option>
                    <?php
                    // recupere les genre du film
                        $genres = possederGenreById($id_film);
                        // boucle pour afficher le nom_genre et envoie en value id_genre
                        foreach ($genres as $genre){
                            echo "<option value='".$genre['id_genre']."'>".$genre['nom_genre']."</option>";                   
                        }
                    ?>
                </select>
            </div>
            
            <div class="inputCasting">
                <input type='submit' name='submitDeleteFilmGenreId' value='supprimer'>
            </div>
        </form>
    </div>
</div><?php
}
// envoie un message de succes si il y en a un 
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// envoie un message d'alert si il y en a un 
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};

$titre = "Delete Genre";
$titre_secondaire = "Supprimer un genre";
$contenu = ob_get_clean();
require "view/template.php";