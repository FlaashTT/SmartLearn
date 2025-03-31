<?php

/*
Os define() no PHP são usados para criar constantes, ou seja, valores que não podem ser alterados durante a execução do código.
Na plataforma de cursos online, os define() são úteis para armazenar configurações importantes, como credenciais da base de dados, URLs e parâmetros de segurança.
*/

// Evitar acesso direto ao ficheiro
if (!defined('ACCESS_ALLOWED')) {
    die('Acesso negado.');
}

// ⚙️ Configurações da Base de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'smartlearn');
define('DB_USER', 'root');
define('DB_PASS', '');

// 🌍 Configuração Global
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/smartlearn/');

define('SITE_NAME', 'SmartLearn');

// 📁 Caminhos Importantes
define('ASSETS_PATH', BASE_URL . 'assets/');
define('LOGS_PATH', __DIR__ . 'logs/'); // Mantido como diretório interno

// 🛠 Configuração de Erros (Ativar apenas em ambiente de desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
