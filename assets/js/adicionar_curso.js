window.onload = function() {
    const verificarDesconto = document.getElementById("verificarDesconto");
    const verificarGratuito = document.getElementById("verificarGratuito");
    const desconto = document.getElementById("desconto");
    const preco = document.getElementById("preco");

    function atualizarEstadoCampos() {
        if (verificarGratuito.checked) {
            // Curso gratuito: desabilita preço e desconto
            preco.disabled = true;
            desconto.disabled = true;
        } else {
            // Curso pago: preço habilitado
            preco.disabled = false;

            // Desconto habilitado só se o checkbox estiver marcado
            desconto.disabled = !verificarDesconto.checked;
        }
    }

    // Quando mudar o checkbox de desconto
    verificarDesconto.addEventListener('change', atualizarEstadoCampos);

    // Quando mudar o checkbox de gratuito
    verificarGratuito.addEventListener('change', atualizarEstadoCampos);

    // Estado inicial na carga da página
    atualizarEstadoCampos();
};
