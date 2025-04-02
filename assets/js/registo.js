
  window.onload = function() {
    let passwordInput = document.getElementById("passwordInput");
    let buttonSubmit = document.getElementById("buttonSubmit");

    if (passwordInput && buttonSubmit) {
      passwordInput.addEventListener("input", function() {
        let passwordValue = passwordInput.value;
        let hasSpecialChar = /[^a-zA-Z0-9]/.test(passwordValue); // Testa caracteres especiais

        if (passwordValue.length < 8) {
          buttonSubmit.disabled = true;
          buttonSubmit.style.opacity = "0.5";
          buttonSubmit.textContent = "Password muito curta";
        } else if (!hasSpecialChar) {
          buttonSubmit.disabled = true;
          buttonSubmit.style.opacity = "0.5";
          buttonSubmit.textContent = "Precisa de um caractere especial";
        } else {
          buttonSubmit.textContent = "Registar";
          buttonSubmit.disabled = false;
          buttonSubmit.style.opacity = "1";
        }
      });
    } else {
      console.error("Erro: Elemento não encontrado!");
    }
  };
