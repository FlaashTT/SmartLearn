window.onload = function () {
    const campoTexto = document.getElementById("pesquisaCat");
    const mensagemErro = document.getElementById("mensagemErro");

    campoTexto.addEventListener("input", pesquisa);

    function pesquisa() {
        const valor = campoTexto.value.toLowerCase().trim();
        const categorias = document.querySelectorAll(".catLabel");
        let encontrouCat = false;

        categorias.forEach(function (label) {
            const nome = label.getAttribute("data-nome").toLowerCase();
            if (nome.includes(valor)) {
                label.style.display = "block";
                encontrouCat = true;
            } else {
                label.style.display = "none";
            }
        });

        mensagemErro.style.display = encontrouCat ? "none" : "block";
    }

    // responsável pelos valores editáveis de preço max e min
    const mensagemErroPreco = document.getElementById("mensagemErroPreco");
    const btn = document.querySelector(".btn-ok");
    const minInput = document.getElementById("precoMin");
    const maxInput = document.getElementById("precoMax");
    const produtos = document.querySelectorAll(".produto");

    btn.addEventListener("click", function () {
        const min = parseFloat(minInput.value) || 0;
        const max = parseFloat(maxInput.value) || Infinity;
        let encontrouPreco = false;

        produtos.forEach(function (produto) {
            const preco = parseFloat(produto.dataset.preco);
            if (preco >= min && preco <= max) {
                produto.style.display = "block";
                encontrouPreco = true;
            } else {
                produto.style.display = "none";
            }
        });

        if (!encontrouPreco) {
            alert("Nenhum produto encontrado nesse intervalo de preço.");
        }
        mensagemErroPreco.style.display = encontrouPreco ? "none" : "block";
    });
};



window.efetuarPesquisa = function (el, tipo) {
    const produtos = document.querySelectorAll(".produto");

    const [categoria, valor] = tipo.split("_");

    // Coletar todos os idiomas e descontos selecionados
    const idiomasSelecionados = Array.from(document.querySelectorAll("input[name='idioma[]']:checked"))
        .map(input => input.value);

    const descontoSelecionado = Array.from(document.querySelectorAll("input[name='desconto[]']:checked"))
        .map(input => input.value);

    let encontrouProduto = false;

    // Lógica para mostrar todos os produtos caso nenhum filtro seja selecionado
    if (idiomasSelecionados.length === 0 && descontoSelecionado.length === 0) {
        produtos.forEach(function (produto) {
            produto.style.display = "block";
        });
        return;
    }

    
    // Loop para verificar as condições dos filtros
    produtos.forEach(function (produto) {
        const idioma = produto.getAttribute("data-idioma").toLowerCase();
        const desconto = produto.getAttribute("data-desconto");

        switch (categoria) {
            case "idioma":
                if (idiomasSelecionados.some(id => idioma.includes(id))) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }
                break;

            case "desconto":
                
                // Lógica especial para "Mostrar tudo"
                if (descontoSelecionado.includes("ambos")) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                    break;
                }

                if (descontoSelecionado.includes(desconto)) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }
                break;


            case "dificuldade":

                break;

            case "tempo":

                break;

            case "avaliacao":

                break;

            case "categoria":

                break;

            case "Preco":

                break;

            default:
                console.log("Categoria não reconhecida:", categoria);
                break;
        }

    });
};




