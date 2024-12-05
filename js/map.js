// Initialisation de la carte
const map = L.map('map').setView([45.764043, 4.835659], 12); // Coordonnées de Lyon

// Ajout des tuiles (OpenStreetMap - rapide)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
}).addTo(map);

// Ajout d'un marqueur sur Lyon
const marker = L.marker([45.764043, 4.835659]).addTo(map);

// Ajout d'une info-bulle pour le marqueur
marker.bindPopup('<b>Lyon</b><br>C’est ici que je suis !').openPopup();