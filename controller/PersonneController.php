<?php

namespace Controller;

use Model\Connect;
use controller\CinemaController;


class PersonneController {

    // affiche personne
    public function affichePersonne($id) {
        // connexion a la bbd
        $pdo = Connect::seConnecter();
        // requete sql sur table personne
        $requete = $pdo->prepare("
        SELECT personne.prenom, personne.nom, personne.date_naissance, personne.sexe
        FROM personne
        WHERE personne.id_personne = :id;
        ");
        $requete->bindparam("id", $id);
        $requete->execute();
        // requete sql qur table realisateur
        $requeteRealisateur = $pdo->prepare("
        SELECT *
        FROM film
        INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
        INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
        WHERE personne.id_personne = :id 
        ");
        $requeteRealisateur->bindparam("id", $id);
        $requeteRealisateur->execute();
        // requete sql sur table casting
        $requeteCasting = $pdo->prepare("
        SELECT *
        FROM casting
        INNER JOIN film
            ON casting.id_film = film.id_film
        INNER JOIN personnage
            ON casting.id_personnage = personnage.id_personnage
        INNER JOIN acteur
            ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
        WHERE personne.id_personne = :id
        ");
        $requeteCasting->bindparam("id", $id);
        $requeteCasting->execute();

        require "view/Personne/personne.php";        
    }

    // ajoute une personne
    public function ajoutePersonne(){
        // vérifie qu'une session user est présente
        if (isset($_SESSION['user'])){
            if (isset($_POST["submitPersonne"])){

                $_SESSION["errors"] = [];

                // récupère et filtre les donnée du formulaire
                ($nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le nom est incorrecte";
                ($prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "le prenom est incorrecte";
                ($date = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'La date est incorrecte';
                ($sexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le sexe est incorrecte";

                // récupère les donnée des checkbox 
                $realisateur = isset($_POST['realisateur']) ? true : false;
                $acteur = isset($_POST['acteur']) ? true : false;
                // connexion a la bbd et requete sql ajoute une personne
                if ($nom && $prenom && $date && $sexe){
                    $pdo = Connect::seConnecter();
                    $requete = $pdo->prepare("
                    INSERT INTO personne 
                    (nom, prenom, date_naissance, sexe)
                    VALUES (:nom,
                            :prenom,
                            :date_naissance,
                            :sexe)
                    ");
                    $requete->bindparam("nom", $nom);
                    $requete->bindparam("prenom", $prenom);
                    $requete->bindparam("date_naissance", $date);
                    $requete->bindparam("sexe", $sexe);
                    $requete->execute();
                    // recupere la derniere id créer dans la bbd
                    $id_personne = $pdo->lastInsertId();
                    // requete sql dans table realisateur
                    if ($realisateur) {
                        $requeteRealisateur = $pdo->prepare("
                        INSERT INTO realisateur (id_personne)
                        VALUES (:id_personne)
                        ");
                        $requeteRealisateur->bindparam("id_personne", $id_personne);
                        $requeteRealisateur->execute();
                    }
                    // requete sql dans table acteur
                    if ($acteur) {
                        $requeteActeur = $pdo->prepare("
                        INSERT INTO acteur (id_personne)
                        VALUES (:id_personne)
                        ");
                        $requeteActeur->bindparam("id_personne", $id_personne);
                        $requeteActeur->execute();
                    }
                    
                    $_SESSION['messageSucces'] = 'Votre personne '.$prenom.' '.$nom.' a bien été ajouté !';

                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }
                }
                        
            }
            require "view/Personne/addPersonne.php";
        } else {
            CinemaController::afficherHome();
        }
    }

    // obtenir l'id d'une personne
    public function modifierPersonne(){
        // verifie qu'une session user est disponible
        if (isset($_SESSION['user'])){
            require ("view/Personne/updateDeletePersonne.php");
            if (isset($_POST['submitUpdatePersonne'])){

                $_SESSION['errors'] = [];
                // récupère et filtre les données du formulaire
                ($id = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'La personne est incorrecte';

                if ($id){
                    $_SESSION['personne'] = $id;
                    formUpdatePersonne ($id);
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

    // update une personne par id
    public function modifierPersonneId($id){
        if (isset($_POST["submitUpdatePersonneId"])){

            $_SESSION["errors"] = [];

            // récupère et filtre les donnée du formulaire
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte' ;
            ($nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le nom est incorrecte";
            ($prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "le prenom est incorrecte";
            ($date = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'La date est incorrecte';
            ($sexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? false : $_SESSION['errors'][] = "Le sexe est incorrecte";
            // connexion a la bbd et requete sql modifie une personne
            if ($id && $nom && $prenom && $date && $sexe){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                UPDATE personne 
                SET nom = :nom,
                    prenom = :prenom,
                    date_naissance = :date_naissance,
                    sexe = :sexe
                WHERE id_personne = :id
                ");
                $requete->bindparam("nom", $nom);
                $requete->bindparam("prenom", $prenom);
                $requete->bindparam("date_naissance", $date);
                $requete->bindparam("sexe", $sexe);
                $requete->bindparam("id", $id);
                $requete->execute();
                
                $_SESSION['messageSucces'] = 'Votre personne '.$prenom.' '.$nom.' a bien été modifié !';

            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
                      
        }

        // supprime une personne
        if (isset($_POST["submitDeletePersonneId"])){

            $_SESSION["errors"] = [];

            // récupère et filtre les donnée du formulaire
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte' ;
            // connexion a la bbd et requete sql supprime une personne
            if ($id){

                try {
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM personne
                WHERE id_personne = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();

                $_SESSION['messageSucces'] = 'Votre personne a bien été supprimé !';
                
                } catch (\PDOException $ex){
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer cette personne car elle détient un statut, veuillez d\'abord supprimez le satut .';                   
                } 
        
    
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }

        require "view/Personne/updateDeletePersonne.php";
    }


}