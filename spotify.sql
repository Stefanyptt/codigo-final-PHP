-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 21-Nov-2018 às 11:37
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` bigint(20) NOT NULL,
  `cpf` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomeCliente` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataNasc` date NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipoPlano` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formaPagamento` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `cpf`, `nomeCliente`, `dataNasc`, `tel`, `email`, `sexo`, `endereco`, `tipoPlano`, `formaPagamento`) VALUES
(11, '051.184.320-81', 'Leonardo Da Silva', '1996-09-04', '55 51 99854-0987', 'leonardo@gmail.com', 'Masculino', 'Rua Dona Maria Isabel 469', 'Premium Estudante', ''),
(12, '71704931072', 'Luisa Gabriela', '1999-03-30', '5551 98634-3745', 'luisa@gabriela.com', 'Feminino', 'Rua Clovis Bevilacqua 200', 'Premium Family', ''),
(13, '123.456.789-10', 'Xuxu Azedo', '2000-04-02', '300 91827434', 'xuxu@gmail.com', 'Feminino', '', 'Premium', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica`
--

CREATE TABLE `musica` (
  `idMusica` bigint(20) NOT NULL,
  `nomeMusica` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataLancMus` date NOT NULL,
  `cantorBanda` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `musica`
--

INSERT INTO `musica` (`idMusica`, `nomeMusica`, `dataLancMus`, `cantorBanda`, `genero`, `album`) VALUES
(3, 'Haha', '2011-03-04', 'The Animals', 'Rock', 'Chove Chuva'),
(4, 'Huhu', '1989-08-06', 'Nx Zero', 'Pop', 'Gugu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `login` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `login`, `senha`, `tipo`) VALUES
(1, 'stefany', '1f591a4c440e29f36bc86358a832dcd1', 'adm'),
(2, 'haha', '673493be69b0ae50524d56346c5ffd4c', 'cliente'),
(3, 'huhu', 'd0994a8045ca160000fa0f2c2fecf81d', 'cliente'),
(4, 'leonardo', '1f591a4c440e29f36bc86358a832dcd1', 'cliente'),
(5, 'lu', '1f591a4c440e29f36bc86358a832dcd1', 'cliente'),
(6, 'xuxu', '1f591a4c440e29f36bc86358a832dcd1', 'cliente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `musica`
--
ALTER TABLE `musica`
  ADD PRIMARY KEY (`idMusica`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `musica`
--
ALTER TABLE `musica`
  MODIFY `idMusica` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
