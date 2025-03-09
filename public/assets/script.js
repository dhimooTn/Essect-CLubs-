// Fonction pour récupérer un paramètre GET dans l'URL
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Vérifier le paramètre 'status' et afficher une alerte
document.addEventListener("DOMContentLoaded", () => {
    let status = getParameterByName('status');
    if (status === "success") {
        alert("✅ Inscription réussie !");
    } else if (status === "error") {
        alert("❌ Erreur lors de l'inscription !");
    }

    // Supprimer le paramètre 'status' de l'URL après affichage du message
    if (status) {
        let newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});

// Classe pour gérer les modales
class Modal {
    constructor(modalId, openButtonId, closeButtonClass) {
        this.modal = document.getElementById(modalId);
        this.openButton = document.getElementById(openButtonId);
        this.closeButton = this.modal.querySelector("." + closeButtonClass);

        if (this.modal && this.openButton && this.closeButton) {
            this.init();
        } else {
            console.error(`Éléments de la modal non trouvés : ${modalId}, ${openButtonId}, ${closeButtonClass}`);
        }
    }

    init() {
        this.openButton.addEventListener("click", () => this.open());
        this.closeButton.addEventListener("click", () => this.close());

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
            this.form.submit();
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
}

// Classes pour la validation des formulaires
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

class InfoLabFormValidator extends FormValidator {
    isValid() {
        const firstName = this.form.querySelector("input[name='first_name']").value.trim();
        const lastName = this.form.querySelector("input[name='last_name']").value.trim();
        const email = this.form.querySelector("input[name='email']").value.trim();
        const phone = this.form.querySelector("input[name='phone_number']").value.trim();

        if (!firstName || !lastName || !email || !phone) {
            alert("Tous les champs obligatoires doivent être remplis.");
            return false;
        }

        if (!this.validateEmail(email)) {
            alert("Adresse email invalide.");
            return false;
        }

        if (!this.validatePhone(phone)) {
            alert("Numéro de téléphone invalide. Il doit contenir 8 chiffres.");
            return false;
        }

        return true;
    }
}

class EnactusFormValidator extends InfoLabFormValidator {}
class ClubRadioFormValidator extends InfoLabFormValidator {}

// Dark Mode Toggle
const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;

if (localStorage.getItem("dark-mode") === "enabled") {
    body.classList.add("dark-mode");
    darkModeToggle.textContent = "☀️";
}

darkModeToggle.addEventListener("click", () => {
    body.classList.toggle("dark-mode");
    const isDarkMode = body.classList.contains("dark-mode");
    darkModeToggle.textContent = isDarkMode ? "☀️" : "🌙";
    localStorage.setItem("dark-mode", isDarkMode ? "enabled" : "disabled");
});

// Initialisation des modales
const loginModal = new Modal("loginModal", "openModal", "close");
const infolabModal = new Modal("modalInfolab", "openModalInfolab", "close");
const enactusModal = new Modal("modalEnactus", "openModalEnactus", "close");
const clubRadioModal = new Modal("modalClubRadio", "openModalClubRadio", "close");

// Initialisation des validateurs de formulaire
const loginFormValidator = new LoginFormValidator("loginForm");
const infolabFormValidator = new InfoLabFormValidator("infolabForm");
const enactusFormValidator = new EnactusFormValidator("EnactusForm");
const clubRadioFormValidator = new ClubRadioFormValidator("ClubRadioForm");

// Gestion du défilement fluide pour les ancres
document.querySelectorAll("a[href^='#']").forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
            });
        }
    });
});
    