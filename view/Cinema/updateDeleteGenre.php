<?php
ob_start();
require ("model/db-function.php");
?>
<div class="formDeleteStatut">
    <!-- formulaire sous forme de liste déroulantes pour choisir le genre a modifier ou supprimer -->
    <form class="formDeletePersonne" action='index.php?action=updateGenre' method='post'>

        <div>
            <label for='genre'>Genre :</label>
            <select name='genre' id='genre'>
                <option value=""></option>
                <?php
                // recupere les donnees de genre
                    $genres = listGenre();
                    // boucle pour afficher le nom du genre et envoye en value id_genre
                    foreach ($genres as $genre){
                        echo "<option value='".$genre['id_genre']."'>".$genre['nom_genre']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="inputCasting">
        <input type='submit' name='submitUpdateGenre' value='Choisir'>
        </div>
    </form>
</div><?php

// fonction qui affichera sous forme de formulaire le genre a modifier ou supprimer
function formUpdateGenre ($id){
    if (isset($_SESSION['genre'])){
        // recupere les donnée de genre par id
        $genres = genreId($_SESSION['genre']);
        // insere les donnees dans des variables
        foreach ($genres as $genre){
            $nom = $genre["nom_genre"];

        }
        $id = $_SESSION['genre'];
    }?>

<div class='functionDiv'>
    <div class="formUpdate">
    <!-- formulaire de modification ou de suppression -->
        <form class="formPersonne" action='index.php?action=modifierGenreId&id=<?=$id?>' method='post'>       
            <div>
                <label for='nom'>Nom :</label>
                <input type='text' name='nom' value="<?= $nom?>" maxlength="25">
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitUpdateGenreId' value='Modifier'>
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitDeleteGenreId' value='Supprimer'>
            </div>
        </form>
    </div>
</div>

<?php } 
// affiche un message de succes si il y en a un 
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
$titre = "Update / Delete Genre";
$titre_secondaire = "Modifier ou Supprimer un genre";
$contenu = ob_get_clean();
require "view/template.php";