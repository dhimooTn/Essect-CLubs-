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
                    <form id="EnactusForm" action="<?php echo BURL; ?>Request/registre/2" method="POST">
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
                                <input type="text" class="form-control" name="specialite" placeholder="Votre Specialité"
                                    aria-label="Votre Specialité" required>
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
                            <input class="form-check-input" type="checkbox" name="competences[]" value="gestion_projet">
                            <label class="form-check-label" for="gestion_projet">Gestion de projet</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="competences[]" value="communication">
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
                            <label class="form-check-label" for="organisation_evenements">Organisation d’événements</label>
                        </div>
                        <label class="form-label">Dans quel département vous voyez-vous le plus ?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departement" id="comm" value="comm"
                                required>
                            <label class="form-check-label" for="comm">Relations externes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="departement" id="design" value="design"
                                required>
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
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="motivation" rows="3"
                                required></textarea>
                        </div>
                        <select class="form-select" name="interview_day" aria-label="Default select example" required>
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