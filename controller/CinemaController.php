<?php

namespace Controller;
// utilise le namespace Model et la classe Connect
use Model\Connect;
session_start();

class CinemaController {

    // -------------------------- Affiche --------------------------
    
    // affiche Home
    public static function afficherHome() {
        include "view/Cinema/home.php";
    }
       
    // affiche la page add_role_genre_casting
    public function affiche_role_genre_casting(){
        if (isset($_SESSION['user'])){
            require "view/Cinema/add_role_genre_casting.php";
        } else {
            self::afficherHome();
        }
    }

    // affiche les genres
    public function afficherGenre(){
        
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT *
            FROM genre
            ORDER BY nom_genre DESC
        ");

        require "view/Cinema/listGenre.php"; 
    }

    // affiche les films celon le genre
    public function afficherGenreId($id) {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        $pdo = Connect::seConnecter();

        $requete = $pdo->prepare("
        SELECT *
        FROM posseder_genre
        INNER JOIN genre
	        ON posseder_genre.id_genre = genre.id_genre
        INNER JOIN film
	        ON posseder_genre.id_film = film.id_film
        WHERE posseder_genre.id_genre = :id
        ");
        $requete->bindparam("id", $id);
        $requete->execute();

        require "view/Cinema/detailGenre.php";
    }
    
    // ------------------------- ADD -----------------------------------

    // ajoute un role
    public function ajouterPersonnage(){

        // si submitRole est activé
        if (isset($_POST['submitRole'])){
                
            // Filtre le nom "role"
            $personnage = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
            // si $personne est valide
            if ($personnage) {

                // ajoute le role a la bbd
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                INSERT INTO personnage
                (nom_personnage)
                VALUES (:role)
                ");
                $requete->bindparam("role", $personnage);
                $requete->execute();

                $_SESSION['messageSucces'] = 'Votre rôle '.$personnage.' a bien été ajouté !';

                } else { // sinon envoie un message d'alert
                    
                    $_SESSION['messageAlert'] = 'Votre Rôle n\' a pas été ajouté, il est incorrecte';
                }
                
            }
            // retourne sur la page d'envoie
            require "view/Cinema/add_role_genre_casting.php";
        } 
    

    // ajoute un genre
    public function ajouteGenre(){
        // si submitGenre est activé
        if (isset($_POST['submitGenre'])){
            // filtre le nom "genre"
            $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // si $genre est valide
            if ($genre) {
                // ajoute un genre a la bbd
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                INSERT INTO genre
                (nom_genre)
                VALUES (:genre)
                ");
                $requete->bindparam("genre", $genre);
                $requete->execute();

                $_SESSION['messageSucces'] = 'Votre genre '.$genre.' a bien été ajouté !';

            } else { // sinon envoie un message d'alert

                $_SESSION['messageAlert'] = 'Votre genre n\' a pas été ajouté, il est incorrecte';
            }
            
        } // revoie sur la page 
        require "view/Cinema/add_role_genre_casting.php";
    }

    // ajoute un casting 
    public function ajouteCasting(){
        if (isset($_POST["submitCasting"])){
            $_SESSION["errors"] = [];

            ($id_film = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';
            ($id_acteur = filter_input(INPUT_POST, "acteur", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'L\' acteur est incorrecte';
            ($id_personnage = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le rôle est incorrecte';

            if ($id_film && $id_acteur && $id_personnage){
                try {
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                INSERT INTO casting 
                (id_film, id_acteur, id_personnage)
                VALUES (:id_film,
                        :id_acteur,
                        :id_personnage)
                ");
                $requete->bindparam("id_film", $id_film);
                $requete->bindparam("id_acteur", $id_acteur);
                $requete->bindparam("id_personnage", $id_personnage);
                $requete->execute();
    
                $_SESSION['messageSucces'] = 'Votre casting a bien été ajouté !';
                } catch (\PDOException $ex) {
                    $_SESSION['messageAlertCasting'] [] = 'Vous ne pouvez pas ajouter ce casting, il est déja crée !';
                }   
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlertCasting'] [] = $error;
                }
            }
        }
        require "view/Cinema/add_role_genre_casting.php";
    }

    // -------------------------------- Update ----------------------------------------
    // recupere l'id d'un role
    public function modifierRole(){

        if (isset($_SESSION['user'])){
        require ("view/Cinema/updateDeleteRole.php");

            if (isset($_POST['submitUpdateRole'])){

                $_SESSION['errors'] = [];

                ($id = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';

                if ($id){
                    $_SESSION['role'] = $id;
                    formUpdateRole ($id);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }
            
                }
            }
        } else {
            self::afficherHome();
        }
    }

    // modifie un role
    public function modifierRoleId($id){
        if (isset($_POST["submitUpdateRoleId"])){

            $_SESSION["errors"] = [];

            // récupère et filtre les donnée du formulaire
            ($id = filter_var($id, FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le role est incorrecte' ;
            ($nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le nom est incorrecte";
            
            if ($id && $nom){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                UPDATE personnage
                SET nom_personnage = :nom
                WHERE id_personnage = :id                                    
                ");
                $requete->bindparam("nom", $nom);
                $requete->bindparam("id", $id);
                $requete->execute();

                $_SESSION['messageSucces'] = 'Votre rôle '.$nom.' a bien été modifié !';

            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
                      
        }

        // supprime le role
        if (isset($_POST["submitDeleteRoleId"])){
            $_SESSION["errors"] = [];

            ($id = filter_var($id, FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le role est incorrecte' ;

            if ($id){
                try {
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM personnage
                WHERE id_personnage = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre role a bien été supprimé !';
                }catch (\PDOException $e){
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer ce role car il est associé a un casting, veuillez supprimer le casting en 1er';
                }
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }

        require "view/Cinema/updateDeleteRole.php";
    }

    // recupere l'id d'un genre
    public function modifierGenre(){
        if (isset($_SESSION['user'])){
            require ("view/Cinema/updateDeleteGenre.php");
            if (isset($_POST['submitUpdateGenre'])){

                $_SESSION['errors'] = [];

                ($id = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le genre est incorrecte';

                if ($id){
                    $_SESSION['genre'] = $id;
                    formUpdateGenre ($id);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }
            
                }
            }
        } else {
            self::afficherHome();
        }
    }

    // moddifier un genre
    public function modifierGenreId($id){
        if (isset($_POST["submitUpdateGenreId"])){

            $_SESSION["errors"] = [];

            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'Le genre est incorrecte' ;
            ($nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le nom est incorrecte";
            
            if ($id && $nom){

                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                UPDATE genre
                SET nom_genre = :nom
                WHERE id_genre = :id                                    
                ");
                $requete->bindparam("nom", $nom);
                $requete->bindparam("id", $id);
                $requete->execute();

                $_SESSION['messageSucces'] = 'Votre genre '.$nom.' a bien été modifié !';

            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
                      
        }

        // supprime le genre
        if (isset($_POST["submitDeleteGenreId"])){
            $_SESSION["errors"] = [];

            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'Le genre est incorrecte' ;

            if ($id){

                try {
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM genre
                WHERE id_genre = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre genre a bien été supprimé !';

                } catch (\PDOException $ex) {
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer ceux genre car il est relié a un film, veuillez supprimer l\'association du film et du genre';
                }
    
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }

        require "view/Cinema/updateDeleteGenre.php";
    }

    // supprimer un film-Genre
    public function modifierFilmGenre(){
        if (isset($_SESSION['user'])){
            require ("view/Cinema/deleteFilmGenre.php");
            if (isset($_POST['submitdeleteFilmGenre'])){

                $_SESSION['errors'] = [];

                ($id_film = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';

                if ($id_film){
                    $_SESSION['film'] = $id_film;
                    listGenreByFilm($id_film);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }           
                }
            }
        } else {
            self::afficherHome();
        }
    }

    // supprime un genre d'un film
    public function supprimerFilmGenreId($id){
        if (isset($_POST["submitDeleteFilmGenreId"])){
            $_SESSION["errors"] = [];

            ($id_film = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte' ;
            ($id_genre = filter_input(INPUT_POST, "id_genre", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le genre est incorrecte';

            if ($id_film && $id_genre){

                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM posseder_genre 
                WHERE id_film = :id_film AND id_genre = :id_genre
                ");
                $requete->bindparam("id_film", $id_film);
                $requete->bindparam("id_genre", $id_genre);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre genre a bien été supprimé !';
    
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }
        require "view/Cinema/deleteFilmGenre.php";
    }
    
    
    // -------------------------------- Delete -------------------------------------------
    // obtenir l'id d'un film
    public function modifierCasting(){
        if (isset($_SESSION['user'])){
            require ("view/Cinema/deleteCasting.php");
            if (isset($_POST['submitdeleteCasting'])){

                $_SESSION['errors'] = [];

                ($id_film = filter_input(INPUT_POST, "film", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte';

                if ($id_film){
                    $_SESSION['film'] = $id_film;
                    listActeurByFilm($id_film);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }           
                }
            }
        } else {
            self::afficherHome();
        }
    }

    // supprime un casting par id_film et id_acteur
    public function supprimerCasting($id){
        if (isset($_POST["submitDeleteCastingId"])){
            $_SESSION["errors"] = [];

            ($id_film = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'Le film est incorrecte' ;
            ($id_acteur = filter_input(INPUT_POST, "id_acteur", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'L\'acteur est incorrecte';

            if ($id_film && $id_acteur){

                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM casting 
                WHERE id_film = :id_film AND id_acteur = :id_acteur
                ");
                $requete->bindparam("id_film", $id_film);
                $requete->bindparam("id_acteur", $id_acteur);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre casting a bien été supprimé !';
    
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }
        require "view/Cinema/deleteCasting.php";
    }
}
