<?php
include("../../../database/basedados.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";
    $nome_categoriaAntigo = "";
    $urlMiniaturaAntiga = "";
    if (!isset($_POST['Id_catEditar']) || empty($_POST['Id_catEditar'])) {
        $textoErro = "Erro na coleta do ID da categoria!";
        $erro = true;
    }

    $idEditar = $_POST['Id_catEditar'];


    $query = "SELECT Nome_cat,Miniatura_cat FROM categoria WHERE Id_categoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idEditar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        

        echo '
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>SmartLearn</title>
                <link rel="stylesheet" href="../../../assets/fontawesome/fontawesome/css/all.min.css" />
                <link rel="stylesheet" href="../../../assets/css/admin/style_admin.css" />
                <link rel="stylesheet" href="../../../assets/css/admin/style_curso_categoria.css" />
            </head>

            <!-- Modal para Editar -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <h2>Editar Curso</h2>
                    <form class="form-content" method="POST" action="alterarCategoria.php" enctype="multipart/form-data">
                        <label for="novoNomeCat">Título da categoria:</label>

                        <input type="text" id="editTitle" name="novoNomeCat" value="' . $row['Nome_cat'] . '" required>

                        <label for="editSubcategories">Miniatura categoria: </label>
                        <div id="subcategoriesContainer">
                        ';
        $sitioImagem = $row['Miniatura_cat'];
        $caminhoImagem = "../../../assets/image/miniatura_cat/" . $sitioImagem;

        if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
            echo '<img src="' . $caminhoImagem . '" alt="Imagem da categoria">';
        } else {
            echo '<img src="../../../assets/image/miniatura_cat/miniatura_default.png" alt="Imagem padrão">';
            echo '<p>Imagem atual não encontrada</p>';
        }
        echo '
                        <div style="display :none" id="divTrocaImagem">
                                    <label for="miniatura">Miniatura da categoria <span>(O tamanho da imagem deve ser 400 x 255)</span></label>
                                    <input type="file" name="url_imagem" id="miniatura" accept=".jpg, .jpeg, .png">
                                </div>
                        </div>
                        <button type="button" id="addSubcategoryBtn" class="btn" onClick= "ativaTrocaImagem()">Alterar imagem</button>

                        <button type="submit" class="btn" name=Id_catEditar value="' . $idEditar . '">Salvar</button>
                        <button type="button" class="btn cancel-btn" onclick="window.history.back()">Cancelar</button>
                    </form>
                </div>
            </div>
            ';
    } else {
        $textoErro = "Erro ao procurar categoria!";
        $erro = true;
    }
} else {
    $erro = true;
    $textoErro = "Pedido não realizado com sucesso!";
}
?>
<?php
if ($erro) {
    echo "<script>alert('" . $textoErro . "');</script>";
    caminho();
}
function caminho()
{
    echo "<script>window.location.href = '../categoria_cursos.php';</script>";
    exit;
}

?>
<script>
    function ativaTrocaImagem() {
        var elemento = document.getElementById('divTrocaImagem')
        addSubcategoryBtn = document.getElementById('addSubcategoryBtn');
        if (elemento.style.display == 'block') {
            elemento.style.display = 'none';
            addSubcategoryBtn.innerHTML = "Alterar imagem";
            

        } else {
            elemento.style.display = 'block';
            addSubcategoryBtn.innerHTML = "cancelar troca de imagem";
        }

        

    }
</script>