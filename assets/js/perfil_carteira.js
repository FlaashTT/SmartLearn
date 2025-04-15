window.onload = function () {
    const levantarSaldo = document.getElementById("levantarSaldo");
    const btnLevantarSaldo = document.getElementById("btnLevantarSaldo");

    const adicionarSaldo = document.getElementById("adicionarSaldo");
    const btnAdicionarSaldo = document.getElementById("btnAdicionarSaldo");

    const form = document.querySelector("form"); // se houver um form

    function atualizarCampos() {
        // Se estiver a adicionar saldo, bloqueia levantamento
        if (adicionarSaldo.value.trim() !== "") {
            levantarSaldo.disabled = true;
            btnLevantarSaldo.disabled = true;
            btnLevantarSaldo.style.opacity = "0.5";
        } else {
            levantarSaldo.disabled = false;
            verificarSaldo(); // força verificação antes de reabilitar botão
        }

        // Se estiver a levantar saldo, bloqueia adicionar
        if (levantarSaldo.value.trim() !== "") {
            adicionarSaldo.disabled = true;
            btnAdicionarSaldo.disabled = true;
            btnAdicionarSaldo.style.opacity = "0.5";
        } else {
            adicionarSaldo.disabled = false;
            btnAdicionarSaldo.disabled = false;
            btnAdicionarSaldo.style.opacity = "1";
        }
    }

    function verificarSaldo() {
        const saldoElemento = document.getElementById("saldo");
        const valorTexto = saldoElemento.querySelector("strong").innerText;

        const saldoAtual = parseFloat(valorTexto.replace(',', '.'));
        const valorInput = parseFloat(levantarSaldo.value.replace(',', '.'));

        // Verificações robustas
        if (
            isNaN(valorInput) ||
            valorInput <= 0 ||
            valorInput > saldoAtual
        ) {
            btnLevantarSaldo.disabled = true;
            btnLevantarSaldo.textContent = "Quantia insuficiente";
            btnLevantarSaldo.style.opacity = "0.5";
        } else {
            btnLevantarSaldo.disabled = false;
            btnLevantarSaldo.textContent = "Levantar";
            btnLevantarSaldo.style.opacity = "1";
        }
    }

    if (levantarSaldo && adicionarSaldo && btnLevantarSaldo && btnAdicionarSaldo) {
        levantarSaldo.addEventListener("input", function () {
            verificarSaldo();
            atualizarCampos();
        });

        adicionarSaldo.addEventListener("input", atualizarCampos);
        atualizarCampos();

        // Impede envio se o botão estiver desabilitado
        if (form) {
            form.addEventListener("submit", function (e) {
                if (btnLevantarSaldo.disabled) {
                    e.preventDefault();
                }
            });
        }
    } else {
        alert("Erro: campos não foram encontrados.");
    }
};
