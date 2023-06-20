<?php
ob_start();
require ("model/db-function.php");?>
<!-- formulaire pour ajouter un role -->
<h2>Role</h2>
<div class="form">
    <form class="formRole" action='index.php?action=addRole' method='post'>
        <label for='role'>Nom du role : </label>
        <input type='text' name='role' maxlength="25">
        <input type='submit' name='submitRole' value='Ajouter'>
    </form>
</div>
<!-- formulaire pour ajouter un genre -->
<h2>Genre</h2>
<div class="form">
    <form class="formRole" action='index.php?action=addGenre' method='post'>
        <label for='genre'>Nom du Genre : </label>
        <input type='text' name='genre' maxlength="25">
        <input type='submit' name='submitGenre' value='Ajouter'>
    </form>
</div>
<!-- formulaire pour ajouter un casting -->
<h2>Casting</h2>
<div class="form">
    <form class="formCasting"  action='index.php?action=addCasting' method='post'>
        <div>
            <label for='film'>Film :</label>
            <select name='film' id='film'>
                <option value="">film</option>
                <?php
                // récupère les films et envoie id_film en value
                    $films = listFilm();
                    foreach ($films as $film){
                        echo "<option value='".$film['id_film']."'>".$film['titre']."</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for='acteur'>acteur :</label>
            <select name='acteur' id='acteur'>
                <option value="">acteur</option>
                <?php
                // recupère les acteurs et envoie id_acteur
                    $acteurs = listActeur();
                    foreach ($acteurs as $acteur){
                        echo "<option value='".$acteur['id_acteur']."'>".$acteur['prenom']." ".$acteur['nom']."</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for='role'>Rôle :</label>
            <select name='role' id='role'>
                <option value="">role</option>
                <?php
                // recupere les roles et envoie id_role
                    $roles = listRole();
                    foreach ($roles as $role){
                        echo "<option value='".$role['id_personnage']."'>".$role['nom_personnage']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="inputCasting">
        <input type='submit' name='submitCasting' value='Ajouter'>
        </div>
    </form>
</div>
<?php
// affiche un message succes si il y en a un 
if (isset($_SESSION['messageSucces'])) {?>
        <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
        unset($_SESSION['messageSucces']);
    };
// affiche un message alert si il y en a un 
if (isset($_SESSION['messageAlert'])) {?>
        <div class='alert'><?=$_SESSION['messageAlert']?></div><?php
        unset($_SESSION['messageAlert']);
    };
// affiche un message alertCasting si il y en a un 
if (isset($_SESSION['messageAlertCasting'])) {
    foreach ($_SESSION['messageAlertCasting'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlertCasting']);
    }
};
?>

<?php
$titre = "Rôle";
$titre_secondaire = "Rôle - Genre - Casting";
$contenu = ob_get_clean();
require "view/template.php";