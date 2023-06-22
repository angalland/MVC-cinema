<?php 
// sert a contenir tout le contenue entre ob_start() et ob_get_clean()
ob_start();
?>

<p class="count">Il y a <?= $requete->rowCount() ?> films</p> <!-- compte le nombre de film dans la bbd -->

<div id="listFilm" class="light">
    <?php
        foreach($requete->fetchAll() as $film) {?>
            <a href="index.php?action=filmById&id=<?= $film["id_film"]?>" class="aDiv">
                <!-- <div class="divListFilm"> -->
                    <div class="card">
                    <?php if ($film["affiche"] == null) {
                        echo "<div class='defaultImg'></div>";
                    } else {
                        echo "<img class='testImg' src=".$film["affiche" ].">";
                    }?>
                    <p class="list"><?= $film["titre"]?></p>
                    <p class="list"><?= $film["annee"] ?></p>
                </div>
            </a>
            <?php
        }?>
</div>
<?php

$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

// injecte le contenue dans le template
require "view/template.php";
    