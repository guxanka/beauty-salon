-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 17 2026 г., 10:43
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `beauty_lab`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','director') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password_hash`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$xmhHrpr4ZnjJR0eYbzzqle/LKTDy/j1q8FsLOryTZWt/XXaoXHgZa', 'admin', '2026-05-07 20:10:02'),
(2, 'director', '$2y$10$C0HPX.ECgu/eCF1J3.yZVOkippYx/H9r41CaYifVXB8BnheY3MSZq', 'director', '2026-05-07 20:10:02');

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `master_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('new','confirmed','cancelled','completed') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `client_id`, `master_id`, `service_id`, `booking_date`, `booking_time`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 22, '2026-05-13', '12:30:00', '', 'cancelled', '2026-05-11 18:19:22', '2026-05-11 18:21:35'),
(2, 4, 7, 25, '2026-05-18', '13:00:00', '', 'cancelled', '2026-05-11 18:24:15', '2026-05-11 18:24:50'),
(3, 4, 7, 24, '2026-05-12', '10:00:00', '', 'confirmed', '2026-05-11 18:25:22', '2026-05-11 18:25:55'),
(5, 3, 7, 22, '2026-05-12', '11:00:00', '', 'confirmed', '2026-05-11 18:50:36', '2026-05-11 18:51:26'),
(6, 4, 7, 7, '2026-05-12', '13:30:00', '', 'cancelled', '2026-05-11 18:52:50', '2026-05-11 18:53:23'),
(9, 3, 7, 15, '2026-05-12', '13:00:00', '', 'confirmed', '2026-05-11 19:01:33', '2026-05-11 19:01:49'),
(10, 3, 7, 21, '2026-05-12', '15:00:00', '', 'cancelled', '2026-05-11 19:07:07', '2026-05-11 19:07:14'),
(20, 3, 7, 24, '2026-06-17', '10:30:00', '', 'cancelled', '2026-06-17 08:40:11', '2026-06-17 08:40:55');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, '24234234', '89235077002', 'andreyka.tsvelev@mail.ru', '$2y$10$laF4imWCjdoLMsF60RDBeu0jemLjvpFBzD5KpD.liYQS7iL2CQWv.', '2026-05-07 20:26:33', '2026-05-07 20:26:33'),
(2, 'Алена', '+79502664890', 'name@example.com', '$2y$10$k.BuCmoKkcfjbAKazvECC.mY8lOF14rvF2GIEECb4x9UrDbADFaxK', '2026-05-07 20:33:46', '2026-05-07 20:33:46'),
(3, 'Тест', '+79999999999', 'test@gmail.com', '$2y$10$gi0O5KNoU4SU3taxAUjDnennsHuLprb3nI5Z6ouHfX9St8E4ckV56', '2026-05-11 16:57:44', '2026-05-11 16:57:44'),
(4, 'ТЕстиров', '8923999-99-99', '', '$2y$10$VDPOBt2hD6It8UubRe5gCeqnT8pViJW.88xk3rxjOXGZaghJhXAiO', '2026-05-11 18:19:22', '2026-05-11 18:19:22');

-- --------------------------------------------------------

--
-- Структура таблицы `masters`
--

CREATE TABLE `masters` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews_count` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `masters`
--

