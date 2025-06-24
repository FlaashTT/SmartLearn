
<?php
include("../../../database/basedados.php");
include("inserirImagemCat.php");
require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";
    $alteracaoFeita = false;



    if (!isset($_POST['Id_catEditar']) || empty($_POST['Id_catEditar'])) {
        $textoErro = "Nao foi possivel encontrar o ID da categoria!";
        $erro = true;
    }
    $idCategoria = $_POST['Id_catEditar'];

    $query = "SELECT Nome_cat,Miniatura_cat FROM categoria WHERE Id_categoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idCategoria);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome_categoriaAntigo = $row['Nome_cat'];
    } else {
        $textoErro = "Erro ao coletar o nome da categoria!";
        $erro = true;
    }

    if (isset($_POST['novoNomeCat']) && !empty(trim($_POST['novoNomeCat']))) {
        $NovoNome_categoria = $_POST['novoNomeCat'];
        //verificar se o  nome é igual ao anterior

        if ($NovoNome_categoria != $nome_categoriaAntigo) {
            $query = "UPDATE categoria SET Nome_cat = ? WHERE Id_categoria = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $NovoNome_categoria, $idCategoria);
            if ($stmt->execute()) {
                $alteracaoFeita = true;
            } else {
                $textoErro = "Erro ao atualizar o nome da categoria!";
                $erro = true;
            }
        }
    }

    if (!empty($_FILES['url_imagem']['name'])) {

        // verificar se já existe imagem na base de dados
        if (empty($row['Miniatura_cat'])) {
            inserirImagem($conn, $idCategoria);
            $alteracaoFeita = true;
        } else {

            $file = "../../../assets/image/miniatura_cat/" . $row['Miniatura_cat'];

            if (file_exists($file)) {

                if (unlink($file)) {
                    echo "<script>alert('Imagem antiga removida com sucesso.');</script>";
                    inserirImagem($conn, $idCategoria);
                    $alteracaoFeita = true;
                } else {
                    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, $idCategoria, "Erro ao remover a imagem antiga da categoria", __FILE__);
                }
            } else {
                $textoErro = "Imagem antiga não encontrada.";
                $erro = true;
            }
        }

        $alteracaoFeita = true;
    }
} else {
    $textoErro = "Erro ao coletar o id da categoria!";
    $erro = true;
}

if (!$erro && $alteracaoFeita) {

    # mostrarPopUp('Alteração feita com sucesso!');
    criarLogs("Categoria alterada", $_SESSION['utilizadorOn']['Id_user'], null, null, $idCategoria);
} elseif (!$alteracaoFeita) {

    # mostrarPopUp('Nenhuma alteração foi feita!');
}

if ($erro) {
    # mostrarPopUp($textoErro);
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, $idCategoria, $textoErro, __FILE__);
}

function caminho()
{
    echo "
    <script>
    window.location.href = '../categoria_cursos.php';
    </script>";
    exit();
}
?>