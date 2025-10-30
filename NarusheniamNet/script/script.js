// script.js
document.addEventListener('DOMContentLoaded', function() {
    const login = document.getElementsByName("login")[0];
    const password = document.getElementsByName("password")[0];
    const error = document.querySelector(".error");
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        let isValid = true;
        error.innerHTML = "";

        // Проверка логина
        if (login.value === "") {
            error.innerHTML += "Введите логин<br>";
            isValid = false;
        } else if (login.value.length < 3) {
            error.innerHTML += "Логин должен быть не менее 3 символов<br>";
            isValid = false;
        }

        // Проверка пароля
        if (password.value === "") {
            error.innerHTML += "Введите пароль<br>";
            isValid = false;
        } else if (password.value.length < 6) {
            error.innerHTML += "Пароль должен быть не менее 6 символов<br>";
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});