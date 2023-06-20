<?php 
ob_start();
?>

<p>Il y a <?= $requete->rowCount() ?> genres</p> <!-- compte le nombre de genre -->
<!-- affiche les genres sous forme de tableau -->

        <?php
        // boucle pour afficher le nom du genre
            foreach($requete->fetchAll() as $genre) {?>
                    <a href="index.php?action=detailGenre&id=<?= $genre["id_genre"]?>">
                    <div class="genre">
                    <?= $genre["nom_genre"] ?>
                    </div>
                    </a>              
        <?php  }?>


<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des Genres";
$contenu = ob_get_clean();

// injecte le contenue dans le template
require "view/template.php";
    