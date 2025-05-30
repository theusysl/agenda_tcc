-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Maio-2025 às 23:05
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
  `tipo_tcc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `ra` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `curso` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tcc`
--

CREATE TABLE `tcc` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `tipo_tcc_id` int(11) DEFAULT NULL,
  `aluno_ra` int(11) DEFAULT NULL,
  `professor_orientador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_tcc`
--

CREATE TABLE `tipo_tcc` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `tipo_tcc_id` (`tipo_tcc_id`);

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
  ADD KEY `aluno_ra` (`aluno_ra`),
  ADD KEY `professor_orientador_id` (`professor_orientador_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tcc`
--
ALTER TABLE `tcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_tcc`
--
ALTER TABLE `tipo_tcc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `agendas_ibfk_7` FOREIGN KEY (`tipo_tcc_id`) REFERENCES `tipo_tcc` (`id`);

--
-- Limitadores para a tabela `tcc`
--
ALTER TABLE `tcc`
  ADD CONSTRAINT `tcc_ibfk_1` FOREIGN KEY (`tipo_tcc_id`) REFERENCES `tipo_tcc` (`id`),
  ADD CONSTRAINT `tcc_ibfk_2` FOREIGN KEY (`aluno_ra`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `tcc_ibfk_3` FOREIGN KEY (`professor_orientador_id`) REFERENCES `professor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
