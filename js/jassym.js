// Fonction pour afficher/masquer les informations de contact
function nav_bar() {
  document.getElementById('contact-btn').addEventListener('click', function() {
    var contactInfo = document.getElementById('contact-info');
    
    // Vérifier si la section des contacts est actuellement visible
    if (contactInfo.style.display === 'none' || contactInfo.style.display === '') {
      // Si elle est masquée, on la rend visible
      contactInfo.style.display = 'block';
    } else {
      // Si elle est visible, on la masque
      contactInfo.style.display = 'none';
    }
  });
}

// Fonction pour activer un lien dans la barre de navigation
function jaja() {
  const list = document.querySelectorAll('.list');

  function activeLink() {
    list.forEach((item) => item.classList.remove('active'));
    this.classList.add('active');
  }

  list.forEach((item) => item.addEventListener('click', activeLink));
}

// Appeler les fonctions après le chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
  nav_bar();
  jaja();
});
