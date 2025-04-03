document.addEventListener("DOMContentLoaded", () => {
  // Sélectionner tous les liens de navigation (sauf l'icône de profil)
  const navLinks = document.querySelectorAll(".nav-links a:not(:last-child)");
  const navLinksContainer = document.querySelector(".nav-links");

  // Créer l'élément indicateur
  const indicator = document.createElement("div");
  indicator.className = "nav-indicator";
  navLinksContainer.appendChild(indicator);

  // Fonction pour mettre à jour l'indicateur
  function updateIndicator(element) {
    // Obtenir les dimensions et la position du lien
    const rect = element.getBoundingClientRect();
    const containerRect = navLinksContainer.getBoundingClientRect();

    // Mettre à jour la position et la largeur de l'indicateur
    indicator.style.width = `${rect.width}px`;
    indicator.style.left = `${rect.left - containerRect.left}px`;
  }

  // Fonction pour cacher l'indicateur
  function hideIndicator() {
    indicator.style.opacity = "0";
  }

  // Fonction pour montrer l'indicateur
  function showIndicator() {
    indicator.style.opacity = "1";
  }

  // Fonction pour définir le lien actif basé sur l'URL actuelle
  function setActiveLink() {
    const currentPath = window.location.search;
    let isMainPage = false;

    // Vérifier si nous sommes sur une des pages principales (recettes ou sessions)
    if (currentPath.includes("recettes") || currentPath.includes("sessions")) {
      isMainPage = true;
      showIndicator();
    } else {
      hideIndicator();
    }

    navLinks.forEach((link) => {
      if (link.href.includes(currentPath) && isMainPage) {
        link.classList.add("active");
        updateIndicator(link);
      } else {
        link.classList.remove("active");
      }
    });
  }

  // Ajouter les écouteurs d'événements pour chaque lien
  navLinks.forEach((link) => {
    link.addEventListener("mouseenter", () => {
      if (link.href.includes("recettes") || link.href.includes("sessions")) {
        showIndicator();
        updateIndicator(link);
      }
    });

    link.addEventListener("click", (e) => {
      navLinks.forEach((link) => link.classList.remove("active"));
      if (
        e.currentTarget.href.includes("recettes") ||
        e.currentTarget.href.includes("sessions")
      ) {
        e.currentTarget.classList.add("active");
      }
    });
  });

  // Remettre l'indicateur sur le lien actif quand la souris quitte la navigation
  navLinksContainer.addEventListener("mouseleave", () => {
    const activeLink = document.querySelector(".nav-links a.active");
    if (activeLink) {
      updateIndicator(activeLink);
    } else {
      hideIndicator();
    }
  });

  // Initialiser l'indicateur
  setActiveLink();

  // Mettre à jour l'indicateur lors du redimensionnement de la fenêtre
  window.addEventListener("resize", () => {
    const activeLink = document.querySelector(".nav-links a.active");
    if (activeLink) {
      updateIndicator(activeLink);
    }
  });
});
