<?php
ob_start();
require ("model/db-function.php");
?>
<div class="formAddPersonne">
<!-- formulaire pour récupérer le nom, prenom et l'id_personne et l'envoie au controller  -->
<form class="formPersonne" action='index.php?action=updatePersonne' method='post'>

    <div>
        <label for='personne'>personne :</label>
        <select name='personne' id='personne'>
            <option value=""></option>
            <?php
            // récupère les donnees de la bbd personne
                $personnes = listPersonne();
            // boucle pour afficher le nom, prenom et envoye en value id_personne
                foreach ($personnes as $personne){
                    echo "<option value='".$personne['id_personne']."'>".$personne['prenom']." ".$personne['nom']."</option>";
                }
            ?>
        </select>
    </div>

    <div class="inputCasting">
    <input type='submit' name='submitUpdatePersonne' value='Choisir'>
    </div>
</form>
</div><?php
// fonction qui affiche les donnée d'une personne pour les modifiers ou la supprimer
function formUpdatePersonne ($id) {
if (isset($_SESSION['personne'])){
    // récupère les donnees d'une personne
    $personneDetails = personneId($_SESSION['personne']);
    // insere ces donnée dans des variables
    foreach ($personneDetails as $detail){
        $nom = $detail["nom"];
        $prenom = $detail["prenom"];
        $date = $detail["date_naissance"];
        $sexe = $detail["sexe"];
    }
    $id = $_SESSION['personne'];
}?>

<!-- formulaire pour modifier ou supprimer une personne -->
<div class="functionDiv">
    <div class="formUpdate">
        <form class="formPersonne" action='index.php?action=updatePersonneDetail&id=<?=$id?>' method='post'>

            <div>
                <label for='nom'>Nom :</label>
                <input type='text' name='nom' value="<?= $nom?>" maxlength="25">
            </div>

            <div>
                <label for='prenom'>Prenom :</label>
                <input type='text' name='prenom' value="<?= $prenom?>" maxlength="25">
            </div>

            <div>
                <label for='date_naissance'>Date de naissance :</label>
                <input class='inputDate' type='date' name='date_naissance' value="<?= $date?>">
            </div>

            <div>
                <label for='sexe'>Sexe :</label>
                <select name='sexe' id='sexe'>
                    <?php if ($detail['sexe'] == "M") {?>
                        <option value="M">Homme</option>
                        <option value="F">Femme</option><?php
                    } elseif ($detail['sexe'] == "F") {?>
                        <option value="F">Femme</option>
                        <option value="M">Homme</option><?php
                    }?>
                </select>
            </div>

            <div class="inputCasting"> 
                <input type='submit' name='submitUpdatePersonneId' value='Modifier'>
            </div>

            <div class='alert'>
                Attention pour pouvoir supprimer une personne, aucun statut acteur ou réalisateur  ne doit lui être associé ! Si la personne a un statut acteur/realisateur, veuillez supprimer le statut en premier       
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitDeletePersonneId' value='Supprimer'>
            </div>
        </form>
    </div>
</div>

<?php }
// affiche un message succes si il'yen a un
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
// affiche un message alert si il'y en a un
if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};
?>

<?php
$titre = "Update / Delete personne";
$titre_secondaire = "Modifier ou supprimer une personne";
$contenu = ob_get_clean();
require "view/template.php";