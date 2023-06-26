<?php 
ob_start();
?>
<div id="filmGenre">
<?php
// Boucle pour afficher les details d'un film celon son genre
foreach ($requete->fetchAll() as $detailGenre) {
    $genre=$detailGenre['nom_genre'];
    $date = $detailGenre["date_sortie"];
    $dt = DateTime::createFromFormat('Y-m-d', $date);?>
    <a href="index.php?action=filmById&id=<?= $detailGenre["id_film"]?>">
    <div class="filmGenre">  
    <div><img class="img" src='<?=$detailGenre['affiche']?>' class='affiche'></div>
    <p class="list"><?=$detailGenre['titre']?></p>
    <p class="list"><?=$dt->format('Y')?></p>
    </div>
    </a>
    <?php
}
?>
</div>


<?php

// verifie qu'un film possede ce genre sinon affiche un message 
$titre = "film par genre";
if (isset($genre)){
    $titre_secondaire = "Genre : ".$genre;
} else {
    $titre_secondaire = "Aucun film ne possede ce genre";
}
$contenu = ob_get_clean();
require "view/template.php";

