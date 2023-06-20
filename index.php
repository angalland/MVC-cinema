<?php

// fait appelle au namespace Controller et au differente Class
use Controller\CinemaController;
use Controller\FilmController;
use Controller\PersonneController;
use Controller\StatutController;
use Controller\Autentification;

// autocharge les classes du projet
spl_autoload_register(function($class_name) {
    include $class_name . '.php';
});

// Insert une nouvelle class de chaque Class
$ctrlCinema = new CinemaController();
$ctrlFilm = new FilmController();
$ctrlPersonne = new PersonneController();
$ctrlStatut = new StatutController();
$ctrlAutentification = new Autentification();

// renvoie la valeur de $id si $_GET["id] est vrai sinon renvoie null
$id = (isset($_GET["id"])) ? $_GET["id"] : null;

// si il y a un $_GET['action]
if(isset($_GET['action'])){
    switch ($_GET['action']){ // regarde pour chaque cas correspondant et intéragit avec la méthode du controller adequa

        // Class CinemaController
        case 'home' : $ctrlCinema->afficherHome(); // pour le cas home appelle la methode afficherHome() de la class CinemaController
        break;

        case 'listGenre' : $ctrlCinema->afficherGenre();
        break;

        case 'detailGenre' : $ctrlCinema->afficherGenreId($id);
        break;
        
        // ------------------ ADD -------------------------------------------
        case 'add_role_genre_casting' : $ctrlCinema->affiche_role_genre_casting();
        break;

        case 'addRole': $ctrlCinema->ajouterPersonnage();
        break;

        case 'addGenre' : $ctrlCinema->ajouteGenre();
        break;

        case 'addCasting' : $ctrlCinema->ajouteCasting();
        break;

        // ----------------------- Update -----------------------------------
        case 'updateRole' : $ctrlCinema->modifierRole();
        break;
        
        case 'modifierRoleId' : $ctrlCinema->modifierRoleId($id);
        break;
        
        case 'updateGenre' : $ctrlCinema->modifierGenre();
        break;
        
        case 'modifierGenreId' : $ctrlCinema->modifierGenreId($id);
        break;
        
        case 'updateFilmGenre' : $ctrlCinema->modifierFilmGenre();
        break;
        // -------------------- Delete -------------------------------------
        case 'deleteCasting' : $ctrlCinema->modifierCasting();
        break;

        case 'deleteCastingId' : $ctrlCinema->supprimerCasting($id);
        break;

        case 'deleteFilmGenre' : $ctrlCinema->supprimerFilmGenre();
        break;

        case 'deleteFilmGenreId' : $ctrlCinema->supprimerFilmGenreId($id);
        break;

        // Class Film
        case 'listFilms' : $ctrlFilm->afficheFilms(); 
        break;
        
        case 'filmById': $ctrlFilm->detailFilm($id); // cas filmById appelle la méthode detailFilm() avec pour argument $id récupérer via $_GET["id]
        break;
        
        case 'addFilm' : $ctrlFilm->ajouteFilm();
        break;
        
        case 'addGenreFilm' : $ctrlFilm->ajouterGenreFilm();
        break;

        case 'updateFilm' : $ctrlFilm->modifierFilm();
        break;

        case 'modifierFilmId' : $ctrlFilm->modifierFilmId($id);
        break;
       
        // class Personne       
        case 'personne' : $ctrlPersonne->affichePersonne($id);
        break;
               
        case 'addPersonne': $ctrlPersonne->ajoutePersonne();
        break;
               
        case 'updatePersonne' : $ctrlPersonne->modifierPersonne();
        break;
        
        case 'updatePersonneDetail' : $ctrlPersonne->modifierPersonneId($id);
        break;

        // Class statut
        case 'listActeurs' : $ctrlStatut->afficheActeurs();
        break;
        
        case 'listRealisateur' : $ctrlStatut->listRealisateur();
        break;

        case 'deleteActeurRealisateur' : $ctrlStatut->supprimerActeurRealisateur();
        break;

        case 'supprimerRealisateurId' : $ctrlStatut->supprimerRealisateur($id);
        break;

        case 'supprimerActeurId' : $ctrlStatut->supprimerActeur($id);
        break;

        // controller autentification

        case 'user' : $ctrlAutentification->profil();
        break;
        
        case 'connexion' : $ctrlAutentification->connexion();
        break;

        case 'inscription' : $ctrlAutentification->inscription();
        break;

        case 'login' : $ctrlAutentification->login();
        break;

        
        case 'deconnexion' : $ctrlAutentification->viewDeconnexion();
        break;
        
        case 'logout' : $ctrlAutentification->logout();
        break;

    }   
}   
?>

