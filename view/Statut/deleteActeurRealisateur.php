<?php
ob_start();
require ("model/db-function.php");
?>
<!-- formulaire pour supprimer un realisateur -->
<div class="formDeleteStatut">
    <form class="formDeletePersonne" action='index.php?action=deleteActeurRealisateur' method='post'>
        <h2>Supprimer un réalisateur</h2>
        <div>
            <label for='nom'>Nom :</label>
            <select name='nom' id='nom'>
                <option value=""></option>
                <?php
                // fait appelle a une fonction pour recupérer les données de realisateur
                    $realisateurs = listRealisateur();
                // boucle pour afficher le nom et prenom de realisateur et envoie en value id_realisateur
                    foreach ($realisateurs as $realisateur){
                        echo "<option value='".$realisateur['id_realisateur']."'>".$realisateur['prenom']." ".$realisateur['nom']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="inputCasting">
            <input type='submit' name='submitDeleteRealisateur' value='Choisir'>
        </div>
    </form>
</div>

<!-- formulaire pour supprimer un acteur -->
<div class="formDeleteStatut">
    <form class="formDeletePersonne" action='index.php?action=deleteActeurRealisateur' method='post'>
        <h2>Supprimer un acteur</h2>
        <div>
            <label for='nom'>Nom :</label>
            <select name='nom' id='nom'>
                <option value=""></option>
                <?php
                // fait appelle a une fonction pour recupérer les données d'acteur
                    $acteurs = listActeur();
                // boucle pour afficher le nom et prenom de l'acteur et envoie en value id_acteur
                    foreach ($acteurs as $acteur){
                        echo "<option value='".$acteur['id_acteur']."'>".$acteur['prenom']." ".$acteur['nom']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="inputCasting">
            <input type='submit' name='submitDeleteActeur' value='Choisir'>
        </div>
    </form>
</div>
<?php

// fonction pour afficher le nom du realisateur et envoyer l'id realisateur a supprimerRealisateurId
function deleteRealisateur ($id){
    if (isset($_SESSION['realisateur'])){
        $realisateurs = realisateurId($_SESSION['realisateur']);
        foreach ($realisateurs as $realisateur){
            $nom = $realisateur["nom"]." ".$realisateur['prenom'];

        }
        $id = $_SESSION['realisateur'];
    }?>
    
<div class='functionDiv'>
    <div class="formUpdate">
        <form class="formDeletePersonne" action='index.php?action=supprimerRealisateurId&id=<?= $id ?>' method='post'>
            
            <div>
                <h3><?= $nom?></h3>
            </div>

            <div class='alert'> 
                Attention, si ceux réalisateur est attribué a un film, vous devez supprimer le film en premier avant de pouvoir supprimer le réalisateur ! 
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitDeleteRealisateurId' value='Supprimer'>
            </div>

        </form>
    </div>
</div>

<?php } 
// fonction pour afficher le nom de l'acteur et envoyer l'id_acteur a supprimerActeurId
function deleteActeur($id) {
    if (isset($_SESSION['acteur'])){
        $acteurs = acteurId($_SESSION['acteur']);
        foreach ($acteurs as $acteur){
            $nom = $acteur["nom"]." ".$acteur['prenom'];

        }
        $id = $_SESSION['acteur'];
    }?>
    
<div class='functionDiv'>
    <div class="formUpdate">
        <form  class="formDeletePersonne" action='index.php?action=supprimerActeurId&id=<?=$id?>' method='post'>
                
            <div>
                <h3> <?= $nom?></h3>
            </div>

            <div class='alert'> 
                Attention, si cette acteur est attribué a un casting, vous devez supprimer tous les castings ou il est affecté avant de pouvoir supprimer l'acteur ! 
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitDeleteActeurId' value='Supprimer'>
            </div>

        </form>
    </div>
<div>
<?php } 
// affiche un message de succes si il y en a un puis le supprime
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// affiche un message d'alert si il y en a un puis le suprime
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};
?>

<?php
$titre = "Delete Acteur/realisateur";
$titre_secondaire = "Supprimer un acteur ou un realisateur";
$contenu = ob_get_clean();
require "view/template.php";