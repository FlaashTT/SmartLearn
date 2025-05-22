-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Maio-2025 às 14:18
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

CREATE TABLE `carrinho_compras` (
  `Id_carrinho` int(11) NOT NULL,
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinho_compras`
--

INSERT INTO `carrinho_compras` (`Id_carrinho`, `Id_user`, `Id_curso`) VALUES
(56, 32, 5),
(57, 32, 6),
(58, 32, 7),
(59, 32, 8),
(60, 32, 9),
(61, 32, 10),
(62, 32, 11),
(63, 32, 12),
(64, 32, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `Id_categoria` int(11) NOT NULL,
  `Nome_cat` varchar(50) NOT NULL,
  `Num_visitasCat` int(11) DEFAULT 0,
  `Quantidade_cursos` int(11) NOT NULL DEFAULT 0,
  `Miniatura_cat` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`Id_categoria`, `Nome_cat`, `Num_visitasCat`, `Quantidade_cursos`, `Miniatura_cat`) VALUES
(1, 'tecnologia', 0, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes_site`
--

CREATE TABLE `configuracoes_site` (
  `Id_configuracao` int(11) NOT NULL,
  `Titulo_banner` varchar(100) NOT NULL,
  `Subtitulo_banner` varchar(100) NOT NULL,
  `Facebook` varchar(100) DEFAULT NULL,
  `Linkedin` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `Id_curso` int(11) NOT NULL,
  `Nome_curso` varchar(40) NOT NULL,
  `Id_categoria` int(11) DEFAULT NULL,
  `Id_idioma` int(11) NOT NULL,
  `Criador_curso` int(11) NOT NULL,
  `Data_criacao` date NOT NULL DEFAULT '2025-01-01',
  `URL_foto_perfil_curso` varchar(100) DEFAULT NULL,
  `Pequena_descricao` varchar(100) DEFAULT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `Preco` decimal(10,2) DEFAULT 0.00,
  `Preco_antigo` decimal(10,2) NOT NULL,
  `Estado_curso` enum('ativo','inativo','pendente') NOT NULL,
  `Classificacao` int(11) DEFAULT 0,
  `Num_visitascurso` int(11) DEFAULT 0,
  `Tempo_estimado` time NOT NULL,
  `Dificuldade` enum('Iniciante','intermedio','avançado') NOT NULL,
  `Quantidade_fases` int(11) NOT NULL DEFAULT 0,
  `Requisitos` varchar(100) NOT NULL,
  `Provedor_geral_curso` enum('youtube','tiktok','instagram','linkedin') DEFAULT NULL,
  `URL_geral_curso` varchar(100) DEFAULT NULL,
  `Keywords` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`Id_curso`, `Nome_curso`, `Id_categoria`, `Id_idioma`, `Criador_curso`, `Data_criacao`, `URL_foto_perfil_curso`, `Pequena_descricao`, `Descricao`, `Preco`, `Preco_antigo`, `Estado_curso`, `Classificacao`, `Num_visitascurso`, `Tempo_estimado`, `Dificuldade`, `Quantidade_fases`, `Requisitos`, `Provedor_geral_curso`, `URL_geral_curso`, `Keywords`) VALUES
(2, 'Curso de Programação', NULL, 2, 14, '2025-04-01', 'capa_curso.png', 'Curso básico de programação', 'Aprenda os fundamentos da programação', NULL, 25.00, 'ativo', 0, 100, '01:30:00', 'Iniciante', 10, 'Nenhum', 'youtube', NULL, 'programação, iniciante, código'),
(3, 'Nome do Curso ', 1, 1, 32, '2025-04-08', 'capa_curso.png', 'Pequena descrição do curso', 'Descrição completa do curso com todos os detalhes.', 99.99, 0.00, 'ativo', 1, 150, '17:00:10', 'intermedio', 5, 'Requisitos básicos de informática', '', 'http://exemplo.com/curso', 'exemplo, curso, online'),
(4, 'teste ', NULL, 2, 32, '2025-04-08', 'capa_curso.png', 'Pequena descrição do cursoPequena descrição do cursoPequena descrição do cursoPequena descrição do c', 'Este curso fornece uma introdução abrangente aos princípios da cibersegurança. Os formandos irão aprender sobre ameaças, vulnerabilidades, e mecanismos de defesa. A formação também aborda práticas de segurança pessoal e empresarial, políticas de segurança, e muito mais. Ideal para quem pretende iniciar carreira na área ou reforçar conhecimentos existentes. A conclusão bem-sucedida deste curso confere um certificado de participação.', 99.99, 0.00, 'ativo', 5, 150, '00:00:10', 'avançado', 5, 'Requisitos básicos de informática', '', 'http://exemplo.com/curso', 'exemplo, curso, online'),
(5, 'Curso 1', 1, 1, 32, '2025-05-22', '/imagens/curso1.jpg', 'Descrição curta do curso 1', 'Descrição completa do curso 1', 49.99, 59.99, 'ativo', 5, 120, '00:00:10', '', 5, 'Noções básicas de informática', '', 'https://curso1.exemplo.com', 'curso, informática'),
(6, 'Curso 2', 1, 1, 32, '2025-05-22', '/imagens/curso2.jpg', 'Descrição curta do curso 2', 'Descrição completa do curso 2', 29.99, 39.99, 'ativo', 4, 80, '00:00:08', '', 4, 'Nenhum requisito', '', 'https://curso2.exemplo.com', 'curso, básico'),
(7, 'Curso 3', 1, 1, 32, '2025-05-22', '/imagens/curso3.jpg', 'Descrição curta do curso 3', 'Descrição completa do curso 3', 59.99, 69.99, 'ativo', 5, 200, '00:00:15', 'avançado', 7, 'Conhecimentos intermediários', '', 'https://curso3.exemplo.com', 'curso, avançado'),
(8, 'Curso 4', 1, 1, 32, '2025-05-22', '/imagens/curso4.jpg', 'Descrição curta do curso 4', 'Descrição completa do curso 4', 19.99, 24.99, 'ativo', 4, 50, '00:00:06', '', 3, 'Nenhum requisito', '', 'https://curso4.exemplo.com', 'curso, iniciante'),
(9, 'Curso 5', 1, 1, 32, '2025-05-22', '/imagens/curso5.jpg', 'Descrição curta do curso 5', 'Descrição completa do curso 5', 39.99, 49.99, 'ativo', 4, 110, '00:00:12', '', 6, 'Conhecimentos básicos', '', 'https://curso5.exemplo.com', 'curso, intermediário'),
(10, 'Curso 6', 1, 1, 32, '2025-05-22', '/imagens/curso6.jpg', 'Descrição curta do curso 6', 'Descrição completa do curso 6', 25.00, 30.00, 'ativo', 4, 70, '00:00:07', '', 4, 'Nenhum requisito', '', 'https://curso6.exemplo.com', 'curso, básico'),
(11, 'Curso 7', 1, 1, 32, '2025-05-22', '/imagens/curso7.jpg', 'Descrição curta do curso 7', 'Descrição completa do curso 7', 44.99, 54.99, 'ativo', 5, 150, '00:00:13', '', 6, 'Conhecimentos intermediários', '', 'https://curso7.exemplo.com', 'curso, tecnologia'),
(12, 'Curso 8', 1, 1, 32, '2025-05-22', '/imagens/curso8.jpg', 'Descrição curta do curso 8', 'Descrição completa do curso 8', 34.99, 44.99, 'ativo', 4, 90, '00:00:09', '', 5, 'Nenhum requisito', '', 'https://curso8.exemplo.com', 'curso, iniciantes'),
(13, 'Curso 9', 1, 1, 32, '2025-05-22', '/imagens/curso9.jpg', 'Descrição curta do curso 9', 'Descrição completa do curso 9', 54.99, 64.99, 'ativo', 5, 180, '00:00:14', 'avançado', 7, 'Conhecimentos avançados', '', 'https://curso9.exemplo.com', 'curso, avançado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_adquiridos`
--

CREATE TABLE `cursos_adquiridos` (
  `Id_adquirido` int(11) NOT NULL,
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `Data_compra` date NOT NULL,
  `Progresso` enum('Iniciado','Concluido') DEFAULT 'Iniciado',
  `Percentagem_progresso` int(11) NOT NULL DEFAULT 0,
  `AdicionadoPor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos_adquiridos`
--

INSERT INTO `cursos_adquiridos` (`Id_adquirido`, `Id_user`, `Id_curso`, `Data_compra`, `Progresso`, `Percentagem_progresso`, `AdicionadoPor`) VALUES
(1, 39, 2, '0000-00-00', 'Iniciado', 0, 32);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_favoritos`
--

CREATE TABLE `cursos_favoritos` (
  `Id_user` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `Data_favorito` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fase`
--

CREATE TABLE `fase` (
  `Id_fase` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `Num_fase` int(11) DEFAULT NULL,
  `Titulo_fase` varchar(255) DEFAULT NULL,
  `Conteudo_fase` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fase`
--

INSERT INTO `fase` (`Id_fase`, `Id_curso`, `Num_fase`, `Titulo_fase`, `Conteudo_fase`) VALUES
(1, 4, 1, 'Introdução ao Curso', NULL),
(2, 4, 2, 'Fundamentos Básicos', NULL),
(3, 4, 3, 'Desenvolvimento Intermediário', NULL),
(4, 4, 4, 'Técnicas Avançadas', NULL),
(5, 4, 5, 'Projeto Final', NULL),
(6, 4, 6, 'Revisão de Conteúdos', NULL),
(7, 4, 7, 'Preparação para Avaliação', NULL),
(8, 4, 8, 'Avaliação Final', NULL),
(9, 4, 9, 'Análise de Resultados', NULL),
(10, 4, 10, 'Encerramento do Curso', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_compras`
--

CREATE TABLE `historico_compras` (
  `Id_historicoCompras` int(11) NOT NULL,
  `Id_user` int(11) NOT NULL,
  `Data_compra` date DEFAULT NULL,
  `Tipo_pagamento` enum('carteira','outro','reembolsado') DEFAULT 'carteira',
  `Id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `historico_compras`
--

INSERT INTO `historico_compras` (`Id_historicoCompras`, `Id_user`, `Data_compra`, `Tipo_pagamento`, `Id_curso`) VALUES
(8, 39, '2025-04-15', 'carteira', 3),
(9, 32, '2025-04-16', 'reembolsado', 3),
(10, 32, '2025-04-16', 'carteira', 4),
(11, 32, '2025-05-06', 'carteira', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `idioma`
--

CREATE TABLE `idioma` (
  `Id_idioma` int(11) NOT NULL,
  `Nome_idioma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `logs_sistema` (
  `Id_log` int(11) NOT NULL,
  `Id_user` int(11) NOT NULL,
  `Descricao_log` varchar(100) NOT NULL,
  `Tipo_log` enum('Informacional','Erro','Aviso','Novo Registo','Deposito de saldo','Levantamento de saldo','Compra curso','Reembolso curso') NOT NULL,
  `Data_log` datetime NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `logs_sistema`
--

INSERT INTO `logs_sistema` (`Id_log`, `Id_user`, `Descricao_log`, `Tipo_log`, `Data_log`, `saldo`) VALUES
(34, 39, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-04-15 11:06:42', 0),
(35, 39, 'O utilizador realizou uma compra no valor de 122.9877 €', '', '2025-04-15 12:46:20', 0),
(36, 32, 'Foi depositado na conta o valor de 10€euros', '', '2025-04-15 16:09:16', 0),
(37, 32, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:12:33', 10),
(38, 32, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:15:25', 10),
(39, 32, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:18:00', 10),
(40, 32, 'Foi depositado na conta o valor de 10 €euros', '', '2025-04-15 16:19:57', 10),
(41, 32, 'Foi depositado na conta o valor de 10€ euros', '', '2025-04-15 16:22:34', 10),
(42, 32, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 16:23:54', 10),
(43, 32, 'Foi depositado na conta o valor de 540€ euros', 'Deposito de saldo', '2025-04-15 17:20:26', 540),
(44, 32, 'Foi depositado na conta o valor de 5€ euros', 'Deposito de saldo', '2025-04-15 17:21:54', 5),
(45, 32, 'Foi depositado na conta o valor de 2€ euros', 'Deposito de saldo', '2025-04-15 17:32:51', 2),
(46, 32, 'Foi levantado saldo no valor de 2 € euros', 'Levantamento de saldo', '2025-04-15 18:30:45', 2),
(47, 32, 'Foi depositado na conta o valor de 200€ euros', 'Deposito de saldo', '2025-04-15 18:35:27', 200),
(48, 32, 'Foi levantado saldo no valor de 100 € euros', 'Levantamento de saldo', '2025-04-15 18:35:34', 100),
(49, 32, 'Foi depositado na conta o valor de 100€ euros', 'Deposito de saldo', '2025-04-15 18:35:38', 100),
(50, 32, 'Foi depositado na conta o valor de 42€ euros', 'Deposito de saldo', '2025-04-15 18:45:55', 42),
(51, 32, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 18:46:01', 10),
(52, 32, 'Foi levantado saldo no valor de 250 € euros', 'Levantamento de saldo', '2025-04-15 18:46:12', 250),
(53, 32, 'Foi depositado na conta o valor de 500€ euros', 'Deposito de saldo', '2025-04-16 12:02:37', 500),
(54, 32, 'O utilizador realizou uma compra no valor de 245.9754 €', 'Compra curso', '2025-04-16 12:06:07', 245.97539999999998),
(55, 32, 'Foi solicitado reembolso do curso com id3', 'Reembolso curso', '2025-04-16 12:10:31', 99.99),
(56, 32, 'O utilizador realizou uma compra no valor de 122.9877 €', 'Compra curso', '2025-05-06 12:38:59', 122.98769999999999);

-- --------------------------------------------------------

--
-- Estrutura da tabela `midia`
--

CREATE TABLE `midia` (
  `Id_midia` int(11) NOT NULL,
  `Id_curso` int(11) NOT NULL,
  `URL_midia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas_forms`
--

CREATE TABLE `perguntas_forms` (
  `Id_pergunta` int(11) NOT NULL,
  `Texto_pergunta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_forms`
--

CREATE TABLE `resposta_forms` (
  `Id_resposta` int(11) NOT NULL,
  `Data_submissao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_perguntas`
--

CREATE TABLE `resposta_perguntas` (
  `Id_perguntaRespondida` int(11) NOT NULL,
  `Id_resposta` int(11) NOT NULL,
  `Id_pergunta` int(11) NOT NULL,
  `Texto_resposta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ticket`
--

CREATE TABLE `ticket` (
  `Id_ticket` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Descricao` varchar(150) NOT NULL,
  `Estado_ticket` enum('Por Responder','Respondido') DEFAULT 'Por Responder'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `Id_user` int(11) NOT NULL,
  `PNome_user` varchar(20) NOT NULL,
  `SNome_user` varchar(20) DEFAULT NULL,
  `Estado_conta` enum('Ativo','Eliminado') NOT NULL DEFAULT 'Ativo',
  `Biografia` varchar(200) DEFAULT NULL,
  `Password` varchar(64) NOT NULL,
  `Data_criacao` date NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Tipo_user` enum('Admin','Cliente') NOT NULL DEFAULT 'Cliente',
  `Carteira` decimal(10,2) DEFAULT 0.00,
  `URL_facebook` varchar(100) DEFAULT NULL,
  `URL_youtube` varchar(100) DEFAULT NULL,
  `URL_linkedin` varchar(100) DEFAULT NULL,
  `URL_foto_perfilUser` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id_user`, `PNome_user`, `SNome_user`, `Estado_conta`, `Biografia`, `Password`, `Data_criacao`, `Email`, `Tipo_user`, `Carteira`, `URL_facebook`, `URL_youtube`, `URL_linkedin`, `URL_foto_perfilUser`) VALUES
(32, 'ruben', 'bras', 'Ativo', 'teste', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-04-02', 'vb@gmail.com', 'Admin', 99999999.00, 'testeee', 'teste', 'test', 'fotoPerfil_32.jpg'),
(39, 'teste', 'teste', 'Ativo', NULL, '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '2025-04-15', 'teste@gmail.com', 'Cliente', 77.01, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho_compras`
--
ALTER TABLE `carrinho_compras`
  ADD PRIMARY KEY (`Id_carrinho`),
  ADD KEY `Id_user` (`Id_user`),
  ADD KEY `Id_curso` (`Id_curso`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_categoria`);

--
-- Índices para tabela `configuracoes_site`
--
ALTER TABLE `configuracoes_site`
  ADD PRIMARY KEY (`Id_configuracao`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`Id_curso`),
  ADD KEY `Id_categoria` (`Id_categoria`),
  ADD KEY `Criador_curso` (`Criador_curso`),
  ADD KEY `fk_idioma` (`Id_idioma`);

--
-- Índices para tabela `cursos_adquiridos`
--
ALTER TABLE `cursos_adquiridos`
  ADD PRIMARY KEY (`Id_adquirido`),
  ADD KEY `fk_curso` (`Id_curso`),
  ADD KEY `fk_user` (`Id_user`),
  ADD KEY `fk_addPor` (`AdicionadoPor`);

--
-- Índices para tabela `cursos_favoritos`
--
ALTER TABLE `cursos_favoritos`
  ADD PRIMARY KEY (`Id_user`,`Id_curso`),
  ADD KEY `Id_curso` (`Id_curso`);

--
-- Índices para tabela `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`Id_fase`),
  ADD KEY `Id_curso` (`Id_curso`);

--
-- Índices para tabela `historico_compras`
--
ALTER TABLE `historico_compras`
  ADD PRIMARY KEY (`Id_historicoCompras`),
  ADD KEY `Id_user` (`Id_user`),
  ADD KEY `fk_id_curso` (`Id_curso`);

--
-- Índices para tabela `idioma`
--
ALTER TABLE `idioma`
  ADD PRIMARY KEY (`Id_idioma`);

--
-- Índices para tabela `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD PRIMARY KEY (`Id_log`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Índices para tabela `midia`
--
ALTER TABLE `midia`
  ADD PRIMARY KEY (`Id_midia`),
  ADD KEY `Id_curso` (`Id_curso`);

--
-- Índices para tabela `perguntas_forms`
--
ALTER TABLE `perguntas_forms`
  ADD PRIMARY KEY (`Id_pergunta`);

--
-- Índices para tabela `resposta_forms`
--
ALTER TABLE `resposta_forms`
  ADD PRIMARY KEY (`Id_resposta`);

--
-- Índices para tabela `resposta_perguntas`
--
ALTER TABLE `resposta_perguntas`
  ADD PRIMARY KEY (`Id_perguntaRespondida`),
  ADD KEY `Id_resposta` (`Id_resposta`),
  ADD KEY `Id_pergunta` (`Id_pergunta`);

--
-- Índices para tabela `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`Id_ticket`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho_compras`
--
ALTER TABLE `carrinho_compras`
  MODIFY `Id_carrinho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `Id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `configuracoes_site`
--
ALTER TABLE `configuracoes_site`
  MODIFY `Id_configuracao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `Id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cursos_adquiridos`
--
ALTER TABLE `cursos_adquiridos`
  MODIFY `Id_adquirido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fase`
--
ALTER TABLE `fase`
  MODIFY `Id_fase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `historico_compras`
--
ALTER TABLE `historico_compras`
  MODIFY `Id_historicoCompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `idioma`
--
ALTER TABLE `idioma`
  MODIFY `Id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `logs_sistema`
--
ALTER TABLE `logs_sistema`
  MODIFY `Id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `midia`
--
ALTER TABLE `midia`
  MODIFY `Id_midia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perguntas_forms`
--
ALTER TABLE `perguntas_forms`
  MODIFY `Id_pergunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resposta_forms`
--
ALTER TABLE `resposta_forms`
  MODIFY `Id_resposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resposta_perguntas`
--
ALTER TABLE `resposta_perguntas`
  MODIFY `Id_perguntaRespondida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ticket`
--
ALTER TABLE `ticket`
  MODIFY `Id_ticket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `Id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
