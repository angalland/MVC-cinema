<?php 
ob_start();?>

<div class="detailFilm light">

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

<!-- affiche les critiques utilisateurs du film -->
<div id='critique'>
        <h3> Critique du publique </h3>

        <div>
            <!-- affiche la note moyennes des utilisateurs du film -->
            <?php foreach ($requeteNote as $note){?>
                <p>Notes moyennes des utilisateur : <?= $note['note']?></p>
            <?php
            }?>
            <p>Avis des utilisateurs :
        <?php
        // boucle pour afficher les critiques du films
        foreach($requeteCritique->fetchAll() as $critique){?>
        <div class="avis">
            <p class="pAvis"><?= $critique['pseudo']?> : <?= $critique['avis']?></p>
        </div>
            <?php
        }?>
        </div>
</div>

<div>
    <button class="btn-open modal-trigger">Donnez votre avis</button>
</div>

<div class="modal-container">
    <div class="overlay modal-trigger">
    </div>
        <div class="modal">
            <button class="close-modal modal-trigger">X</button>
            <form class="utilisateur" method="POST" action="index.php?action=inscription">
                <h3 class="h3Modal"> Votre avis </h3>
                <div class='divUtilisateur'>
                    <label for="avis" class='labelModal'>Avis :</label>
                    <textarea name="avis" id="avis" maxlength="500" placeholder="500 caractère maximum" class="utilisateurTextarea"></textarea>
                </div>
                <div>
                    <label for='note' class='labelModal'>Note :</label>
                    <input class="note" type='number' id="note" name='note' min="0" max="5" step="0.01">
                </div>
                <div>
                    <input type="submit" value='Donnez son avis' class="inputModal">
                </div>
            </form>
        </div>
</div>
<?php


$titre = "Détail du film";
$titre_secondaire = "Détail du film";
$contenu = ob_get_clean();
require "view/template.php";


