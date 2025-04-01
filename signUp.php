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
    <title>Sign Up</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<div class="containerLogin">
    <form id="signup-form" method="post">
        <div class="container">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <label for="username"><b>Username</b></label>
            <input id="username" type="text" placeholder="Enter Username" name="username" required>

            <label for="psw"><b>Password</b></label>
            <input id="psw" type="password" placeholder="Enter Password" name="psw" required>

            <label for="pswRepeat"><b>Repeat Password</b></label>
            <input id="pswRepeat" type="password" placeholder="Repeat Password" name="pswRepeat" required>

            <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

            <div class="clearfix">
                <button type="submit" class="signUpBtn">Sign Up</button>
                <button id="cancelBtn" type="button" class="cancelBtn">Cancel</button>
            </div>
        </div>
    </form>
</div>

<script src="public/js/signUp.js"></script>
</body>
</html>

