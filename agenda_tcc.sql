-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Jun-2025 às 22:17
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendas`
--

CREATE TABLE `agendas` (
  `id` int(11) NOT NULL,
  `data_hora` datetime DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `prof_orientador_id` int(11) DEFAULT NULL,
  `prof_convidado1_id` int(11) DEFAULT NULL,
  `prof_convidado2_id` int(11) DEFAULT NULL,
  `aluno1_ra` int(11) DEFAULT NULL,
  `aluno2_ra` int(11) DEFAULT NULL,
  `aluno3_ra` int(11) DEFAULT NULL,
  `nota_final` decimal(4,2) DEFAULT NULL,
  `aprovado` enum('Sim','Não') DEFAULT NULL,
  `curso` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `tipo_tcc_id` int(11) DEFAULT NULL,
  `tcc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agendas`
--

INSERT INTO `agendas` (`id`, `data_hora`, `local`, `prof_orientador_id`, `prof_convidado1_id`, `prof_convidado2_id`, `aluno1_ra`, `aluno2_ra`, `aluno3_ra`, `nota_final`, `aprovado`, `curso`, `cidade`, `tipo_tcc_id`, `tcc_id`) VALUES
(2, '2025-06-06 18:04:00', 'Fatec Praia Grande', 1, 2, 3, 432154366, 2147483647, 439025498, 10.00, 'Sim', 'ADS', 'Praia Grande', 2, 2),
(4, '2025-06-06 18:10:00', 'Fatec Praia Grande', 1, 3, 2, 432154366, NULL, NULL, 54.00, 'Sim', 'ADS', 'Praia Grande', 1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `ra` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `curso` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`ra`, `nome`, `curso`) VALUES
(432154366, 'Menor Gestão', 'ADS'),
(439025498, 'Matheus', 'ADS'),
(643643643, 'Boca', 'ADS'),
(2147483647, 'DJ Ttheu da vm', 'ADS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `area_especializacao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`id`, `nome`, `email`, `area_especializacao`) VALUES
(1, 'Jonatas', 'jonatas@gmail.com', 'TI'),
(2, 'Vagner', 'vagner@gmail.com', 'TI'),
(3, 'Simone', 'simone@gmail.com', 'TI');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tcc`
--

CREATE TABLE `tcc` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `tipo_tcc_id` int(11) DEFAULT NULL,
  `aluno1_ra` int(11) DEFAULT NULL,
  `professor_orientador_id` int(11) DEFAULT NULL,
  `curso` varchar(100) DEFAULT NULL,
  `aluno2_ra` int(11) DEFAULT NULL,
  `aluno3_ra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tcc`
--

INSERT INTO `tcc` (`id`, `titulo`, `tipo_tcc_id`, `aluno1_ra`, `professor_orientador_id`, `curso`, `aluno2_ra`, `aluno3_ra`) VALUES
(2, 'Pesquisa sobre o Chupa-Cabra', 2, 432154366, 1, 'ADS', 2147483647, 439025498),
(4, 'Pesquisa sobre Bebes Reborn', 1, 432154366, 1, 'ADS', NULL, NULL),
(5, 'fdsretgreger', 4, 432154366, 2, 'ADS', 439025498, 2147483647);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_tcc`
--

CREATE TABLE `tipo_tcc` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipo_tcc`
--

INSERT INTO `tipo_tcc` (`id`, `descricao`) VALUES
(1, 'Monografia'),
(2, 'Artigo científico'),
(3, 'Projeto aplicado'),
(4, 'Estudo de caso'),
(5, 'Relatório técnico'),
(6, 'Revisão bibliográfica');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prof_orientador_id` (`prof_orientador_id`),
  ADD KEY `prof_convidado1_id` (`prof_convidado1_id`),
  ADD KEY `prof_convidado2_id` (`prof_convidado2_id`),
  ADD KEY `aluno1_ra` (`aluno1_ra`),
  ADD KEY `aluno2_ra` (`aluno2_ra`),
  ADD KEY `aluno3_ra` (`aluno3_ra`),
  ADD KEY `tipo_tcc_id` (`tipo_tcc_id`),
  ADD KEY `tcc_id` (`tcc_id`);

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`ra`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tcc`
--
ALTER TABLE `tcc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_tcc_id` (`tipo_tcc_id`),
  ADD KEY `aluno_ra` (`aluno1_ra`),
  ADD KEY `professor_orientador_id` (`professor_orientador_id`),
  ADD KEY `aluno2_ra` (`aluno2_ra`),
  ADD KEY `aluno3_ra` (`aluno3_ra`);

--
-- Índices para tabela `tipo_tcc`
--
ALTER TABLE `tipo_tcc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tcc`
--
ALTER TABLE `tcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tipo_tcc`
--
ALTER TABLE `tipo_tcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`prof_orientador_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `agendas_ibfk_2` FOREIGN KEY (`prof_convidado1_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `agendas_ibfk_3` FOREIGN KEY (`prof_convidado2_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `agendas_ibfk_4` FOREIGN KEY (`aluno1_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `agendas_ibfk_5` FOREIGN KEY (`aluno2_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `agendas_ibfk_6` FOREIGN KEY (`aluno3_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `agendas_ibfk_7` FOREIGN KEY (`tipo_tcc_id`) REFERENCES `tipo_tcc` (`id`),
  ADD CONSTRAINT `agendas_ibfk_8` FOREIGN KEY (`tcc_id`) REFERENCES `tcc` (`id`);

--
-- Limitadores para a tabela `tcc`
--
ALTER TABLE `tcc`
  ADD CONSTRAINT `tcc_ibfk_1` FOREIGN KEY (`tipo_tcc_id`) REFERENCES `tipo_tcc` (`id`),
  ADD CONSTRAINT `tcc_ibfk_2` FOREIGN KEY (`aluno1_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `tcc_ibfk_3` FOREIGN KEY (`professor_orientador_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `tcc_ibfk_4` FOREIGN KEY (`aluno2_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `tcc_ibfk_5` FOREIGN KEY (`aluno3_ra`) REFERENCES `aluno` (`ra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
