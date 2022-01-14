-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2022 年 01 月 13 日 11:02
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
('000-000-000-0', '測試&quot;--', '測試&quot;', '測試&quot;', 474, '2021-12-26'),
('000-000-000-1', '測試', 'test', '資料', 474, '2021-12-26'),
('000-000-000-2', '測試編輯', '編輯測試', '1231', 550, '2021-12-29'),
('000-000-000-3', '測試', 'test', '資料', 474, '2021-12-31'),
('000-000-000-4', '測試', 'test', '資料', 560, '2021-12-28'),
('000-000-000-5', '測試', '編輯測試', '1231', 550, '2021-12-27'),
('000-000-000-6', '旗標', '測試&quot;', 'STEVE SIEJRING', 550, '2021-12-27'),
('000-000-000-7', '旗標', '測試&quot;', 'STEVE SIEJRING', 474, '2021-12-28'),
('000-000-000-8', '旗標', '編輯測試', 'Wallace', 560, '2021-12-27'),
('000-000-000-9', '旗標', 'test', '資料', 680, '2022-01-01'),
('000-000-001-0', '旗標', 'test', '資料', 560, '2021-12-28'),
('000-000-001-1', '旗標', '應該要分頁了', '1231', 550, '2022-01-01'),
('111-222-333-444-5', '測試', '測試&quot;', '1231', 550, '2022-01-02'),
('957-442-217-8', '旗標', '函式庫參考手冊', '王大砲', 580, '2004-06-13'),
('957-442-246-7', '旗標', '防火牆頻寬管理連線管制', '施威銘', 560, '2006-07-01'),
('978-711-543-633-7', '人民郵電出版社', 'Linux防火牆', 'STEVE SIEJRING', 474, '2016-11-01'),
('978-986-312-999-9', 'NINI出版\\&amp;', '連環泡泡;&quot;', '毛果', 666, '2021-12-28');

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
