-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Дек 28 2007 г., 13:01
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.1
-- 
-- БД: `orto`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `zarp_card`
-- 

CREATE TABLE `zarp_card` (
  `id` int(11) NOT NULL auto_increment,
  `sotr` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `stavka` float NOT NULL default '0',
  `ps` int(11) NOT NULL default '0',
  `ph` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Зарплатная карта' AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `zarp_card`
-- 

INSERT INTO `zarp_card` (`id`, `sotr`, `type`, `stavka`, `ps`, `ph`) VALUES (1, 1, 1, 10000, 9, 0);
