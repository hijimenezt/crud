document.getElementById("signUpButton").onclick = function (){
    window.location = "signUp.php";
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const csrf_token = document.getElementById('csrf_token').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/loginController.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password) + '&csrf_token=' + csrf_token);

        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === 'success') {
                    window.location.href = 'dashboard.php';
                } else {
                    alert(xhr.responseText);
                }
            } else {
                alert('There was an error processing your request');
            }
        };
    });
});
