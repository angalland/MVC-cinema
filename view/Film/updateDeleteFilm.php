<?php
ob_start();
require ("model/db-function.php");
?>
<div class="formAddPersonne">
<!-- formulaire pour selectionne le film a modifier ou supprimer -->
<form class="formPersonne" action='index.php?action=updateFilm' method='post'>

    <div>
        <label for='film'>film :</label>
        <select name='film' id='film'>
            <option value=""></option>
            <?php
            // récupère les données de film de la bbd
                $films = listFilm();
                // boucle pour afficher le titre et envoyé en value id_film
                foreach ($films as $film){
                    echo "<option value='".$film['id_film']."'>".$film['titre']."</option>";
                }
            ?>
        </select>
    </div>

    <div class="inputCasting">
    <input type='submit' name='submitUpdateFilm' value='Choisir'>
    </div>
</form>
</div><?php

// fonction qui affichera sous forme de formulaire les données a modifier d'un film 
function formUpdateFilm ($id) {
if (isset($_SESSION['film'])){
    // récupère les donnée d'un film celon l'id récupérer plus haut
    $films = filmId($_SESSION['film']);
    // les insere dans des variables
    foreach ($films as $detail){
        $titre = $detail["titre"];
        $duree = $detail["duree_film"];
        $date_sortie = $detail["date_sortie"];
        $synopsis= $detail["synopsis"];
        $note = $detail['note'];
        $affiche = $detail['affiche'];
        $realisateur = $detail['id_realisateur'];
    }
    $id = $_SESSION['film'];
}?>

<div class='functionDiv'>
    <div class="formUpdate">
        <!-- affiche les données dans un formulaire -->
        <form class="formPersonne" action='index.php?action=modifierFilmId&id=<?=$id?>' method='post' enctype="multipart/form-data">

            <input type="hidden" name='ancienneAffiche' value='<?= $affiche?>'>
        
            <div>
                <label for='titre'>Titre :</label>
                <input type='text' name='titre' value="<?= $titre?>" maxlength="50">
            </div>

            <div>
                <label for='duree_film'>Durée :</label>
                <input type='number' name='duree_film' value='<?= $duree?>' min="0" max="500">
            </div>

            <div>
                <label for='date_sortie'>Date de sortie :</label>
                <input  class='inputDate' type='date' name='date_sortie' value='<?= $date_sortie?>'>
            </div>

            <div>
                <label for="synopsis">Synopsis : </label>
                <textarea name="synopsis" maxlength="500"><?= $synopsis?></textarea>
            </div>

            <div>
                <label for='note'>Note :</label>
                <input  class="note" type='number' name='note' value='<?= $note?>' min="0" max="5">
            </div>

            <div>
                <label for='affiche'>Affiche :</label>
                <input type='file' name='affiche'>
            </div>

            <div>
                <label for='realisateur'>realisateur :</label>
                <select name='realisateur' id='realisateur'>
                    <option value="">Choisissez le réalisateur</option>
                    <?php
                    // récupère les données de realisateur
                        $realisateurs = listRealisateur();
                        // boucle pour afficher le nom, le prenom et envoie en value id_realisateur
                        foreach ($realisateurs as $realisateur){
                            echo "<option value='".$realisateur['id_realisateur']."'>".$realisateur['prenom']." ".$realisateur['nom']."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitUpdateFilmId' value='Modifier'>
            </div>

            <div class='alert'>
                Attention pour pouvoir supprimer un film, aucun casting ne doit lui être associé ! Si le film détient un casting veuillez supprimer le casting en premier
            </div>
            
            <div class="inputCasting">
                <input type='submit' name='submitDeleteFilmId' value='Supprimer'>
            </div>
        </form>
    </div>
</div>

<?php } 
// affiche un message succes si il y en a un
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// affiche un message d'alert si il y en a un
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};
?>

<?php
$titre = "Update / Delete film";
$titre_secondaire = "Modifier ou supprimer un film";
$contenu = ob_get_clean();
require "view/template.php";