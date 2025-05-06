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

    const dificuldadeSelecionado = Array.from(document.querySelectorAll("input[name='dificuldade[]']:checked"))
        .map(input => input.value);

    const duracaoSelecionado = Array.from(document.querySelectorAll("input[name='duracao[]']:checked"))
        .map(input => input.value);

    const avaliacaoSelecionado = Array.from(document.querySelectorAll("input[name='avaliacao[]']:checked"))
        .map(input => input.value);

    const categoriaSelecionado = Array.from(document.querySelectorAll("input[name='categoria[]']:checked"))
        .map(input => input.value);

    const precoSelecionado = Array.from(document.querySelectorAll("input[name='preco[]']:checked"))
        .map(input => input.value);

    let encontrouProduto = false;

    // Lógica para mostrar todos os produtos caso nenhum filtro seja selecionado
    if (idiomasSelecionados.length === 0
        && descontoSelecionado.length === 0
        && dificuldadeSelecionado.length === 0
        && duracaoSelecionado.length === 0
        && avaliacaoSelecionado.length === 0
        && categoriaSelecionado.length === 0
        && precoSelecionado.length === 0) {
        produtos.forEach(function (produto) {
            produto.style.display = "block";
        });
        return;
    }

    // Loop para verificar as condições dos filtros
    produtos.forEach(function (produto) {
        const idioma = produto.getAttribute("data-idioma").toLowerCase();
        const desconto = produto.getAttribute("data-desconto");
        const dificuldade = produto.getAttribute("data-dificuldade");
        const duracao = produto.getAttribute("data-duracao");
        const avaliacao = produto.getAttribute("data-avaliacao");
        const categoriaSeleçao = produto.getAttribute("data-categoria");
        const preco = produto.getAttribute("data-preco");


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
                console.log(" entrou dificuldade")

                if (dificuldadeSelecionado.includes(dificuldade)) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }
                break;

            case "tempo":
                console.log(" entrou tempo")

                const [horas, minutos, segundos] = duracao.split(":").map(Number);
                const tempoSegundos = horas * 3600 + minutos * 60 + segundos;

                let corresponde = false;

                duracaoSelecionado.forEach(filtro => {
                    switch (filtro) {
                        case "menos1h":
                            if (tempoSegundos <= 3600) corresponde = true;
                            break;
                        case "1ha3h":
                            if (tempoSegundos > 3600 && tempoSegundos <= 10800) corresponde = true;
                            break;
                        case "3ha6h":
                            if (tempoSegundos > 10800 && tempoSegundos <= 21600) corresponde = true;
                            break;
                        case "de6a17h":
                            if (tempoSegundos > 21600 && tempoSegundos <= 61200) corresponde = true;
                            break;
                        case "mais17":
                            if (tempoSegundos > 61200) corresponde = true;
                            break;
                    }
                });

                if (corresponde) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }
                break;


            case "avaliacao":


                if (avaliacaoSelecionado.includes(avaliacao)) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }

                break;

            case "categoria":


                if (categoriaSelecionado.includes(categoriaSeleçao)) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }

                break;

            case "preco":


                
                const precoProduto = parseFloat(preco);

                let correspondePreco = false;

                precoSelecionado.forEach(filtro => {
                    switch (filtro) {
                        case "gratuito":
                            if (precoProduto === 0) correspondePreco = true;
                            break;
                        case "ate30":
                            if (precoProduto <= 30) correspondePreco = true;
                            break;
                        case "de30a60":
                            if (precoProduto > 30 && precoProduto <= 60) correspondePreco = true;
                            break;
                        case "maisde60":
                            if (precoProduto > 60) correspondePreco = true;
                            break;
                    }
                });

                // Se o preço corresponder ao filtro, mostre o produto
                if (correspondePreco) {
                    produto.style.display = "block";
                    encontrouProduto = true;
                } else {
                    produto.style.display = "none";
                }

                break;


            default:
                console.log("Erro ao verificar");
                break;
        }

    });
};







