<?php 

ob_start();
?>

    <?php
    // recupère les données de la global $_SESSION['user]
    $email = $_SESSION['user']['pseudo'];
    $date = $_SESSION['user']['createdAt'];
    // insère la date en DateTime
    $dt = new DateTime($date); 
    ?>
    <!-- affiche les donnée d'user -->
    <div id="home">
        <h3>Profil</h3>
        <p>Email : <?=$email?></p>
        <!-- format de la date en fr + h -->
        <p>Date d'inscription : <?=$dt->format("d/m/Y H:i") ?></p>
    </div>

<?php
if (isset($_SESSION['messageSucces'])) {?>
    <p class="uk-alert-success"><?= $_SESSION['messageSucces'];?></p><?php
    unset($_SESSION['messageSucces']);
};

if (isset($_SESSION['messageAlert'])) {
    foreach ($_SESSION['messageAlert'] as $alert){?>
        <div class='alert'><?= $alert ?></div><?php
        unset($_SESSION['messageAlert']);
    }
};
$titre = "Profil";
$titre_secondaire = "Utilisateur";
$contenu = ob_get_clean();
require "view/template.php";
    