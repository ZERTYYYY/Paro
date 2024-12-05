


// Texte dynamique avec alternance de couleurs
const messages = [
  " print(''Bonjour / Welcome !'') ",
  " print(''Bienvenue sur le Cyberfolio de notre équipe 😀'') ",
  " print(''Bonne découverte ;)'') "
];

const dynamicText = document.getElementById('dynamic-text');
let messageIndex = 0;
let charIndex = 0;
let isDeleting = false;

function typeEffect() {
  const currentMessage = messages[messageIndex];
  const currentSlice = isDeleting
    ? currentMessage.substring(0, charIndex--)
    : currentMessage.substring(0, charIndex++);

  const coloredText = Array.from(currentSlice)
    .map((char, index) => {
      const color = index % 2 === 0 ? 'white' : 'MediumSlateBlue';
      return `<span style="color: ${color};">${char}</span>`;
    })
    .join('');

  dynamicText.innerHTML = coloredText;

  if (!isDeleting && charIndex === currentMessage.length) {
    isDeleting = true;
    setTimeout(typeEffect, 1700);
  } else if (isDeleting && charIndex === 0) {
    isDeleting = false;
    messageIndex = (messageIndex + 1) % messages.length;
    setTimeout(typeEffect, 500);
  } else {
    setTimeout(typeEffect, isDeleting ? 50 : 100);
  }
}

typeEffect();

//Récupérer les élement chéckbox et le lien vers le fichier css


function style_mode() {
  const darkModeToggle = document.getElementById('darkmode-toggle'); 
  const themeLink = document.getElementById('theme-link');
  var themeVideo = document.getElementById('background-video');
  var themeVideo1 = document.getElementById('background-video1');
  //

  function toggleVideoVisibility() {
    if (darkModeToggle.checked){
      themeVideo.removeAttribute("hidden");
      themeVideo1.setAttribute("hidden" ,"true");
    }
    else{
      themeVideo1.removeAttribute("hidden");
      themeVideo.setAttribute("hidden","true");
    }
  }


  // Vérifie si l'état du mode sombre est mémorisé dans localStorage
  if(localStorage.getItem('darkMode') === 'enabled') {
    darkModeToggle.checked = true;
    themeVideo.removeAttribute("hidden");
    themeLink.href = 'css/style.css';
  } 
  else {
    darkModeToggle.checked = false;
    themeVideo1.removeAttribute("hidden");
    themeLink.href = 'css/style_clair.css';
  }


  // Écoute les changements sur le checkbox (quand l'utilisateur change le mode)
  darkModeToggle.addEventListener('change', () => {
    if (darkModeToggle.checked) {
      themeLink.href = 'css/style.css';
      localStorage.setItem('darkMode', 'enabled');
    } else {
      // Si l'utilisateur désactive le mode sombre (mode clair)
      themeLink.href = 'css/style_clair.css'; 
      localStorage.setItem('darkMode', 'disabled'); 
    }
    toggleVideoVisibility();
  });
}



style_mode();