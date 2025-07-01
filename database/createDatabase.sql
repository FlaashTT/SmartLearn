-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jul-2025 às 15:48
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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `Id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_cat` varchar(50) NOT NULL,
  `Miniatura_cat` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`Id_categoria`, `Nome_cat`, `Miniatura_cat`) VALUES
(30, 'Programação', 'miniatura_cat30.png'),
(33, 'Eletronica', 'miniatura_cat33.png'),
(34, 'Video jogos', 'miniatura_cat34.png');

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
  `Cidade` text NOT NULL,
  `Endereco` text NOT NULL,
  `Emails` text NOT NULL,
  `Contactos` text NOT NULL,
  PRIMARY KEY (`Id_configuracao`),
  KEY `fk_idUpdater` (`Id_utilizador_Ultimo_update`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `configuracoes_site`
--

INSERT INTO `configuracoes_site` (`Id_configuracao`, `Titulo_banner`, `Subtitulo_banner`, `Facebook`, `Linkedin`, `Id_utilizador_Ultimo_update`, `Cookies_status`, `cookie_note`, `politica_cookies`, `data_update`, `Cidade`, `Endereco`, `Emails`, `Contactos`) VALUES
(1, 'Título exemplo', 'Subtítulo exemplo', 'https://facebook.com/seuPerfil', 'https://linkedin.com/in/seuPerfil', 32, 'ativo', 'nota ', NULL, '2025-06-30 16:03:16', 'covilhã', 'Rua do teste,6200-501', 'ruben_pinheiro@pt.softintinsa.com;leandro_pinto@pt.softintinsa.com', '123456789;987654321');

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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`Id_curso`, `Nome_curso`, `Id_categoria`, `Id_idioma`, `Criador_curso`, `Data_criacao`, `URL_foto_perfil_curso`, `Pequena_descricao`, `Descricao`, `Preco`, `Preco_antigo`, `Estado_curso`, `Classificacao`, `Num_visitascurso`, `Tempo_estimado`, `Dificuldade`, `Quantidade_fases`, `Requisitos`, `Provedor_geral_curso`, `URL_geral_curso`, `Keywords`) VALUES
(23, 'Como fazer um cronometro', 30, 1, 32, '2025-06-25', 'curso_id23.png', 'Cronometro em android Studio', 'Como fazer uma sdfaplicação de um cronometro para telemovel usando java e android Studio', 9.99, 19.99, 'ativo', 2, 64, '00:15:00', 'Iniciante', 0, 'dfg', 'conta_proria', '', ''),
(45, 'Fazer um circuito pisca pisca', 33, 1, 32, '2025-06-26', 'curso_id45.png', '', 'Como fazer um circuito pisca pisca com eletronica utilizando um ne555', 0.00, 0.00, 'ativo', 3, 79, '00:10:00', 'Iniciante', 0, '', 'conta_proria', '', ''),
(46, 'Stardew valey', 34, 1, 32, '2025-07-01', 'curso_id46.png', '', 'Este é um curso sobre a explicação basica do jogo Stardew valey onde se fala sobre os principios do jogo', 0.00, 0.00, 'ativo', 0, 5, '00:10:00', 'Iniciante', 0, '', 'conta_proria', '', ''),
(47, 'Como diminuir os FPS no Fivem', 34, 1, 32, '2025-07-01', 'curso_id47.png', '', 'Curso destinado a jogadores de FIVEM que têm problemas com os Fps durante o jogo no FIvem seja por ter um computador mais fraco ou entao por muito consumo por parte do FIVEM', 0.00, 0.00, 'ativo', 0, 4, '00:10:00', 'Iniciante', 0, '', 'conta_proria', '', ''),
(48, 'Como fazer o jogo do galo', 30, 1, 32, '2025-07-01', 'curso_id48.png', 'Realização do jogo do galo em java', 'Este curso ensina o passo a passo de forma explicativa como fazer o jogo do galo em java ', 0.00, 0.00, 'ativo', 0, 3, '00:10:00', 'intermedio', 0, '', 'conta_proria', '', ''),
(49, 'Tutorial do champion Sett do LOL', 34, 1, 32, '2025-07-01', 'curso_id49.png', 'Tutorial do Sett de como jogar com o Sett', 'Detalhando as melhores runas, itens para comprar e mais informações acerca do mesmo', 0.00, 0.00, 'ativo', 0, 2, '00:10:00', 'Iniciante', 0, '', 'conta_proria', '', '');

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
  `Data_conclusao` date DEFAULT NULL,
  PRIMARY KEY (`Id_adquirido`),
  KEY `fk_curso` (`Id_curso`),
  KEY `fk_user` (`Id_user`),
  KEY `fk_addPor` (`AdicionadoPor`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos_adquiridos`
--

INSERT INTO `cursos_adquiridos` (`Id_adquirido`, `Id_user`, `Id_curso`, `Data_compra`, `Progresso`, `Percentagem_progresso`, `AdicionadoPor`, `Notas`, `Avaliacao`, `Data_conclusao`) VALUES
(46, 32, 46, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01'),
(47, 32, 47, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01'),
(48, 32, 48, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01'),
(49, 32, 23, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01'),
(50, 32, 45, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01'),
(51, 32, 49, '2025-07-01', 'Concluido', 100, NULL, '', NULL, '2025-07-01');

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fase`
--

INSERT INTO `fase` (`Id_fase`, `Id_curso`, `Num_fase`, `Titulo_fase`, `Conteudo_fase`, `Imagem`, `video`) VALUES
(18, 23, 1, 'Instalar o Android Studio', 'Para instalar o android studio deve ir ao site oficial do mesmo e seguir os passos indicados para a instalação', 'Imagem_fase1_curso23.png', ''),
(26, 23, 2, 'Realizar o cronometro', 'Com a visualização do conteudo audiovisual deve conseguir realizar o cronometro', 'Imagem_fase2_curso23.png', 'video_fase2_curso23.mp4'),
(40, 45, 1, 'Introdução', 'Neste curso ira aprender como montar um circuito pisca pisca com um Ne555 utilizando apenas eletronica.\r\nTodos os componentes utilizados seram descritos\r\nTanto em um meio virtual como um meio fisico', '', ''),
(41, 45, 2, 'Materiais necessarios', 'Tem na imagem todos os componentes necessarios para a montagem', 'Imagem_fase2_curso45.png', ''),
(42, 45, 3, 'Valores dos materiais', 'Resistencia variavel: 47kΩ(ohms).\r\nCapacitor polarizado : 100 µF(miroFarads).\r\nResistencias de 1kΩ(ohms), 220Ω(ohms), 330Ω(ohms).\r\nBateria de 9 volts.', '', ''),
(43, 45, 4, 'Exibição do video ', 'Agora com o video explicativo demonstrando todos os passos consegue realizar a montagem do seu circuito tanto virtualmente como fisicamente', '', 'video_fase4_curso45.mp4'),
(62, 41, 1, 'f1', '', 'Imagem_fase1_curso41.png', 'video_fase1_curso41.mp4'),
(66, 41, 2, 'f2', '', '', ''),
(67, 46, 1, 'Introdução', 'Este curso foi criado devido á forte fama que o jogo ganhou e com o surgimento de questões sobre o mesmo fiz este curso para tentar esclarecer.', '', ''),
(68, 46, 2, 'Sobre o jogo', 'Um jogo com foco na agricultura, pesca e mineração tendo que gerir a quinta deixada pelo seu avô e com uma historia por tras interessante surgem algumas missoes propostas por pessoas da aldeia proxima á quinta que deixam algumas duvidas aos jogados novatos', '', ''),
(69, 46, 3, 'Video explicativo', 'Com o video espero que consiga compreender melhor alguns aspetos do jogo em si', '', 'video_fase3_curso46.mp4'),
(70, 47, 1, 'Introdução', 'Apos algum tempo de jogo reparei que varios jogadores tiveram dificuldade em ter uma quantidade de FPS estaveis principalmente em computadores mais fracos, por isso decidi ir atras de como podia resolver esse problema ', '', ''),
(71, 47, 2, 'Video explicativo', 'Com alguns passos detalhados no video deve ajudar a ter uma estabilidade de fps melhor', '', 'video_fase2_curso47.mp4'),
(72, 48, 1, 'Introdução', 'Neste curso pretendo demonstrar como fazer um jogo do galo funcional utilizando java e o programa processing ', '', ''),
(73, 48, 2, 'Video explicativo', 'Video autoexplicativo sobre como fazer o jogo do galo', '', 'video_fase2_curso48.mp4'),
(74, 49, 1, 'Introdução', 'Sett é um champion muito utilizado por varios jogadores de League of legends,muitos iniciantes sentem dificuldades em começar a jogar com o mesmo por isso e por tambem gostar de jogar com ele fiz este curso sobre o mesmo', '', ''),
(75, 49, 2, 'Mais informações', 'Neste curso irei falar sobre como jogar com ele na Lane top, que é a mais frequente dele,irei falar das runas,habilidades,a passiva do mesmo, spells e itens a comprar durante o jogo', '', ''),
(76, 49, 3, 'Video explicativo', 'Com o video espero que tenha sido util para começar a jogar com o mesmo', '', 'video_fase3_curso49.mp4');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, 32, '2025-06-26', 'reembolsado', 44),
(25, 32, '2025-07-01', 'carteira', 46),
(26, 32, '2025-07-01', 'carteira', 47),
(27, 32, '2025-07-01', 'carteira', 48),
(28, 32, '2025-07-01', 'carteira', 23),
(29, 32, '2025-07-01', 'carteira', 45),
(30, 32, '2025-07-01', 'carteira', 49);

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
  `idUserAlterado` int(11) DEFAULT NULL,
  `Ficheiro` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_log`),
  KEY `Id_user` (`Id_user`),
  KEY `fk_logs_curso` (`Id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=436 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `logs_sistema`
