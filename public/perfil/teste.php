<?php
include("pesquisa.php");

$sql = pesquisaFiltro("cursos_favorito", "32");

echo "<h1>SQL Gerado:</h1>";
echo "<p>" . htmlspecialchars($sql) . "</p>";
?>
