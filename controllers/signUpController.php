<?php
session_start();
require_once '../db/db.php';

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $passwordRepeat = $_POST['passwordRepeat'] ?? null;

    // Verificar si el usuario existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo 'The user already exists';
    } else {
        if( $password === $passwordRepeat ) {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            $stmtUser = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmtUser->execute(['username' => $username]);
            $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user_id'] = $userData['user_id'];
            $_SESSION['username'] = $userData['username'];

            echo 'success';
        }else{
            echo "Password doesn't match";
        }
    }
}