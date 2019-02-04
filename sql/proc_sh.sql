-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Дек 28 2007 г., 13:02
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.1
-- 
-- БД: `orto`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `proc_sh`
-- 

CREATE TABLE `proc_sh` (
  `id` int(11) NOT NULL auto_increment,
  `naim` varchar(200) NOT NULL default '',
  `type` int(11) NOT NULL default '0',
  `proc` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Процентные схемы' AUTO_INCREMENT=11 ;

-- 
-- Дамп данных таблицы `proc_sh`
-- 

INSERT INTO `proc_sh` (`id`, `naim`, `type`, `proc`) VALUES (1, '14%', 0, 0),
(2, '15%', 0, 0),
(3, '16%', 0, 0),
(4, '17%', 0, 0),
(5, '18%', 0, 0),
(6, '19%', 0, 0),
(7, '20%', 0, 0),
(8, '21%', 0, 0),
(9, 'Схема 3 года', 0, 0),
(10, 'Схема техник', 0, 0);
