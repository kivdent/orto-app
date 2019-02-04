-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Апр 04 2007 г., 21:16
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.0
-- 
-- БД: `test`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `edizm`
-- 

CREATE TABLE `edizm` (
  `id` int(11) NOT NULL auto_increment,
  `abbr` varchar(5) NOT NULL default '',
  `naim` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Едкницы измерения' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `edizm`
-- 

