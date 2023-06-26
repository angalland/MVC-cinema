<?php

namespace Controller;

use Model\Connect;

class CritiqueController {

    // ajouter un avis sur un film
    public function addAvis($id){
       
        // filtre les donnée envoyé par le formulaire
        $id_film = filter_var($id, FILTER_VALIDATE_INT);
        $id_user = filter_var($_SESSION['user']['id_user'], FILTER_VALIDATE_INT);
        $avis = htmlspecialchars($_POST['avis'], ENT_QUOTES);
        $note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_INT);


        if ($id_film && $id_user && $avis && $note) {
            // connexion a la bbd$
            try {
            $pdo = Connect::seConnecter();
            // requete sql
            $requete = $pdo->prepare("
            INSERT INTO critique 
                (id_film, id_user, avis, note)
                VALUES (:id_film,
                        :id_user,
                        :avis,
                        :note)
            ");
            $requete->bindparam("id_film", $id_film);
            $requete->bindparam("id_user", $id_user);
            $requete->bindparam("avis", $avis);
            $requete->bindparam("note", $note);
            $requete->execute();
            $_SESSION['messageSucces'] = "Votre avis a bien été pris en compte";
            } catch (\PDOException $ex) {
                $_SESSION['messageAlert'] [] = 'Vous avez déja un avis sur ce film, vous ne pouvez pas en donner un second';
            }

        }
        header("Location:index.php?action=filmById&id=$id_film");
    }
} 