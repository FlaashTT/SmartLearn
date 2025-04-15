window.onload = function () {
    const levantarSaldo = document.getElementById("levantarSaldo");
    const btnLevantarSaldo = document.getElementById("btnLevantarSaldo");

    const adicionarSaldo = document.getElementById("adicionarSaldo");
    const btnAdicionarSaldo = document.getElementById("btnAdicionarSaldo");

    const form = document.querySelector("form"); // se houver um form

    function atualizarCampos() {
        const valorAdicionar = adicionarSaldo.value.trim();
        const valorLevantar = levantarSaldo.value.trim();

        // Se estiver a adicionar saldo, bloqueia levantamento
        if (valorAdicionar !== "") {
            levantarSaldo.disabled = true;
            btnLevantarSaldo.disabled = true;
            btnLevantarSaldo.style.opacity = "0.5";

            adicionarSaldo.disabled = false;
            btnAdicionarSaldo.disabled = false;
            btnAdicionarSaldo.style.opacity = "1";
        } else {
            levantarSaldo.disabled = false;
            verificarSaldo(); // força verificação antes de reabilitar botão
        }

        // Se estiver a levantar saldo, bloqueia adicionar
        if (valorLevantar !== "") {
            adicionarSaldo.disabled = true;
            btnAdicionarSaldo.disabled = true;
            btnAdicionarSaldo.style.opacity = "0.5";
        } else if (valorAdicionar === "") {
            // Apenas ativa adicionar se não houver texto nos dois campos
            adicionarSaldo.disabled = false;
            btnAdicionarSaldo.disabled = false;
            btnAdicionarSaldo.style.opacity = "1";
        }
    }

    function verificarSaldo() {
        const saldoElemento = document.getElementById("saldo");
        const valorTexto = saldoElemento.querySelector("strong").innerText;

        const saldoAtual = parseFloat(valorTexto.replace(',', '.'));
        const valorInputTexto = levantarSaldo.value.trim().replace(',', '.');

        if (valorInputTexto === "" || valorInputTexto === "0") {
            // Se for vazio ou zero, sai da função sem mexer nos botões
            btnLevantarSaldo.disabled = false;
            btnLevantarSaldo.textContent = "Levantar";
            btnLevantarSaldo.style.opacity = "1";
            return;
        }

        const valorInput = parseFloat(valorInputTexto);

        // Se o valor for inválido ou maior que o saldo
        if (isNaN(valorInput) || valorInput > saldoAtual || valorInput <= 0) {
            btnLevantarSaldo.disabled = true;
            btnLevantarSaldo.textContent = "Quantia inválida ou insuficiente";
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
                if (btnLevantarSaldo.disabled && btnAdicionarSaldo.disabled) {
                    e.preventDefault();
                }
            });
        }
    } else {
        alert("Erro: campos não foram encontrados.");
    }
};
