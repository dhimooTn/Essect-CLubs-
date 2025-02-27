<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESSECT CLUBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Prachason+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS externe -->
</head>

<body>
    <!--navbar-->
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
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">InfoLab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">Enactus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">ClubRadio</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="#" class="login-button">Login</a>
            <button id="dark-mode-toggle" class="dark-mode-button" aria-label="Toggle dark mode">🌙</button>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!--end --navbar-->

    <!--header section-->
    <header class="header-section section-animation">
        <a href="#" class="discover-button">Discover</a>
    </header>
    <!--end --header section-->

    <!-- InfoLab section -->
    <section class="infoLab-section club-section section-animation delay-1">
        <img src="upload/LogoInfolab.png" alt="InfoLab Logo" class="club-logo">
        <h2 class="club-name">InfoLab</h2>
        <div class="club-background">
            <div class="club-content">
                <a href="#" class="join-button">Join</a>
            </div>
        </div>
        <div class="our-team-section">
            <h3>Bureau Memebre</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="upload/Nour.png" >
                    <h4>Nour Cherni</h4>
                    <p>President</p>
                </div>
                <div class="team-member">
                    <img src="upload/seif.png" >
                    <h4>Saief Bouali</h4>
                    <p>Vice President</p>
                </div>
                <div class="team-member">
                    <img src="upload/amen.png" >
                    <h4>Amenallah Robanna</h4>
                    <p>Human Ressource</p>
                </div>
                <div class="team-member">
                    <img src="upload/Khdija.png" >
                    <h4>Khadija Majdoub</h4>
                    <p>Trésorière</p>
                </div>
                <div class="team-member">
                    <img src="upload/sta.png" >
                    <h4>Yasmine Ben Sta</h4>
                    <p>Secrétaire Générale</p>
                </div>
                <div class="team-member">
                    <img src="upload/jha.png">
                    <h4>Wassim Jha</h4>
                    <p>Chef Département Communication</p>
                </div>
                <div class="team-member">
                    <img src="upload/iheb.png" >
                    <h4>Iheb Baccar</h4>
                    <p>Chef Département Event</p>
                </div>
                <div class="team-member">
                    <img src="upload/maha.png" >
                    <h4>Maha Nourdine</h4>
                    <p>Chef Département Desgin </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end --infolab section -->

    <!--Enactus section-->
    <section class="enactus-section club-section section-animation delay-1">
    <img src="upload/enactusLogo.png" alt="Enactus Logo" class="club-logo">
    <h2 class="club-name">Enactus</h2>
        <div class="club-background">
            <div class="club-content">
                <a href="#" class="join-button">Join</a>
            </div>
        </div>
        <div class="our-team-section">
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="upload/rayen.png">
                    
                </div>
                <div class="team-member">
                    <img src="public/team/member5.jpg" alt="Member 5">
                    <h4>Emily Davis</h4>
                    <p>Vice President</p>
                </div>
                <div class="team-member">
                    <img src="public/team/member6.jpg" alt="Member 6">
                    <h4>David Wilson</h4>
                    <p>Project Manager</p>
                </div>
            </div>
        </div>
    </section>
    <!--end --Enactus section-->

    <!--ClubRadio section-->
    <section class="clubRadio-section club-section section-animation delay-1">
    <img src="upload/clubradioessect.jpg" alt="ClubRadio Logo" class="club-logo">
    <h2 class="club-name">ClubRadio</h2>
        <div class="club-background">
            <div class="club-content">
                <a href="#" class="join-button">Join</a>
            </div>
        </div>
        <div class="our-team-section">
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="public/team/member7.jpg" alt="Member 7">
                    <h4>Sarah Lee</h4>
                    <p>President</p>
                </div>
                <div class="team-member">
                    <img src="public/team/member8.jpg" alt="Member 8">
                    <h4>Chris Evans</h4>
                    <p>Vice President</p>
                </div>
                <div class="team-member">
                    <img src="public/team/member9.jpg" alt="Member 9">
                    <h4>Laura Green</h4>
                    <p>Project Manager</p>
                </div>
            </div>
        </div>
    </section>
    <!--end --ClubRadio section-->

    <!--Map section-->
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
    <!--end --Map section-->

    <!--footer section-->
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
    <!--end --footer section-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Dark Mode Toggle avec sauvegarde dans localStorage
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;

        // Vérifie le mode précédent
        if (localStorage.getItem('dark-mode') === 'enabled') {
            body.classList.add('dark-mode');
            darkModeToggle.textContent = '☀️';
        }

        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDarkMode = body.classList.contains('dark-mode');
            darkModeToggle.textContent = isDarkMode ? '☀️' : '🌙';
            localStorage.setItem('dark-mode', isDarkMode ? 'enabled' : 'disabled');
        });
    </script>
</body>

</html>