<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crud</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<div class="containerLogin">
    <form id="login-form" method="post">
        <div class="imgContainer">
            <img src="public/img/avatar.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input id="username" type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input id="password" type="password" placeholder="Enter Password" name="password" required>
            <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <button type="submit">Login</button>
            <button id="signUpButton" type="button" class="btn">Sign Up</button>
        </div>
    </form>
</div>

<script src="public/js/script.js"></script>
</body>
</html>
