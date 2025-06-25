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
            if ($categoria !== null) {
                $sql .= " AND c.Id_categoria = ?";
            }
            if ($textoPesquisa !== null) {
                $sql .= " AND c.Nome_curso LIKE ?";
            }
            break;

        case "cursos_favoritos":
            $sql =  "SELECT * 
                     FROM cursos_favoritos cf
                     INNER JOIN curso c ON cf.Id_curso = c.Id_curso
                     WHERE cf.Id_user = ?";
            if ($categoria !== null) {
                $sql .= " AND c.Id_categoria = ?";
            }
            if ($textoPesquisa !== null) {
                $sql .= " AND c.Nome_curso LIKE ?";
            }
            break;

        case "logs_sistema":
            $sql =  "SELECT * 
             FROM logs_sistema
             WHERE Id_user = ?
             AND Tipo_Log IN ('Depósito de saldo', 'Levantamento de saldo', 'Compra curso', 'Reembolso curso')";

            if ($textoPesquisa !== null) {
                $sql .= " AND (Data_log LIKE ? OR Tipo_log LIKE ? OR saldo LIKE ?)";
            }

            $sql .= " ORDER BY Data_log DESC";
            break;

        default:
            return false;
    }

    return $sql;
}