INSERT INTO `masters` (`id`, `name`, `specialization`, `description`, `photo`, `rating`, `reviews_count`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Елена', 'Администратор-координатор', 'Координатор работы в салоне, администратор записи. Стаж работы в салоне более 10 лет.', 'master_1781684947.JPG', 4.90, 156, 1, '2026-05-11 17:16:19', '2026-06-17 08:29:07'),
(2, 'Настя', 'Женский зал, SPA-уходы, окрашивание, стрижки', 'SPA-уход для кожи головы — это настоящая симфония красоты и гармонии, где каждая нота создаёт неповторимую мелодию преображения. Словно заботливые руки природы, профессиональные процедуры окутывают вашу голову нежным облаком заботы, даря волосам новую жизнь. Стаж 4 года.', NULL, 4.80, 98, 1, '2026-05-11 17:16:19', '2026-05-11 17:16:19'),
(3, 'Оксана', 'Топ-мастер-универсал', 'Мастер-универсал: мужские и женские стрижки, окрашивание, мелирование, сложные окрашивания. Стаж 15 лет.', 'master_1781684956.JPG', 4.90, 203, 1, '2026-05-11 17:16:19', '2026-06-17 08:29:16'),
(4, 'Полина', 'Мужской парикмахер, бровист-броудизайнер', 'Молодой специалист. Повышение квалификации: \"БАРБЕР\". Стаж 2 года.', NULL, 4.60, 47, 1, '2026-05-11 17:16:19', '2026-05-11 17:16:19'),
(5, 'Татьяна', 'Администратор-координатор', 'Координатор работы в салоне, администратор записи. Стаж работы в салоне более 9 лет.', NULL, 4.80, 134, 1, '2026-05-11 17:16:19', '2026-05-11 17:16:19'),
(6, 'Галина', 'Топ-мастер-универсал', 'Мастер-универсал: мужские и женские стрижки, окрашивание, мелирование, сложные окрашивания. Стаж 15 лет.', 'master_1781684935.JPG', 4.90, 187, 1, '2026-05-11 17:16:19', '2026-06-17 08:28:55'),
(7, 'Алексей', 'Топ-мастер-универсал', 'Мастер-универсал: мужские и женские стрижки, окрашивание, мелирование, сложные окрашивания. Стаж 15 лет.', 'master_1781684535.JPG', 4.90, 175, 1, '2026-05-11 17:16:19', '2026-06-17 08:43:01');

-- --------------------------------------------------------

--
-- Структура таблицы `master_services`
--

CREATE TABLE `master_services` (
  `master_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `master_vacations`
--

CREATE TABLE `master_vacations` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `duration_min` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `category`, `duration_min`, `price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Авторское окрашивание', 'Тотальная перезагрузка цвета — смывка, анализ структуры, персональная формула', 'coloring', 360, 9500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(2, 'Сложная техника окрашивания', 'Airtouch, балаяж, шатуш — растяжка цвета с эффектом натуральности', 'coloring', 210, 7500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(3, 'Окрашивание сложное (коррекция)', 'Обновление балаяж / шатуш — работа с отросшей зоной', 'coloring', 150, 5500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(4, 'Экстра блонд', 'Осветление прикорневой зоны с тонированием', 'coloring', 150, 4500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(5, 'Окрашивание КЛАССИКА (полное)', 'Равномерное окрашивание по всей длине в один тон', 'coloring', 120, 3800.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(6, 'Мелирование (классика)', 'Осветление прядей — коррекция без тонирования', 'coloring', 120, 4500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(7, 'Мелирование', 'Частичное осветление прядей — акценты и блики', 'coloring', 90, 2000.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(8, 'Экспресс-тонирование PRIMA', 'Краска-пена — чистота и глубина цвета за 40–60 минут', 'coloring', 50, 2100.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(9, 'Камуфляж седины ALPHA | PRIMA', 'Тонирование седых волос — естественный результат', 'coloring', 60, 1500.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(10, 'Стрижка женская + мытьё + сушка', 'Стрижка с финишной укладкой по форме', 'haircuts_women', 60, 1200.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(11, 'Экспресс-стрижка', 'Подравнивание кончиков на сухих волосах — один срез', 'haircuts_women', 30, 800.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(12, 'Плетение косичек', 'Различные виды плетения — от повседневного до вечернего', 'haircuts_women', 45, 1000.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(13, 'Стрижка мужская комплекс', 'Классическая мужская стрижка машинкой и ножницами', 'haircuts_men', 45, 700.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(14, 'Стрижка мужская КОМПЛЕКС+', 'Расширенный комплекс — стрижка, мытьё, укладка', 'haircuts_men', 60, 900.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(15, 'Стрижка + правка бороды', 'Комплексное оформление — стрижка головы и моделирование бороды', 'haircuts_men', 75, 1200.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(16, 'Стрижка налысо', 'Чистое бритьё головы', 'haircuts_men', 20, 260.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(17, 'Удаление волос на лице', 'Коррекция линии роста волос', 'haircuts_men', 15, 200.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(18, 'Сервис для мужчин', 'Мытьё-пилинг, свето-массаж головы, восстанавливающая ампула', 'haircuts_men', 45, 1300.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(19, 'Экспресс-сушка волос', 'Быстрая сушка феном с расчёсыванием', 'styling', 20, 650.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(20, 'Укладка феном (вечерняя)', 'Объёмная или гладкая укладка со стайлингом', 'styling', 45, 1000.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(21, 'Причёска вечерняя', 'Сложная вечерняя причёска для особого случая', 'styling', 75, 2000.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(22, 'Детокс кожи головы + реконструкция', 'Молекулярное очищение, пенное обёртывание с протеинами, гиалуроновое восстановление', 'care', 60, 1600.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(23, 'Уходы для волос и кожи головы', 'Базовый восстанавливающий уход — питание и увлажнение', 'care', 30, 350.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(24, 'Долговременная укладка бровей', 'Ламинирование + коррекция + окрашивание', 'brows', 60, 1100.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(25, 'Коррекция + окрашивание бровей', 'Точная форма + подобранный оттенок', 'brows', 40, 680.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(26, 'Коррекция бровей', 'Пинцет / воск — чёткий контур', 'brows', 20, 300.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01'),
(27, 'Окрашивание бровей или ресниц', 'Краска / хна — выразительный взгляд', 'brows', 20, 300.00, 1, '2026-05-07 20:10:01', '2026-05-07 20:10:01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slot` (`master_id`,`booking_date`,`booking_time`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `idx_bookings_date` (`booking_date`),
  ADD KEY `idx_bookings_master_date` (`master_id`,`booking_date`),
  ADD KEY `idx_bookings_client` (`client_id`),
  ADD KEY `idx_bookings_status` (`status`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `master_services`
--
ALTER TABLE `master_services`
  ADD PRIMARY KEY (`master_id`,`service_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Индексы таблицы `master_vacations`
--
ALTER TABLE `master_vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_services_category` (`category`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `masters`
--
ALTER TABLE `masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `master_vacations`
--
ALTER TABLE `master_vacations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`master_id`) REFERENCES `masters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `master_services`
--
ALTER TABLE `master_services`
  ADD CONSTRAINT `master_services_ibfk_1` FOREIGN KEY (`master_id`) REFERENCES `masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `master_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `master_vacations`
--
ALTER TABLE `master_vacations`
  ADD CONSTRAINT `master_vacations_ibfk_1` FOREIGN KEY (`master_id`) REFERENCES `masters` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
