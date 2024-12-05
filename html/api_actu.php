<?php
    // Active les erreurs pour faciliter le débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // API Key et le sujet pour la recherche
    $apiKey = 'INI9zwFEU6GD6T7wbtAtzuBAoQzFl2wW';
    $topic = 'Technology'; // Sujet des articles

    // URL de l'API de New York Times
    $url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q={$topic}&api-key={$apiKey}";

    // Initialisation de cURL
    $ch = curl_init();


    // Définir l'URL de la requête cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Désactive la vérification SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Exécuter la requête cURL
    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Erreur cURL : ' . curl_error($ch);
        curl_close($ch);
        exit;
    }

    // Décoder la réponse JSON
    $data = json_decode($response, true);
    if ($data === null) {
        echo "Erreur lors du décodage JSON : " . json_last_error_msg() . "<br>";
        exit;
    }

    // Vérifier si des articles sont disponibles
    $articles = [];
    if (isset($data['response']['docs']) && count($data['response']['docs']) > 0) {
        $articles = $data['response']['docs'];
    }

    // Fermer la session cURL
    curl_close($ch);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css" id="theme-link1">
        <link rel="stylesheet" href="../css/api.css">
        <title>Page De Actualiter</title>
    </head>
    <body>

        <!-- Vidéo de fond -->
        <video autoplay muted loop id="background-video" hidden>
            <source src="../img/background_index.mp4" type="video/mp4" id="background-d">
            Votre navigateur ne supporte pas les vidéos HTML5.
        </video>

        <video autoplay muted loop id="background-video1" hidden> 
            <source src="../img/background_clair.mp4" type="video/mp4">
            Votre navigateur ne supporte pas les vidéos HTML5.
        </video>
    
        <!-- Barre de navigation -->
        <nav>
            <section class="top-nav">
                <input id="menu-toggle" type="checkbox" />
                <label class="menu-button-container" for="menu-toggle">
                    <div class="menu-button"></div>
                </label>
                <ul class="menu">
                    <li><a href="../index.html">Accueil</a></li>
                    <li><a href="html/partenaires.html">Partenaire</a></li>
                    <li><a href="html/contact.html">Contact</a></li>
                    <li><a href="/html/Recherche2.php">Recherche</a></li>
                </ul>
                <a href="https://guardia.school/campus/lyon.html?utm_term=&utm_campaign=PMX+GU+-+Etudiants&utm_source=adwords&utm_medium=ppc&hsa_acc=1749547295&hsa_cam=20907422767&hsa_grp=&hsa_ad=&hsa_src=x&hsa_tgt=&hsa_kw=&hsa_mt=&hsa_net=adwords&hsa_ver=3&gad_source=1&gclid=Cj0KCQiA0fu5BhDQARIsAMXUBOLF5lQxduMnrC_3qKBJVAWHTUJK-DNhqhYN9tiGD5igEzrigsmo3pAaAjjzEALw_wcB">
                    <img src="../img/guardiagif.gif" alt="Logo" class="logo">
                </a>
                <input class="inputswitch" type="checkbox" id="darkmode-toggle">
                <label class="switch" for="darkmode-toggle"></label>
                <div class="backswitch"></div>
            </section>
        </nav>

        
        <h1>Actualiter New York Times</h1>

        <div id="api_data">
            <?php if (count($articles) > 0): ?>
                <div class="articles">
                    <?php foreach ($articles as $article): ?>
                        <div class="article">
                            <h2><?php echo htmlspecialchars($article['headline']['main']); ?></h2>
                            <p><?php echo htmlspecialchars($article['abstract']); ?></p>
                            <a href="<?php echo htmlspecialchars($article['web_url']); ?>" target="_blank">Lire l'article complet</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun article trouvé sur ce sujet.</p>
            <?php endif; ?>
        </div>
        <script src="js/script.js"></script>
    </body>
</html>