--

INSERT INTO `logs_sistema` (`Id_log`, `Id_user`, `Id_curso`, `Descricao_log`, `Tipo_log`, `Data_log`, `saldo`, `idUserAlterado`, `Ficheiro`) VALUES
(34, 39, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-04-15 11:06:42', 0, NULL, NULL),
(42, 32, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 16:23:54', 10, NULL, NULL),
(43, 32, NULL, 'Foi depositado na conta o valor de 540€ euros', 'Deposito de saldo', '2025-04-15 17:20:26', 540, 32, 'teste.php'),
(44, 32, NULL, 'Foi depositado na conta o valor de 5€ euros', 'Deposito de saldo', '2025-04-15 17:21:54', 5, NULL, NULL),
(45, 32, NULL, 'Foi depositado na conta o valor de 2€ euros', 'Deposito de saldo', '2025-04-15 17:32:51', 2, NULL, NULL),
(46, 32, NULL, 'Foi levantado saldo no valor de 2 € euros', 'Levantamento de saldo', '2025-04-15 18:30:45', 2, NULL, NULL),
(47, 32, NULL, 'Foi depositado na conta o valor de 200€ euros', 'Deposito de saldo', '2025-04-15 18:35:27', 200, NULL, NULL),
(48, 32, NULL, 'Foi levantado saldo no valor de 100 € euros', 'Levantamento de saldo', '2025-04-15 18:35:34', 100, NULL, NULL),
(49, 32, NULL, 'Foi depositado na conta o valor de 100€ euros', 'Deposito de saldo', '2025-04-15 18:35:38', 100, NULL, NULL),
(50, 32, NULL, 'Foi depositado na conta o valor de 42€ euros', 'Deposito de saldo', '2025-04-15 18:45:55', 42, NULL, NULL),
(51, 32, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-04-15 18:46:01', 10, NULL, NULL),
(52, 32, NULL, 'Foi levantado saldo no valor de 250 € euros', 'Levantamento de saldo', '2025-04-15 18:46:12', 250, NULL, NULL),
(53, 32, NULL, 'Foi depositado na conta o valor de 500€ euros', 'Deposito de saldo', '2025-04-16 12:02:37', 500, NULL, NULL),
(54, 32, NULL, 'O utilizador realizou uma compra no valor de 245.9754 €', 'Compra curso', '2025-04-16 12:06:07', 245.97539999999998, NULL, NULL),
(55, 32, NULL, 'Foi solicitado reembolso do curso com id3', 'Reembolso curso', '2025-04-16 12:10:31', 99.99, NULL, NULL),
(56, 32, NULL, 'O utilizador realizou uma compra no valor de 122.9877 €', 'Compra curso', '2025-05-06 12:38:59', 122.98769999999999, NULL, NULL),
(57, 32, NULL, 'O utilizador realizou uma compra no valor de 49.1877 €', 'Compra curso', '2025-05-23 11:27:39', 49.18770000000001, NULL, NULL),
(58, 71, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:20:16', NULL, NULL, NULL),
(59, 72, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:24:48', NULL, NULL, NULL),
(60, 73, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:25:38', NULL, NULL, NULL),
(61, 74, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:28:02', NULL, NULL, NULL),
(62, 75, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-05-30 16:29:16', NULL, NULL, NULL),
(73, 40, NULL, 'O utilizador com id 40 foi matriculado no de id 2 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-05 15:46:58', NULL, NULL, NULL),
(74, 40, NULL, 'O utilizador com id 40 foi matriculado no de id 5 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-05 15:49:20', NULL, NULL, NULL),
(83, 32, 2, 'Correção de erros na aula 1', 'Update Curso', '2024-12-15 10:30:00', 0, NULL, NULL),
(84, 32, 2, 'Adicionado novo exercício prático na seção 2', 'Update Curso', '2025-01-10 14:45:00', 0, NULL, NULL),
(85, 32, 2, 'Texto introdutório atualizado', 'Update Curso', '2025-03-05 09:15:00', 0, NULL, NULL),
(86, 32, 2, 'Vídeo da aula 3 substituído por uma versão em HD', 'Update Curso', '2025-03-20 11:00:00', 0, NULL, NULL),
(87, 32, 2, 'Atualização do material PDF da seção 4', 'Update Curso', '2025-04-02 08:30:00', 0, NULL, NULL),
(88, 32, 2, 'Corrigido erro de formatação na descrição da aula 5', 'Update Curso', '2025-04-18 16:10:00', 0, NULL, NULL),
(89, 32, 2, 'Adicionadas legendas em português na aula 6', 'Update Curso', '2025-05-25 12:45:00', 0, NULL, NULL),
(90, 32, 2, 'Link externo corrigido na aula 7', 'Update Curso', '2025-06-08 17:25:00', 0, NULL, NULL),
(91, 32, 2, 'Atualização do material didático da aula 3', 'Update Curso', '2025-03-20 11:00:00', 0, NULL, NULL),
(92, 32, 2, 'Correção de erros na avaliação final', 'Update Curso', '2025-04-02 15:30:00', 0, NULL, NULL),
(93, 32, 2, 'Inclusão de vídeo explicativo na aula 4', 'Update Curso', '2025-04-15 09:45:00', 0, NULL, NULL),
(94, 32, 2, 'Revisão do conteúdo da seção 5', 'Update Curso', '2025-04-28 14:20:00', 0, NULL, NULL),
(95, 32, 2, 'Atualização do cronograma do curso', 'Update Curso', '2025-05-05 10:10:00', 0, NULL, NULL),
(96, 32, 2, 'Melhoria no design dos slides', 'Update Curso', '2025-05-15 13:55:00', 0, NULL, NULL),
(97, 32, 2, 'Adicionado quiz interativo na aula 6', 'Update Curso', '2025-05-25 16:40:00', 0, NULL, NULL),
(98, 32, 2, 'Correção de links quebrados nas referências', 'Update Curso', '2025-06-01 08:30:00', 0, NULL, NULL),
(99, 32, 2, 'Atualização dos exemplos práticos da aula 7', 'Update Curso', '2025-06-10 12:15:00', 0, NULL, NULL),
(100, 32, 2, 'Inclusão de nota de rodapé em material suplementar', 'Update Curso', '2025-06-20 17:50:00', 0, NULL, NULL),
(101, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLear', 'Erro', '2025-06-16 17:52:28', NULL, NULL, NULL),
(102, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-16 17:54:44', NULL, NULL, NULL),
(103, 32, NULL, 'O utilizador realizou uma compra no valor de 61.4877 €', 'Compra curso', '2025-06-17 15:04:57', 61.487700000000004, NULL, NULL),
(104, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:46:38', NULL, NULL, NULL),
(105, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:48:14', NULL, NULL, NULL),
(106, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:56', NULL, NULL, NULL),
(107, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:57', NULL, NULL, NULL),
(108, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:49:57', NULL, NULL, NULL),
(109, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:50:14', NULL, NULL, NULL),
(110, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:16', NULL, NULL, NULL),
(111, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:34', NULL, NULL, NULL),
(112, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:51:39', NULL, NULL, NULL),
(113, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:52:31', NULL, NULL, NULL),
(114, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:54:02', NULL, NULL, NULL),
(115, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 11:55:25', NULL, NULL, NULL),
(116, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:00:29', NULL, NULL, NULL),
(117, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:04:41', NULL, NULL, NULL),
(118, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:05:47', NULL, NULL, NULL),
(119, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:06:11', NULL, NULL, NULL),
(120, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:07:17', NULL, NULL, NULL),
(121, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:19:10', NULL, NULL, NULL),
(122, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:38:32', NULL, NULL, NULL),
(123, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:38:49', NULL, NULL, NULL),
(124, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 12:39:18', NULL, NULL, NULL),
(125, 32, NULL, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-18 13:01:30', NULL, NULL, NULL),
(126, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:55', NULL, NULL, NULL),
(127, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:57', NULL, NULL, NULL),
(128, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:58', NULL, NULL, NULL),
(129, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:58', NULL, NULL, NULL),
(130, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:58:59', NULL, NULL, NULL),
(131, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:00', NULL, NULL, NULL),
(132, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:11', NULL, NULL, NULL),
(133, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:12', NULL, NULL, NULL),
(134, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:12', NULL, NULL, NULL),
(135, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:13', NULL, NULL, NULL),
(136, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:13', NULL, NULL, NULL),
(137, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:14', NULL, NULL, NULL),
(138, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:15', NULL, NULL, NULL),
(139, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:37', NULL, NULL, NULL),
(140, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 15:59:39', NULL, NULL, NULL),
(141, 32, NULL, 'Ocorreu um erro: Erro ao carregar configurações do sistema no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\configuracoes_sistema.php', 'Erro', '2025-06-18 16:06:13', NULL, NULL, NULL),
(142, 78, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-06-23 15:53:39', NULL, NULL, NULL),
(143, 79, NULL, 'Foi criado um novo utilizador no sistema!', 'Novo Registo', '2025-06-24 16:51:02', NULL, NULL, NULL),
(144, 32, NULL, 'Ocorreu um erro: Erro ao eliminar categoria! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\apagarCategoria.php', 'Erro', '2025-06-24 17:12:45', NULL, NULL, NULL),
(158, 32, NULL, 'Ocorreu um erro: Categoria com esse nome já existe! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionarCategoria.php', 'Erro', '2025-06-25 10:35:04', NULL, NULL, NULL),
(159, 32, NULL, 'Ocorreu um erro: Categoria com esse nome já existe! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionarCategoria.php', 'Erro', '2025-06-25 10:35:25', NULL, NULL, NULL),
(177, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:38:52', NULL, NULL, NULL),
(178, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:40:46', NULL, NULL, NULL),
(179, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:41:00', NULL, NULL, NULL),
(180, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:42:15', NULL, NULL, NULL),
(181, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:42:46', NULL, NULL, NULL),
(182, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar o video,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-25 11:44:58', NULL, NULL, NULL),
(183, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:45:27', NULL, NULL, NULL),
(184, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:47:51', NULL, NULL, NULL),
(185, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:48:19', NULL, NULL, NULL),
(186, 32, NULL, 'O administrador com Id32 removeu a uma fase do curso com Id:23', 'Fase removida', '2025-06-25 11:53:02', NULL, NULL, NULL),
(187, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:53:19', NULL, NULL, NULL),
(188, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:54:04', NULL, NULL, NULL),
(189, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:55:14', NULL, NULL, NULL),
(190, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:55:30', NULL, NULL, NULL),
(191, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:57:03', NULL, NULL, NULL),
(192, 32, NULL, 'O administrador com Id32 removeu a uma fase do curso com Id:23', 'Fase removida', '2025-06-25 11:57:33', NULL, NULL, NULL),
(193, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:57:59', NULL, NULL, NULL),
(194, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:58:15', NULL, NULL, NULL),
(195, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:59:14', NULL, NULL, NULL),
(196, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 11:59:31', NULL, NULL, NULL),
(197, 32, NULL, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-06-25 12:00:10', NULL, NULL, NULL),
(199, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:34', NULL, NULL, NULL),
(200, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:40', NULL, NULL, NULL),
(201, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:14:57', NULL, NULL, NULL),
(202, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:16:25', NULL, NULL, NULL),
(203, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:10', NULL, NULL, NULL),
(204, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:32', NULL, NULL, NULL),
(205, 32, NULL, 'Ocorreu um erro: Preço inválido ou vazio no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:17:49', NULL, NULL, NULL),
(206, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:18:58', NULL, NULL, NULL),
(207, 32, NULL, 'Ocorreu um erro: Erro ao finalizar compra no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\finalizaCompra.php', 'Erro', '2025-06-25 12:19:34', NULL, NULL, NULL),
(208, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 12:20:21', 0, NULL, NULL),
(209, 32, NULL, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 13:06:01', 0, NULL, NULL),
(210, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:24', 0, NULL, NULL),
(211, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:36', 0, NULL, NULL),
(212, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:10:57', 0, NULL, NULL),
(213, 32, NULL, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 13:11:18', 0, NULL, NULL),
(214, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-25 13:11:32', 0, NULL, NULL),
(215, 32, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-25 13:13:31', 12.287700000000001, NULL, NULL),
(219, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:07:31', NULL, NULL, NULL),
(220, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:08:03', NULL, NULL, NULL),
(221, 32, NULL, 'O administrador com Id:32 removeu o curso com Id:43', 'Curso eliminado', '2025-06-25 15:14:46', NULL, NULL, NULL),
(222, 32, 42, 'O administrador com Id:32 removeu o curso com Id:42', 'Curso eliminado', '2025-06-25 15:22:55', NULL, NULL, NULL),
(223, 32, NULL, 'Foram alteradas informações do curso com id', '', '2025-06-25 15:53:19', NULL, NULL, NULL),
(224, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(225, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(226, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(227, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(228, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(229, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(230, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(231, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(232, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(233, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(234, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(235, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(236, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(237, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(238, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(239, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(240, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(241, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(242, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:21', NULL, NULL, NULL),
(243, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(244, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(245, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(246, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(247, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(248, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(249, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(250, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(251, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(252, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(253, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(254, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(255, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(256, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:22', NULL, NULL, NULL),
(257, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(258, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(259, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(260, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(261, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(262, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(263, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(264, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(265, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(266, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(267, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(268, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(269, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:23', NULL, NULL, NULL),
(270, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL, NULL, NULL),
(271, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL, NULL, NULL),
(272, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL, NULL, NULL),
(273, 32, NULL, 'Ocorreu um erro:  no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 15:53:24', NULL, NULL, NULL),
(274, 32, 43, 'Foram alteradas informações do curso com id43', '', '2025-06-25 16:32:42', NULL, NULL, NULL),
(275, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:33:14', NULL, NULL, NULL),
(276, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:33:29', NULL, NULL, NULL),
(277, 32, 43, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:34:58', NULL, NULL, NULL),
(278, 32, 40, 'Foram alteradas informações do curso com id40', '', '2025-06-25 16:35:29', NULL, NULL, NULL),
(279, 32, 23, 'Foram alteradas informações do curso com id23', '', '2025-06-25 16:36:47', NULL, NULL, NULL),
(280, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-25 16:36:51', NULL, NULL, NULL),
(281, 32, 23, 'Foram alteradas informações do curso com id23', '', '2025-06-25 16:37:05', NULL, NULL, NULL),
(282, 32, 43, 'O administrador com Id:32 removeu o curso com Id:43', 'Curso eliminado', '2025-06-25 16:37:42', NULL, NULL, NULL),
(283, 32, 40, 'Foram alteradas informações do curso com id40', '', '2025-06-25 16:40:46', NULL, NULL, NULL),
(284, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-25 16:41:17', NULL, NULL, NULL),
(285, 32, 40, 'Foram alteradas informações do curso com id40', 'Alteração de curso', '2025-06-25 16:44:21', NULL, NULL, NULL),
(286, 32, 40, 'O administrador com Id:32 removeu o curso com Id:40', 'Curso eliminado', '2025-06-25 16:44:44', NULL, NULL, NULL),
(287, 32, 23, 'Foi solicitado reembolso do curso com id23', 'Reembolso curso', '2025-06-25 17:09:12', 9.99, NULL, NULL),
(288, 32, 40, 'Foi solicitado reembolso do curso com id40', 'Reembolso curso', '2025-06-25 17:09:15', 50, NULL, NULL),
(289, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:09:22', NULL, NULL, NULL),
(290, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:28', NULL, NULL, NULL),
(291, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:38', NULL, NULL, NULL),
(292, 32, NULL, 'Ocorreu um erro: Ocorreu um erro ao adicionar o curso no carrinho no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\carrinho\\adicionarAocarrinho.php', 'Erro', '2025-06-25 17:12:47', NULL, NULL, NULL),
(293, 78, NULL, 'Foi depositado na conta o valor de 10€ euros', 'Deposito de saldo', '2025-06-26 11:03:15', 10, NULL, NULL),
(294, 78, NULL, 'Foi depositado na conta o valor de 5€ euros', 'Deposito de saldo', '2025-06-26 11:04:14', 5, NULL, NULL),
(295, 78, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-26 11:04:32', 12.287700000000001, NULL, NULL),
(296, 78, 23, 'Foi solicitado reembolso do curso com id23', 'Reembolso curso', '2025-06-26 12:05:17', 9.99, NULL, NULL),
(297, 78, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-06-26 12:19:48', 12.287700000000001, NULL, NULL),
(298, 32, 23, 'O utilizador com id 32 foi matriculado no curso de id 23 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:18:53', NULL, NULL, NULL),
(299, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:00', NULL, NULL, NULL),
(300, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:19', NULL, NULL, NULL),
(301, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:20', NULL, NULL, NULL),
(302, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:21', NULL, NULL, NULL),
(303, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:22', NULL, NULL, NULL),
(304, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:23', NULL, NULL, NULL),
(305, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL, NULL, NULL),
(306, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL, NULL, NULL),
(307, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:24', NULL, NULL, NULL),
(308, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL, NULL, NULL),
(309, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL, NULL, NULL),
(310, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:25', NULL, NULL, NULL),
(311, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:26', NULL, NULL, NULL),
(312, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:41', NULL, NULL, NULL),
(313, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:19:56', NULL, NULL, NULL),
(315, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:21:42', NULL, NULL, NULL),
(316, 32, 23, 'O utilizador com id 32 foi matriculado no curso de id 23 pelo admin com id 32', 'Utilizador Matriculado', '2025-06-26 16:23:09', NULL, NULL, NULL),
(317, 32, 45, 'Foi adicionado um novo curso(45) pelo administrador com ID: 32', '', '2025-06-26 17:44:23', NULL, NULL, NULL),
(318, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar o video,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:05:58', NULL, NULL, NULL),
(319, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:11:26', NULL, NULL, NULL),
(320, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:11:59', NULL, NULL, NULL),
(321, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:12:05', NULL, NULL, NULL),
(322, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:15:24', NULL, NULL, NULL),
(323, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:33', NULL, NULL, NULL),
(324, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:40', NULL, NULL, NULL),
(325, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:46', NULL, NULL, NULL),
(326, 32, 45, 'Foi removida fase do curso: 45 pelo administrador com Id: 32', 'Fase removida', '2025-06-26 18:19:51', NULL, NULL, NULL),
(327, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:20:42', NULL, NULL, NULL),
(328, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:21:45', NULL, NULL, NULL),
(329, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:22:55', NULL, NULL, NULL),
(330, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:37:21', NULL, NULL, NULL),
(331, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:41:50', NULL, NULL, NULL),
(332, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:43:34', NULL, NULL, NULL),
(333, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:44:21', NULL, NULL, NULL),
(334, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:45:10', NULL, NULL, NULL),
(335, 32, NULL, 'Ocorreu um erro: O arquivo não existe. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\remover_midia.php', 'Erro', '2025-06-26 18:46:41', NULL, NULL, NULL),
(336, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-26 18:52:39', NULL, NULL, NULL),
(337, 32, NULL, 'Ocorreu um erro: ERRO ao atualizar a imagem,tente mais tarde! no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\adicionar_alterar_conteudo.php', 'Erro', '2025-06-26 18:55:43', NULL, NULL, NULL),
(338, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:57:03', NULL, NULL, NULL),
(339, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:57:29', NULL, NULL, NULL),
(340, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-06-26 18:58:21', NULL, NULL, NULL),
(341, 32, 45, 'Foram alteradas informações do curso com id45', 'Alteração de curso', '2025-06-26 18:59:49', NULL, NULL, NULL),
(342, 32, 45, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:01:01', NULL, NULL, NULL),
(343, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:01:10', NULL, NULL, NULL),
(344, 32, 45, 'Foram alteradas informações do curso com id45', 'Alteração de curso', '2025-06-26 19:02:05', NULL, NULL, NULL),
(345, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:02:13', NULL, NULL, NULL),
(346, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-26 19:07:38', NULL, NULL, NULL),
(347, 32, 23, 'Foram alteradas informações do curso com id23', 'Alteração de curso', '2025-06-26 19:07:43', NULL, NULL, NULL),
(348, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:07:49', NULL, NULL, NULL),
(349, 32, 23, 'Ocorreu um erro: Nenhuma alteração feita ou ID não encontrado. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\editarCurso.php', 'Erro', '2025-06-26 19:07:59', NULL, NULL, NULL),
(350, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-26 19:36:11', 0, NULL, NULL),
(351, 32, NULL, 'O utilizador realizou uma compra no valor de 0 €', 'Compra curso', '2025-06-26 19:57:48', 0, NULL, NULL),
(352, 32, 44, 'Foi solicitado reembolso do curso com id44', 'Reembolso curso', '2025-06-26 20:00:39', 0, NULL, NULL),
(353, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 11:14:46', NULL, NULL, NULL),
(354, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 11:14:51', NULL, NULL, NULL),
(355, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 11:15:36', NULL, NULL, NULL),
(356, 32, NULL, 'Ocorreu um erro: O utilizador vb@gmail.com / Ruben Bras já está matriculado no curso Como fazer um cronometro. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\realizaMatricular.php', 'Erro', '2025-06-27 12:20:05', NULL, NULL, NULL),
(357, 32, NULL, 'O utilizador com id  foi matriculado no curso de id  pelo admin com id 32', 'Utilizador Matriculado', '2025-06-27 12:20:07', NULL, NULL, NULL),
(358, 32, NULL, 'Foi alterado dados do utilizador com Id: 41 pelo administrador com ID:32', 'Utilizador Alterado por admin', '2025-06-27 12:23:04', NULL, NULL, NULL),
(359, 32, NULL, 'Ocorreu um erro: Método de requisição inválido. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarUtilizador.php', 'Erro', '2025-06-27 12:23:06', NULL, NULL, NULL),
(360, 32, NULL, 'Ocorreu um erro: Método de requisição inválido. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarUtilizador.php', 'Erro', '2025-06-27 12:23:07', NULL, NULL, NULL),
(361, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 12:57:35', NULL, NULL, NULL),
(362, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 12:57:40', NULL, NULL, NULL),
(363, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 12:57:50', NULL, NULL, NULL),
(364, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 12:58:54', NULL, NULL, NULL),
(365, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 12:59:00', NULL, NULL, NULL),
(366, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 13:09:16', NULL, NULL, NULL),
(367, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 13:10:26', NULL, NULL, NULL),
(368, 32, 23, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-27 14:25:10', NULL, NULL, NULL),
(369, 32, 45, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-27 14:27:09', NULL, NULL, NULL),
(370, 32, 23, 'Ocorreu um erro: Erro ao realizar o update,tente mais tarde no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\curso\\concluirCurso.php', 'Erro', '2025-06-27 14:29:23', NULL, NULL, NULL),
(371, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:43:35', NULL, NULL, NULL),
(372, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 14:44:32', NULL, NULL, NULL),
(373, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:44:44', NULL, NULL, NULL),
(374, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 14:44:49', NULL, NULL, NULL),
(375, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:45:02', NULL, NULL, NULL),
(376, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:45:42', NULL, NULL, NULL),
(377, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:45:54', NULL, NULL, NULL),
(378, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:46:22', NULL, NULL, NULL),
(379, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:46:36', NULL, NULL, NULL),
(380, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 14:55:18', NULL, NULL, NULL),
(381, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 14:55:24', NULL, NULL, NULL),
(382, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 14:55:29', NULL, NULL, NULL),
(383, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 14:55:40', NULL, NULL, NULL),
(384, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 15:02:17', NULL, NULL, NULL),
(385, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 15:02:26', NULL, NULL, NULL),
(386, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:03:23', NULL, NULL, NULL),
(387, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 15:04:37', NULL, NULL, NULL),
(388, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:04:49', NULL, NULL, NULL),
(389, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:06:40', NULL, NULL, NULL),
(390, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:09:37', NULL, NULL, NULL),
(391, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 15:09:46', NULL, NULL, NULL),
(392, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:09:57', NULL, NULL, NULL),
(393, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:11:21', NULL, NULL, NULL),
(394, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:12:18', NULL, NULL, NULL),
(395, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:12:19', NULL, NULL, NULL),
(396, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:12:31', NULL, NULL, NULL),
(397, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 15:13:21', NULL, NULL, NULL),
(398, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 15:14:37', NULL, NULL, NULL),
(399, 32, 41, 'Foi removida fase do curso: 41 pelo administrador com Id: 32', 'Fase removida', '2025-06-27 17:19:16', NULL, NULL, NULL),
(400, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 17:19:22', NULL, NULL, NULL),
(401, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 17:19:53', NULL, NULL, NULL),
(402, 32, 41, 'O administrador com id 32 alterou o conteúdo do curso 41', 'Conteudo curso alterado', '2025-06-27 17:20:24', NULL, NULL, NULL),
(403, 32, NULL, 'Foi levantado saldo no valor de 10 € euros', 'Levantamento de saldo', '2025-06-30 15:18:29', 10, NULL, NULL),
(404, 32, NULL, 'Foi levantado saldo no valor de 99999926 € euros', 'Levantamento de saldo', '2025-06-30 15:18:42', 99999926, NULL, NULL),
(405, 32, NULL, 'Foi depositado na conta o valor de 9999€ euros', 'Deposito de saldo', '2025-06-30 15:19:26', 9999, NULL, NULL),
(406, 32, NULL, 'Foi levantado saldo no valor de 10 € euros', 'Levantamento de saldo', '2025-06-30 15:19:32', 10, NULL, NULL),
(407, 32, NULL, 'Foi criada uma nova categoria34pelo administador com id: 32', '', '2025-07-01 12:27:32', NULL, NULL, NULL),
(408, 32, NULL, 'A categoria 33 foi alterada', '', '2025-07-01 12:29:53', NULL, NULL, NULL),
(409, 32, NULL, 'Ocorreu um erro: Imagem antiga não encontrada. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarCategoria.php', 'Erro', '2025-07-01 12:31:12', NULL, NULL, 'C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarCategoria.php');
INSERT INTO `logs_sistema` (`Id_log`, `Id_user`, `Id_curso`, `Descricao_log`, `Tipo_log`, `Data_log`, `saldo`, `idUserAlterado`, `Ficheiro`) VALUES
(410, 32, NULL, 'Ocorreu um erro: Imagem antiga não encontrada. no ficheiro :C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarCategoria.php', 'Erro', '2025-07-01 12:31:27', NULL, NULL, 'C:\\xampp\\htdocs\\SmartLearn\\public\\admin\\acoes\\alterarCategoria.php'),
(411, 32, NULL, 'A categoria 30 foi alterada', '', '2025-07-01 12:32:23', NULL, NULL, NULL),
(412, 32, 46, 'Foi adicionado um novo curso(46) pelo administrador com ID: 32', '', '2025-07-01 12:33:14', NULL, NULL, NULL),
(413, 32, 47, 'Foi adicionado um novo curso(47) pelo administrador com ID: 32', '', '2025-07-01 12:34:34', NULL, NULL, NULL),
(414, 32, 46, 'O administrador com id 32 alterou o conteúdo do curso 46', 'Conteudo curso alterado', '2025-07-01 12:47:12', NULL, NULL, NULL),
(415, 32, 47, 'O administrador com id 32 alterou o conteúdo do curso 47', 'Conteudo curso alterado', '2025-07-01 12:48:12', NULL, NULL, NULL),
(416, 32, 48, 'Foi adicionado um novo curso(48) pelo administrador com ID: 32', '', '2025-07-01 12:54:14', NULL, NULL, NULL),
(417, 32, 48, 'O administrador com id 32 alterou o conteúdo do curso 48', 'Conteudo curso alterado', '2025-07-01 12:56:15', NULL, NULL, NULL),
(418, 32, 49, 'Foi adicionado um novo curso(49) pelo administrador com ID: 32', '', '2025-07-01 12:59:46', NULL, NULL, NULL),
(419, 32, 49, 'O administrador com id 32 alterou o conteúdo do curso 49', 'Conteudo curso alterado', '2025-07-01 13:01:18', NULL, NULL, NULL),
(420, 32, 48, 'Foram alteradas informações do curso com id48', 'Alteração de curso', '2025-07-01 13:01:41', NULL, NULL, NULL),
(421, 32, 49, 'Foram alteradas informações do curso com id49', 'Alteração de curso', '2025-07-01 13:01:53', NULL, NULL, NULL),
(422, 32, 49, 'Foram alteradas informações do curso com id49', 'Alteração de curso', '2025-07-01 13:02:07', NULL, NULL, NULL),
(423, 32, 46, 'Foram alteradas informações do curso com id46', 'Alteração de curso', '2025-07-01 13:02:18', NULL, NULL, NULL),
(424, 32, 47, 'Foram alteradas informações do curso com id47', 'Alteração de curso', '2025-07-01 13:02:29', NULL, NULL, NULL),
(425, 32, 48, 'Foram alteradas informações do curso com id48', 'Alteração de curso', '2025-07-01 13:04:23', NULL, NULL, NULL),
(426, 32, 46, 'O administrador com id 32 alterou o conteúdo do curso 46', 'Conteudo curso alterado', '2025-07-01 14:28:49', NULL, NULL, NULL),
(427, 32, 47, 'O administrador com id 32 alterou o conteúdo do curso 47', 'Conteudo curso alterado', '2025-07-01 14:31:11', NULL, NULL, NULL),
(428, 32, NULL, 'O utilizador realizou uma compra no valor de 12.2877 €', 'Compra curso', '2025-07-01 14:33:28', 12.287700000000001, NULL, NULL),
(429, 32, 46, 'O administrador com id 32 alterou o conteúdo do curso 46', 'Conteudo curso alterado', '2025-07-01 14:34:29', NULL, NULL, NULL),
(430, 32, 47, 'O administrador com id 32 alterou o conteúdo do curso 47', 'Conteudo curso alterado', '2025-07-01 14:35:55', NULL, NULL, NULL),
(431, 32, 48, 'O administrador com id 32 alterou o conteúdo do curso 48', 'Conteudo curso alterado', '2025-07-01 14:37:06', NULL, NULL, NULL),
(432, 32, 23, 'O administrador com id 32 alterou o conteúdo do curso 23', 'Conteudo curso alterado', '2025-07-01 14:38:17', NULL, NULL, NULL),
(433, 32, 45, 'O administrador com id 32 alterou o conteúdo do curso 45', 'Conteudo curso alterado', '2025-07-01 14:39:52', NULL, NULL, NULL),
(434, 32, 49, 'O administrador com id 32 alterou o conteúdo do curso 49', 'Conteudo curso alterado', '2025-07-01 14:41:12', NULL, NULL, NULL),
(435, 32, 49, 'O administrador com id 32 alterou o conteúdo do curso 49', 'Conteudo curso alterado', '2025-07-01 14:45:24', NULL, NULL, NULL);

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
(32, 'Ruben', 'Bras', 'Ativo', 'teste', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2025-04-02', 'vb@gmail.com', 'Admin', 9976.73, 'testeee', 'teste', 'test', 'fotoPerfil_32.png', 'Aceite'),
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
