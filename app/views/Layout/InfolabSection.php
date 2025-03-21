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
                    <form id="infolabForm" action="<?php echo BURL; ?>Request/registre/1" method="POST">
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
                                <input type="text" class="form-control" placeholder="Votre Specialité" name="specialite"
                                    aria-label="Votre Specialité">
                            </div>
                        </div>
                        <label class="form-label">Avez-vous déjà fait partie d'un club universitaire ou associatif
                            ?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="club_experience" id="oui" value="oui">
                            <label class="form-check-label" for="oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="club_experience" id="non" value="non">
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
                            <input class="form-check-input" type="checkbox" id="design_graphique" name="competences[]"
                                value="design_graphique">
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
                            <input class="form-check-input" type="radio" name="departement" id="design" value="design">
                            <label class="form-check-label" for="design">Design</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departement" id="event" value="event">
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
    <div class="fondation">
        <h3>our-foundation</h3>
        <p>Fondation
            La Naissance de l’Innovation.
            Créé en 2022 à l’ESSEC, notre initiative est un carrefour dynamique de créativité et de technologie. Nous
            visons à transformer des concepts innovants en projets concrets, cultivant un environnement collaboratif
            propice au développement.

            📍 Club Universitaire
            📅 3 ans d’ancienneté
            👥 130 Membres </p>
    </div>
    <div class="our-mission">
        <h3>our-mission</h3>
        <p>
            Notre mission se concentre sur l’avancement des compétences, préparant les étudiants à s’épanouir sur le
            marché du travail compétitif.
            Nous transformons l’apprentissage en une aventure captivante, fournissant aux membres des outils essentiels
            pour réussir.

        </p>
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
    <div class="club-social-links">
        <a href="https://www.facebook.com/profile.php?id=100086193647142&locale=fr_FR" target="_blank">
            <img src="upload/face.png" alt="Facebook">
        </a>
        <a href="https://www.instagram.com/infolab_essect/" target="_blank">
            <img src="upload/insta.png" alt="Instagram">
        </a>
    </div>
</section>
<!-- Fin de la InfoLab Section -->