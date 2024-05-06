-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: d123181.mysql.zonevs.eu
-- Время создания: Май 06 2024 г., 09:37
-- Версия сервера: 10.4.32-MariaDB-log
-- Версия PHP: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d123181_andmebaas`
--

-- --------------------------------------------------------

--
-- Структура таблицы `konsultatsioon`
--

CREATE TABLE `konsultatsioon` (
  `id` int(11) NOT NULL,
  `paev` varchar(20) NOT NULL,
  `tund` varchar(100) DEFAULT NULL,
  `klassiruum` int(11) DEFAULT NULL,
  `periood` int(11) DEFAULT NULL,
  `kommentaar` varchar(100) DEFAULT NULL,
  `opetajaNimi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `konsultatsioon`
--

INSERT INTO `konsultatsioon` (`id`, `paev`, `tund`, `klassiruum`, `periood`, `kommentaar`, `opetajaNimi`) VALUES
(1, 'Esmaspäev', '4', 236, 1, '12.06 jääb ära', 'Silvia Lepik'),
(2, 'Neljapäev', '9', 139, 1, '24.05 kell 18.00', 'Aivas Roos'),
(3, 'Kolmapäev', '8', 236, 2, '-', 'Silvia Lepik'),
(4, 'Esmaspäev', '9', 236, 3, '-', 'Silvia Lepik'),
(5, 'Kolmapäev', '9', 236, 4, '-', 'Silvia Lepik'),
(6, 'Esmaspäev', '11', 236, 5, '-', 'Silvia Lepik'),
(7, 'Reede', '10', 139, 2, '-', 'Aivas Roos'),
(8, 'Neljapäev', '10', 139, 3, '-', 'Aivas Roos'),
(9, 'Reede', '10', 129, 4, '-', 'Aivas Roos'),
(10, 'Neljapäev', '10', 139, 5, '-', 'Aivas Roos'),
(11, '-', '-', 346, 1, 'pole mingeid konsultatsioone', 'Taivos Mang');


INSERT INTO `konsultatsioon` (`id`, `paev`, `tund`, `klassiruum`, `periood`, `kommentaar`, `opetajaNimi`) VALUES
(12, 'Esmaspäev', '4', 236, 1, '12.06 jääb ära', 'Klopats Lepik'),
(13, 'Neljapäev', '9', 139, 1, '24.05 kell 18.00', 'Aivas Pots');
--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `konsultatsioon`
--
ALTER TABLE `konsultatsioon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `konsultatsioon`
--
ALTER TABLE `konsultatsioon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
