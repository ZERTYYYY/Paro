<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php

session_start();
if ($_SESSION['pseudo'] !== 'dimitri') {
    header('Location: login.php');
    exit();
}

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "cyberfolio";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$titre = $date = $texte = $competence1 = $competence2 = $competence3 = "";
$titre2 = $date2 = $texte2 = $competence12 = $competence22 = $competence32 = "";
?>




<!-- Modificcation présentation -->
<?php 
$sql = "SELECT * FROM autres WHERE Nom = ? AND Titre = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL preparation failed: " . $conn->error);
}
$pseudo = $_SESSION['pseudo'];
$titre0 = 'presentation';
$stmt->bind_param("ss", $pseudo, $titre0);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<div class='container mt-5'>
        <h2>Présentation</h2>
        <form method='POST' enctype='multipart/form-data'>
            <textarea type='text' name='Texte0' placeholder='Texte' class='form-control'  required>" . htmlspecialchars($row['Texte'], ENT_QUOTES, 'UTF-8') . "</textarea>
            <button type='submit' name='modifpresentation' class='btn btn-primary mt-2'>Modifier</button>
        </form>
    </div>";
}
$stmt->close();


?>
<?php
if (isset($_POST['modifpresentation'])) {
    if (!empty($_POST['Texte0'])) {
        $texte0 = $_POST['Texte0'];
            $stmt3 = $conn->prepare("UPDATE autres SET Texte=? where Titre='presentation' and Nom='". $_SESSION['pseudo'] ."'");
            $stmt3->bind_param("s", $texte0);
            if ($stmt3->execute()) {
                echo "<p class='text-success'>Modification realiser avec succès !</p>";
            } else {
                echo "<p class='text-danger'>Erreur lors de la modification : " . $stmt3->error . "</p>";
            }
            $stmt3->close();
        } else {
            echo "<p class='text-danger'>Erreur lors du téléchargement du fichier.</p>";
        }
    } 
?>



<!-- Modification Activiter -->
<?php

$pseudo = $_SESSION['pseudo'];
$type = 'activiter';
$sql = "SELECT * FROM autres WHERE Nom = ? AND type = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL preparation failed: " . $conn->error);
}

$stmt->bind_param("ss", $pseudo, $type);
$stmt->execute();
$result = $stmt->get_result();
$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[$row['Titre']] = $row['Texte'];
}

$stmt->close();
?>

