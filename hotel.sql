-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Июн 26 2021 г., 19:02
-- Версия сервера: 8.0.25
-- Версия PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hotel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `params_table`
--

CREATE TABLE `params_table` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `params_table`
--

INSERT INTO `params_table` (`id`, `name`) VALUES
(1, 'Наличие Wi-fi'),
(2, 'Личная терраса');

-- --------------------------------------------------------

--
-- Структура таблицы `params_value_table`
--

CREATE TABLE `params_value_table` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `param_id` int NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `params_value_table`
--

INSERT INTO `params_value_table` (`id`, `room_id`, `param_id`, `value`) VALUES
(1, 1, 1, 'Да'),
(2, 1, 2, 'Есть');

-- --------------------------------------------------------

--
-- Структура таблицы `photos_table`
--

CREATE TABLE `photos_table` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rooms_table`
--

CREATE TABLE `rooms_table` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `count_person` int NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `rooms_table`
--

INSERT INTO `rooms_table` (`id`, `name`, `count_person`, `description`) VALUES
(1, 'test room', 2, 'opisanie');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `params_table`
--
ALTER TABLE `params_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `params_value_table`
--
ALTER TABLE `params_value_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `param_id` (`param_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Индексы таблицы `photos_table`
--
ALTER TABLE `photos_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Индексы таблицы `rooms_table`
--
ALTER TABLE `rooms_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `params_table`
--
ALTER TABLE `params_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `params_value_table`
--
ALTER TABLE `params_value_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `photos_table`
--
ALTER TABLE `photos_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rooms_table`
--
ALTER TABLE `rooms_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `params_value_table`
--
ALTER TABLE `params_value_table`
  ADD CONSTRAINT `params_value_table_ibfk_1` FOREIGN KEY (`param_id`) REFERENCES `params_table` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `params_value_table_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `photos_table`
--
ALTER TABLE `photos_table`
  ADD CONSTRAINT `photos_table_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms_table` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
