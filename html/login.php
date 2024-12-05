<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hacker Login Form | Helpme_coder</title>
  <link rel="stylesheet" href="../css/Login_style.css">
</head>
<body>


<section> 
<span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  

    <div class="signin">
      <div class="content">
        <h2>Sign In</h2>
        <div class="form">
          <!-- Formulaire qui envoie les données en POST à la même page -->
          <form method="POST" action="">
            <div class="inputBox">
              <input type="text" name="pseudo" required>
              <i>Username</i>
            </div>
            <div class="inputBox">
              <input type="password" name="mdp" required>
              <i>Password</i>
            </div>
            <div class="links">
              <a href="#"></a>
              <a href="#"></a>
            </div>
            <div class="inputBox">
              <input type="submit" name="envoi" value="Login">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<!-- partial -->
  
</body>
</html>

<?php
// Connexion à la base de données
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');

// Vérifier si le formulaire a été soumis
if(isset($_POST['envoi'])){
  if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])){
    // Assainir les données envoyées par l'utilisateur
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mdp = sha1(htmlspecialchars($_POST['mdp'])); // Le mot de passe est haché en SHA1

    // Requête pour vérifier les identifiants dans la base de données
    $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
    $recupUser->execute(array($pseudo, $mdp));

    // Si un utilisateur correspondant est trouvé
    if ($recupUser->rowCount() > 0){
      $_SESSION['pseudo'] = $pseudo; // Enregistrer le pseudo dans la session
      $_SESSION['mdp'] = $mdp; // Enregistrer le mot de passe dans la session
      $_SESSION['id'] = $recupUser->fetch()['id']; // Enregistrer l'ID de l'utilisateur dans la session

      // Rediriger vers les pages d'administration en fonction du pseudo
      switch ($pseudo) {
        case 'emile':
          header('Location: adminemile.php');
          break;
        case 'dimitri':
          header('Location: admindimitri.php');
          break;
        case 'emeric':
          header('Location: adminemeric.php');
          break;
        case 'ilyass':
          header('Location: adminilyass.php');
          break;
        default:
          // Redirection par défaut si nécessaire
          echo "Utilisateur inconnu.";
          break;
      }
    } else {
      echo 'Le Username ou/et le Mot de passe est incorrect';
    }
  } else {
    echo "Veuillez renseigner tous les champs";
  }
}
?>
