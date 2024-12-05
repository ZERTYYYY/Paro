<?php
// VARIABLE CONNEXION A NE PAS TOUCHER
$host = 'localhost'; 
$dbname = 'TEST_db'; 
$username = 'root'; 
$password = 'root'; 

try {
    // Connexion au serveur MySQL
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("USE $dbname");

    //  verif si le form est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message,
        ]);

        echo "Votre message a été envoyé avec succès !";
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
