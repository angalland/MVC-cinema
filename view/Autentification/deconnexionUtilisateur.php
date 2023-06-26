<?php 

ob_start();
?>
<!-- formulaire de deconnexion -->
<div class="formDeleteStatut">
    <form class="formDeletePersonne" method="POST" action="index.php?action=logout">
        <h3>Voulez-vous vous deconnecter ?</h3>
        <div class="inputCasting">
            <button type="submit" value="true" name="deconnexion">Oui</button>
        </div>
        <div class="inputCasting">  
            <button type="submit" value="false" name="deconnexion">Non</button>
        </div>
    </form> 
</div>

<?php
// affiche les messages de succes et de deconnexion si il'y en a
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};
if (isset($_SESSION['deconnexion'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['deconnexion'];?></p><?php
    unset($_SESSION['deconnexion']);
}

$titre = "deconnexion";
$titre_secondaire = "deconnexion";
$contenu = ob_get_clean();
require "view/template.php";