<?php


function pesquisaFiltro($tabela, $Id_user, $categoria = null, $textoPesquisa = null)
{
    $sql = "";

    switch ($tabela) {
        case "cursos_adquiridos":
            $sql =  "SELECT * 
                     FROM cursos_adquiridos ca
                     INNER JOIN curso c ON ca.Id_curso = c.Id_curso
                     WHERE ca.Id_user = ?";
            break;

        case "cursos_favoritos":
            $sql =  "SELECT * 
                     FROM cursos_favoritos cf
                     INNER JOIN curso c ON cf.Id_curso = c.Id_curso
                     WHERE cf.Id_user = ?";
            break;

        default:
            return false;
    }

    if ($categoria !== null) {
        $sql .= " AND c.Id_categoria = ?";
    }

    if ($textoPesquisa !== null) {
        $sql .= " AND c.Nome_curso LIKE ?";
    }

    return $sql;
}
?>
