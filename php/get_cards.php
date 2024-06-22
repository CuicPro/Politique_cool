<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "politique_cool";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'La connexion a échoué: ' . $conn->connect_error]));
}

$sql = "SELECT * FROM partie";
$result = $conn->query($sql);

$cards = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$conn->close();

echo json_encode($cards);
?>
