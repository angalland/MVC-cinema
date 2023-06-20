<?php

// utilise le namespace Model et la classe Connect
use Model\Connect;

// affiche les réalisateurs
    function listRealisateur() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT  personne.prenom, personne.nom, personne.id_personne, realisateur.id_realisateur
        FROM personne
        INNER JOIN realisateur
            ON personne.id_personne = realisateur.id_personne
        ORDER BY personne.prenom
        ");

        $realisateurs = $requete->fetchAll();
        return $realisateurs;

    }

// affiche les films 
    function listFilm(){

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT film.id_film, film.titre
        FROM film
        ");

        $films = $requete->fetchAll();
        return $films;
    }

// affiche les acteurs
    function listActeur() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT  personne.prenom, personne.nom, personne.id_personne, acteur.id_acteur
        FROM personne
        INNER JOIN acteur
            ON personne.id_personne = acteur.id_personne
        ");

        $acteurs = $requete->fetchAll();
        return $acteurs;

    }

// affiche les roles
    function listRole() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT personnage.id_personnage, personnage.nom_personnage
        FROM personnage
        ");
        $roles = $requete->fetchAll();
        return $roles;
    }

// affiche les genres 
function listGenre() {

    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
    SELECT genre.id_genre, genre.nom_genre
    FROM genre
    ");
    $genres = $requete->fetchAll();
    return $genres;
}

// affiche les personnes
    function listPersonne() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT *
        FROM personne
        ");

        $personnes = $requete->fetchAll();
        return $personnes;
    }

// récupère les données personne par id
    function personneId($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT *
        FROM personne
        WHERE id_personne = :id
        ");
        $requete->bindparam("id", $id);
        $requete->execute();
        $personnes = $requete->fetchAll();
        return $personnes;
    }

// recupére les donnée realisateur par id
    function realisateurId($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT *
        FROM realisateur
        INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
        WHERE realisateur.id_realisateur = :id
        ");
        $requete->bindparam("id", $id);
        $requete->execute();
        $realisateurs = $requete->fetchAll();
        return $realisateurs;
    }

// récupére les donnée acteur par id 
function acteurId($id){
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM acteur
    INNER JOIN personne
        ON acteur.id_personne = personne.id_personne
    WHERE acteur.id_acteur = :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $acteurs = $requete->fetchAll();
    return $acteurs;
}

// recupére les donnée film par id
function filmId($id){
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM film
    WHERE id_film = :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $films = $requete->fetchAll();
    return $films;
}

// recupére les donnée role par id
function roleId($id){
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM personnage
    WHERE id_personnage = :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $roles = $requete->fetchAll();
    return $roles;
}

// recupére les donnée genre par id
function genreId($id){
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM genre
    WHERE id_genre= :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $genres = $requete->fetchAll();
    return $genres;
}

function castingByActeur($id) {
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM casting
    INNER JOIN acteur
        ON casting.id_acteur = acteur.id_acteur
    INNER JOIN personne 
        ON acteur.id_personne = personne.id_personne
    WHERE id_film= :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $acteurs = $requete->fetchAll();
    return $acteurs;
}

function possederGenreById($id) {
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare("
    SELECT *
    FROM posseder_genre
    INNER JOIN genre
        ON posseder_genre.id_genre = genre.id_genre
    WHERE id_film = :id
    ");
    $requete->bindparam("id", $id);
    $requete->execute();
    $genres = $requete->fetchAll();
    return $genres;
}
