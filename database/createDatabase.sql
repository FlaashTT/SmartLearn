-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Jun-2025 às 17:24
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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `Id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_cat` varchar(50) NOT NULL,
  `Num_visitasCat` int(11) DEFAULT 0,
  `Quantidade_cursos` int(11) NOT NULL DEFAULT 0,
  `Miniatura_cat` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`Id_categoria`, `Nome_cat`, `Num_visitasCat`, `Quantidade_cursos`, `Miniatura_cat`) VALUES
(1, 'tecnologia', 0, 1, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Estado_curso` enum('Incompleto','ativo','inativo','pendente') NOT NULL,
  `Classificacao` int(11) DEFAULT 0,
  `Num_visitascurso` int(11) DEFAULT 0,
  `Tempo_estimado` time DEFAULT NULL,
  `Dificuldade` enum('Iniciante','intermedio','avançado') DEFAULT NULL,
  `Quantidade_fases` int(11) DEFAULT 0,
  `Requisitos` varchar(100) DEFAULT NULL,
  `Provedor_geral_curso` enum('youtube','tiktok','instagram','linkedin') DEFAULT NULL,
  `URL_geral_curso` varchar(100) DEFAULT NULL,
  `Keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id_curso`),
  KEY `Id_categoria` (`Id_categoria`),
  KEY `Criador_curso` (`Criador_curso`),
  KEY `fk_idioma` (`Id_idioma`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`Id_curso`, `Nome_curso`, `Id_categoria`, `Id_idioma`, `Criador_curso`, `Data_criacao`, `URL_foto_perfil_curso`, `Pequena_descricao`, `Descricao`, `Preco`, `Preco_antigo`, `Estado_curso`, `Classificacao`, `Num_visitascurso`, `Tempo_estimado`, `Dificuldade`, `Quantidade_fases`, `Requisitos`, `Provedor_geral_curso`, `URL_geral_curso`, `Keywords`) VALUES
(2, 'Curso de Programação', 1, 2, 32, '2025-04-01', 'capa_curso.png', 'Curso básico de programação', 'Aprenda os fundamentos da programação', NULL, 25.00, 'ativo', 0, 100, '01:30:00', 'Iniciante', 10, 'Nenhum', 'youtube', NULL, 'programação, iniciante, código'),
(3, 'Nome do Curso ', 1, 1, 32, '2025-04-08', 'capa_curso.png', 'Pequena descrição do curso', 'Descrição completa do curso com todos os detalhes.', 99.99, 0.00, 'ativo', 0, 150, '17:00:10', 'intermedio', 5, 'Requisitos básicos de informática', '', 'http://exemplo.com/curso', 'exemplo, curso, online'),
(4, 'teste ', NULL, 2, 32, '2025-04-08', 'capa_curso.png', 'Pequena descrição do cursoPequena descrição do cursoPequena descrição do cursoPequena descrição do c', 'Este curso fornece uma introdução abrangente aos princípios da cibersegurança. Os formandos irão aprender sobre ameaças, vulnerabilidades, e mecanismos de defesa. A formação também aborda práticas de segurança pessoal e empresarial, políticas de segurança, e muito mais. Ideal para quem pretende iniciar carreira na área ou reforçar conhecimentos existentes. A conclusão bem-sucedida deste curso confere um certificado de participação.', 99.99, 0.00, 'ativo', 0, 150, '00:00:10', 'avançado', 5, 'Requisitos básicos de informática', '', 'http://exemplo.com/curso', 'exemplo, curso, online'),
(5, 'Curso 1', 1, 1, 32, '2025-05-22', 'curso1.jpg', 'Descrição curta do curso 1', 'Descrição completa do curso 1', 49.99, 59.99, 'ativo', 0, 120, '00:00:10', '', 5, 'Noções básicas de informática', '', 'https://curso1.exemplo.com', 'curso, informática'),
(6, 'Curso 2', 1, 1, 32, '2025-05-22', '/imagens/curso2.jpg', 'Descrição curta do curso 2', 'Descrição completa do curso 2', 29.99, 39.99, 'ativo', 0, 80, '00:00:08', '', 4, 'Nenhum requisito', '', 'https://curso2.exemplo.com', 'curso, básico'),
(7, 'Curso 3', 1, 1, 32, '2025-05-22', '/imagens/curso3.jpg', 'Descrição curta do curso 3', 'Descrição completa do curso 3', 59.99, 69.99, 'ativo', 0, 200, '00:00:15', 'avançado', 7, 'Conhecimentos intermediários', '', 'https://curso3.exemplo.com', 'curso, avançado'),
(8, 'Curso 4', 1, 1, 32, '2025-05-22', '/imagens/curso4.jpg', 'Descrição curta do curso 4', 'Descrição completa do curso 4', 19.99, 24.99, 'ativo', 0, 50, '00:00:06', '', 3, 'Nenhum requisito', '', 'https://curso4.exemplo.com', 'curso, iniciante'),
(9, 'Curso 5', 1, 1, 32, '2025-05-22', '/imagens/curso5.jpg', 'Descrição curta do curso 5', 'Descrição completa do curso 5', 39.99, 49.99, 'ativo', 0, 110, '00:00:12', '', 6, 'Conhecimentos básicos', '', 'https://curso5.exemplo.com', 'curso, intermediário'),
(10, 'Curso 6', 1, 1, 32, '2025-05-22', '/imagens/curso6.jpg', 'Descrição curta do curso 6', 'Descrição completa do curso 6', 25.00, 30.00, 'ativo', 0, 70, '00:00:07', '', 4, 'Nenhum requisito', '', 'https://curso6.exemplo.com', 'curso, básico'),
(11, 'Curso 7', 1, 1, 32, '2025-05-22', '/imagens/curso7.jpg', 'Descrição curta do curso 7', 'Descrição completa do curso 7', 44.99, 54.99, 'ativo', 0, 150, '00:00:13', '', 6, 'Conhecimentos intermediários', '', 'https://curso7.exemplo.com', 'curso, tecnologia'),
(12, 'Curso 8', 1, 1, 32, '2025-05-22', '/imagens/curso8.jpg', 'Descrição curta do curso 8', 'Descrição completa do curso 8', 34.99, 44.99, 'ativo', 0, 90, '00:00:09', '', 5, 'Nenhum requisito', '', 'https://curso8.exemplo.com', 'curso, iniciantes'),
(13, 'Curso 9', 1, 1, 32, '2025-05-22', '/imagens/curso9.jpg', 'Descrição curta do curso 9', 'Descrição completa do curso 9', 54.99, 64.99, 'ativo', 2, 180, '00:00:14', 'avançado', 7, 'Conhecimentos avançados', '', 'https://curso9.exemplo.com', 'curso, avançado'),
(21, 'teste', NULL, 2, 32, '2025-06-06', 'curso_id21.jpg', '', '', 0.00, 0.00, 'Incompleto', 0, 0, '00:00:00', '', 0, '', '', NULL, ''),
(22, 'fgh', 1, 1, 32, '2025-06-06', 'curso_id22.png', 'fgh', 'fhg', 0.00, 0.00, '', 0, 0, '00:00:00', 'intermedio', 0, '', '', NULL, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(33, 32, 5, '2025-06-17', 'Concluido', 100, NULL, NULL, NULL);

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `fase`
--

CREATE TABLE IF NOT EXISTS `fase` (
  `Id_fase` int(11) NOT NULL AUTO_INCREMENT,
  `Id_curso` int(11) NOT NULL,
  `Num_fase` int(11) DEFAULT NULL,
  `Titulo_fase` varchar(255) DEFAULT NULL,
  `Conteudo_fase` varchar(255) DEFAULT NULL,
  `Imagem` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_fase`),
  KEY `Id_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fase`
