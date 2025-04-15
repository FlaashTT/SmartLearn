window.onload = function () {
    let levantarSaldo = document.getElementById("levantarSaldo");
    let btnLevantarSaldo = document.getElementById("btnLevantarSaldo");

    let adicionarSaldo = document.getElementById("adicionarSaldo");
    let btnAdicionarSaldo = document.getElementById("btnAdicionarSaldo");

    function atualizarCampos() {
        if (adicionarSaldo.value !== "") {
            levantarSaldo.disabled = true;
            btnLevantarSaldo.disabled = true;
            btnLevantarSaldo.style.opacity = "0.5";
        } else {
            levantarSaldo.disabled = false;
            btnLevantarSaldo.disabled = false;
            btnLevantarSaldo.style.opacity = "1";
        }

        if (levantarSaldo.value !== "") {
            adicionarSaldo.disabled = true;
            btnAdicionarSaldo.disabled = true;
            btnAdicionarSaldo.style.opacity = "0.5";
        } else {
            adicionarSaldo.disabled = false;
            btnAdicionarSaldo.disabled = false;
            btnAdicionarSaldo.style.opacity = "1";
        }
    }

    if (levantarSaldo && adicionarSaldo && btnAdicionarSaldo && btnLevantarSaldo) {
        levantarSaldo.addEventListener("input", atualizarCampos);
        adicionarSaldo.addEventListener("input", atualizarCampos);
        atualizarCampos(); 
    } else {
        alert("Dados não alcançados");
    }
};
