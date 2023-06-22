<?php
ob_start();
require ("model/db-function.php");
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
?>

<!-- <div class="formDeleteStatut"> 
formulaire d'inscription
    <form class="formDeletePersonne" method="POST" action="index.php?action=inscription">
        <h3> Inscription </h3>
        <div>
            <input type="email" placeholder="email" name="email">
        </div>
        <div>
            <input type="password" placeholder="Mot de passe" name="password">
        </div>
        <div>
            <input type="password" placeholder="Confirmer mot de passe" name="confirmPassword">
        </div>
        <div class="inputCasting">
            <input type="submit" value='inscription'>
        </div>
    </form>
</div> -->


<!-- Modal caché d'inscription -->
<div class="modal-container">
    <div class="overlay modal-trigger">
    </div>
        <div class="modal">
            <button class="close-modal modal-trigger">X</button>
            <p class="pModal">Vous n'avez pas de compte, veuillez vous inscrire</p>
            <form class="formDeletePersonne" method="POST" action="index.php?action=inscription">
                <h3 class="h3Modal"> Inscription </h3>
                <div>
                    <input type="email" placeholder="email" name="email">
                </div>
                <div>
                    <input type="password" placeholder="Mot de passe" name="password">
                </div>
                <div>
                    <input type="password" placeholder="Confirmer mot de passe" name="confirmPassword">
                </div>
                <div class="inputCasting">
                    <input type="submit" value='inscription'>
                </div>
            </form>
        </div>
</div>


<div class="formDeleteStatut">
<!-- formulaire de connexion -->
    <form class="formDeletePersonne" method="POST" action="index.php?action=login">
        <h3> Connexion </h3>
        <div>
            <input type="email" placeholder="email" name="email">
        </div>
        <div>
            <input type="password" placeholder="Mot de passe" name="password">
        </div>
        <div class="inputCasting">
            <input type="submit" value='connexion'>
        </div>
    </form>
    <div class="inputCasting ">
    <input type="submit" value="S'inscrire">
    </div>
</div>

<?php
$titre = "Connexion";
$titre_secondaire = "se connecter";
$contenu = ob_get_clean();
require "view/template.php";