<?php
// index.php - Ponto de entrada da aplicação SmartLearn
define("ACCESS_ALLOWED", true);
require_once '../config.php';
$content = "<h1>Bem-vindo à Plataforma de Cursos</h1><p>Explore os nossos cursos e comece a aprender hoje mesmo!</p>";
include "../src/views/layout/layout_base.html";

?>