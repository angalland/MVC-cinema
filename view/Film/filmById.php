<?php 
ob_start();?>

<div class="detailFilm">

    <?php
    // boucle pour afficher les donnée d'un film
        foreach ($requete->fetchAll() as $detailFilm){
            $affiche = $detailFilm['affiche'];?>
            <div class="imgDetail">
            <img class='img' src="<?= $affiche ?>">
            </div>
            <h2 class='detail'><?= $detailFilm["titre"]?></h2>
            <div class='detail'>Réalisateur : <a href="index.php?action=personne&id=<?=$detailFilm['id_personne']?>"><?= $detailFilm["realisateur"]?></a></div>
            <div class='detail'>Durée : <?= $detailFilm["duree_film"]?> min</div>
            <div class='detail'>Annee de sortie : <?= $detailFilm["annee"]?></div><?php
            // affiche le synopsis que si il y en a un 
            if ($detailFilm["synopsis"] == null) {
                echo "";
            } else {
                echo '<div class="synopsis">Synopsis : '.$detailFilm["synopsis"].'</div>';
            }
            // affiche la note que si il y'en a un
            if ($detailFilm["note"] == null) {
                echo "";
            } else {
                echo '<div class="detail">Note : '.$detailFilm["note"].'</div>';           
            }
        }?>
        
        <div class='detail'>Genre : <?php 
        // boucle pour afficher les genres du film
        foreach ($requeteGenre->fetchAll() as $detailGenre){?>
           <a href='index.php?action=detailGenre&id=<?=$detailGenre['id_genre']?>'><?=$detailGenre['nom_genre']?></a>
           <?php
        }?></div>

        <div class='detail'>Casting : <br>
        <?php
        // boucle pour afficher les castings du films
        foreach ($requeteCasting->fetchAll() as $casting){?>
            <?=$casting["nom_personnage"]?> : <a href='index.php?action=personne&id=<?=$casting['id_personne']?>'><?=$casting["acteur"]?></a><br>
            <?php
        }
        ?></div>

</div>

<?php


$titre = "Détail du film";
$titre_secondaire = "Détail du film";
$contenu = ob_get_clean();
require "view/template.php";


