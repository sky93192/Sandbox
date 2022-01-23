-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2022 年 01 月 21 日 08:23
-- 伺服器版本: 10.1.19-MariaDB
-- PHP 版本： 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `form_test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `contact_list`
--

CREATE TABLE `contact_list` (
  `id` int(11) NOT NULL,
  `name` varchar(26) CHARACTER SET utf8mb4 NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(60) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(50) NOT NULL,
  `last-edit` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `contact_list`
--

INSERT INTO `contact_list` (`id`, `name`, `gender`, `phone`, `birthday`, `address`, `email`, `last-edit`) VALUES
(1, 'test', 'Male', '0987-654321', '1988-01-02', 'test home', 'test@email.com', '2021-12-16 16:14:56'),
(2, 'aaa', 'Male', '0900-000-000', '0000-00-00', 'eeee', 'asdfe@dsfjsk.com', '2021-12-16 17:23:40'),
(6, 'update', 'Female', '0933-333333', '1333-12-31', 'agdfgeg', 'test@email.com', '2021-12-17 11:18:50'),
(9, 'new', 'Male', '0933-333-333', '1988-01-02', 'agdfgeg', 'sdawfe@mail.com', '2021-12-20 13:48:28');

-- --------------------------------------------------------

--
-- 資料表結構 `library_content`
--

CREATE TABLE `library_content` (
  `isbn` varchar(18) CHARACTER SET utf8mb4 NOT NULL,
  `publisher` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `book_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `price` int(11) NOT NULL,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `library_content`
--

INSERT INTO `library_content` (`isbn`, `publisher`, `book_name`, `author`, `price`, `release_date`) VALUES
('000-000-000-0', '測,試"--', '測,試"', '測試"', 474, '2021-12-26'),
('000-000-000-1', 'test', 'test', 'test', 540, '2021-12-27'),
('000-000-000-2', '測試編輯', '編輯測試', '1231', 550, '2021-12-29'),
('000-000-000-3', '測試', 'test', '資料', 474, '2021-12-31'),
('000-000-000-4', '測試', 'test', '資料', 560, '2021-12-28'),
('000-000-000-5', '測試', '編輯測試', '1231', 550, '2021-12-27'),
('000-000-000-6', '旗標', '測試"', 'STEVE SIEJRING', 550, '2021-12-27'),
('000-000-000-7', '旗標', '測試"', 'STEVE SIEJRING', 474, '2021-12-28'),
('000-000-000-8', '旗標', '編輯測試', 'Wallace', 560, '2021-12-27'),
('000-000-000-9', '旗標', 'test', '資料', 680, '2022-01-01'),
('000-000-001-0', '旗標', 'test', '資料', 560, '2021-12-28'),
('000-000-001-1', 'test', 'test', 'test', 410, '2022-01-03'),
('000-000-001-2', 'aaa', 'bbb2', 'qq', 474, '2021-12-26'),
('000-000-001-3', 'aaa', 'bbb3', 'qq', 555, '2021-12-26'),
('000-000-001-4', 'aaa', 'bbb4', 'qq', 222, '2021-12-26'),
('000-000-001-5', '愛文出版', '連環泡泡', 'qq', 555, '2021-12-26'),
('000-000-001-6', '愛文出版', '連環泡跑', 'qq', 154, '2021-12-26'),
('000-000-001-7', '愛文出版', '連環泡竹', 'qq', 848, '2021-12-26'),
('000-000-001-8', '愛文出版', '連環炮炮', 'qq', 98, '2021-12-26'),
('000-000-002-0', '愛文出版', '連環泡泡柯基', 'qq', 884, '2021-12-11'),
('000-000-002-1', '愛文出版', '連環泡泡貓', 'qq', 9999, '2021-12-14'),
('000-000-002-3', '愛文出版', '衣錦還鄉', 'qq', 323, '2022-01-09'),
('000-000-007-1', 'aaa', 'bbb1', 'qq', 474, '2021-12-26'),
('111-222-333-444-5', '測試', '測試"', '1231', 550, '2022-01-02'),
('957-442-217-8', '旗標', '函式庫參考手冊', '王大砲', 580, '2004-06-13'),
('957-442-245-7', '交通部', '五月花號-英國人,美國人', '氣象局', 666, '2021-12-31'),
('957-442-246-1', 'N8I出版', 'Linux,防火牆', '*YYY', 1688, '2022-01-13'),
('957-442-246-2', '交通部', '台灣的101種天氣', '氣象局', 666, '2022-01-05'),
('957-442-246-7', '旗標', '防火牆頻寬管理連線管制', '施威銘', 560, '2006-07-01'),
('978-711-543-633-7', '人民郵電出版社', 'Linux防火牆', 'STEVE SIEJRING', 474, '2016-11-01'),
('978-986-312-776-6', 'SSS', '假日之森', '竹南', 5445, '1999-10-10'),
('978-986-312-777-6', 'SSS', '假日之森', '竹南', 5445, '0000-00-00'),
('978-986-312-999-9', 'NINI出版\\&', '連環泡泡;"', '毛果', 666, '2021-12-28'),
('aaa000-000-002-1', 'NINI出版', '猜謎1000', '90%', 666, '2022-01-18');

-- --------------------------------------------------------

--
-- 資料表結構 `publisher_info`
--

CREATE TABLE `publisher_info` (
  `publisher` varchar(60) CHARACTER SET utf8mb4 NOT NULL,
  `phone` varchar(13) CHARACTER SET utf8mb4 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `publisher_info`
--

INSERT INTO `publisher_info` (`publisher`, `phone`, `location`) VALUES
('愛文出版', '0999-999999', '台南市玉井區玉田里玉里路777號'),
('旗標', '04-27050888', '台中市西屯區西屯路二段256巷6號3樓之6');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `contact_list`
--
ALTER TABLE `contact_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `library_content`
--
ALTER TABLE `library_content`
  ADD PRIMARY KEY (`isbn`);

--
-- 資料表索引 `publisher_info`
--
ALTER TABLE `publisher_info`
  ADD PRIMARY KEY (`publisher`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `contact_list`
--
ALTER TABLE `contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
