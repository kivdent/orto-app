-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Апр 04 2007 г., 18:16
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.0
-- 
-- БД: `test`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `mater`
-- 

CREATE TABLE `mater` (
  `id` int(11) NOT NULL auto_increment,
  `naim` varchar(100) NOT NULL default '',
  `edizm` int(11) NOT NULL default '0',
  `PrPakc` float NOT NULL default '0',
  `QPack` int(11) NOT NULL default '0',
  `UpId` int(11) NOT NULL default '0',
  `Cat` int(11) NOT NULL default '0',
  `MinSk` int(11) NOT NULL default '0',
  `MinKl` int(11) NOT NULL default '0',
  `prim` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `naim` (`naim`)
) TYPE=MyISAM COMMENT='Материалы' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `mater`
-- 

