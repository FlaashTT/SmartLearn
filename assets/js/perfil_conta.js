window.onload = function () {
     let oldPassword = document.getElementById("old-password"),
     newPassword = document.getElementById("new-password"),
     confirmPassword = document.getElementById("confirm-password"),
     Button = document.getElementById("Button");


    let oldVal,newVal,confirmVal;
    if (oldPassword && newPassword && confirmPassword && Button) {
        oldPassword.addEventListener("input", () => {
             oldVal = oldPassword.value.trim();
             newVal = newPassword.value;
             confirmVal = confirmPassword.value;
             hasSpecialChar = /[^a-zA-Z0-9]/.test(newVal);

            if (newVal.length < 8) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Password muito curta";
            } else if (!hasSpecialChar) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Precisa de um caractere especial";
            } else if (oldVal === "") {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Tem de inserir a sua password atual";
            } else if (newVal !== confirmVal) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Palavra passe não coincide!";
            } else {
                Button.disabled = false;
                Button.style.opacity = "1";
                Button.textContent = "Registar";
            }
        });

        newPassword.addEventListener("input", () => {
             oldVal = oldPassword.value.trim();
             newVal = newPassword.value;
             confirmVal = confirmPassword.value;
             hasSpecialChar = /[^a-zA-Z0-9]/.test(newVal);

            if (newVal.length < 8) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Password muito curta";
            } else if (!hasSpecialChar) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Precisa de um caractere especial";
            } else if (oldVal === "") {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Tem de inserir a sua password atual";
            } else if (newVal !== confirmVal) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Palavra passe não coincide!";
            } else {
                Button.disabled = false;
                Button.style.opacity = "1";
                Button.textContent = "Registar";
            }
        });

        confirmPassword.addEventListener("input", () => {
             oldVal = oldPassword.value.trim();
             newVal = newPassword.value;
             confirmVal = confirmPassword.value;
             hasSpecialChar = /[^a-zA-Z0-9]/.test(newVal);

            if (newVal.length < 8) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Password muito curta";
            } else if (!hasSpecialChar) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Precisa de um caractere especial";
            } else if (oldVal === "") {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Tem de inserir a sua password atual";
            } else if (newVal !== confirmVal) {
                Button.disabled = true;
                Button.style.opacity = "0.5";
                Button.textContent = "Palavra passe não coincide!";
            } else {
                Button.disabled = false;
                Button.style.opacity = "1";
                Button.textContent = "Registar";
            }
        });
    } else {
        console.error("Erro: Elemento(s) não encontrado(s)!");
    }
};
