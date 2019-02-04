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
-- Структура таблицы `nadb`
-- 

CREATE TABLE `nadb` (
  `id` int(11) NOT NULL auto_increment,
  `summ` int(11) NOT NULL default '0',
  `naim` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Надбавки к зарплате' AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `nadb`
-- 

INSERT INTO `nadb` (`id`, `summ`, `naim`) VALUES (1, 300, 'сок за вредность'),
(2, 5000, 'За старшую мед сестру');
