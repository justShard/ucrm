-- phpMyAdmin SQL Dump

-- version 5.1.0

-- https://www.phpmyadmin.net/

--

-- Хост: 127.0.0.1

-- Час створення: Трв 15 2025 р., 13:44

-- Версія сервера: 10.4.19-MariaDB

-- Версія PHP: 7.3.28



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";





/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;



--

-- База даних: `ucrm`

--

https://chatgpt.com/share/6825d75e-da10-800f-b863-476f2c871eaf

-- --------------------------------------------------------



--

-- Структура таблиці `docs`

--



CREATE TABLE `docs` (

`docs_id` int(11) NOT NULL,

`docs_hash` int(11) NOT NULL,

`docs_name` varchar(32) NOT NULL,

`docs_type_id` int(11) DEFAULT NULL,

`docs_status_id` int(11) DEFAULT NULL,

`access_id` int(11) DEFAULT NULL,

`priority_id` int(11) DEFAULT NULL,

`abstract` varchar(256) DEFAULT NULL,

`parent_docs_id` int(11) DEFAULT NULL,

`deadline` datetime DEFAULT NULL,

`date_created` datetime NOT NULL DEFAULT current_timestamp(),

`date_updated` datetime NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `docs_employee` (

`docs_id` int(11) NOT NULL,

`employee_id` int(11) NOT NULL,

`position_id` int(11) DEFAULT NULL,

`signed` tinyint(4) NOT NULL DEFAULT 0

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `docs_files` (

`doc_id` int(11) NOT NULL,

`file_id` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `docs_status` (

`docs_status_id` int(11) NOT NULL,

`docs_status_name` varchar(32) NOT NULL,

`active` tinyint(4) NOT NULL DEFAULT 1

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







INSERT INTO `docs_status` (`docs_status_id`, `docs_status_name`, `active`) VALUES

(1, 'Новий', 1),

(2, 'На узгодженні', 1),

(3, 'Повернутий з узгодження', 1),

(4, 'На доопрацюванні', 1),

(5, 'Узгоджений', 1),

(6, 'На розгляді', 1),

(7, 'На виконанні', 1),

(8, 'Виконаний', 1),

(9, 'Закритий', 1);







CREATE TABLE `docs_type` (

`docs_type_id` int(11) NOT NULL,

`docs_type_name` varchar(64) NOT NULL,

`active` tinyint(11) NOT NULL DEFAULT 1

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;





INSERT INTO `docs_type` (`docs_type_id`, `docs_type_name`, `active`) VALUES

(1, 'Службові', 1),

(2, 'Розпорядження', 1),

(3, 'Накази', 1),

(4, 'Інформаційна розсилка', 1);







CREATE TABLE `doc_access` (

`access_id` int(11) NOT NULL,

`access_name` varchar(32) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







INSERT INTO `doc_access` (`access_id`, `access_name`) VALUES

(2, 'Загальний'),

(1, 'Приватний');







CREATE TABLE `employee` (

`employee_id` int(11) NOT NULL,

`employee_name` varchar(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `files` (

`file_id` int(11) NOT NULL,

`file_path` varchar(256) NOT NULL,

`file_type` varchar(8) NOT NULL DEFAULT '',

`size` int(11) DEFAULT NULL,

`date_created` date NOT NULL DEFAULT current_timestamp(),

`hash` varchar(256) DEFAULT NULL,

`employee_id` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







CREATE TABLE `priority_id` (

`priority_id` int(11) NOT NULL,

`priority_name` varchar(32) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;







INSERT INTO `priority_id` (`priority_id`, `priority_name`) VALUES

(1, 'Без контролю'),

(2, 'Особливий');





ALTER TABLE `docs`

ADD PRIMARY KEY (`docs_id`),

ADD KEY `access_id` (`access_id`),

ADD KEY `docs_status_id` (`docs_status_id`),

ADD KEY `docs_type_id` (`docs_type_id`),

ADD KEY `priority_id` (`priority_id`);





ALTER TABLE `docs_employee`

ADD UNIQUE KEY `docs_id` (`docs_id`,`employee_id`),

ADD KEY `employee_id` (`employee_id`);





ALTER TABLE `docs_files`

ADD UNIQUE KEY `doc_id` (`doc_id`,`file_id`),

ADD KEY `file_id` (`file_id`);





ALTER TABLE `docs_status`

ADD PRIMARY KEY (`docs_status_id`),

ADD UNIQUE KEY `docs_status_name` (`docs_status_name`);





ALTER TABLE `docs_type`

ADD PRIMARY KEY (`docs_type_id`),

ADD UNIQUE KEY `docs_type_name` (`docs_type_name`);





ALTER TABLE `doc_access`

ADD PRIMARY KEY (`access_id`),

ADD UNIQUE KEY `access_name` (`access_name`);





ALTER TABLE `employee`

ADD PRIMARY KEY (`employee_id`);





ALTER TABLE `files`

ADD PRIMARY KEY (`file_id`);





ALTER TABLE `priority_id`

ADD PRIMARY KEY (`priority_id`),

ADD UNIQUE KEY `priority_name` (`priority_name`);





ALTER TABLE `docs`

MODIFY `docs_id` int(11) NOT NULL AUTO_INCREMENT;





ALTER TABLE `docs_status`

MODIFY `docs_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;





ALTER TABLE `docs_type`

MODIFY `docs_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;





ALTER TABLE `doc_access`

MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



ALTER TABLE `employee`

MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;





ALTER TABLE `files`

MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;





ALTER TABLE `priority_id`

MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;





ALTER TABLE `docs`

ADD CONSTRAINT `docs_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `doc_access` (`access_id`),

ADD CONSTRAINT `docs_ibfk_2` FOREIGN KEY (`docs_status_id`) REFERENCES `docs_status` (`docs_status_id`),

ADD CONSTRAINT `docs_ibfk_3` FOREIGN KEY (`docs_type_id`) REFERENCES `docs_type` (`docs_type_id`),

ADD CONSTRAINT `docs_ibfk_4` FOREIGN KEY (`priority_id`) REFERENCES `priority_id` (`priority_id`);





ALTER TABLE `docs_employee`

ADD CONSTRAINT `docs_employee_ibfk_1` FOREIGN KEY (`docs_id`) REFERENCES `docs` (`docs_id`),

ADD CONSTRAINT `docs_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);





ALTER TABLE `docs_files`

ADD CONSTRAINT `docs_files_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `docs` (`docs_id`),

ADD CONSTRAINT `docs_files_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;p
