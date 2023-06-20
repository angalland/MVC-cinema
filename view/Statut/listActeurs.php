<?php ob_start();?>

<p>Il y a <?= $requete->rowCount() ?> acteurs</p> <!-- compte le nombre d'acteurs dans la base de donné -->
    <div id="listFilm">
        <?php
        // boucle pour lire le nom et prenom de l'acteur
            foreach($requete->fetchAll() as $personne) {?>
                <a href="index.php?action=personne&id=<?= $personne["id_personne"]?>">
                    <!-- <div class="divListFilm"> -->
                        <div class="card">
                        <!-- fait un lien en recupérant l'id de la personne pour affiche les detail de la personne -->
                        <img class='testImg' src="public/img/imgPersonne/imgTest.jpg"/>
                        <div class='list'><?= $personne["acteur"] ?></div>
                    </div>
                </a>
        <?php } ?>
    </div>
<?php

$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";