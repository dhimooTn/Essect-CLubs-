// Classe pour gérer les modales
class Modal {
    constructor(modalId, openButtonId, closeButtonClass) {
        this.modal = document.getElementById(modalId);
        this.openButton = document.getElementById(openButtonId);
        this.closeButton = this.modal.querySelector(closeButtonClass);

        if (this.modal && this.openButton && this.closeButton) {
            this.init();
        } else {
            console.error("Éléments de la modal non trouvés. Vérifiez les IDs et classes.");
        }
    }

    init() {
        // Ouvrir la modal
        this.openButton.addEventListener("click", () => this.open());

        // Fermer la modal
        this.closeButton.addEventListener("click", () => this.close());

        // Fermer la modal si on clique en dehors
        window.addEventListener("click", (event) => {
            if (event.target === this.modal) {
                this.close();
            }
        });
    }

    open() {
        this.modal.style.display = "flex";
    }

    close() {
        this.modal.style.display = "none";
    }
}

// Classe de base pour valider les formulaires
class FormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        if (this.form) {
            this.init();
        } else {
            console.error(`Formulaire avec l'ID ${formId} non trouvé.`);
        }
    }

    init() {
        this.form.addEventListener("submit", (event) => this.validate(event));
    }

    validate(event) {
        event.preventDefault();

        if (this.isValid()) {
            alert("Formulaire valide. Envoi des données...");
            // Ici, vous pouvez ajouter une requête AJAX pour envoyer les données au serveur
        } else {
            alert("Veuillez corriger les erreurs dans le formulaire.");
        }
    }

    isValid() {
        throw new Error("La méthode isValid() doit être implémentée.");
    }

    validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    validatePhone(phone) {
        const regex = /^\d{8}$/;
        return regex.test(phone);
    }

    validateFile(file, allowedTypes) {
        return allowedTypes.includes(file.type);
    }
}

// Classe pour valider le formulaire de login
class LoginFormValidator extends FormValidator {
    isValid() {
        const email = this.form.querySelector("#exampleInputEmail1").value;
        const password = this.form.querySelector("#exampleInputPassword1").value;

        if (!email || !password) {
            alert("Veuillez remplir tous les champs obligatoires.");
            return false;
        }

        if (!this.validateEmail(email)) {
            alert("Veuillez entrer une adresse email valide.");
            return false;
        }

        return true;
    }
}

// Classe pour valider le formulaire InfoLab
class InfoLabFormValidator extends FormValidator {
    isValid() {
        const firstName = this.form.querySelector("input[placeholder='First name']").value;
        const lastName = this.form.querySelector("input[placeholder='Last name']").value;
        const email = this.form.querySelector("#exampleFormControlInput1").value;
        const phone = this.form.querySelector("#formGroupExampleInput").value;
        const cv = this.form.querySelector("#cv").files[0];

        if (!firstName || !lastName || !email || !phone || !cv) {
            alert("Veuillez remplir tous les champs obligatoires.");
            return false;
        }

        if (!this.validateEmail(email)) {
            alert("Veuillez entrer une adresse email valide.");
            return false;
        }

        if (!this.validatePhone(phone)) {
            alert("Veuillez entrer un numéro de téléphone valide (8 chiffres).");
            return false;
        }

        const allowedTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        if (!this.validateFile(cv, allowedTypes)) {
            alert("Veuillez télécharger un fichier au format PDF, DOC ou DOCX.");
            return false;
        }

        return true;
    }
}

// Classe pour valider le formulaire Enactus
class EnactusFormValidator extends InfoLabFormValidator {}

// Classe pour valider le formulaire ClubRadio
class ClubRadioFormValidator extends InfoLabFormValidator {}

// Dark Mode Toggle
const darkModeToggle = document.getElementById('dark-mode-toggle');
const body = document.body;

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

// Initialisation des modales
const loginModal = new Modal("loginModal", "openModal", ".close");
const infolabModal = new Modal("modalInfolab", "openModalInfolab", ".close");
const enactusModal = new Modal("modalEnactus", "openModalEnactus", ".close");
const clubRadioModal = new Modal("modalClubRadio", "openModalClubRadio", ".close");

// Initialisation des validateurs de formulaire
//const loginFormValidator = new LoginFormValidator("loginForm");
const infolabFormValidator = new InfoLabFormValidator("infolabForm");
const enactusFormValidator = new EnactusFormValidator("EnactusForm");
const clubRadioFormValidator = new ClubRadioFormValidator("ClubRadioForm");

// Gestion du défilement fluide pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});