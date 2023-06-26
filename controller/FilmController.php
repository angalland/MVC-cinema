<?php

namespace Controller;

use Model\Connect;
use Controller\CinemaController;

class FilmController {

    // affiche les films
    public function afficheFilms() {
        // on se connecte a la bbd
        $pdo = Connect::seConnecter();
        
        // on execute la requete
        $requete = $pdo->query("
            SELECT id_film, titre, YEAR(date_sortie) AS annee, affiche
            FROM film
            ORDER BY annee DESC
        ");

        // on relie a la vue listFilms.php
        require "view/Film/listFilms.php";           
    }

    // affiche le détail des films par id
    public function detailFilm($id){
        // filtre l'id récupérer en get
        $id = filter_var($id, FILTER_VALIDATE_INT);
        // connexion a la bbd
        $pdo = Connect::seConnecter();
        // requete sql
        $requete = $pdo->prepare("
        SELECT titre, YEAR(date_sortie) AS annee, affiche, duree_film, synopsis, note, CONCAT(personne.prenom,' ',personne.nom) AS 'realisateur', personne.id_personne
        FROM film
        INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
        INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
        WHERE film.id_film = :id
        ORDER BY titre
        ");
        $requete->bindparam("id", $id);
        $requete->execute();

        $requeteGenre = $pdo->prepare("
        SELECT *
        FROM posseder_genre
        INNER JOIN genre
            ON posseder_genre.id_genre = genre.id_genre
        INNER JOIN film
            ON posseder_genre.id_film = film.id_film
        WHERE film.id_film = :id
        ");
        $requeteGenre->bindparam("id", $id);
        $requeteGenre->execute();

        $requeteCasting = $pdo->prepare("
        SELECT personnage.nom_personnage, CONCAT(personne.prenom,' ',personne.nom) AS acteur, casting.id_film, casting.id_acteur, casting.id_personnage, personne.id_personne
        FROM casting
        INNER JOIN personnage
            ON casting.id_personnage = personnage.id_personnage
        INNER JOIN acteur
            ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
        INNER JOIN film
            ON casting.id_film = film.id_film
        WHERE film.id_film = :id;
        ");
        $requeteCasting->bindparam("id", $id);
        $requeteCasting->execute();

        $requeteCritique = $pdo->prepare("
        SELECT critique.avis, critique.note, user.pseudo
        FROM critique
        INNER JOIN user
	        ON critique.id_user = user.id_user
        WHERE critique.id_film = :id
        ");
        $requeteCritique->bindparam("id", $id);
        $requeteCritique->execute();

        // envoie les donnees sur la page filmById
        require "view/Film/filmById.php";
    }

    // ajoute un film
    public function ajouteFilm(){
        // verifie qu'une session user est présente
        if (isset($_SESSION['user'])){
            if (isset($_POST["submitFilm"])){

                $_SESSION["errors"] = [];

                // récupère et filtre les donnée du formulaire
                ($titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le titre est incorrecte";
                ($duree = filter_input(INPUT_POST, "duree_film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = "la durée est incorrecte";
                ($date = filter_input(INPUT_POST, "date_sortie", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'La date est incorrecte';
                ($synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $synopsis = null;
                ($note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) ? false : $note = null;
                ($id_realisateur = filter_input(INPUT_POST, "realisateur", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le réalisateur est incorrecte';

                // filtre les données pour les genres
                if (isset($_POST['genres'])){
                $id_genres = $_POST['genres'];
                if ($id_genres){
                foreach ($id_genres as $id_genre){
                ($id_genresSelectionnes [] = filter_var($id_genre, FILTER_VALIDATE_INT))? false : $_SESSION['errors'][] = "L\id est incorrecte";
                }}}

                // ajouter une affiche 
                if (isset($_FILES["affiche"])){ // vérifie que l'utilisateur a bien transmis son fichier 

                    // Récupere les informations du fichiers
                    $tmpName = $_FILES["affiche"]['tmp_name']; 
                    $nameImage = $_FILES["affiche"]["name"];
                    $type = $_FILES["affiche"]["type"];
                    $error = $_FILES["affiche"]["error"];
                    $size = $_FILES["affiche"]["size"];
                
                    // separe la chaine de caractere $name a chaque fois qu'il a un "."
                    $tabExtension = explode('.', $nameImage);               
                    // Prend le dernier element de $tabExtension et le renvoie en minuscule
                    $extension = strtolower(end($tabExtension));                
                    // Introduit une variable ayant pour valeur un int
                    $tailleMax = 3000000;                
                    //Tableau des extensions qu'on autorise 
                    $extensionAutorisees = ['jpg', 'jpeg', 'gif', 'png'];

                        if(in_array($extension, $extensionAutorisees) && $size <= $tailleMax && $error == 0 ){ // vérifie que $extension soit compris dans $extensionAutorisees et que la taille du fichier soit <= a la valeur de $tailleMax et que le fichier ne renvoie aucune erreure

                            // génere un nom unique ex: 5f586bf96dcd38.73540086
                            $uniqueName = uniqid('', true);

                            // on ajoute $uniqueName avec $extension = 5f586bf96dcd38.73540086.jpg
                            $fileName = $uniqueName.'.'.$extension;
                            
                            //transfere le fichier img ($tmpName etant le chemin ou il est sur l'ordinateur dans le fichier /upload/ et lui assigne $fileName)
                            move_uploaded_file($tmpName, 'public/img/'.$fileName);


                            
                        } elseif (in_array($extension, $extensionAutorisees) == false) { // sinon
                            
                            // envoie un message d'alerte si la premiere condition n'est pas respecté et le fichier ne sera pas transmis
                            $_SESSION['errors'] [] = "Le fichier n'a pas été ajouté, vous devez transmettre des fichiers au format jpg, jpeg, gif ou png";
                            
                        } elseif ($size > $tailleMax) { // sinon 
                            
                            // envoie un message d'alerte si la taille du fichier dépasse la taille autorisé
                            $_SESSION['errors'] [] = "Le fichier n'a pas été ajouté, vous devez transmettre des fichiers de moins de 3 méga";
                        }

                        if (isset($fileName)) {
                        $affiche = "public/img/".$fileName; // crée une variable qui = au chemin d'acces du fichier dans le dossier upload
                        }
                    }        

                // connexion a la bbd et requete sql ajoute un film
                if ($titre && $duree && $date && $id_realisateur){
                    $pdo = Connect::seConnecter();
                    $requete = $pdo->prepare("
                    INSERT INTO film 
                    (titre, duree_film, date_sortie, id_realisateur, note, synopsis, affiche)
                    VALUES (:titre,
                            :duree_film,
                            :date_sortie,
                            :id_realisateur,
                            :note,
                            :synopsis,
                            :affiche)
                    ");
                    $requete->bindparam("titre", $titre);
                    $requete->bindparam("duree_film", $duree);
                    $requete->bindparam("date_sortie", $date);
                    $requete->bindparam("id_realisateur", $id_realisateur);
                    $requete->bindparam("note", $note);
                    $requete->bindparam("synopsis", $synopsis);
                    $requete->bindparam("affiche", $affiche);
                    $requete->execute();
                    // selectionne la derniere id créer dans la bbd
                    $id_film = $pdo->lastInsertId();

                    if (isset($id_genresSelectionnes)) {
                    // boucle pour inserer dans la table posseder_genre tous les genres cocher
                    foreach ($id_genresSelectionnes as $id_genre){
                        $pdo = Connect::seConnecter();
                        $requeteGenre = $pdo->prepare("
                        INSERT INTO posseder_genre
                        (id_film, id_genre)
                        VALUES (:id_film,
                                :id_genre)
                        ");
                        $requeteGenre->bindparam("id_film", $id_film);
                        $requeteGenre->bindparam("id_genre", $id_genre);
                        $requeteGenre->execute();
                    }
                    }

                    $_SESSION['messageSucces'] = 'Votre Film '.$titre.' a bien été ajouté !';

                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'][] = $error;
                    }
                }
                        
            }
            require "view/Film/addFilm.php";
        } else {
            CinemaController::afficherHome();
        }
    }

    // obtenir l'id d'un film
    public function modifierFilm(){
        // verifie qu'une session user est présente
        if (isset($_SESSION['user'])){
            require ("view/Film/updateDeleteFilm.php");
            if (isset($_POST['submitUpdateFilm'])){

                $_SESSION['errors'] = [];
                // récupère et filtre les données du formulaire
                ($id = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';

                if ($id){
                    $_SESSION['film'] = $id;
                    formUpdateFilm ($id);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }
            
                }
            }
        } else {
            CinemaController::afficherHome();
        }
    }

    // modifie un film
    public function modifierFilmId($id){
        if (isset($_POST["submitUpdateFilmId"])){

            $_SESSION["errors"] = [];

            // récupère et filtre les donnée du formulaire
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte' ;
            ($titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le titre est incorrecte";
            ($duree = filter_input(INPUT_POST, "duree_film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = "la durée est incorrecte";
            ($date = filter_input(INPUT_POST, "date_sortie", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'La date est incorrecte';
            ($synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $synopsis = null;
            ($note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) ? false : $note = null;
            ($id_realisateur = filter_input(INPUT_POST, "realisateur", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le réalisateur est incorrecte';

            ($ancienneAffiche = filter_input(INPUT_POST, "ancienneAffiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "L'affiche est incorrecte";
            
            // ajouter une affiche 
            if (isset($_FILES["affiche"])){ // vérifie que l'utilisateur a bien transmis son fichier 
                
                // Récupere les informations du fichiers
                $tmpName = $_FILES["affiche"]['tmp_name']; 
                $nameImage = $_FILES["affiche"]["name"];
                $type = $_FILES["affiche"]["type"];
                $error = $_FILES["affiche"]["error"];
                $size = $_FILES["affiche"]["size"];
            
                // separe la chaine de caractere $name a chaque fois qu'il a un "."
                $tabExtension = explode('.', $nameImage);               
                // Prend le dernier element de $tabExtension et le renvoie en minuscule
                $extension = strtolower(end($tabExtension));                
                // Introduit une variable ayant pour valeur un int
                $tailleMax = 3000000;                
                //Tableau des extensions qu'on autorise 
                $extensionAutorisees = ['jpg', 'jpeg', 'gif', 'png'];

                    if(in_array($extension, $extensionAutorisees) && $size <= $tailleMax && $error == 0 ){ // vérifie que $extension soit compris dans $extensionAutorisees et que la taille du fichier soit <= a la valeur de $tailleMax et que le fichier ne renvoie aucune erreure

                        // génere un nom unique ex: 5f586bf96dcd38.73540086
                        $uniqueName = uniqid('', true);

                        // on ajoute $uniqueName avec $extension = 5f586bf96dcd38.73540086.jpg
                        $fileName = $uniqueName.'.'.$extension;

                        //transfere le fichier img ($tmpName etant le chemin ou il est sur l'ordinateur dans le fichier /upload/ et lui assigne $fileName)
                        move_uploaded_file($tmpName, 'public/img/'.$fileName);


                        
                    } elseif (in_array($extension, $extensionAutorisees) == false) { // sinon
                        
                        // envoie un message d'alerte si la premiere condition n'est pas respecté et le fichier ne sera pas transmis
                        $_SESSION['errors'] [] = "Le fichier n'a pas été ajouté, vous devez transmettre des fichiers au format jpg, jpeg, gif ou png";
                        
                    } elseif ($size > $tailleMax) { // sinon 
                        
                        // envoie un message d'alerte si la taille du fichier dépasse la taille autorisé
                        $_SESSION['errors'] []= "Le fichier n'a pas été ajouté, vous devez transmettre des fichiers de moins de 3 méga";
                    } 

                    if (isset($fileName)){
                    $affiche = "public/img/".$fileName; // crée une variable qui = au chemin d'acces du fichier dans le dossier upload
                    }
                }
                // connexion a la bbd et requete sql modifie un film
            if ($titre && $duree && $date && $id_realisateur){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                UPDATE film 
                SET titre = :titre,
                    duree_film = :duree_film,
                    date_sortie = :date_sortie,
                    id_realisateur = :id_realisateur,
                    note = :note,
                    synopsis = :synopsis,
                    affiche = :affiche
                WHERE id_film = :id                                    
                ");
                $requete->bindparam("titre", $titre);
                $requete->bindparam("duree_film", $duree);
                $requete->bindparam("date_sortie", $date);
                $requete->bindparam("id_realisateur", $id_realisateur);
                $requete->bindparam("note", $note);
                $requete->bindparam("synopsis", $synopsis);
                $requete->bindparam("id", $id);
                $requete->bindparam("affiche", $affiche);
                $requete->execute();

                // supprime l'ancienne affiche dans le fichier upload
                if ($affiche) {
                    if ($ancienneAffiche){
                    unlink($ancienneAffiche);
                    }
                }

                $_SESSION['messageSucces'] = 'Votre Film '.$titre.' a bien été modifié !';

            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
                      
        }

        // supprime un film
        if (isset($_POST["submitDeleteFilmId"])){

            $_SESSION["errors"] = [];

            // récupère et filtre les donnée du formulaire
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte' ;
            ($ancienneAffiche = filter_input(INPUT_POST, "ancienneAffiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "L'affiche est incorrecte";

            // connexion a la bbd et requete sql suppression du film
            if ($id){
                try {
                $pdo = Connect::seConnecter();
                
                $requeteGenre = $pdo->prepare("
                DELETE FROM posseder_genre
                WHERE id_film = :id
                ");
                $requeteGenre->bindparam("id", $id);
                $requeteGenre->execute();

                $requete = $pdo->prepare("
                DELETE FROM film 
                WHERE id_film = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();

                if ($ancienneAffiche){
                unlink($ancienneAffiche);
                }
                
                $_SESSION['messageSucces'] = 'Votre film a bien été supprimé !';
                } catch (\PDOException $ex){
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer ce film car il possède un casting veuillez supprimer le casting en 1er';
                }
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] = $error;
                }
            }
        }

        require "view/Film/updateDeleteFilm.php";
    }

    // ajouter un genre a un film
    public function ajouterGenreFilm(){
        // verifie qu'une session user est disponible
        if (isset($_SESSION['user'])){
            if (isset($_POST["submitGenreFilm"])){
                $_SESSION["errors"] = [];
                // récupère et filtre les données du formulaire
                ($id_film = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';
                ($id_genre= filter_input(INPUT_POST, "genre", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le genre est incorrecte';
                // connexion a la bbd et requete sql ajoute un genre
                if ($id_film && $id_genre){
                    try {
                    $pdo = Connect::seConnecter();
                    $requete = $pdo->prepare("
                    INSERT INTO posseder_genre
                    (id_film, id_genre)
                    VALUES (:id_film,
                            :id_genre)
                    ");
                    $requete->bindparam("id_film", $id_film);
                    $requete->bindparam("id_genre", $id_genre);
                    $requete->execute();
        
                    $_SESSION['messageSucces'] = 'Votre genre a bien été ajouté !';
                    } catch (\PDOException $ex) {
                        $_SESSION['messageAlerte'] [] = 'Ce film possède deja ce genre';
                    }

                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlerte'] [] = $error;
                    }
                }
            }
            require "view/Film/addGenreFilm.php";
        } else {
            CinemaController::afficherHome();
        }
    }
}