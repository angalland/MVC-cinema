<?php

namespace Controller;

use Model\Connect;
use controller\CinemaController;


class StatutController {
    // affiche les réalisateurs
    public function listRealisateur() {
        // connexion a la bbd et requete sql 
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT  CONCAT(personne.prenom,' ',personne.nom) as realisateur, personne.id_personne
        FROM personne
        INNER JOIN realisateur
            ON personne.id_personne = realisateur.id_personne
        ORDER BY personne.prenom
        ");
        

        require "view/Statut/listRealisateur.php";
    }

    // affiche les acteurs
    public function afficheActeurs() {
        // connexion a la bbd et requete sql
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT  CONCAT(personne.prenom,' ',personne.nom) AS acteur, personne.id_personne
        FROM personne
        INNER JOIN acteur
            ON personne.id_personne = acteur.id_personne
        ORDER BY personne.prenom
        ");
        
        require "view/Statut/listActeurs.php";
    }

    // ------------------------ Update / Delete ------------------------

    // recupere l'id d'un statut acteur ou un realisateur
    public function supprimerActeurRealisateur() {
        // vérifie qu'une session user soit présente
        if (isset($_SESSION['user'])){
            require ("view/Statut/deleteActeurRealisateur.php");

            $_SESSION['errors'] = [];

            if (isset($_POST['submitDeleteRealisateur'])){
                // récupère et filtre les données du formulaire
                ($id = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'Le realisateur est incorrecte';

                if ($id){
                    $_SESSION['realisateur'] = $id;
                    deleteRealisateur($id);
                    
                } elseif (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $error){
                    $_SESSION['messageAlert'] [] = $error;
                    }           
                }
            }

            if (isset($_POST['submitDeleteActeur'])){
                // récupère et filtre les données du formulaire
                ($id = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_NUMBER_INT)) ? false : $_SESSION['errors'][] = 'L\'acteur est incorrecte';

                if ($id){
                    $_SESSION['acteur'] = $id;
                    deleteActeur($id);
                    
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

    // supprimer un realisateur
    public function supprimerRealisateur($id){

        if (isset($_POST["submitDeleteRealisateurId"])){
            
            $_SESSION["errors"] = [];
            // récupère et filtre les données
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte';
            // connexion a la bbd et requete sql suppression realisateur
            if ($id){

                try {

                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM realisateur
                WHERE id_realisateur = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre realisateur a bien été supprimé !';

                } catch (\PDOException $ex) {
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer le réalisateur car il est lié avec un film, veuillez supprimer le film en 1er';
                }

            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }
        require "view/Statut/deleteActeurRealisateur.php";
    }

    // supprime un acteur
    public function supprimerActeur($id){

        if (isset($_POST["submitDeleteActeurId"])){

            $_SESSION["errors"] = [];
            // recupere et filtre les données du formulaire
            ($id = filter_var($id, FILTER_VALIDATE_INT)) ? false : $_SESSION['errors'][] = 'L\'id est incorrecte' ;
            // connexion a la bbd et requete sql suppression acteur
            if ($id){

                try {
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare("
                DELETE FROM acteur
                WHERE id_acteur = :id
                ");
                $requete->bindparam("id", $id);
                $requete->execute();
        
                $_SESSION['messageSucces'] = 'Votre acteur a bien été supprimé !';
                
                } catch (\PDOException $ex) {
                    $_SESSION['messageAlert'] [] = 'Vous ne pouvez pas supprimer l\'acteur car il est lié avec un casting, veuillez supprimer le casting en 1er';
                }
                
            } elseif (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $error){
                $_SESSION['messageAlert'] [] = $error;
                }
            }
        }
        require "view/Statut/deleteActeurRealisateur.php";
    }
}