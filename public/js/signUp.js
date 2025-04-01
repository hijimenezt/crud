document.getElementById("cancelBtn").onclick = function (){
    window.location = "index.php";
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signup-form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('psw').value;
        const passwordRepeat = document.getElementById('pswRepeat').value;
        const csrf_token = document.getElementById('csrf_token').value;

        if ( password !== passwordRepeat ){
            alert("Password doesn't match");
            return false;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/signUpController.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password) + '&passwordRepeat=' + encodeURIComponent(passwordRepeat) + '&csrf_token=' + csrf_token );

        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === 'success') {
                    window.location.href = 'dashboard.php';
                } else {
                    alert(xhr.responseText);
                }
            } else {
                alert("There was an error processing your request");
            }
        };
    });
});