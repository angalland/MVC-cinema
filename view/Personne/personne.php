<?php
ob_start();?>

<div class="detailFilm">
    <div>
    <img class="imgPersonne" src="public/img/imgPersonne/Aaron_Horvath.jpg"/>
    <?php
    // boucle pour afficher les données de personne de la bbd
        foreach ($requete->fetchAll() as $personne){?>
            <p class="personne"><?= $personne["nom"];?> <?= $personne["prenom"]?></p>
            <?php   $date = $personne["date_naissance"];
                    $dt = DateTime::createFromFormat('Y-m-d', $date);?> <!-- formate la date en fr -->
            <p class="personne">Née le <?= $dt->format('d/m/Y');?></p>
            <?php 
            // calcule l'age de la personne
            $today = new DateTime;
            $diff = $today->diff($dt);?>
            <p class="personne"> Age : <?= $diff->y?> ans</p>  
            <p class="personne">
                <!-- affiche homme ou femme celon le genre -->
                <?php if ($personne["sexe"] == "M"){
                        echo "Homme";
                    } else {
                        echo "Femme";
                    }?></p>
        <?php }
    ?>
    </div>

    <div>
        <h4>Filmographie</h4><?php
        foreach ($requeteRealisateur->fetchAll() as $real){?>
        <p class="personne"><a href='index.php?action=filmById&id=<?=$real['id_film']?>'><?= $real['titre']?></a></p><?php 
        }?>      
     
        <?php
        // boucle pour afficher les roles joués
            foreach ($requeteCasting->fetchAll() as $casting){?>
                <p class="personne"><a href='index.php?action=filmById&id=<?=$casting['id_film']?>'><?=$casting["titre"];?></a></br>
                Rôle : <?= $casting["nom_personnage"];?></p><?php
            }
        ?>
    </div>
</div>

<?php
$titre = "Personne";
$titre_secondaire = "Personne";
$contenu = ob_get_clean();
require "view/template.php";

