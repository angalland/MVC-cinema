<?php ob_start();?>

<p>Il y a <?= $requete->rowCount()?> réalisateurs</p> <!-- Compte le nombre de réalisateur dans la bbd -->

<!-- affiche les réalisateurs dans un tableau -->
    <div id="listFilm">
        <?php
        // boucle pour lire les noms et prenoms des realisateurs
            foreach($requete->fetchAll() as $personne) {?>
                <a href="index.php?action=personne&id=<?= $personne["id_personne"]?>">
                    <!-- <div class="divListFilm"> -->
                    <div class="card">
                        <!-- Fait un lien en récupérant l'id de la personne pour afficher en detail la personne -->
                        <img class='testImg' src="public/img/imgPersonne/imgTest.jpg"/>
                        <div class='list'><?= $personne["realisateur"] ?></div>
                    </div>
                </a>
        <?php } ?>
    </div>


<?php

$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";
$contenu = ob_get_clean();
require "view/template.php";

