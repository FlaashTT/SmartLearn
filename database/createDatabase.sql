-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Jun-2025 às 13:52
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smartlearndb`
--
CREATE DATABASE IF NOT EXISTS `smartlearndb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `smartlearndb`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho_compras`
--

CREATE TABLE IF NOT EXISTS `carrinho_compras` (
  `Id_carrinho` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  PRIMARY KEY (`Id_carrinho`),
  KEY `Id_user` (`Id_user`),
  KEY `Id_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `Id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_cat` varchar(50) NOT NULL,
  `Miniatura_cat` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`Id_categoria`, `Nome_cat`, `Miniatura_cat`) VALUES
(30, 'Programação', 'miniatura_cat30.png'),
(33, 'Eletronica', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes_site`
--

CREATE TABLE IF NOT EXISTS `configuracoes_site` (
  `Id_configuracao` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo_banner` varchar(100) NOT NULL,
  `Subtitulo_banner` varchar(100) NOT NULL,
  `Facebook` varchar(100) DEFAULT NULL,
  `Linkedin` varchar(100) DEFAULT NULL,
  `Id_utilizador_Ultimo_update` int(11) DEFAULT NULL,
  `Cookies_status` varchar(200) DEFAULT NULL,
  `cookie_note` varchar(200) DEFAULT NULL,
  `politica_cookies` text DEFAULT NULL,
  `data_update` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_configuracao`),
  KEY `fk_idUpdater` (`Id_utilizador_Ultimo_update`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `configuracoes_site`
--

INSERT INTO `configuracoes_site` (`Id_configuracao`, `Titulo_banner`, `Subtitulo_banner`, `Facebook`, `Linkedin`, `Id_utilizador_Ultimo_update`, `Cookies_status`, `cookie_note`, `politica_cookies`, `data_update`) VALUES
(1, 'Título exemplo', 'Subtítulo exemplo', 'https://facebook.com/seuPerfil', 'https://linkedin.com/in/seuPerfil', 32, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `Id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_curso` varchar(40) NOT NULL,
  `Id_categoria` int(11) DEFAULT NULL,
  `Id_idioma` int(11) DEFAULT NULL,
  `Criador_curso` int(11) NOT NULL,
  `Data_criacao` date NOT NULL DEFAULT '2025-01-01',
  `URL_foto_perfil_curso` varchar(100) DEFAULT NULL,
  `Pequena_descricao` varchar(100) DEFAULT NULL,
  `Descricao` varchar(1000) DEFAULT NULL,
  `Preco` decimal(10,2) DEFAULT 0.00,
  `Preco_antigo` decimal(10,2) DEFAULT NULL,
  `Estado_curso` enum('Incompleto','ativo','inativo','pendente','Eliminado') NOT NULL,
  `Classificacao` int(11) DEFAULT 0,
  `Num_visitascurso` int(11) DEFAULT 0,
  `Tempo_estimado` time DEFAULT NULL,
  `Dificuldade` enum('Iniciante','intermedio','avançado') DEFAULT NULL,
  `Quantidade_fases` int(11) DEFAULT 0,
  `Requisitos` varchar(100) DEFAULT NULL,
  `Provedor_geral_curso` enum('youtube','tiktok','instagram','linkedin','conta_proria','outro') DEFAULT NULL,
  `URL_geral_curso` varchar(100) DEFAULT NULL,
  `Keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id_curso`),
  KEY `Id_categoria` (`Id_categoria`),
  KEY `Criador_curso` (`Criador_curso`),
  KEY `fk_idioma` (`Id_idioma`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`Id_curso`, `Nome_curso`, `Id_categoria`, `Id_idioma`, `Criador_curso`, `Data_criacao`, `URL_foto_perfil_curso`, `Pequena_descricao`, `Descricao`, `Preco`, `Preco_antigo`, `Estado_curso`, `Classificacao`, `Num_visitascurso`, `Tempo_estimado`, `Dificuldade`, `Quantidade_fases`, `Requisitos`, `Provedor_geral_curso`, `URL_geral_curso`, `Keywords`) VALUES
(23, 'Como fazer um cronometro', 30, 1, 32, '2025-06-25', 'curso_id23.png', 'Cronometro em android Studio', 'Como fazer uma sdfaplicação de um cronometro para telemovel usando java e android Studio', 9.99, 19.99, 'ativo', 2, 21, '00:15:00', 'Iniciante', 0, 'dfg', 'conta_proria', '', ''),
(40, 'testefgh', 30, 1, 32, '2025-06-25', NULL, 'dafg', 'dafg', 50.00, 0.00, 'Eliminado', 0, 0, '01:00:00', 'Iniciante', 0, 'adfg', 'youtube', '', ''),
(41, 'test', NULL, 2, 32, '2025-06-25', NULL, '', '', 0.00, 0.00, 'Incompleto', 0, 0, '00:00:00', '', 0, '', '', NULL, ''),
(42, 'test', NULL, 2, 32, '2025-06-25', NULL, '', '', 0.00, 0.00, 'Eliminado', 0, 0, '00:00:00', '', 0, '', '', NULL, ''),
(43, 'testando mais 1sdf', 30, 3, 32, '2025-06-25', NULL, '', 'sdfxcv', 333.00, 0.00, 'Eliminado', 0, 0, '01:00:00', 'avançado', 0, 'sdfsdsdxcsdf', 'tiktok', 'nmbnv', ''),
(44, 'sdf', NULL, 3, 32, '2025-06-25', NULL, '', '', 0.00, 0.00, 'ativo', 0, 11, '00:00:00', '', 0, 'sdfsd', '', NULL, ''),
(45, 'Fazer um circuito pisca pisca', 33, 1, 32, '2025-06-26', 'curso_id45.png', '', 'Como fazer um circuito pisca pisca com eletronica utilizando um ne555', 0.00, 0.00, 'ativo', 3, 5, '00:10:00', 'Iniciante', 0, '', 'conta_proria', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_adquiridos`
--

CREATE TABLE IF NOT EXISTS `cursos_adquiridos` (
  `Id_adquirido` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `Data_compra` date NOT NULL,
  `Progresso` enum('Por Iniciar','Iniciado','Concluido') DEFAULT 'Iniciado',
  `Percentagem_progresso` int(11) NOT NULL DEFAULT 0,
  `AdicionadoPor` int(11) DEFAULT NULL,
  `Notas` text DEFAULT NULL,
  `Avaliacao` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_adquirido`),
  KEY `fk_curso` (`Id_curso`),
  KEY `fk_user` (`Id_user`),
  KEY `fk_addPor` (`AdicionadoPor`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos_adquiridos`
--

INSERT INTO `cursos_adquiridos` (`Id_adquirido`, `Id_user`, `Id_curso`, `Data_compra`, `Progresso`, `Percentagem_progresso`, `AdicionadoPor`, `Notas`, `Avaliacao`) VALUES
(2, 39, 5, '0000-00-00', 'Iniciado', 0, 39, NULL, NULL),
(3, 39, 6, '0000-00-00', 'Iniciado', 0, 32, NULL, NULL),
(4, 39, 7, '0000-00-00', 'Iniciado', 0, 32, NULL, NULL),
(5, 39, 8, '0000-00-00', 'Iniciado', 0, 32, NULL, NULL),
(6, 39, 9, '0000-00-00', 'Iniciado', 0, 32, NULL, NULL),
(7, 39, 10, '0000-00-00', 'Iniciado', 0, 39, NULL, NULL),
(8, 39, 11, '0000-00-00', 'Iniciado', 0, 32, NULL, NULL),
(9, 39, 13, '0000-00-00', 'Iniciado', 0, 32, NULL, 2),
(10, 32, 13, '0000-00-00', 'Concluido', 80, 32, 'mas este nao', 3),
(20, 32, 2, '2025-06-05', 'Concluido', 100, NULL, NULL, NULL),
(21, 40, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(22, 39, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(23, 41, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(24, 42, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(25, 43, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(26, 44, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(27, 45, 2, '2025-06-05', 'Por Iniciar', 0, NULL, NULL, NULL),
(28, 46, 2, '2025-06-05', 'Por Iniciar', 0, 32, NULL, NULL),
(30, 47, 2, '2025-06-05', 'Por Iniciar', 0, 32, NULL, NULL),
(31, 40, 5, '2025-06-05', 'Por Iniciar', 0, 32, NULL, NULL),
(32, 32, 22, '2025-06-17', 'Concluido', 100, NULL, NULL, NULL),
(33, 32, 5, '2025-06-17', 'Concluido', 100, NULL, NULL, NULL),
(41, 78, 23, '2025-06-26', 'Iniciado', 0, NULL, NULL, NULL),
(43, 32, 23, '2025-06-26', 'Por Iniciar', 50, 32, '', NULL),
(44, 32, 45, '2025-06-26', 'Iniciado', 75, NULL, 'est a a atualiza sozinho', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_favoritos`
--

CREATE TABLE IF NOT EXISTS `cursos_favoritos` (
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `Data_favorito` date DEFAULT NULL,
  PRIMARY KEY (`Id_user`,`Id_curso`),
  KEY `Id_curso` (`Id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos_favoritos`
--

INSERT INTO `cursos_favoritos` (`Id_user`, `Id_curso`, `Data_favorito`) VALUES
(32, 44, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fase`
--

CREATE TABLE IF NOT EXISTS `fase` (
  `Id_fase` int(11) NOT NULL AUTO_INCREMENT,
  `Id_curso` int(11) NOT NULL,
  `Num_fase` int(11) DEFAULT NULL,
  `Titulo_fase` varchar(255) DEFAULT NULL,
  `Conteudo_fase` varchar(500) DEFAULT NULL,
  `Imagem` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_fase`),
  KEY `Id_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fase`
--

INSERT INTO `fase` (`Id_fase`, `Id_curso`, `Num_fase`, `Titulo_fase`, `Conteudo_fase`, `Imagem`, `video`) VALUES
(18, 23, 1, 'Instalar o Android Studio', 'Para instalar o android studio deve ir ao site oficial do mesmo e seguir os passos indicados para a instalação', 'Imagem_fase1_curso23.png', ''),
(26, 23, 2, 'Realizar o cronometro', 'Com a visualização do conteudo audiovisual deve conseguir realizar o cronometro', 'Imagem_fase2_curso23.png', 'video_fase2_curso23.mp4'),
(40, 45, 1, 'Introdução', 'Neste curso ira aprender como montar um circuito pisca pisca com um Ne555 utilizando apenas eletronica.\r\nTodos os componentes utilizados seram descritos\r\nTanto em um meio virtual como um meio fisico', '', ''),
(41, 45, 2, 'Materiais necessarios', 'Tem na imagem todos os componentes necessarios para a montagem', 'Imagem_fase2_curso45.png', ''),
(42, 45, 3, 'Valores dos materiais', 'Resistencia variavel: 47kΩ(ohms).\nCapacitor polarizado : 100 µF(miroFarads).\nResistencias de 1kΩ(ohms), 220Ω(ohms), 330Ω(ohms).\nBateria de 9 volts.', '', ''),
(43, 45, 4, 'Exibição do video ', 'Agora com o video explicativo demonstrando todos os passos consegue realizar a montagem do seu circuito tanto virtualmente como fisicamente', '', 'video_fase4_curso45.mp4'),
(46, 41, 1, 'f2', '', '', ''),
(47, 41, 1, 'f2', '', '', ''),
(48, 41, 2, NULL, NULL, '', ''),
(49, 41, 2, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_compras`
--

CREATE TABLE IF NOT EXISTS `historico_compras` (
  `Id_historicoCompras` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` int(11) NOT NULL,
  `Data_compra` date DEFAULT NULL,
  `Tipo_pagamento` enum('carteira','outro','reembolsado') DEFAULT 'carteira',
  `Id_curso` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_historicoCompras`),
  KEY `Id_user` (`Id_user`),
  KEY `fk_id_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `historico_compras`
--

INSERT INTO `historico_compras` (`Id_historicoCompras`, `Id_user`, `Data_compra`, `Tipo_pagamento`, `Id_curso`) VALUES
(8, 39, '2025-04-15', 'carteira', 3),
(9, 32, '2025-04-16', 'reembolsado', 3),
(10, 32, '2025-04-16', 'carteira', 4),
(11, 32, '2025-05-06', 'carteira', 3),
(12, 32, '2025-05-23', 'carteira', 9),
(13, 32, '2025-06-17', 'carteira', 22),
(14, 32, '2025-06-17', 'carteira', 5),
(15, 32, '2025-06-25', 'reembolsado', 40),
(16, 32, '2025-06-25', 'reembolsado', 40),
(17, 32, '2025-06-25', 'reembolsado', 40),
(18, 32, '2025-06-25', 'reembolsado', 40),
(19, 32, '2025-06-25', 'reembolsado', 40),
(20, 32, '2025-06-25', 'reembolsado', 23),
(21, 78, '2025-06-25', 'reembolsado', 23),
(22, 78, '2025-06-26', 'carteira', 23),
(23, 32, '2025-06-26', 'carteira', 45),
(24, 32, '2025-06-26', 'reembolsado', 44);

-- --------------------------------------------------------

--
-- Estrutura da tabela `idioma`
--

CREATE TABLE IF NOT EXISTS `idioma` (
  `Id_idioma` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_idioma` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_idioma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `idioma`
--

INSERT INTO `idioma` (`Id_idioma`, `Nome_idioma`) VALUES
(1, 'Português'),
(2, 'Ingles'),
(3, 'Espanhol');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs_sistema`
--

CREATE TABLE IF NOT EXISTS `logs_sistema` (
  `Id_log` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) DEFAULT NULL,
  `Descricao_log` text NOT NULL,
  `Tipo_log` enum('Update Curso','Utilizador Matriculado','Informacional','Erro','Aviso','Novo Registo','Deposito de saldo','Levantamento de saldo','Compra curso','Reembolso curso','Conteudo curso alterado','Configurações alteradas','Utilizador Alterado por admin','Fase removida','Curso eliminado','Alteração de curso') NOT NULL,
  `Data_log` datetime NOT NULL,
  `saldo` double DEFAULT 0,
  PRIMARY KEY (`Id_log`),
  KEY `Id_user` (`Id_user`),
  KEY `fk_logs_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `logs_sistema`
--

INSERT INTO `logs_sistema` (`Id_log`, `Id_user`, `Id_curso`, `Descricao_log`, `Tipo_log`, `Data_log`, `saldo`) VALUES
(34, 39, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-04-15 11:06:42', 0),
(42, 32, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 16:23:54', 10),
(43, 32, NULL, 'Foi depositado na conta o valor de 540€ euros', 'Deposito de saldo', '2025-04-15 17:20:26', 540),
(44, 32, NULL, 'Foi depositado na conta o valor de 5€ euros', 'Deposito de saldo', '2025-04-15 17:21:54', 5),
(45, 32, NULL, 'Foi depositado na conta o valor de 2€ euros', 'Deposito de saldo', '2025-04-15 17:32:51', 2),
(46, 32, NULL, 'Foi levantado saldo no valor de 2 € euros', 'Levantamento de saldo', '2025-04-15 18:30:45', 2),
(47, 32, NULL, 'Foi depositado na conta o valor de 200€ euros', 'Deposito de saldo', '2025-04-15 18:35:27', 200),
(48, 32, NULL, 'Foi levantado saldo no valor de 100 € euros', 'Levantamento de saldo', '2025-04-15 18:35:34', 100),
(49, 32, NULL, 'Foi depositado na conta o valor de 100€ euros', 'Deposito de saldo', '2025-04-15 18:35:38', 100),
(50, 32, NULL, 'Foi depositado na conta o valor de 42€ euros', 'Deposito de saldo', '2025-04-15 18:45:55', 42),
(51, 32, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 18:46:01', 10),
(52, 32, NULL, 'Foi levantado saldo no valor de 250 € euros', 'Levantamento de saldo', '2025-04-15 18:46:12', 250),
(53, 32, NULL, 'Foi depositado na conta o valor de 500€ euros', 'Deposito de saldo', '2025-04-16 12:02:37', 500),
(54, 32, NULL, 'O utilizador realizou uma compra no valor de 245.9754 €', 'Compra curso', '2025-04-16 12:06:07', 245.97539999999998),
(55, 32, NULL, 'Foi solicitado reembolso do curso com id3', 'Reembolso curso', '2025-04-16 12:10:31', 99.99),
(56, 32, NULL, 'O utilizador realizou uma compra no valor de 122.9877 €', 'Compra curso', '2025-05-06 12:38:59', 122.98769999999999),
(57, 32, NULL, 'O utilizador realizou uma compra no valor de 49.1877 €', 'Compra curso', '2025-05-23 11:27:39', 49.18770000000001),
(58, 71, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:20:16', NULL),
(59, 72, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:24:48', NULL),
(60, 73, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:25:38', NULL),
(61, 74, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:28:02', NULL),
(62, 75, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:29:16', NULL),
(73, 40, NULL, 'O utilizador com id 40 foi matriculado no de id 2 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-05 15:46:58', NULL),
(74, 40, NULL, 'O utilizador com id 40 foi matriculado no de id 5 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-05 15:49:20', NULL),
(83, 32, 2, 'Correção de erros na aula 1', 'Update Curso', '2024-12-15 10:30:00', 0),
(84, 32, 2, 'Adicionado novo exercício prático na seção 2', 'Update Curso', '2025-01-10 14:45:00', 0),
(85, 32, 2, 'Texto introdutório atualizado', 'Update Curso', '2025-03-05 09:15:00', 0),
(86, 32, 2, 'Vídeo da aula 3 substituído por uma versão em HD', 'Update Curso', '2025-03-20 11:00:00', 0),
(87, 32, 2, 'Atualização do material PDF da seção 4', 'Update Curso', '2025-04-02 08:30:00', 0),
(88, 32, 2, 'Corrigido erro de formatação na descrição da aula 5', 'Update Curso', '2025-04-18 16:10:00', 0),
(89, 32, 2, 'Adicionadas legendas em português na aula 6', 'Update Curso', '2025-05-25 12:45:00', 0),
(90, 32, 2, 'Link externo corrigido na aula 7', 'Update Curso', '2025-06-08 17:25:00', 0),
(91, 32, 2, 'Atualização do material didático da aula 3', 'Update Curso', '2025-03-20 11:00:00', 0),
(92, 32, 2, 'Correção de erros na avaliação final', 'Update Curso', '2025-04-02 15:30:00', 0),
(93, 32, 2, 'Inclusão de vídeo explicativo na aula 4', 'Update Curso', '2025-04-15 09:45:00', 0),
(94, 32, 2, 'Revisão do conteúdo da seção 5', 'Update Curso', '2025-04-28 14:20:00', 0),
(95, 32, 2, 'Atualização do cronograma do curso', 'Update Curso', '2025-05-05 10:10:00', 0),
(96, 32, 2, 'Melhoria no design dos slides', 'Update Curso', '2025-05-15 13:55:00', 0),
(97, 32, 2, 'Adicionado quiz interativo na aula 6', 'Update Curso', '2025-05-25 16:40:00', 0),
(98, 32, 2, 'Correção de links quebrados nas referências', 'Update Curso', '2025-06-01 08:30:00', 0),
(99, 32, 2, 'Atualização dos exemplos práticos da aula 7', 'Update Curso', '2025-06-10 12:15:00', 0),
(100, 32, 2, 'Inclusão de nota de rodapé em material suplementar', 'Update Curso', '2025-06-20 17:50:00', 0),
(101, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLear', 'Erro', '2025-06-16 17:52:28', NULL),
(102, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-16 17:54:44', NULL),
(103, 32, NULL, 'O utilizador realizou uma compra no valor de 61.4877 €', 'Compra curso', '2025-06-17 15:04:57', 61.487700000000004),
(104, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:46:38', NULL),
(105, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:48:14', NULL),
(106, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:56', NULL),
(107, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:57', NULL),
(108, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:57', NULL),
(109, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:50:14', NULL),
(110, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:16', NULL),
(111, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:34', NULL),
(112, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:39', NULL),
(113, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:52:31', NULL),
(114, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:54:02', NULL),
(115, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:55:25', NULL),
(116, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:00:29', NULL),
(117, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:04:41', NULL),
(118, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:05:47', NULL),
(119, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:06:11', NULL),
(120, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:07:17', NULL),
(121, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:19:10', NULL),
(122, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:38:32', NULL),
(123, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:38:49', NULL),
(124, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:39:18', NULL),
(125, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 13:01:30', NULL),
(126, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:55', NULL),
(127, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:57', NULL),
(128, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:58', NULL),
(129, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:58', NULL),
(130, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:59', NULL),
(131, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:00', NULL),
(132, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:11', NULL),
(133, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:12', NULL),
(134, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:12', NULL),
(135, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:13', NULL),
(136, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:13', NULL),
(137, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:14', NULL),
(138, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:15', NULL),
(139, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:37', NULL),
(140, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:39', NULL),
(141, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 16:06:13', NULL),
(142, 78, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-06-23 15:53:39', NULL),
(143, 79, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-06-24 16:51:02', NULL),
(144, 32, NULL, 'Ocorreu um erro: Erro ao eliminar categoria! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\apagarCategoria.php', 'Erro', '2025-06-24 17:12:45', NULL),
(158, 32, NULL, 'Ocorreu um erro: Categoria com esse nome já existe! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionarCategoria.php', 'Erro', '2025-06-25 10:35:04', NULL),
(159, 32, NULL, 'Ocorreu um erro: Categoria com esse nome já existe! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionarCategoria.php', 'Erro', '2025-06-25 10:35:25', NULL),
(177, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:38:52', NULL),
(178, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:40:46', NULL),
(179, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:41:00', NULL),
(180, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:42:15', NULL),
(181, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:42:46', NULL),
(182, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar o video,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:44:58', NULL),
(183, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:45:27', NULL),
(184, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:47:51', NULL),
(185, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:48:19', NULL),
(186, 32, NULL, 'O administrador com Id32 removeu a uma fase do curso com Id:23', 'Fase removida', '2025-06-25 11:53:02', NULL),
(187, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:53:19', NULL),
(188, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:54:04', NULL),
(189, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:55:14', NULL),
(190, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:55:30', NULL),
(191, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:57:03', NULL),
(192, 32, NULL, 'O administrador com Id32 removeu a uma fase do curso com Id:23', 'Fase removida', '2025-06-25 11:57:33', NULL),
(193, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:57:59', NULL),
(194, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:58:15', NULL),
(195, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:59:14', NULL),
(196, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:59:31', NULL),
(197, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 12:00:10', NULL),
(199, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:34', NULL),
(200, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:40', NULL),
(201, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:57', NULL),
(202, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:16:25', NULL),
(203, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:10', NULL),
(204, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:32', NULL),
(205, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:49', NULL),
(206, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:18:58', NULL),
(207, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:19:34', NULL),
(208, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 12:20:21', 0),
(209, 32, NULL, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 13:06:01', 0),
(210, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:24', 0),
(211, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:36', 0),
(212, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:57', 0),
(213, 32, NULL, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 13:11:18', 0),
(214, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:11:32', 0),
(215, 32, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-25 13:13:31', 12.287700000000001),
(219, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:07:31', NULL),
(220, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:08:03', NULL),
(221, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:43', 'Curso eliminado', '2025-06-25 15:14:46', NULL),
(222, 32, 42, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:22:55', NULL),
(223, 32, NULL, 'Foram alteradas informações do curso com id', '', '2025-06-25 15:53:19', NULL),
(224, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(225, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(226, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(227, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(228, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(229, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(230, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(231, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(232, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(233, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(234, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(235, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(236, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(237, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(238, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(239, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(240, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(241, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(242, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL),
(243, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(244, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(245, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(246, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(247, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(248, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(249, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(250, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(251, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(252, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(253, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(254, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(255, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(256, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL),
(257, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(258, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(259, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(260, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(261, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(262, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(263, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(264, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(265, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(266, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(267, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(268, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(269, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL),
(270, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL),
(271, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL),
(272, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL),
(273, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL),
(274, 32, 43, 'Foram alteradas informações do curso com id43', '', '2025-06-25 16:32:42', NULL),
(275, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:33:14', NULL),
(276, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:33:29', NULL),
(277, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:34:58', NULL),
(278, 32, 40, 'Foram alteradas informações do curso com id40', '', '2025-06-25 16:35:29', NULL),
(279, 32, 23, 'Foram alteradas informações do curso com id23', '', '2025-06-25 16:36:47', NULL),
(280, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:36:51', NULL),
(281, 32, 23, 'Foram alteradas informações do curso com id23', '', '2025-06-25 16:37:05', NULL),
(282, 32, 43, 'O administrador com Id:32 removeu o curso com Id:43', 'Curso eliminado', '2025-06-25 16:37:42', NULL),
(283, 32, 40, 'Foram alteradas informações do curso com id40', '', '2025-06-25 16:40:46', NULL),
(284, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-25 16:41:17', NULL),
(285, 32, 40, 'Foram alteradas informações do curso com id40', 'Alteração de curso', '2025-06-25 16:44:21', NULL),
(286, 32, 40, 'O administrador com Id:32 removeu o curso com Id:40', 'Curso eliminado', '2025-06-25 16:44:44', NULL),
(287, 32, 23, 'Foi solicitado reembolso do curso com id23', 'Reembolso curso', '2025-06-25 17:09:12', 9.99),
(288, 32, 40, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 17:09:15', 50),
(289, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:09:22', NULL),
(290, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:28', NULL),
(291, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:38', NULL),
(292, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:47', NULL),
(293, 78, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-06-26 11:03:15', 10),
(294, 78, NULL, 'Foi depositado na conta o valor de 5€ euros', 'Deposito de saldo', '2025-06-26 11:04:14', 5),
(295, 78, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-26 11:04:32', 12.287700000000001),
(296, 78, 23, 'Foi solicitado reembolso do curso com id23', 'Reembolso curso', '2025-06-26 12:05:17', 9.99),
(297, 78, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-26 12:19:48', 12.287700000000001),
(298, 32, 23, 'O utilizador com id 32 foi matriculado no curso de id 23 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:18:53', NULL),
(299, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:00', NULL),
(300, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:19', NULL),
(301, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:20', NULL),
(302, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:21', NULL),
(303, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:22', NULL),
(304, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:23', NULL),
(305, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL),
(306, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL),
(307, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL),
(308, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL),
(309, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL),
(310, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL),
(311, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:26', NULL),
(312, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:41', NULL),
(313, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:56', NULL),
(315, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:21:42', NULL),
(316, 32, 23, 'O utilizador com id 32 foi matriculado no curso de id 23 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:23:09', NULL),
(317, 32, 45, 'Foi adicionado um novo curso(45) pelo administrador com ID: 32', '', '2025-06-26 17:44:23', NULL),
(318, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar o video,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:05:58', NULL),
(319, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:11:26', NULL),
(320, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:11:59', NULL),
(321, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:12:05', NULL),
(322, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:15:24', NULL),
(323, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:33', NULL),
(324, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:40', NULL),
(325, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:46', NULL),
(326, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:51', NULL),
(327, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:20:42', NULL),
(328, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:21:45', NULL),
(329, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:22:55', NULL),
(330, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:37:21', NULL),
(331, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:41:50', NULL),
(332, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:43:34', NULL),
(333, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:44:21', NULL),
(334, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:45:10', NULL),
(335, 32, NULL, 'Ocorreu um erro: O arquivo não existe. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\remover_midia.php', 'Erro', '2025-06-26 18:46:41', NULL),
(336, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:52:39', NULL),
(337, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:55:43', NULL),
(338, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:57:03', NULL),
(339, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:57:29', NULL),
(340, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:58:21', NULL),
(341, 32, 45, 'Foram alteradas informações do curso com id45', 'Alteração de curso', '2025-06-26 18:59:49', NULL),
(342, 32, 45, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:01:01', NULL),
(343, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:01:10', NULL),
(344, 32, 45, 'Foram alteradas informações do curso com id45', 'Alteração de curso', '2025-06-26 19:02:05', NULL),
(345, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:02:13', NULL),
(346, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-26 19:07:38', NULL),
(347, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-26 19:07:43', NULL),
(348, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:07:49', NULL),
(349, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:07:59', NULL),
(350, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-26 19:36:11', 0),
(351, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-26 19:57:48', 0),
(352, 32, 44, 'Foi solicitado reembolso do curso com id44', 'Reembolso curso', '2025-06-26 20:00:39', 0),
(353, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 11:14:46', NULL),
(354, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 11:14:51', NULL),
(355, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 11:15:36', NULL),
(356, 32, NULL, 'Ocorreu um erro: O utilizador vb@gmail.com / Ruben Bras já está matriculado no curso Como fazer um cronometro. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\realizaMatricular.php', 'Erro', '2025-06-27 12:20:05', NULL),
(357, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-27 12:20:07', NULL),
(358, 32, NULL, 'Foi alterado dados do utilizador com Id: 41 pelo administrador com ID:32', 'Utilizador Alterado por admin', '2025-06-27 12:23:04', NULL),
(359, 32, NULL, 'Ocorreu um erro: Método de requisição inválido. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarUtilizador.php', 'Erro', '2025-06-27 12:23:06', NULL),
(360, 32, NULL, 'Ocorreu um erro: Método de requisição inválido. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarUtilizador.php', 'Erro', '2025-06-27 12:23:07', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `midia`
--
-- Erro ao ler a estrutura para a tabela smartlearndb.midia: #1932 - Table &#039;smartlearndb.midia&#039; doesn&#039;t exist in engine
-- Erro ao ler dados para tabela smartlearndb.midia: #1064 - Você tem um erro de sintaxe no seu SQL próximo a &#039;FROM `smartlearndb`.`midia`&#039; na linha 1

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas_forms`
--

CREATE TABLE IF NOT EXISTS `perguntas_forms` (
  `Id_pergunta` int(11) NOT NULL AUTO_INCREMENT,
  `Texto_pergunta` varchar(200) NOT NULL,
  PRIMARY KEY (`Id_pergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_forms`
--

CREATE TABLE IF NOT EXISTS `resposta_forms` (
  `Id_resposta` int(11) NOT NULL AUTO_INCREMENT,
  `Id_user` int(11) DEFAULT NULL,
  `Data_submissao` datetime NOT NULL,
  PRIMARY KEY (`Id_resposta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_perguntas`
--

CREATE TABLE IF NOT EXISTS `resposta_perguntas` (
  `Id_perguntaRespondida` int(11) NOT NULL AUTO_INCREMENT,
  `Id_resposta` int(11) NOT NULL,
  `Id_pergunta` int(11) NOT NULL,
  `Texto_resposta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id_perguntaRespondida`),
  KEY `Id_resposta` (`Id_resposta`),
  KEY `Id_pergunta` (`Id_pergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `Id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) NOT NULL,
  `Descricao` varchar(150) NOT NULL,
  `Estado_ticket` enum('Por Responder','Respondido') DEFAULT 'Por Responder',
  PRIMARY KEY (`Id_ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Id_user` int(11) NOT NULL AUTO_INCREMENT,
  `PNome_user` varchar(20) NOT NULL,
  `SNome_user` varchar(20) DEFAULT NULL,
  `Estado_conta` enum('Ativo','Eliminado') NOT NULL DEFAULT 'Ativo',
  `Biografia` varchar(200) DEFAULT NULL,
  `Password` varchar(64) NOT NULL,
  `Data_criacao` date NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Tipo_user` enum('Admin','Cliente','Main-admin') NOT NULL DEFAULT 'Cliente',
  `Carteira` decimal(10,2) DEFAULT 0.00,
  `URL_facebook` varchar(100) DEFAULT NULL,
  `URL_youtube` varchar(100) DEFAULT NULL,
  `URL_linkedin` varchar(100) DEFAULT NULL,
  `URL_foto_perfilUser` varchar(100) DEFAULT NULL,
  `Estado_cookies_user` enum('Aceite','Nao aceite','','') NOT NULL DEFAULT 'Nao aceite',
  PRIMARY KEY (`Id_user`),
  UNIQUE KEY `unique_email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id_user`, `PNome_user`, `SNome_user`, `Estado_conta`, `Biografia`, `Password`, `Data_criacao`, `Email`, `Tipo_user`, `Carteira`, `URL_facebook`, `URL_youtube`, `URL_linkedin`, `URL_foto_perfilUser`, `Estado_cookies_user`) VALUES
(32, 'Ruben', 'Bras', 'Ativo', 'teste', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-04-02', 'vb@gmail.com', 'Admin', 99999936.02, 'testeee', 'teste', 'test', 'fotoPerfil_32.png', 'Aceite'),
(39, 'teste', 'teste', 'Ativo', NULL, '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '2025-04-15', 'teste@gmail.com', 'Cliente', 77.01, NULL, NULL, NULL, NULL, 'Nao aceite'),
(40, 'ana', 'gomes', 'Ativo', NULL, 'senha123', '2024-01-10', 'ana.gomes@example.com', 'Cliente', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(41, 'Bruno', 'Ferreiras', 'Ativo', NULL, '123bruno', '2024-02-15', 'bruno.ferreira@example.com', 'Main-admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(42, 'Carla', 'Santos', 'Eliminado', NULL, 'carlaPass', '2024-03-20', 'carla.santos@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(43, 'Daniel', 'Oliveira', 'Ativo', NULL, 'dan1234', '2024-01-05', 'daniel.oliveira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(44, 'Eduarda', 'Martins', 'Ativo', NULL, 'edupass', '2024-02-22', 'eduarda.martins@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(45, 'Filipe', 'Costa', 'Ativo', NULL, 'filipeC0d3', '2024-04-01', 'filipe.costa@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(46, 'Gabriela', 'Rocha', 'Ativo', NULL, 'gabriela123', '2024-03-18', 'gabriela.rocha@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(47, 'Henrique', 'Lopes', 'Ativo', NULL, 'henriquePass', '2024-05-01', 'henrique.lopes@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(48, 'Inês', 'Pereira', 'Ativo', NULL, 'ines321', '2024-05-10', 'ines.pereira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(49, 'João', 'Vieira', 'Ativo', NULL, 'joao_123', '2024-01-25', 'joao.vieira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(50, 'Kátia', 'andrade', 'Ativo', NULL, 'katia456', '2024-04-12', 'katia.gomes@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(51, 'Lucas', 'Ribeiro', 'Ativo', NULL, 'lucasPass', '2024-03-05', 'lucas.ribeiro@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(52, 'Mariana', 'Carvalho', 'Ativo', NULL, 'mariC123', '2024-02-28', 'mariana.carvalho@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(53, 'Nuno', 'Teixeira', 'Eliminado', NULL, 'nuno777', '2024-01-17', 'nuno.teixeira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(54, 'Olívia', 'Sousa', 'Eliminado', NULL, 'olivia999', '2024-03-30', 'olivia.sousa@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite'),
(78, 'ola', 'soueu', 'Ativo', NULL, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-06-23', 'eu@gmail.com', 'Cliente', 0.41, NULL, NULL, NULL, NULL, 'Nao aceite'),
(79, 'teste', '123', 'Ativo', NULL, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-06-24', 'testeasyhfbs@gmail.com', 'Cliente', 0.00, NULL, NULL, NULL, NULL, 'Nao aceite');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho_compras`
--
ALTER TABLE `carrinho_compras`
  ADD CONSTRAINT `carrinho_compras_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `user` (`Id_user`),
  ADD CONSTRAINT `carrinho_compras_ibfk_2` FOREIGN KEY (`Id_curso`) REFERENCES `curso` (`Id_curso`);

--
-- Limitadores para a tabela `configuracoes_site`
--
ALTER TABLE `configuracoes_site`
  ADD CONSTRAINT `fk_idUpdater` FOREIGN KEY (`Id_utilizador_Ultimo_update`) REFERENCES `user` (`Id_user`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`Id_categoria`) REFERENCES `categoria` (`Id_categoria`),
  ADD CONSTRAINT `fk_idioma` FOREIGN KEY (`Id_idioma`) REFERENCES `idioma` (`Id_idioma`);

--
-- Limitadores para a tabela `cursos_adquiridos`
--
ALTER TABLE `cursos_adquiridos`
  ADD CONSTRAINT `cursos_adquiridos_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `user` (`Id_user`),
  ADD CONSTRAINT `cursos_adquiridos_ibfk_2` FOREIGN KEY (`Id_curso`) REFERENCES `curso` (`Id_curso`),
  ADD CONSTRAINT `fk_addPor` FOREIGN KEY (`AdicionadoPor`) REFERENCES `user` (`Id_user`),
  ADD CONSTRAINT `fk_adicionadoPor` FOREIGN KEY (`AdicionadoPor`) REFERENCES `user` (`Id_user`),
  ADD CONSTRAINT `fk_curso` FOREIGN KEY (`Id_curso`) REFERENCES `curso` (`Id_curso`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`Id_user`) REFERENCES `user` (`Id_user`);

--
-- Limitadores para a tabela `fase`
--
ALTER TABLE `fase`
  ADD CONSTRAINT `fk_fase_curso` FOREIGN KEY (`Id_curso`) REFERENCES `curso` (`Id_curso`);

--
-- Limitadores para a tabela `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD CONSTRAINT `fk_logs_curso` FOREIGN KEY (`Id_curso`) REFERENCES `curso` (`Id_curso`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
