window.onload = function() {
    const botaoCheckGratis = document.getElementById("verificarGratuito");

    if ( botaoCheckGratis.checked) {
        console.log("Checkbox marcado: curso gratuito");
        document.getElementById("preco").disabled = true;
        document.getElementById("desconto").disabled = true;
    }
};
