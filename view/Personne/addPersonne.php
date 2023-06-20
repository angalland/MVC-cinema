<?php
ob_start();?>
<div class="formAddPersonne">
    <!-- formulaire pour ajouter une personne, le status acteur ou réalisateur se définit ici -->
    <form class="formPersonne" action='index.php?action=addPersonne' method='post'>

        <div>
        <label for='nom'>Nom :</label>
        <input type='text' name='nom' maxlength="25">
        </div>

        <div>
        <label for='prenom'>Prenom :</label>
        <input type='text' name='prenom' maxlength="25">
        </div>

        <div>
        <label for='date_naissance'>Date de naissance :</label>
        <input class='inputDate' type='date' name='date_naissance'>
        </div>

        <div>
        <label for='sexe'>Sexe :</label>
        <select name='sexe' id='sexe'>
            <option value="">Choisissez le genre</option>
            <option value="M">Homme</option>
            <option value="F">Femme</option>
        </select>
        </div>

        <div class='checkbox'>
            <input type="checkbox" id='realisateur' name='realisateur'>
            <label for='realisateur'>Réalisateur</label>
        </div>

        <div class='checkbox'>
            <input type="checkbox" id="acteur" name="acteur">
            <label for='acteur'>Acteur</label>
        </div>

        <div class="inputCasting">
        <input type='submit' name='submitPersonne' value='Ajouter'>
        </div>
    </form>
</div>
<?php
// affiche un message de succes si il y en a un 
if (isset($_SESSION['messageSucces'])) {?>
        <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
        unset($_SESSION['messageSucces']);
    };
// affiche un message d'erreure si il y en a un
if (isset($_SESSION['messageAlert'])) {
        foreach ($_SESSION['messageAlert'] as $alert){?>
            <div class='alert'><?= $alert ?></div><?php
            unset($_SESSION['messageAlert']);
        }
    };
?>

<?php
$titre = "addPersonne";
$titre_secondaire = "Ajouter une personne";
$contenu = ob_get_clean();
require "view/template.php";

exit();