--

INSERT INTO `fase` (`Id_fase`, `Id_curso`, `Num_fase`, `Titulo_fase`, `Conteudo_fase`, `Imagem`, `video`) VALUES
(6, 13, 1, 'fase fase 1', 'fase 2', 'Imagem_fase1_curso2.png', 'video_fase1_curso2.mp4'),
(12, 13, 2, 'Introdução ao Curso', 'Neste módulo, vamos apresentar os objetivos e a estrutura do curso.', 'intro.jpg', 'intro.mp4'),
(13, 13, 3, 'Fundamentos Básicos', 'Aqui exploramos os conceitos fundamentais necessários para avançar.', 'fundamentos.jpg', 'fundamentos.mp4'),
(14, 13, 4, 'Aplicações Práticas', 'Vamos aplicar os conceitos em exemplos reais e exercícios.', 'aplicacoes.jpg', 'aplicacoes.mp4'),
(15, 13, 5, 'Conclusão e Avaliação', 'Encerramos o curso com uma avaliação e reflexões finais.', 'conclusao.jpg', 'avaliacao.mp4');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 32, '2025-06-17', 'carteira', 5);

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
  `Tipo_log` enum('Update Curso','Utilizador Matriculado','Informacional','Erro','Aviso','Novo Registo','Deposito de saldo','Levantamento de saldo','Compra curso','Reembolso curso','Conteudo curso alterado') NOT NULL,
  `Data_log` datetime NOT NULL,
  `saldo` double DEFAULT 0,
  PRIMARY KEY (`Id_log`),
  KEY `Id_user` (`Id_user`),
  KEY `fk_logs_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `logs_sistema`
--

INSERT INTO `logs_sistema` (`Id_log`, `Id_user`, `Id_curso`, `Descricao_log`, `Tipo_log`, `Data_log`, `saldo`) VALUES
(34, 39, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-04-15 11:06:42', 0),
(35, 39, NULL, 'O utilizador realizou uma compra no valor de 122.9877 €', '', '2025-04-15 12:46:20', 0),
(36, 32, NULL, 'Foi depositado na conta o valor de 10€euros', '', '2025-04-15 16:09:16', 0),
(37, 32, NULL, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:12:33', 10),
(38, 32, NULL, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:15:25', 10),
(39, 32, NULL, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:18:00', 10),
(40, 32, NULL, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:19:57', 10),
(41, 32, NULL, 'Foi depositado na conta o valor de 10€ euros', '', '2025-04-15 16:22:34', 10),
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
(75, 32, 2, 'Correção de erros na aula 1', '', '2024-12-15 10:30:00', 0),
(76, 32, 2, 'Adicionado novo exercício prático na seção 2', '', '2025-01-10 14:45:00', 0),
(77, 32, 2, 'Texto introdutório atualizado', '', '2025-03-05 09:15:00', 0),
(78, 32, 2, 'Vídeo da aula 3 substituído por uma versão em HD', '', '2025-03-20 11:00:00', 0),
(79, 32, 2, 'Atualização do material PDF da seção 4', '', '2025-04-02 08:30:00', 0),
(80, 32, 2, 'Corrigido erro de formatação na descrição da aula 5', '', '2025-04-18 16:10:00', 0),
(81, 32, 2, 'Adicionadas legendas em português na aula 6', '', '2025-05-25 12:45:00', 0),
(82, 32, 2, 'Link externo corrigido na aula 7', '', '2025-06-08 17:25:00', 0),
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
(141, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 16:06:13', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `midia`
--

CREATE TABLE IF NOT EXISTS `midia` (
  `Id_midia` int(11) NOT NULL AUTO_INCREMENT,
  `Id_curso` int(11) NOT NULL,
  `URL_midia` varchar(100) NOT NULL,
  PRIMARY KEY (`Id_midia`),
  KEY `Id_curso` (`Id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  PRIMARY KEY (`Id_user`),
  UNIQUE KEY `unique_email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id_user`, `PNome_user`, `SNome_user`, `Estado_conta`, `Biografia`, `Password`, `Data_criacao`, `Email`, `Tipo_user`, `Carteira`, `URL_facebook`, `URL_youtube`, `URL_linkedin`, `URL_foto_perfilUser`) VALUES
