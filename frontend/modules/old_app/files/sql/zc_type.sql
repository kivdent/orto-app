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
-- Структура таблицы `zc_type`
-- 

CREATE TABLE `zc_type` (
  `id` int(11) NOT NULL auto_increment,
  `naim` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Типы зарплатных карт' AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `zc_type`
-- 

INSERT INTO `zc_type` (`id`, `naim`) VALUES (1, 'Процент от выручки'),
(2, 'Ставка'),
(3, 'Почасовая оплата');
