<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESSECT CLUBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Prachason+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/style.css">
    <!-- Lien vers le fichier CSS externe -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="#">EssectClubs</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#header">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#infolab">InfoLab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#enactus">Enactus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#clubradio">ClubRadio</a>
                        </li>
                    </ul>
                </div>
            </div>
            <button id="openModal" class="login-button">Login</button>
            <button id="dark-mode-toggle" class="dark-mode-button" aria-label="Toggle dark mode">🌙</button>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- Fin de la Navbar -->

    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form id="loginForm" action="app\controllers\SessionController.php" action="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
        </div>
    </div>
    <!-- Fin de la Modal de Login -->

    <!-- Header Section -->
    <header id="header" class="header-section section-animation">
        <a href="#infolab" class="discover-button">Discover</a>
    </header>
    <!-- Fin de la Header Section -->

    <!-- InfoLab Section -->
    <section id="infolab" class="infoLab-section club-section section-animation delay-1">
        <img src="upload/LogoInfolab.png" alt="InfoLab Logo" class="club-logo">
        <h2 class="club-name">InfoLab</h2>
        <div class="club-background">
            <div class="club-content">
                <!-- Bouton pour ouvrir la modal -->
                <button id="openModalInfolab" class="join-button">Join</button>

                <!-- Modal pour InfoLab -->
                <div id="modalInfolab" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Rejoignez la famille InfoLAB</h2>
                        <form id="infolabForm" action="app\controllers\RequestController.php" method="POST">
                            <!-- Formulaire -->
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name" name="first_name"
                                        aria-label="First name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name" name="last_name"
                                        aria-label="Last name">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                                    placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="formGroupExampleInput" name="phone_number"
                                    placeholder="Example input placeholder">
                            </div>
                            <div class="mb-3">
                                <label for="basic-url" class="form-label">Your Facebook URL</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                                    <input type="text" class="form-control" id="basic-url" name="facebook_url"
                                        aria-describedby="basic-addon3 basic-addon4">
                                </div>
                            </div>
                            <label class="form-label">Vous êtes en ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l1" value="L1">
                                <label class="form-check-label" for="l1">L1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l2" value="L2">
                                <label class="form-check-label" for="l2">L2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l3" value="L3">
                                <label class="form-check-label" for="l3">L3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m1" value="M1">
                                <label class="form-check-label" for="m1">M1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m2" value="M2">
                                <label class="form-check-label" for="m2">M2</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Votre Specialité"
                                        name="specialite" aria-label="Votre Specialité">
                                </div>
                            </div>
                            <label class="form-label">Avez-vous déjà fait partie d'un club universitaire ou associatif
                                ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="oui"
                                    value="oui">
                                <label class="form-check-label" for="oui">Oui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="non"
                                    value="non">
                                <label class="form-check-label" for="non">Non</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control"
                                        placeholder="Si oui, précisez le(s) club(s) et votre rôle" name="club_details"
                                        aria-label="Si oui, précisez le(s) club(s) et votre rôle">
                                </div>
                            </div>
                            <label class="form-label">Quelles compétences ou expériences possédez-vous en lien avec le
                                domaine du club ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestion_projet" name="competences[]"
                                    value="gestion_projet">
                                <label class="form-check-label" for="gestion_projet">Gestion de projet</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="communication" name="competences[]"
                                    value="communication">
                                <label class="form-check-label" for="communication">Communication</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="design_graphique"
                                    name="competences[]" value="design_graphique">
                                <label class="form-check-label" for="design_graphique">Design graphique</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="organisation_evenements"
                                    name="competences[]" value="organisation_evenements">
                                <label class="form-check-label" for="organisation_evenements">Organisation
                                    d’événements</label>
                            </div>
                            <label class="form-label">Dans quel département vous voyez-vous le plus ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="comm" value="comm">
                                <label class="form-check-label" for="comm">Comm</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="design"
                                    value="design">
                                <label class="form-check-label" for="design">Design</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="event"
                                    value="event">
                                <label class="form-check-label" for="event">Event</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Pourquoi souhaitez-vous
                                    rejoindre ce club ?</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="motivation"
                                    rows="3"></textarea>
                            </div>
                            <select class="form-select" aria-label="Default select example" name="entretien_jour">
                                <option selected>Quand serez-vous disponible pour passer un entretien cette semaine ?
                                </option>
                                <option value="1">Lundi</option>
                                <option value="2">Mardi</option>
                                <option value="3">Mercredi</option>
                                <option value="4">Jeudi</option>
                                <option value="5">Vendredi</option>
                                <option value="6">Samedi</option>
                            </select>
                            <label for="cv">Télécharger votre CV (PDF, DOC, DOCX) :</label>
                            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required><br><br>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Section "Our Team" -->
        <div class="our-team-section">
            <h3>Bureau Membre</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="upload/Nour.png" alt="Nour Cherni">
                    <h4>Nour Cherni</h4>
                    <p>President</p>
                </div>
                <div class="team-member">
                    <img src="upload/seif.png" alt="Saief Bouali">
                    <h4>Saief Bouali</h4>
                    <p>Vice President & Trésorière</p>
                </div>
                <div class="team-member">
                    <img src="upload/amen.png" alt="Amenallah Robanna">
                    <h4>Amenallah Robanna</h4>
                    <p>Human Ressource</p>
                </div>
                <div class="team-member">
                    <img src="upload/sta.png" alt="Yasmine Ben Sta">
                    <h4>Yasmine Ben Sta</h4>
                    <p>Secrétaire Générale</p>
                </div>
                <div class="team-member">
                    <img src="upload/jha.png" alt="Wassim Jha">
                    <h4>Wassim Jha</h4>
                    <p>Chef Département Communication</p>
                </div>
                <div class="team-member">
                    <img src="upload/iheb.png" alt="Iheb Baccar">
                    <h4>Iheb Baccar</h4>
                    <p>Chef Département Event</p>
                </div>
                <div class="team-member">
                    <img src="upload/maha.png" alt="Maha Nourdine">
                    <h4>Maha Nourdine</h4>
                    <p>Chef Département Design</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la InfoLab Section -->

    <!-- Enactus Section -->
    <section id="enactus" class="enactus-section club-section section-animation delay-1">
        <img src="upload/enactusLogo.png" alt="Enactus Logo" class="club-logo">
        <h2 class="club-name">Enactus</h2>
        <div class="club-background">
            <div class="club-content">
                <!-- Bouton pour ouvrir la modal -->
                <button id="openModalEnactus" class="join-button">Join</button>

                <!-- Modal pour InfoLab -->
                <div id="modalEnactus" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Rejoignez la famille Enactus</h2>
                        <form id="EnactusForm" action="app\controllers\RequestController.php" method="POST">
                            <!-- Formulaire -->
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="first_name" placeholder="First name"
                                        aria-label="First name" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last name"
                                        aria-label="Last name" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                                    placeholder="name@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="formGroupExampleInput" name="phone_number"
                                    placeholder="Example input placeholder" required>
                            </div>
                            <div class="mb-3">
                                <label for="basic-url" class="form-label">Your Facebook URL</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                                    <input type="text" class="form-control" id="basic-url" name="facebook_url"
                                        aria-describedby="basic-addon3 basic-addon4">
                                </div>
                            </div>
                            <label class="form-label">Vous êtes en ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l1" value="L1" required>
                                <label class="form-check-label" for="l1">L1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l2" value="L2" required>
                                <label class="form-check-label" for="l2">L2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l3" value="L3" required>
                                <label class="form-check-label" for="l3">L3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m1" value="M1" required>
                                <label class="form-check-label" for="m1">M1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m2" value="M2" required>
                                <label class="form-check-label" for="m2">M2</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="specialite"
                                        placeholder="Votre Specialité" aria-label="Votre Specialité" required>
                                </div>
                            </div>
                            <label class="form-label">Avez-vous déjà fait partie d'un club universitaire ou associatif
                                ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="oui" value="oui"
                                    required>
                                <label class="form-check-label" for="oui">Oui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="non" value="non"
                                    required>
                                <label class="form-check-label" for="non">Non</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="club_details"
                                        placeholder="Si oui, précisez le(s) club(s) et votre rôle"
                                        aria-label="Si oui, précisez le(s) club(s) et votre rôle">
                                </div>
                            </div>
                            <label class="form-label">Quelles compétences ou expériences possédez-vous en lien avec le
                                domaine du club ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="competences[]"
                                    value="gestion_projet">
                                <label class="form-check-label" for="gestion_projet">Gestion de projet</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="competences[]"
                                    value="communication">
                                <label class="form-check-label" for="communication">Communication</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="competences[]"
                                    value="design_graphique">
                                <label class="form-check-label" for="design_graphique">Design graphique</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="competences[]"
                                    value="organisation_evenements">
                                <label class="form-check-label" for="organisation_evenements">Organisation
                                    d’événements</label>
                            </div>
                            <label class="form-label">Dans quel département vous voyez-vous le plus ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="comm" value="comm"
                                    required>
                                <label class="form-check-label" for="comm">Relations externes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="design"
                                    value="design" required>
                                <label class="form-check-label" for="design">Projet</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="event" value="event"
                                    required>
                                <label class="form-check-label" for="event">Comm</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Pourquoi souhaitez-vous
                                    rejoindre ce club ?</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="motivation"
                                    rows="3" required></textarea>
                            </div>
                            <select class="form-select" name="interview_day" aria-label="Default select example"
                                required>
                                <option selected>Quand serez-vous disponible pour passer un entretien cette semaine ?
                                </option>
                                <option value="1">Lundi</option>
                                <option value="2">Mardi</option>
                                <option value="3">Mercredi</option>
                                <option value="4">Jeudi</option>
                                <option value="5">Vendredi</option>
                                <option value="6">Samedi</option>
                            </select>
                            <label for="cv">Télécharger votre CV (PDF, DOC, DOCX) :</label>
                            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required><br><br>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="our-team-section">
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="upload/ray.png" alt="Rayen">
                    <h4>Rayen SOULI</h4>
                    <p>Team Leader</p>
                </div>
                <div class="team-member">
                    <img src="upload/fedi.png" alt="Emily Davis">
                    <h4>FEDI HAMDI</h4>
                    <p>Vice Team Leader</p>
                </div>
                <div class="team-member">
                    <img src="upload/mbh.png" alt="David Wilson">
                    <h4>MOUHIB BEN HASSEN</h4>
                    <p>Communication & Marketing Mangager</p>
                </div>
                <div class="team-member">
                    <img src="upload/souhail.png" alt="David Wilson">
                    <h4>SOUHAIL BEN CHAABANE</h4>
                    <p>Project Manager</p>
                </div>
                <div class="team-member">
                    <img src="upload/ag.png" alt="David Wilson">
                    <h4>ALIA GUEDICHE</h4>
                    <p>HR Manager</p>
                </div>
                <div class="team-member">
                    <img src="upload/mw.png" alt="David Wilson">
                    <h4>MARIEM WANEN</h4>
                    <p>GENERAL SECRETARY</p>
                </div>
                <div class="team-member">
                    <img src="upload/last.png" alt="David Wilson">
                    <h4>HAMDA BOUCHOUCHA</h4>
                    <p>RH & Comm/Marketinf Assistant</p>
                </div>
                <div class="team-member">
                    <img src="upload/ls.png" alt="David Wilson">
                    <h4>SAiF ALLAH BEN LAASIR</h4>
                    <p>RH & External Relation Assistant</p>
                </div>
                <div class="team-member">
                    <img src="upload/fj.png" alt="David Wilson">
                    <h4>FEDI JAOUAHDOU</h4>
                    <p>RH & Project Assistant</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Enactus Section -->

    <!-- ClubRadio Section -->
    <section id="clubradio" class="clubRadio-section club-section section-animation delay-1">
        <img src="upload/clubradioessect.jpg" alt="ClubRadio Logo" class="club-logo">
        <h2 class="club-name">ClubRadio</h2>
        <div class="club-background">
            <div class="club-content">
                <!-- Bouton pour ouvrir la modal -->
                <button id="openModalClubRadio" class="join-button">Join</button>

                <!-- Modal pour InfoLab -->
                <div id="modalClubRadio" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Rejoignez la famille ClubRadio Essect</h2>
                        <form id="ClubRadioForm" action="app\controllers\RequestController.php" method="POST">
                            <!-- Formulaire -->
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name"
                                        aria-label="First name" name="first_name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name"
                                        aria-label="Last name" name="last_name">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1"
                                    placeholder="name@example.com" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="formGroupExampleInput"
                                    placeholder="Example input placeholder" name="phone_number">
                            </div>
                            <div class="mb-3">
                                <label for="basic-url" class="form-label">Your Facebook URL</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                                    <input type="text" class="form-control" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" name="facebook_url">
                                </div>
                            </div>
                            <label class="form-label">Vous êtes en ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l1" value="L1">
                                <label class="form-check-label" for="l1">L1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l2" value="L2">
                                <label class="form-check-label" for="l2">L2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="l3" value="L3">
                                <label class="form-check-label" for="l3">L3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m1" value="M1">
                                <label class="form-check-label" for="m1">M1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="niveau" id="m2" value="M2">
                                <label class="form-check-label" for="m2">M2</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Votre Specialité"
                                        aria-label="Votre Specialité" name="specialite">
                                </div>
                            </div>
                            <label class="form-label">Avez-vous déjà fait partie d'un club universitaire ou associatif
                                ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="oui"
                                    value="oui">
                                <label class="form-check-label" for="oui">Oui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="club_experience" id="non"
                                    value="non">
                                <label class="form-check-label" for="non">Non</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control"
                                        placeholder="Si oui, précisez le(s) club(s) et votre rôle"
                                        aria-label="Si oui, précisez le(s) club(s) et votre rôle" name="club_details">
                                </div>
                            </div>
                            <label class="form-label">Quelles compétences ou expériences possédez-vous en lien avec le
                                domaine du club ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestion_projet"
                                    value="gestion_projet" name="competences[]">
                                <label class="form-check-label" for="gestion_projet">Gestion de projet</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="communication" value="communication"
                                    name="competences[]">
                                <label class="form-check-label" for="communication">Communication</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="design_graphique"
                                    value="design_graphique" name="competences[]">
                                <label class="form-check-label" for="design_graphique">Design graphique</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="organisation_evenements"
                                    value="organisation_evenements" name="competences[]">
                                <label class="form-check-label" for="organisation_evenements">Organisation
                                    d’événements</label>
                            </div>
                            <label class="form-label">Dans quel département vous voyez-vous le plus ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="comm" value="comm">
                                <label class="form-check-label" for="comm">Marketing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="design"
                                    value="design">
                                <label class="form-check-label" for="design">Design</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="event"
                                    value="event">
                                <label class="form-check-label" for="event">Diffusion</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="departement" id="finance"
                                    value="finance">
                                <label class="form-check-label" for="finance">Finance</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Pourquoi souhaitez-vous
                                    rejoindre ce club ?</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    name="motivation"></textarea>
                            </div>
                            <select class="form-select" aria-label="Default select example" name="interview_day">
                                <option selected>Quand serez-vous disponible pour passer un entretien cette semaine ?
                                </option>
                                <option value="1">Lundi</option>
                                <option value="2">Mardi</option>
                                <option value="3">Mercredi</option>
                                <option value="4">Jeudi</option>
                                <option value="5">Vendredi</option>
                                <option value="6">Samedi</option>
                            </select>
                            <label for="cv">Télécharger votre CV (PDF, DOC, DOCX) :</label>
                            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required><br><br>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="our-team-section">
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="upload/ao.png" alt="Sarah Lee">
                    <h4>ABDELKRIM OUCEMA</h4>
                    <p>President</p>
                </div>
                <div class="team-member">
                    <img src="upload/he.png" alt="Chris Evans">
                    <h4>HACHICHA ELYES</h4>
                    <p>Vice President</p>
                </div>
                <div class="team-member">
                    <img src="upload/am.png" alt="Laura Green">
                    <h4>ADOUNI MOHAMEDALI</h4>
                    <p>Exécutive</p>
                </div>
                <div class="team-member">
                    <img src="upload/tf.png" alt="Laura Green">
                    <h4>THABET FATMA</h4>
                    <p>Secrétaire Général</p>
                </div>
                <div class="team-member">
                    <img src="upload/abidi.png" alt="Laura Green">
                    <h4>ABDI ISLEM</h4>
                    <p>Responsabme RH</p>
                </div>
                <div class="team-member">
                    <img src="upload/bib.png" alt="Laura Green">
                    <h4>BIBANI GHASSEN</h4>
                    <p>Responsable Event</p>
                </div>
                <div class="team-member">
                    <img src="upload/bo.png" alt="Laura Green">
                    <h4>BELHOULA OUMAIMA</h4>
                    <p>Responsable Diffusion</p>
                </div>
                <div class="team-member">
                    <img src="upload/hamidou.png" alt="Laura Green">
                    <h4>HAMIDOU FARES</h4>
                    <p>Responsable Finance</p>
                </div>
                <div class="team-member">
                    <img src="upload/eya.png" alt="Laura Green">
                    <h4>BENNACEUR EYA</h4>
                    <p>Responsable Marketing</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la ClubRadio Section -->

    <!-- Map Section -->
    <section id="map" class="section-animation">
        <h5><strong>Our location</strong></h5>
        <div class="mapHome">
            <div>
                <div id="home_map">
                    <div class="map_canvas">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7599.725803087307!2d10.172196108299469!3d36.78757052997988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd3408c0a06d69%3A0x3b8c5efde9487a09!2sESSECT%2C%20Ave%20Ali%20Trad%2C%20Tunis!5e0!3m2!1sfr!2stn!4v1587574590390!5m2!1sfr!2stn"
                            width="100%" height="400" style="border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Map Section -->

    <!-- Footer Section -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Pressroom</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3>Help & Support</h3>
                    <ul>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Community Guidelines</a></li>
                        <li><a href="#">Report a Bug</a></li>
                        <li><a href="#">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3>Follow Us</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Fin de la Footer Section -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../public/asstes/script.js"></script> <!-- Lien vers le fichier JavaScript externe -->
</body>

</html>