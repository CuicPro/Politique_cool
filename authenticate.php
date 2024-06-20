<?php
session_start();

// Informations d'identification administrateur
$admin_username = "admin";
$admin_password = password_hash("adminpassword", PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $admin_username && password_verify($password, $admin_password)) {
        $_SESSION['username'] = $username;
        echo json_encode(["message" => "Login successful"]);
    } else {
        echo json_encode(["error" => "Invalid username or password"]);
    }
}
?>
