<?php
ob_start();
require ("model/db-function.php");
?>
<div class="formDeleteStatut">
    <!-- formulaire sous forme de liste déroulantes pour choisir le role a modifier ou supprimer -->
    <form class="formDeletePersonne" action='index.php?action=updateRole' method='post'>
        <div>
            <label for='role'>Rôle :</label>
            <select name='role' id='role'>
                <option value=""></option>
                <?php
                // recupere les roles
                    $roles = listRole();
                    // affiche le nom du role et envoie en value id_role
                    foreach ($roles as $role){
                        echo "<option value='".$role['id_personnage']."'>".$role['nom_personnage']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="inputCasting">
            <input type='submit' name='submitUpdateRole' value='Choisir'>
        </div>
    </form>
</div><?php

// fonction qui affichera sous forme de formulaire le role a modifier ou supprimer récupérer via l'id ci dessus
function formUpdateRole ($id) {
    if (isset($_SESSION['role'])){
        // recupere les donnée de role par id
        $roles = roleId($_SESSION['role']);
        // insere les donnée dans une variable
        foreach ($roles as $role){
            $nom = $role["nom_personnage"];

        }
        $id = $_SESSION['role'];
    }?>

<div class='functionDiv'>
    <div class="formUpdate">
        <!-- formulaire de modification ou suppression -->
        <form class="formPersonne" action='index.php?action=modifierRoleId&id=<?= $id?>' method='post'>            
            <div>
                <label for='nom'>Nom :</label>
                <input type='text' name='nom' value="<?= $nom?>" maxlength="25">
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitUpdateRoleId' value='Modifier'>
            </div>

            <div class="inputCasting">
                <input type='submit' name='submitDeleteRoleId' value='Supprimer'>
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
$titre = "Update / Delete Role";
$titre_secondaire = "Modifier ou Supprimer un role";
$contenu = ob_get_clean();
require "view/template.php";