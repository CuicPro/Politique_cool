<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "politique_cool";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Gestion du téléchargement d'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                echo json_encode(["error" => "Désolé, une erreur s'est produite lors du téléchargement de votre fichier."]);
                exit();
            }
        } else {
            echo json_encode(["error" => "Le fichier n'est pas une image."]);
            exit();
        }
    } else {
        echo json_encode(["error" => "Aucun fichier image téléchargé."]);
        exit();
    }

    // Préparation des variables
    $name = $conn->real_escape_string($_POST['name']);

    $skills = [
        'nucleaire',
        'education',
        'emploie',
        'droit_travail',
        'droit_lgbtquia',
        'feminisme',
        'impot',
        'pouvoir_achat',
        'ecologie',
        'retraite',
        'salaire',
        'droit_animeaux',
        'agriculture',
        'europe',
        'immigration',
        'sante'
    ];

    // Préparation de la requête SQL
    $sql = "INSERT INTO partie (name, image, " . implode(", ", $skills) . ") VALUES ('$name', '$image'";

    foreach ($skills as $skill) {
        $value = $conn->real_escape_string($_POST[$skill]);
        $sql .= ", '$value'";
    }

    $sql .= ")";

    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Nouvelle carte créée avec succès"]);
    } else {
        echo json_encode(["error" => "Erreur: " . $sql . "<br>" . $conn->error]);
    }

    // Fermeture de la connexion
    $conn->close();
    header('Location: ../admin.php?success=true');
}
?>
