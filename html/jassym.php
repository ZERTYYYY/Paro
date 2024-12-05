<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Jassym Ferah</title>
    <link rel="stylesheet" href="../css/jassym.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>

<header>
  <div class="navigation">
    <ul>
        <li class="list active">
            <a href="../index.html">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="text">Home</span>
            </a>
        </li>

        <li class="list">
            <a href="../html/contact.html">
                <span class="icon"><i class="fas fa-user"></i></span>
                <span class="text">contact</span>
            </a>
        </li>

        <li class="list">
            <a href="#">
                <span class="icon"><i class="fas fa-comment-dots"></i></span>
                <span class="text"></span>
            </a>
        </li>

        <li class="list">
            <a href="#">
                <span class="icon"><i class="fas fa-photo-video"></i></span>
                <span class="text">Partenaire</span>
            </a>
        </li>

        <div class="indicator"></div>
    </ul>
</div>
</header>

<?php
        
        // Informations de connexion à la base de données
        $host = "localhost"; // Serveur
        $username = "root";  // Nom d'utilisateur
        $password = "root";      // Mot de passe
        $dbname = "cyberfolio"; // Nom de la base de données
        $nom = "jassym";
        
        // Connexion à la base
        $conn = new mysqli($host, $username, $password, $dbname);
        
        // Vérifiez la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }
        $conn->set_charset("utfmb4");
        
?>
<header>
 
 


    <h1>Portfolio - Jassym Ferah</h1>
    <p>Étudiant en cybersécurité à Guardia School</p>
</header>

<section class="biography">
    <div class="bio-container">
        <img src="../assets/my-avatar.png" alt="Jassym Ferah" class="bio-photo">
        <div class="bio-info">
            
            <h2>Jassym Ferah</h2>
      
            <?php
        $sql = "SELECT * FROM autres where Nom='". $nom ."' AND Titre='presentation'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<p>". $row['Texte'] ."</p>";

}
}
?>

            <button id="contact-btn" class="contact-btn">Mes contacts</button>

            <div id="contact-info" class="contact-info">
                <p>Email : <a href="mailto:jferah@guardiaschool.fr">jferah@guardiaschool.fr</a></p>
                <p>LinkedIn : <a href="https://www.linkedin.com/in/jassymferah" target="_blank">Mon LinkedIn</a></p>
                <p>GitHub : <a href="https://github.com/JassymFerah" target="_blank">Mon GitHub</a></p>
                <p>Téléphone : <a href="tel:+33912345678">+33 9 12 34 56 78</a></p>
                <p>Localisation : Lyon, France</p>
                <section class="location">
                  <h2>Localisation</h2>
                  <div id="map" style="width: 100%; height: 400px;"></div>
                </section>
                
                
            </div>

<!-- Barre de recherche -->

            
            <section class="search-section">
                <h2>Recherche</h2>
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Rechercher...">


<!-- Barre de recherche -->



                </div>
            </section>
            
        </div>
    </div>
</section>

<section class="what-i-do">
    <h2>Ce que je fais</h2>
    <div class="services">

        <?php
        $sql = "SELECT * FROM autres where Nom='". $nom ."' AND type='activiter'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<div class='service'><h3>". $row['Titre'] ."</h3><p>". $row['Texte'] ."</p></div>";
 $presentation = $row['Texte'];

}
}
?>
    </div>
</section>

<section class="skills">
    <h2>Compétences</h2>
    <div class="skill">
        <span>Python</span>
        <div class="progress-bar">
            <div style="width: 75%;"></div>
        </div>
    </div>
    <div class="skill">
        <span>Kali Linux</span>
        <div class="progress-bar">
            <div style="width: 85%;"></div>
        </div>
    </div>
    <div class="skill">
        <span>SQL Injection</span>
        <div class="progress-bar">
            <div style="width: 90%;"></div>
        </div>
    </div>
</section>

<section class="events">
    <h2>Événements réalisés</h2>
    <ul>

        <?php
        $sql = "SELECT * FROM competence where Nom='". $nom ."' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<li>". $row['Competence2'] ."</li>";

}
}
?>
    </ul>

</section>

<section class="employer-reviews">
    <h2>Avis Employeurs</h2>
    <div class="review-slider">
        <div class="review">
            <img src="../assets/avatar-1.png" alt="Employeur 1">
            <p>« Très satisfait du travail de Jassym, notamment sur les tests d'intrusion. »</p>
            <strong>- Jean Dupont</strong>
        </div>
        <div class="review">
            <img src="../assets/avatar-2.png" alt="Employeur 2">
            <p>« Son expertise en sécurité applicative est impressionnante. »</p>
            <strong>- Claire Martin</strong>
        </div>
        <div class="review">
            <img src="../assets/avatar-3.png" alt="Employeur 3">
            <p>« Excellent travail sur l'analyse de failles. »</p>
            <strong>- Paul Lemoine</strong>
        </div>
        <div class="review">
            <img src="../assets/avatar-4.png" alt="Employeur 4">
            <p>« Un travail de grande qualité, je recommande. »</p>
            <strong>- Sophie Moreau</strong>
        </div>
    </div>
</section>

<!-- Autres sections (compétences, événements, avis employeurs) -->


















<script src="../js/jassym.js"></script>
<script src="../js/map.js"></script>
</body>
</html>
