-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Мар 10 2007 г., 20:45
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.0
-- 
-- БД: `test`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `CatDs`
-- 

CREATE TABLE `catds` (
  `id` int(11) NOT NULL auto_increment,
  `Nazv` varchar(50) NOT NULL default '',
  `upID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `upID` (`upID`)
) TYPE=MyISAM COMMENT='Категории дигнозов' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `CatDs`
-- 