<div class="container mt-5">
    <h2>Modifier une Activité</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="activiter">Sélectionnez une activité :</label>
            <select name="activiter" id="activiter" class="form-control" onchange="updateForm()" required>
                <option value="">--Choisissez l'activité--</option>
                <?php foreach ($activities as $titre4 => $texte4) : ?>
                    <option value="<?php echo htmlspecialchars($titre4, ENT_QUOTES, 'UTF-8'); ?>" <?php echo isset($_POST['activiter']) && $_POST['activiter'] == $titre4 ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($titre4, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="titre">Titre :</label>
            <input type="text" name="Titre4" id="titre" class="form-control" value="<?php echo htmlspecialchars($_POST['Titre4'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="texte">Texte :</label>
            <textarea name="Texte4" id="texte" rows="5" class="form-control" required><?php echo htmlspecialchars($_POST['Texte4'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <button type="submit" name="modifactiviter" class="btn btn-primary mt-2">Modifier</button>
    </form>
</div>

<script>
    function updateForm() {
        const activities = <?php echo json_encode($activities, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
        const selectedActivity = document.getElementById('activiter').value;
        document.getElementById('titre').value = selectedActivity || ''; 
        document.getElementById('texte').value = activities[selectedActivity] || '';
    }
    window.onload = function() {
        updateForm();
    }
</script>

<?php
if (isset($_POST['modifactiviter'])) {
    $newTitre = $_POST['Titre4'] ?? null; 
    $newTexte = $_POST['Texte4'] ?? null; 
    $activiter = $_POST['activiter'] ?? null; 

    if ($newTitre && $newTexte && $activiter) {
        $stmt3 = $conn->prepare("UPDATE autres SET Titre = ?, Texte = ? WHERE Titre = ? AND Nom = ?");
        if (!$stmt3) {
            die("SQL preparation failed: " . $conn->error);
        }
        $stmt3->bind_param("ssss", $newTitre, $newTexte, $activiter, $pseudo);
        if ($stmt3->execute()) {
            echo "<p class='text-success'>Modification réalisée avec succès !</p>";
        } else {
            echo "<p class='text-danger'>Erreur lors de la modification : " . $stmt3->error . "</p>";
        }
        $stmt3->close();
    } else {
        echo "<p class='text-danger'>Veuillez remplir tous les champs.</p>";
    }
}
?>

























<!-- Ajouter un projet -->
<?php
if (isset($_POST['envoiprojet'])) {
    if (!empty($_POST['Titre']) && !empty($_POST['Date']) && !empty($_POST['Texte']) &&
        !empty($_POST['Competence1']) && !empty($_POST['Competence2']) && !empty($_POST['Competence3']) && isset($_FILES['file'])) {

        $titre = $_POST['Titre'];
        $date = $_POST['Date'];
        $texte = $_POST['Texte'];
        $competence1 = $_POST['Competence1'];
        $competence2 = $_POST['Competence2'];
        $competence3 = $_POST['Competence3'];

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = uniqid('file_', true) . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            $stmt = $conn->prepare("INSERT INTO projet (Titre, Date1, Texte, Competence1, Competence2, Competence3, Fichier, Nom) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $titre, $date, $texte, $competence1, $competence2, $competence3, $uploadPath, $_SESSION['pseudo']);
            if ($stmt->execute()) {
                echo "<p class='text-success'>Projet ajouté avec succès !</p>";
            } else {
                echo "<p class='text-danger'>Erreur lors de l'ajout du projet : " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p class='text-danger'>Erreur lors du téléchargement du fichier.</p>";
        }
    } else {
        echo "<p class='text-danger'>Veuillez remplir tous les champs et télécharger un fichier.</p>";
    }
}

if (isset($_POST['envoiexperience'])) {
    if (!empty($_POST['Titre2']) && !empty($_POST['Date2']) && !empty($_POST['Texte2']) &&
        !empty($_POST['Competence12']) && !empty($_POST['Competence22']) && !empty($_POST['Competence32'])) {

        $titre2 = $_POST['Titre2'];
        $date2 = $_POST['Date2'];
        $texte2 = $_POST['Texte2'];
        $competence12 = $_POST['Competence12'];
        $competence22 = $_POST['Competence22'];
        $competence32 = $_POST['Competence32'];

        $stmt = $conn->prepare("INSERT INTO experience (Titre, Date1, Texte, Competence1, Competence2, Competence3, Nom) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $titre2, $date2, $texte2, $competence12, $competence22, $competence32, $_SESSION['pseudo']);
        if ($stmt->execute()) {
            echo "<p class='text-success'>Expérience ajoutée avec succès !</p>";
        } else {
            echo "<p class='text-danger'>Erreur lors de l'ajout de l'expérience : " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-danger'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<h1 class="text-center bg-dark text-white p-3">Administrateur - <?php echo strtoupper($_SESSION['pseudo']); ?></h1>
<div class="container mt-5" >
    <h2>Ajouter un Projet</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="Titre" placeholder="Titre" class="form-control" value="<?php echo $titre; ?>" required>
        <input type="text" name="Date" placeholder="Date" class="form-control mt-2" value="<?php echo $date; ?>" required>
        <textarea name="Texte" placeholder="Texte" class="form-control mt-2" required><?php echo $texte; ?></textarea>
        <input type="text" name="Competence1" placeholder="Compétence 1" class="form-control mt-2" value="<?php echo $competence1; ?>" required>
        <input type="text" name="Competence2" placeholder="Compétence 2" class="form-control mt-2" value="<?php echo $competence2; ?>" required>
        <input type="text" name="Competence3" placeholder="Compétence 3" class="form-control mt-2" value="<?php echo $competence3; ?>" required>
        <input type="file" name="file" class="form-control mt-2" required>
        <button type="submit" name="envoiprojet" class="btn btn-primary mt-2">Envoyer</button>
        <button type='submit' name='viewprojet' class="btn btn-warning mt-2">Voir l'aperçu</button>
    </form>

    <?php if (isset($_POST['viewprojet'])): 
        if (!empty($_POST['Titre']) && !empty($_POST['Date']) && !empty($_POST['Texte']) &&!empty($_POST['Competence1']) && !empty($_POST['Competence2']) && !empty($_POST['Competence3'])) {
        $titre = $_POST['Titre'];
        $date = $_POST['Date'];
        $texte = $_POST['Texte'];
        $competence1 = $_POST['Competence1'];
        $competence2 = $_POST['Competence2'];
        $competence3 = $_POST['Competence3'];
        }
        ?>
        <div class='projet'>
            <h2 class='title_projet'><?php echo $titre; ?></h2>
            <p class='date_projet'><?php echo $date; ?></p>
            <p class='text_description'><?php echo $texte; ?></p>
            <div class='ContainerCompetence'>
                <div class='competences2'>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence1; ?></p>
                    </div>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence2; ?></p>
                    </div>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence3; ?></p>
                    </div>
                </div>
                <a href='' download>
                    <button class='Download'>Télécharger les fichiers du projet</button>
                </a>
            </div>
        </div>
    <?php endif; ?>









    <?php

$sql = "SELECT ID, Titre FROM projet where Nom='". $_SESSION['pseudo'] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo '<form method="POST">';
    echo '<h2 for="projet_select">Sélectionnez un projet à supprimer :</h2>';
    echo '<select name="projet_id" id="projet_select" class="form-control" onchange="updateForm()" required>';
    echo '<option value="">-- Choisissez un projet --</option>';

    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8') . '">' 
             . htmlspecialchars($row['Titre'], ENT_QUOTES, 'UTF-8') 
             . '</option>';
    }

    echo '</select>';
    echo '<button type="submit" name="deleteprojet" class="btn btn-danger">Supprimer</button>';
    echo '</form>';
} else {
    echo '<p>Aucun projet disponible.</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteprojet']) && isset($_POST['projet_id'])) {
    $projet_id = intval($_POST['projet_id']);

    $stmt = $conn->prepare("DELETE FROM projet WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $projet_id);
        if ($stmt->execute()) {
            echo '<p class="success">Le projet a été supprimé avec succès.</p>';
        } else {
            echo '<p class="error">Erreur lors de la suppression : ' . $stmt->error . '</p>';
        }
        $stmt->close();
    } else {
        echo '<p class="error">Erreur lors de la préparation de la requête : ' . $conn->error . '</p>';
    }
}
?>














    <h2 class="mt-5">Ajouter une Expérience Professionnelle</h2>
    <form method="POST">
        <input type="text" name="Titre2" placeholder="Titre" class="form-control" value="<?php echo $titre2; ?>" required>
        <input type="text" name="Date2" placeholder="Date" class="form-control mt-2" value="<?php echo $date2; ?>" required>
        <textarea name="Texte2" placeholder="Texte" class="form-control mt-2" required><?php echo $texte2; ?></textarea>
        <input type="text" name="Competence12" placeholder="Compétence 1" class="form-control mt-2" value="<?php echo $competence12; ?>" required>
        <input type="text" name="Competence22" placeholder="Compétence 2" class="form-control mt-2" value="<?php echo $competence22; ?>" required>
        <input type="text" name="Competence32" placeholder="Compétence 3" class="form-control mt-2" value="<?php echo $competence32; ?>" required>
        <button type="submit" name="envoiexperience" class="btn btn-primary mt-2">Envoyer</button>
        <button type='submit' name='viewexperience' class="btn btn-warning mt-2">Voir l'aperçu</button>
    </form>
 
 
 
 
<?php if (isset($_POST['viewexperience'])): ?>
        <div class='projet'>
            <h2 class='title_projet'><?php echo $titre2; ?></h2>
            <p class='date_projet'><?php echo $date2; ?></p>
            <p class='text_description'><?php echo $texte2; ?></p>
            <div class='ContainerCompetence'>
                <div class='competences2'>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence12; ?></p>
                    </div>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence22; ?></p>
                    </div>
                    <div class='competence2'>
                        <img src='../img/logo.png' class='logo2'>
                        <p class='desc_competence'><?php echo $competence32; ?></p>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>


<br>




<?php

$sql = "SELECT ID, Titre FROM experience where Nom='". $_SESSION['pseudo'] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo '<form method="POST">';
    echo '<h2 for="experience_select">Sélectionnez une experience à supprimer :</h2>';
    echo '<select name="experience_id" id="experience_select" class="form-control" onchange="updateForm()" required>';
    echo '<option value="">-- Choisissez une expérience --</option>';

    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8') . '">' 
             . htmlspecialchars($row['Titre'], ENT_QUOTES, 'UTF-8') 
             . '</option>';
    }

    echo '</select>';
    echo '<button type="submit" name="deleteexperience" class="btn btn-danger">Supprimer</button>';
    echo '</form>';
} else {
    echo '<p>Aucune experience disponible.</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteexperience']) && isset($_POST['experience_id'])) {
    $experience_id = intval($_POST['experience_id']);

    $stmt = $conn->prepare("DELETE FROM experience WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $experience_id);
        if ($stmt->execute()) {
            echo '<p class="success">L experince a été supprimé avec succès.</p>';
        } else {
            echo '<p class="error">Erreur lors de la suppression : ' . $stmt->error . '</p>';
        }
        $stmt->close();
    } else {
        echo '<p class="error">Erreur lors de la préparation de la requête : ' . $conn->error . '</p>';
    }
}
?>
























<?php



if (isset($_POST['envoicompetence'])) {
    if (!empty($_POST['Titre3']) &&  isset($_FILES['file3'])) {

        $titre3 = $_POST['Titre3'];

        $uploadDir3 = 'uploads/';
        if (!is_dir($uploadDir3)) {
            mkdir($uploadDir3, 0777, true);
        }

        $fileTmpPath3 = $_FILES['file3']['tmp_name'];
        $fileName3 = uniqid('file_', true) . '.' . pathinfo($_FILES['file3']['name'], PATHINFO_EXTENSION);
        $uploadPath3 = $uploadDir3 . $fileName3;

        if (move_uploaded_file($fileTmpPath3, $uploadPath3)) {
            $stmt3 = $conn->prepare("INSERT INTO competence (Competence2, Fichier, nom) VALUES (?, ?, ?)");
            $stmt3->bind_param("sss", $titre3, $uploadPath3,$_SESSION['pseudo']);
            if ($stmt3->execute()) {
                echo "<p class='text-success'>Compétence ajouté avec succès !</p>";
            } else {
                echo "<p class='text-danger'>Erreur lors de l'ajout de la compétence : " . $stmt3->error . "</p>";
            }
            $stmt3->close();
        } else {
            echo "<p class='text-danger'>Erreur lors du téléchargement du fichier.</p>";
        }
    } else {
        echo "<p class='text-danger'>Veuillez remplir tous les champs et télécharger un fichier.</p>";
    }
}
?>
<div class="container mt-5" >
    <h2>Ajouter une compétence</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="Titre3" placeholder="Titre" class="form-control" value="<?php echo $titre; ?>" required>
        <input type="file" name="file3" class="form-control mt-2" required>
        <button type="submit" name="envoicompetence" class="btn btn-primary mt-2">Envoyer</button>
    </form>
</div>


<br>
<?php

$sql = "SELECT Competence2 FROM competence where nom='". $_SESSION['pseudo'] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo '<form method="POST">';
    echo '<h2 for="competence_select">Sélectionnez une compétence à supprimer :</h2>';
    echo '<select name="competence_id" id="competence_select" class="form-control" onchange="updateForm()" required>';
    echo '<option value="">-- Choisissez une compétence --</option>';

    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['Competence2'], ENT_QUOTES, 'UTF-8') . '">' 
             . htmlspecialchars($row['Competence2'], ENT_QUOTES, 'UTF-8') 
             . '</option>';
    }

    echo '</select>';
    echo '<button type="submit" name="deletecompetence" class="btn btn-danger">Supprimer</button>';
    echo '</form>';
} else {
    echo '<p>Aucune compétence disponible.</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletecompetence']) && isset($_POST['competence_id'])) {
    $competence_id = $_POST['competence_id'];

    $stmt = $conn->prepare("DELETE FROM competence WHERE Competence2 = ?");
    if ($stmt) {
        $stmt->bind_param("s", $competence_id);
        if ($stmt->execute()) {
            echo '<p class="success">La compétence a été supprimé avec succès.</p>';
        } else {
            echo '<p class="error">Erreur lors de la suppression : ' . $stmt->error . '</p>';
        }
        $stmt->close();
    } else {
        echo '<p class="error">Erreur lors de la préparation de la requête : ' . $conn->error . '</p>';
    }
}
?>

















</body>



<style type="text/css">
    h1 {
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        background-color: black;
        color: white;
        text-align: center;
        padding: 10px;
    }
    body{
        margin-top:100px;
    }
    .presentation {
        font-size: 20px;
        font-weight: bold;
        text-decoration: underline;
    }
    .projet {
        width: 500px;

        background-color: rgb(227, 227, 227);
        box-shadow: 0px 0px 10px black;
        margin: 0;
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid black;
        padding: 10px;
    }
    .title_projet {
        text-align: center;
        margin-top: 10px;
    }
    .competences2 {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 30px;
        margin: 0;
    }
    .competence2 {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
    }
    .logo2 {
        width: 70px;
        height: 70px;
        border-radius: 100%;
        object-fit: cover;
        overflow: hidden;
    }
    .Download {
        width: 100%;
        height: 50px;
        border: 1px solid black;
        background-color: rgb(0, 0, 0, 0.1);
        color: black;
    }
    .Download:hover {
        background-color: rgb(0, 0, 0, 0.5);
        color: white;
    }
    .console{
        width: 40%;
        margin-top: 100px;
        height: 200px;
        overflow-y: scroll;
        box-shadow: 0px 0px 10px black;
    }

</style>









</html>
