<?php
ob_start();
require ("model/db-function.php");
?>

<div class="formDeleteStatut">
    <!-- formulaire de suppression d'un casting -->
    <form  class="formDeletePersonne" action='index.php?action=deleteCasting' method='post'>
        
        <h2>Choisissez le film dont vous voulez supprimer le casting</h2>
        <div>
            <label for='film'>film :</label>
                <select name='film' id='film'>
                    <option value=""></option>
                    <?php
                    // recupère les donnés d'un film
                        $films = listFilm();
                        // boucle pour afficher le titre et envoyer id_film en value
                        foreach ($films as $film){
                            echo "<option value='".$film['id_film']."'>".$film['titre']."</option>";
                        }
                    ?>
                </select>
        </div>

        <div class="inputCasting">
            <input type='submit' name='submitdeleteCasting' value='Choisir'>
        </div>
    </form>
</div>
<?php

// fonction qui supprime un casting celon le film recupérer ci dessus et l'acteur sous forme de formulaire
function listActeurByFilm($id_film){?>
<div class='functionDiv'>
<div class="formUpdate">
    <form class="formPersonne" action='index.php?action=deleteCastingId&id=<?=$id_film?>' method='post'>
     
    <h2>Choisissez l'acteur dont vous voulez supprimer le casting</h2>
    <div>
        <label for='id_acteur'>Acteur :</label>
        <select name='id_acteur' id='id_acteur'>
            <option value=""></option>
            <?php
            // recupere les données de casting en fonction de l'acteur
                $acteurs = castingByActeur($id_film);
                // boucle pour afficher le nom, prenom et envoie en value id_acteur
                foreach ($acteurs as $acteur){
                    echo "<option value='".$acteur['id_acteur']."'>".$acteur['nom']." ".$acteur['prenom']."</option>";
                    
                }
            ?>
        </select>
    </div>
    
    <div class="inputCasting"> 
    <input type='submit' name='submitDeleteCastingId' value='supprimer'>
    </div>
</form>
</div>
</div><?php
}
// affiche un message de succes si il y en a un 
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// affiche un message d'alerte si il y en a un
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};

$titre = "Delete Casting";
$titre_secondaire = "Supprimer un casting";
$contenu = ob_get_clean();
require "view/template.php";