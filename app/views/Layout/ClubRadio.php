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
                        <form id="ClubRadioForm" action="<?php echo BURL; ?>Request/registre/3" method="POST">
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