(32, 'Ruben', 'Bras', 'Ativo', 'teste', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-04-02', 'vb@gmail.com', 'Main-admin', 99999888.32, 'testeee', 'teste', 'test', 'fotoPerfil_32.jpg'),
(39, 'teste', 'teste', 'Ativo', NULL, '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '2025-04-15', 'teste@gmail.com', 'Cliente', 77.01, NULL, NULL, NULL, NULL),
(40, 'ana', 'gomes', 'Ativo', NULL, 'senha123', '2024-01-10', 'ana.gomes@example.com', 'Cliente', 0.00, NULL, NULL, NULL, NULL),
(41, 'Bruno', 'Ferreiras', 'Ativo', NULL, '123bruno', '2024-02-15', 'bruno.ferreira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(42, 'Carla', 'Santos', 'Eliminado', NULL, 'carlaPass', '2024-03-20', 'carla.santos@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(43, 'Daniel', 'Oliveira', 'Ativo', NULL, 'dan1234', '2024-01-05', 'daniel.oliveira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(44, 'Eduarda', 'Martins', 'Ativo', NULL, 'edupass', '2024-02-22', 'eduarda.martins@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(45, 'Filipe', 'Costa', 'Ativo', NULL, 'filipeC0d3', '2024-04-01', 'filipe.costa@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(46, 'Gabriela', 'Rocha', 'Ativo', NULL, 'gabriela123', '2024-03-18', 'gabriela.rocha@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(47, 'Henrique', 'Lopes', 'Ativo', NULL, 'henriquePass', '2024-05-01', 'henrique.lopes@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(48, 'Inês', 'Pereira', 'Ativo', NULL, 'ines321', '2024-05-10', 'ines.pereira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(49, 'João', 'Vieira', 'Ativo', NULL, 'joao_123', '2024-01-25', 'joao.vieira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(50, 'Kátia', 'andrade', 'Ativo', NULL, 'katia456', '2024-04-12', 'katia.gomes@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(51, 'Lucas', 'Ribeiro', 'Ativo', NULL, 'lucasPass', '2024-03-05', 'lucas.ribeiro@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(52, 'Mariana', 'Carvalho', 'Ativo', NULL, 'mariC123', '2024-02-28', 'mariana.carvalho@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(53, 'Nuno', 'Teixeira', 'Eliminado', NULL, 'nuno777', '2024-01-17', 'nuno.teixeira@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL),
(54, 'Olívia', 'Sousa', 'Eliminado', NULL, 'olivia999', '2024-03-30', 'olivia.sousa@example.com', 'Admin', 0.00, NULL, NULL, NULL, NULL);

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
