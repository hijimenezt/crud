<?php
session_start();
require_once '../db/db.php';

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido');
}

/*function checkLoginAttempts($username, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM login_attempts WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $attempts = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($attempts && $attempts['attempts'] >= 5) {
        // Si hay más de 5 intentos fallidos, bloquear por 15 minutos
        $lockTime = strtotime($attempts['last_attempt']) + 900;  // 900 segundos = 15 minutos
        if (time() < $lockTime) {
            return true;  // Bloquear el login
        } else {
            // Reiniciar contador de intentos si ya ha pasado el tiempo de bloqueo
            $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = 0 WHERE username = :username");
            $stmt->execute(['username' => $username]);
            return false;
        }
    }
    return false;
}*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario está bloqueado
    /*if (checkLoginAttempts($username, $pdo)) {
        echo 'Demasiados intentos fallidos. Intenta de nuevo más tarde.';
        exit();
    }*/

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Reiniciar los intentos fallidos
//            $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = 0 WHERE username = :username");
//            $stmt->execute(['username' => $username]);

            // Guardar sesión del usuario
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            echo 'success';
        } else {
            // Aumentar contador de intentos fallidos
            /*$stmt = $pdo->prepare("INSERT INTO login_attempts (username, attempts, last_attempt) VALUES (:username, 1, NOW())
                                   ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
            $stmt->execute(['username' => $username]);*/

            echo 'Usuario o contraseña incorrectos';
        }
    } else {
        echo 'Usuario no encontrado';
    }
}

?>
