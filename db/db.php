<?php
$host = 'localhost'; // o la dirección de tu servidor
$usuario = 'root';   // tu usuario de MySQL
$password = '';      // tu contraseña de MySQL
$base_de_datos = 'crud';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}