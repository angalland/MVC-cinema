<!DOCTYPE html>
<!-- Le template sert de squelette a toutes les pages vues de l'application -->
    <html lang="fr">
        
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=$, initial-scale=1.0">

            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet" />

            
            <link rel="stylesheet" href="public/css/uikit/uikit-rtl.css" />
            <link rel="stylesheet" href="public/css/uikit/uikit-rtl.min.css" />
            <link rel="stylesheet" href="public/css/uikit/uikit.css" />
            <link rel="stylesheet" href="public/css/uikit/uikit.min.css" />

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="public/css/style/style.css" />
            <link rel="stylesheet" href="public/css/style/styleCinema.css" />
            <link rel="stylesheet" href="public/css/style/styleFilm.css" />
            <link rel="stylesheet" href="public/css/style/styleForm.css" />
            <link rel="stylesheet" href="public/css/style/styleUpdate.css" />
            <link rel="stylesheet" href="public/css/style/styleTest.css" />
            <link rel="stylesheet" href="public/css/styleMobile/styletel.css" />
            <link rel="stylesheet" href="public/css/styleDark/styleDarkMode.css" />
            <link rel="stylesheet" href="public/css/style/styleAuthentification.css" />

            <script src="public/js/uikit-icons.js"></script>
            <script src="public/js/uikit-icons.min.js"></script>
            <script src="public/js/uikit.js"></script>
            <script src="public/js/uikit.min.js"></script>

            <script src="public/js/js/js.js"></script>
            <script src="public/js/js/modaljs.js"></script>
            
            <!-- $titre fournit par les pages vues -->
            <title><?= $titre; ?></title> 
        </head>
            
        <body class="light"> 
                <div class="btn-toggle"></div> 
                <nav class="uk-navbar-container" uk-navbar>
                    <div class="uk-navbar-center">   
                        <ul class="uk-navbar-nav uk-flex-middle">
                            <!-- section list -->
                            <li class="uk-active">
                                <a href="index.php?action=home">Home</a>
                            </li>                        
                            <li class="uk-active">
                                <a href="index.php?action=listFilms">Films</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listRealisateur">Réalisateur</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listActeurs">Acteur</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listGenre">Genre</a>
                            </li>
                            <?php
                            // affiche si une session['user] est présente
                            if (isset($_SESSION['user'])){?>
                                <li class="uk-active">
                                    <a href="index.php?action=deconnexion"> Deconnexion</a>
                                </li>
                                <li class="uk-active">
                                    <a href="index.php?action=user">Profil</a>
                                </li>
                                <!-- section admin -->
                                <div>Admin <span uk-navbar-parent-icon></span></div>
                                <div class="uk-navbar-dropdown">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        <!-- section add -->
                                        <li class="uk-active">
                                        <a href="index.php?action=add_role_genre_casting">Ajouter un rôle - genre - casting</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addPersonne">Ajouter une personne</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addFilm">Ajouter un film</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addGenreFilm">Ajouter un genre a un film</a>
                                        </li>
                                        <!-- section modifier -->
                                        <li class="uk-nav-divider"></li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updatePersonne">Update/Delete personne</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateFilm">Update/Delete Film</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateRole">Update/Delete Rôle</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateGenre">Update/Delete Genre</a>
                                        </li>
                                        <!-- section delete -->
                                        <li class="uk-nav-divider"></li>
                                        <li class="uk-active">
                                            <a href="index.php?action=deleteCasting">Delete Casting</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=deleteActeurRealisateur">Delete Acteur/Realisateur</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateFilmGenre">Delete Film-genre</a>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            // sinon affiche ca
                           } else {?> 
                            <li class="uk-active">
                                <a href="index.php?action=connexion">Connexion</a>
                            </li><?php 
                           }?>
                        </ul>
                    </div>
                </nav>

                <div class='burger'>
                <a href="#" class="uk-navbar-toggle uk-hidden@s" uk-navbar-toggle-icon uk-toggle="target: #sidenav"></a>
                </div>
                <!-- menu burger -->
                <div id="sidenav" uk-offcanvas="flip: true" class="uk-offcanvas">
                    <div class="uk-offcanvas-bar">
                        <ul class="uk-nav">
                        <li class="uk-active">
                                <a href="index.php?action=home">Home</a>
                            </li>                        
                            <li class="uk-active">
                                <a href="index.php?action=listFilms">Films</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listRealisateur">Réalisateur</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listActeurs">Acteur</a>
                            </li>
                            <li class="uk-active">
                                <a href="index.php?action=listGenre">Genre</a>
                            </li>
                            <?php
                            // affiche si une session['user] est présente
                            if (isset($_SESSION['user'])){?>
                                <li class="uk-active">
                                    <a href="index.php?action=deconnexion"> Deconnexion</a>
                                </li>
                                <li class="uk-active">
                                    <a href="index.php?action=user">Profil</a>
                                </li>
                                <!-- section admin -->
                                <!-- <div>Admin <span uk-navbar-parent-icon></span></div> -->
                                <div class='admin'>Admin</div>
                                <!-- <div class="uk-navbar-dropdown"> -->
                                    <!-- <ul class="uk-nav uk-navbar-dropdown-nav"> -->
                                        <!-- section add -->
                                        <li class="uk-active">
                                        <a href="index.php?action=add_role_genre_casting">Ajouter un rôle - genre - casting</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addPersonne">Ajouter une personne</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addFilm">Ajouter un film</a>
                                        </li>
                                        <li class="uk-active">
                                        <a href="index.php?action=addGenreFilm">Ajouter un genre a un film</a>
                                        </li>
                                        <!-- section modifier -->
                                        <li class="uk-nav-divider"></li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updatePersonne">Update/Delete personne</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateFilm">Update/Delete Film</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateRole">Update/Delete Rôle</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateGenre">Update/Delete Genre</a>
                                        </li>
                                        <!-- section delete -->
                                        <li class="uk-nav-divider"></li>
                                        <li class="uk-active">
                                            <a href="index.php?action=deleteCasting">Delete Casting</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=deleteActeurRealisateur">Delete Acteur/Realisateur</a>
                                        </li>
                                        <li class="uk-active">
                                            <a href="index.php?action=updateFilmGenre">Delete Film-genre</a>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            // sinon affiche ca
                           } else {?> 
                            <li class="uk-active">
                                <a href="index.php?action=connexion">Connexion/Creer un compte</a>
                            </li><?php 
                           }?>
                        </ul>
                    </div>
                </div>
           
                <main id="main">
                    <div id="mainDiv">
                        <h1>PDO Cinema</h1>
                        <h2><?= $titre_secondaire; ?></h2>
                        <?= $contenu; ?>
                        <!-- $titre_secondaire et $contenu fournit par les pages vue -->
                </main>
            </div>

        </body>
    </html>
