<?php
ob_start();
require ("model/db-function.php");

?>
<div class="formAddPersonne">
<!-- formulaire pour ajouter un film -->
<form class="formPersonne" action='index.php?action=addFilm' method='post' enctype="multipart/form-data">

    <div>
    <label for='titre'>Titre :</label>
    <input type='text' name='titre' maxlength="50">
    </div>

    <div>
    <label for='duree_film'>Durée :</label>
    <input type='number' name='duree_film' min="0" max="500">
    </div>

    <div>
    <label for='date_sortie'>Date de sortie :</label>
    <input class='inputDate' type='date' name='date_sortie'>
    </div>

    <div>
        <label for="synopsis">Synopsis : </label>
        <textarea name="synopsis" maxlength="500"></textarea>
    </div>

    <div>
        <label for='note'>Note :</label>
        <input class="note" type='number' name='note' min="0" max="5" step="0.01">
    </div>

    <div>
        <label for='file'>Affiche :</label>
        <input type='file' name='affiche'>
    </div>

    <!-- affiche les realisateurs sous forme de liste déroulantes -->
    <div>
    <label for='realisateur'>realisateur :</label>
    <select name='realisateur' id='realisateur'>
        <option value="">Realisateur</option>
        <?php
        // recupere les realisateurs
            $realisateurs = listRealisateur();
            // boucle pour afficher les noms, prenoms des realisateurs et envoyé en value id_realisateur
            foreach ($realisateurs as $realisateur){
                echo "<option value='".$realisateur['id_realisateur']."'>".$realisateur['prenom']." ".$realisateur['nom']."</option>";
            }
        ?>
    </select>
    </div>

    <!-- affiche les genres sous forme de checkbox a cocher -->
    <div>       
        <label for='genre'>Genre :</label><br>
        <div class='listGenre'>
        <?php
        // recupere les genres
        $genres = listGenre();
        // boucle pour afficher les noms des genres et envoye en value id_genre
        foreach ($genres as $genre){?>
            <div class='checkbox'>
            <input type='checkbox' name='genres[]' value='<?=$genre['id_genre']?>'>
            <label for='<?=$genre['nom_genre']?>'><?=$genre['nom_genre']?></label>
            </div><?php
        }?>
        </div>
    </div>

    <div class="inputCasting">
    <input type='submit' name='submitFilm' value='Ajouter'>
    </div>

</form>
</div><?php
// affiche un message succes si il y en a un 
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// affiche un message alert si il y en a un 
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};

$titre = "Ajouter film";
$titre_secondaire = "Ajouter un film";
$contenu = ob_get_clean();
require "view/template.php";