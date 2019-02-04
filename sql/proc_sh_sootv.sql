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
-- Структура таблицы `proc_sh_sootv`
-- 

CREATE TABLE `proc_sh_sootv` (
  `id` int(11) NOT NULL auto_increment,
  `proc_sh` int(11) NOT NULL default '0',
  `predel` float NOT NULL default '0',
  `proc` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='соответсвия в процентной схеме' AUTO_INCREMENT=14 ;

-- 
-- Дамп данных таблицы `proc_sh_sootv`
-- 

INSERT INTO `proc_sh_sootv` (`id`, `proc_sh`, `predel`, `proc`) VALUES (1, 1, 1e+007, 14),
(2, 2, 1e+007, 15),
(3, 3, 1e+007, 16),
(4, 4, 1e+007, 17),
(5, 5, 1e+007, 18),
(6, 6, 1e+007, 19),
(7, 7, 1e+007, 20),
(8, 8, 1e+007, 21),
(9, 9, 100000, 18),
(10, 9, 150000, 19),
(11, 9, 1e+007, 21),
(12, 10, 100000, 18),
(13, 10, 1e+007, 19.5);
