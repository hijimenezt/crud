<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>

<div class="header">
    <a href="dashboard.php" class="logo">CRUD</a>
    <div class="header-right">
        <a href="product.php">Product</a>
        <a href="category.php">Category</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<h1 style="text-align: center">Welcome <?php echo $_SESSION['username'] ?></h1>
</body>
</html>
