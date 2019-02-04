-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Дек 28 2007 г., 13:03
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.1
-- 
-- БД: `orto`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `nadb_sootv`
-- 

CREATE TABLE `nadb_sootv` (
  `id` int(11) NOT NULL auto_increment,
  `zc` int(11) NOT NULL default '0',
  `nadb` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Соответсвия в зарплатной карте' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nadb_sootv`
-- 

