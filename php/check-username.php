<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $email = $_SESSION['email'];

    // CLEAN THE INPUT
    $username = mysqli_real_escape_string($conn, $username);

    // VALIDATE LENGTH OF THE USERNAME
    if (strlen($username) < 5 || strlen($username) > 15 || !preg_match('/^\w+$/', $username)) {
        echo "Invalid username.";
        exit;
    }

    // CONSULT IF THE USERNAME IS TAKEN
    $stmt = $conn->prepare("SELECT id FROM register WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Username already taken.";
        $stmt->close();
        exit;
    } else {
        // IF THE USERNAME IS AVAILABLE, THE REGISTER IS LOAD
        $stmt->close();
        $stmt = $conn->prepare("UPDATE register SET username = ?, profile_complete = 1 WHERE email = ?");
        $stmt->bind_param("ss", $username, $email);
        if ($stmt->execute()) {
            echo "Profile updated successfully.";
            exit;
        } else {
            echo "Error updating profile.";
            exit;
        }
    }
} else {
    echo "Access denied.";
}
?>
