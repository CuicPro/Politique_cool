<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "politique_cool";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize_file_name($filename) {
    $filename = preg_replace("/[^a-zA-Z0-9\.\-\_\s]/", "", $filename);
    $filename = str_replace(" ", "_", $filename);
    return $filename;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "add_card") {
        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
            $image = "uploads/" . sanitize_file_name(basename($_FILES["image"]["name"]));
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                echo json_encode(["error" => "Failed to upload image."]);
                exit();
            }
        } else {
            $image = $conn->real_escape_string($_POST["image"]);
        }

        $name = $conn->real_escape_string($_POST["name"]);
        $skills = $conn->real_escape_string(json_encode($_POST["skills"], JSON_UNESCAPED_UNICODE));

        $sql = "INSERT INTO partie (image, name, skills) VALUES ('$image', '$name', '$skills')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "New card added successfully"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT image, name, skills FROM partie";
    $result = $conn->query($sql);

    $cards = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $row['skills'] = json_decode($row['skills']);
            $cards[] = $row;
        }
    }
    echo json_encode($cards);
}

$conn->close();
?>
