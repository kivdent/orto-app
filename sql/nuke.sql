-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Фев 13 2007 г., 08:51
-- Версия сервера: 4.0.26
-- Версия PHP: 4.4.0
-- 
-- БД: `test`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `klinikpat`
-- 

CREATE TABLE `klinikpat` (
  `id` double NOT NULL auto_increment,
  `surname` varchar(20) NOT NULL default '',
  `name` varchar(15) NOT NULL default '',
  `otch` varchar(15) NOT NULL default '',
  `dr` date NOT NULL default '0000-00-00',
  `sex` varchar(5) NOT NULL default '',
  `adres` mediumtext NOT NULL,
  `MestRab` varchar(15) NOT NULL default '',
  `prof` varchar(15) NOT NULL default '',
  `email` varchar(15) NOT NULL default '',
  `DTel` varchar(15) NOT NULL default '',
  `RTel` varchar(15) NOT NULL default '',
  `MTel` varchar(15) NOT NULL default '',
  `FLech` varchar(15) NOT NULL default '',
  `Skidka` varchar(15) NOT NULL default '',
  `Prim` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `surname` (`surname`,`name`)
) TYPE=MyISAM COMMENT='Пациенты клиники' AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `klinikpat`
-- 

INSERT INTO `klinikpat` (`id`, `surname`, `name`, `otch`, `dr`, `sex`, `adres`, `MestRab`, `prof`, `email`, `DTel`, `RTel`, `MTel`, `FLech`, `Skidka`, `Prim`) VALUES (1, 'Иванов', 'Иван', 'Иванович', '1982-02-04', 'муж', 'г.Новокузнецк, Кирова45-255', 'Завод', 'Директор', '', '11111', '222222', '3333333', 'наличные', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_authors`
-- 

CREATE TABLE `nuke_authors` (
  `aid` varchar(25) NOT NULL default '',
  `name` varchar(50) default NULL,
  `url` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `pwd` varchar(40) default NULL,
  `counter` int(11) NOT NULL default '0',
  `radminsuper` tinyint(1) NOT NULL default '1',
  `admlanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`aid`),
  KEY `aid` (`aid`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_authors`
-- 

INSERT INTO `nuke_authors` (`aid`, `name`, `url`, `email`, `pwd`, `counter`, `radminsuper`, `admlanguage`) VALUES ('kivdent', 'God', 'http://', 'kivdent@yandex.ru', '597cb1c46559ed712d13061c0e80e6af', 2, 1, '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_autonews`
-- 

CREATE TABLE `nuke_autonews` (
  `anid` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `aid` varchar(30) NOT NULL default '',
  `title` varchar(80) NOT NULL default '',
  `time` varchar(19) NOT NULL default '',
  `hometext` text NOT NULL,
  `bodytext` text NOT NULL,
  `topic` int(3) NOT NULL default '1',
  `informant` varchar(20) NOT NULL default '',
  `notes` text NOT NULL,
  `ihome` int(1) NOT NULL default '0',
  `alanguage` varchar(30) NOT NULL default '',
  `acomm` int(1) NOT NULL default '0',
  `associated` text NOT NULL,
  PRIMARY KEY  (`anid`),
  KEY `anid` (`anid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_autonews`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banned_ip`
-- 

CREATE TABLE `nuke_banned_ip` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(15) NOT NULL default '',
  `reason` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_banned_ip`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banner`
-- 

CREATE TABLE `nuke_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `alttext` varchar(255) NOT NULL default '',
  `date` datetime default NULL,
  `dateend` datetime default NULL,
  `position` int(10) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `ad_class` varchar(5) NOT NULL default '',
  `ad_code` text NOT NULL,
  `ad_width` int(4) default '0',
  `ad_height` int(4) default '0',
  PRIMARY KEY  (`bid`),
  KEY `bid` (`bid`),
  KEY `cid` (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_banner`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banner_clients`
-- 

CREATE TABLE `nuke_banner_clients` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `login` varchar(10) NOT NULL default '',
  `passwd` varchar(10) NOT NULL default '',
  `extrainfo` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_banner_clients`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banner_plans`
-- 

CREATE TABLE `nuke_banner_plans` (
  `pid` int(10) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `delivery` varchar(10) NOT NULL default '',
  `delivery_type` varchar(25) NOT NULL default '',
  `price` varchar(25) NOT NULL default '0',
  `buy_links` text NOT NULL,
  PRIMARY KEY  (`pid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_banner_plans`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banner_positions`
-- 

CREATE TABLE `nuke_banner_positions` (
  `apid` int(10) NOT NULL auto_increment,
  `position_number` int(5) NOT NULL default '0',
  `position_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`apid`),
  KEY `position_number` (`position_number`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `nuke_banner_positions`
-- 

INSERT INTO `nuke_banner_positions` (`apid`, `position_number`, `position_name`) VALUES (1, 0, 'Page Top'),
(2, 1, 'Left Block'),
(3, 2, 'Right Block');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_banner_terms`
-- 

CREATE TABLE `nuke_banner_terms` (
  `terms_body` text NOT NULL,
  `country` varchar(255) NOT NULL default ''
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_banner_terms`
-- 

INSERT INTO `nuke_banner_terms` (`terms_body`, `country`) VALUES ('<div align="justify"><strong>Introduction:</strong> This Agreement between you and&nbsp;[sitename] consists of these Terms and Conditions. &quot;You&quot; or &quot;Advertiser&quot; means the entity identified in this enrollment form, and/or any agency acting on its behalf, which shall also be bound by the terms of this Agreement. Please read very carefully these Terms and Conditions.<br /><strong><br />Uses:</strong> You agree that your ads may be placed on (i) [sitename] web site and (ii) Any ads may be modified without your consent to comply with any policy of [sitename]. [sitename] reserves the right to, and in its sole discretion may, at any time review, reject, modify, or remove any ad. No liability of [sitename] and/or its owner(s) shall result from any such decision.<br /><br /></div><div align="justify"><strong>Parties&#039; Responsibilities:</strong> You are responsible of your own site and/or service advertised in [sitename] web site. You are solely responsible for the advertising image creation, advertising text and for the content of your ads, including URL links. [sitename] is not responsible for anything regarding your Web site(s) including, but not limited to, maintenance of your Web site(s), order entry, customer service, payment processing, shipping, cancellations or returns.<br /><br /></div><div align="justify"><strong>Impressions Count:</strong> Any hit to [sitename] web site is counted as an impression. Due to our advertising price we don&#039;t discriminate from users or automated robots. Even if you access to [sitename] web site and see your own banner ad it will be counted as a valid impression. Only in the case of [sitename] web site administrator, the impressions will not be counted.<br /><br /></div><div align="justify"><strong>Termination, Cancellation:</strong> [sitename] may at any time, in its sole discretion, terminate the Campaign, terminate this Agreement, or cancel any ad(s) or your use of any Target. [sitename] will notify you via email of any such termination or cancellation, which shall be effective immediately. No refund will be made for any reason. Remaining impressions will be stored in a database and you&#039;ll be able to request another campaign to complete your inventory. You may cancel any ad and/or terminate this Agreement with or without cause at any time. Termination of your account shall be effective when [sitename] receives your notice via email. No refund will be made for any reason. Remaining impressions will be stored in a database for future uses by you and/or your company.<br /><br /></div><div align="justify"><strong>Content:</strong> [sitename] web site doesn&#039;t accepts advertising that contains: (i) pornography, (ii) explicit adult content, (iii) moral questionable content, (iv) illegal content of any kind, (v) illegal drugs promotion, (vi) racism, (vii) politics content, (viii) religious content, and/or (ix) fraudulent suspicious content. If your advertising and/or target web site has any of this content and you purchased an advertising package, you&#039;ll not receive refund of any kind but your banners ads impressions will be stored for future use.<br /><br /></div><div align="justify"><strong>Confidentiality:</strong> Each party agrees not to disclose Confidential Information of the other party without prior written consent except as provided herein. &quot;Confidential Information&quot; includes (i) ads, prior to publication, (ii) submissions or modifications relating to any advertising campaign, (iii) clickthrough rates or other statistics (except in an aggregated form that includes no identifiable information about you), and (iv) any other information designated in writing as &quot;Confidential.&quot; It does not include information that has become publicly known through no breach by a party, or has been (i) independently developed without access to the other party&#039;s Confidential Information; (ii) rightfully received from a third party; or (iii) required to be disclosed by law or by a governmental authority.<br /><br /></div><div align="justify"><strong>No Guarantee:</strong> [sitename] makes no guarantee regarding the levels of clicks for any ad on its site. [sitename] may offer the same Target to more than one advertiser. You may not receive exclusivity unless special private contract between [sitename] and you.<br /><br /></div><div align="justify"><strong>No Warranty:</strong> [sitename] MAKES NO WARRANTY, EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION WITH RESPECT TO ADVERTISING AND OTHER SERVICES, AND EXPRESSLY DISCLAIMS THE WARRANTIES OR CONDITIONS OF NONINFRINGEMENT, MERCHANTABILITY AND FITNESS FOR ANY PARTICULAR PURPOSE.<br /><br /></div><div align="justify"><strong>Limitations of Liability:</strong> In no event shall [sitename] be liable for any act or omission, or any event directly or indirectly resulting from any act or omission of Advertiser, Partner, or any third parties (if any). EXCEPT FOR THE PARTIES&#039; INDEMNIFICATION AND CONFIDENTIALITY OBLIGATIONS HEREUNDER, (i) IN NO EVENT SHALL EITHER PARTY BE LIABLE UNDER THIS AGREEMENT FOR ANY CONSEQUENTIAL, SPECIAL, INDIRECT, EXEMPLARY, PUNITIVE, OR OTHER DAMAGES WHETHER IN CONTRACT, TORT OR ANY OTHER LEGAL THEORY, EVEN IF SUCH PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF ESSENTIAL PURPOSE OF ANY LIMITED REMEDY AND (ii) [sitename] AGGREGATE LIABILITY TO ADVERTISER UNDER THIS AGREEMENT FOR ANY CLAIM IS LIMITED TO THE AMOUNT PAID TO [sitename] BY ADVERTISER FOR THE AD GIVING RISE TO THE CLAIM. Each party acknowledges that the other party has entered into this Agreement relying on the limitations of liability stated herein and that those limitations are an essential basis of the bargain between the parties. Without limiting the foregoing and except for payment obligations, neither party shall have any liability for any failure or delay resulting from any condition beyond the reasonable control of such party, including but not limited to governmental action or acts of terrorism, earthquake or other acts of God, labor conditions, and power failures.<br /><br /></div><div align="justify"><strong>Payment:</strong> You agree to pay in advance the cost of the advertising. [sitename] will not setup any banner ads campaign(s) unless the payment process is complete. [sitename] may change its pricing at any time without prior notice. If you have an advertising campaign running and/or impressions stored for future use for any mentioned cause and [sitename] changes its pricing, you&#039;ll not need to pay any difference. Your purchased banners fee will remain the same. Charges shall be calculated solely based on records maintained by [sitename]. No other measurements or statistics of any kind shall be accepted by [sitename] or have any effect under this Agreement.<br /><br /></div><div align="justify"><strong>Representations and Warranties:</strong> You represent and warrant that (a) all of the information provided by you to [sitename] to enroll in the Advertising Campaign is correct and current; (b) you hold all rights to permit [sitename] and any Partner(s) to use, reproduce, display, transmit and distribute your ad(s); and (c) [sitename] and any Partner(s) Use, your Target(s), and any site(s) linked to, and products or services to which users are directed, will not, in any state or country where the ad is displayed (i) violate any criminal laws or third party rights giving rise to civil liability, including but not limited to trademark rights or rights relating to the performance of music; or (ii) encourage conduct that would violate any criminal or civil law. You further represent and warrant that any Web site linked to your ad(s) (i) complies with all laws and regulations in any state or country where the ad is displayed; (ii) does not breach and has not breached any duty toward or rights of any person or entity including, without limitation, rights of publicity or privacy, or rights or duties under consumer protection, product liability, tort, or contract theories; and (iii) is not false, misleading, defamatory, libelous, slanderous or threatening.<br /><br /></div><div align="justify"><strong>Your Obligation to Indemnify:</strong> You agree to indemnify, defend and hold [sitename], its agents, affiliates, subsidiaries, directors, officers, employees, and applicable third parties (e.g., all relevant Partner(s), licensors, licensees, consultants and contractors) (&quot;Indemnified Person(s)&quot;) harmless from and against any and all third party claims, liability, loss, and expense (including damage awards, settlement amounts, and reasonable legal fees), brought against any Indemnified Person(s), arising out of, related to or which may arise from your use of the Advertising Program, your Web site, and/or your breach of any term of this Agreement. Customer understands and agrees that each Partner, as defined herein, has the right to assert and enforce its rights under this Section directly on its own behalf as a third party beneficiary.<br /><br /></div><div align="justify"><strong>Information Rights:</strong> [sitename] may retain and use for its own purposes all information you provide, including but not limited to Targets, URLs, the content of ads, and contact and billing information. [sitename] may share this information about you with business partners and/or sponsors. [sitename] will not sell your information. Your name, web site&#039;s URL and related graphics shall be used by [sitename] in its own web site at any time as a sample to the public, even if your Advertising Campaign has been finished.<br /><br /></div><div align="justify"><strong>Miscellaneous:</strong> Any decision made by [sitename] under this Agreement shall be final. [sitename] shall have no liability for any such decision. You will be responsible for all reasonable expenses (including attorneys&#039; fees) incurred by [sitename] in collecting unpaid amounts under this Agreement. This Agreement shall be governed by the laws of [country]. Any dispute or claim arising out of or in connection with this Agreement shall be adjudicated in [country]. This constitutes the entire agreement between the parties with respect to the subject matter hereof. Advertiser may not resell, assign, or transfer any of its rights hereunder. Any such attempt may result in termination of this Agreement, without liability to [sitename] and without any refund. The relationship(s) between [sitename] and the &quot;Partners&quot; is not one of a legal partnership relationship, but is one of independent contractors. This Agreement shall be construed as if both parties jointly wrote it.</div>', 'Canada');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbauth_access`
-- 

CREATE TABLE `nuke_bbauth_access` (
  `group_id` mediumint(8) NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `auth_view` tinyint(1) NOT NULL default '0',
  `auth_read` tinyint(1) NOT NULL default '0',
  `auth_post` tinyint(1) NOT NULL default '0',
  `auth_reply` tinyint(1) NOT NULL default '0',
  `auth_edit` tinyint(1) NOT NULL default '0',
  `auth_delete` tinyint(1) NOT NULL default '0',
  `auth_sticky` tinyint(1) NOT NULL default '0',
  `auth_announce` tinyint(1) NOT NULL default '0',
  `auth_vote` tinyint(1) NOT NULL default '0',
  `auth_pollcreate` tinyint(1) NOT NULL default '0',
  `auth_attachments` tinyint(1) NOT NULL default '0',
  `auth_mod` tinyint(1) NOT NULL default '0',
  KEY `group_id` (`group_id`),
  KEY `forum_id` (`forum_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbauth_access`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbbanlist`
-- 

CREATE TABLE `nuke_bbbanlist` (
  `ban_id` mediumint(8) unsigned NOT NULL auto_increment,
  `ban_userid` mediumint(8) NOT NULL default '0',
  `ban_ip` varchar(8) NOT NULL default '',
  `ban_email` varchar(255) default NULL,
  `ban_time` int(11) default NULL,
  `ban_expire_time` int(11) default NULL,
  `ban_by_userid` mediumint(8) default NULL,
  `ban_priv_reason` text,
  `ban_pub_reason_mode` tinyint(1) default NULL,
  `ban_pub_reason` text,
  PRIMARY KEY  (`ban_id`),
  KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbbanlist`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbcategories`
-- 

CREATE TABLE `nuke_bbcategories` (
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_order` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_bbcategories`
-- 

INSERT INTO `nuke_bbcategories` (`cat_id`, `cat_title`, `cat_order`) VALUES (1, 'Орто-премьер', 10);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbconfig`
-- 

CREATE TABLE `nuke_bbconfig` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`config_name`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbconfig`
-- 

INSERT INTO `nuke_bbconfig` (`config_name`, `config_value`) VALUES ('config_id', '1'),
('board_disable', '0'),
('sitename', 'Orto-премьер'),
('site_desc', ''),
('cookie_name', 'phpbb2mysql'),
('cookie_path', '/'),
('cookie_domain', 'MySite.com'),
('cookie_secure', '0'),
('session_length', '3600'),
('allow_html', '1'),
('allow_html_tags', 'b,i,u,pre'),
('allow_bbcode', '1'),
('allow_smilies', '1'),
('allow_sig', '1'),
('allow_namechange', '0'),
('allow_theme_create', '0'),
('allow_avatar_local', '1'),
('allow_avatar_remote', '0'),
('allow_avatar_upload', '0'),
('override_user_style', '0'),
('posts_per_page', '15'),
('topics_per_page', '50'),
('hot_threshold', '25'),
('max_poll_options', '10'),
('max_sig_chars', '255'),
('max_inbox_privmsgs', '100'),
('max_sentbox_privmsgs', '100'),
('max_savebox_privmsgs', '100'),
('board_email_sig', 'Thanks, webmaster@MySite.com'),
('board_email', 'webmaster@MySite.com'),
('smtp_delivery', '0'),
('smtp_host', ''),
('require_activation', '2'),
('flood_interval', '15'),
('board_email_form', '0'),
('avatar_filesize', '6144'),
('avatar_max_width', '80'),
('avatar_max_height', '80'),
('avatar_path', 'modules/Forums/images/avatars'),
('avatar_gallery_path', 'modules/Forums/images/avatars'),
('smilies_path', 'modules/Forums/images/smiles'),
('default_style', '1'),
('default_dateformat', 'D M d, Y g:i a'),
('board_timezone', '6'),
('prune_enable', '0'),
('privmsg_disable', '0'),
('gzip_compress', '0'),
('coppa_fax', ''),
('coppa_mail', ''),
('board_startdate', '1013908210'),
('default_lang', 'russian'),
('smtp_username', ''),
('smtp_password', ''),
('record_online_users', '2'),
('record_online_date', '1034668530'),
('server_name', 'Орто-премьер'),
('server_port', '80'),
('script_path', '/modules/Forums/'),
('version', '.0.20'),
('enable_confirm', '0'),
('sendmail_fix', '0'),
('allow_autologin', '1'),
('max_autologin_time', '0'),
('max_login_attempts', '5'),
('login_reset_time', '30'),
('search_flood_interval', '15'),
('rand_seed', 'b2675b50ca33bacef7597da921f6aa8e');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbdisallow`
-- 

CREATE TABLE `nuke_bbdisallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL auto_increment,
  `disallow_username` varchar(25) default NULL,
  PRIMARY KEY  (`disallow_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbdisallow`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbforum_prune`
-- 

CREATE TABLE `nuke_bbforum_prune` (
  `prune_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `prune_days` tinyint(4) unsigned NOT NULL default '0',
  `prune_freq` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`prune_id`),
  KEY `forum_id` (`forum_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbforum_prune`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbforums`
-- 

CREATE TABLE `nuke_bbforums` (
  `forum_id` smallint(5) unsigned NOT NULL auto_increment,
  `cat_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_name` varchar(150) default NULL,
  `forum_desc` text,
  `forum_status` tinyint(4) NOT NULL default '0',
  `forum_order` mediumint(8) unsigned NOT NULL default '1',
  `forum_posts` mediumint(8) unsigned NOT NULL default '0',
  `forum_topics` mediumint(8) unsigned NOT NULL default '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `prune_next` int(11) default NULL,
  `prune_enable` tinyint(1) NOT NULL default '1',
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_read` tinyint(2) NOT NULL default '0',
  `auth_post` tinyint(2) NOT NULL default '0',
  `auth_reply` tinyint(2) NOT NULL default '0',
  `auth_edit` tinyint(2) NOT NULL default '0',
  `auth_delete` tinyint(2) NOT NULL default '0',
  `auth_sticky` tinyint(2) NOT NULL default '0',
  `auth_announce` tinyint(2) NOT NULL default '0',
  `auth_vote` tinyint(2) NOT NULL default '0',
  `auth_pollcreate` tinyint(2) NOT NULL default '0',
  `auth_attachments` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `nuke_bbforums`
-- 

INSERT INTO `nuke_bbforums` (`forum_id`, `cat_id`, `forum_name`, `forum_desc`, `forum_status`, `forum_order`, `forum_posts`, `forum_topics`, `forum_last_post_id`, `prune_next`, `prune_enable`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_delete`, `auth_sticky`, `auth_announce`, `auth_vote`, `auth_pollcreate`, `auth_attachments`) VALUES (3, 1, 'Тематика статей', '', 0, 30, 0, 0, 0, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 0),
(2, 1, 'Пожелания', 'Сообщайте все ваши пожелания, предложени и т.д.', 0, 20, 0, 0, 0, NULL, 0, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbgroups`
-- 

CREATE TABLE `nuke_bbgroups` (
  `group_id` mediumint(8) NOT NULL auto_increment,
  `group_type` tinyint(4) NOT NULL default '1',
  `group_name` varchar(40) NOT NULL default '',
  `group_description` varchar(255) NOT NULL default '',
  `group_moderator` mediumint(8) NOT NULL default '0',
  `group_single_user` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`group_id`),
  KEY `group_single_user` (`group_single_user`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `nuke_bbgroups`
-- 

INSERT INTO `nuke_bbgroups` (`group_id`, `group_type`, `group_name`, `group_description`, `group_moderator`, `group_single_user`) VALUES (1, 1, 'Anonymous', 'Personal User', 0, 1),
(3, 2, 'Moderators', 'Moderators of this Forum', 5, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbposts`
-- 

CREATE TABLE `nuke_bbposts` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `poster_id` mediumint(8) NOT NULL default '0',
  `post_time` int(11) NOT NULL default '0',
  `poster_ip` varchar(8) NOT NULL default '',
  `post_username` varchar(25) default NULL,
  `enable_bbcode` tinyint(1) NOT NULL default '1',
  `enable_html` tinyint(1) NOT NULL default '0',
  `enable_smilies` tinyint(1) NOT NULL default '1',
  `enable_sig` tinyint(1) NOT NULL default '1',
  `post_edit_time` int(11) default NULL,
  `post_edit_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbposts`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbposts_text`
-- 

CREATE TABLE `nuke_bbposts_text` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) NOT NULL default '',
  `post_subject` varchar(60) default NULL,
  `post_text` text,
  PRIMARY KEY  (`post_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbposts_text`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbprivmsgs`
-- 

CREATE TABLE `nuke_bbprivmsgs` (
  `privmsgs_id` mediumint(8) unsigned NOT NULL auto_increment,
  `privmsgs_type` tinyint(4) NOT NULL default '0',
  `privmsgs_subject` varchar(255) NOT NULL default '0',
  `privmsgs_from_userid` mediumint(8) NOT NULL default '0',
  `privmsgs_to_userid` mediumint(8) NOT NULL default '0',
  `privmsgs_date` int(11) NOT NULL default '0',
  `privmsgs_ip` varchar(8) NOT NULL default '',
  `privmsgs_enable_bbcode` tinyint(1) NOT NULL default '1',
  `privmsgs_enable_html` tinyint(1) NOT NULL default '0',
  `privmsgs_enable_smilies` tinyint(1) NOT NULL default '1',
  `privmsgs_attach_sig` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`privmsgs_id`),
  KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  KEY `privmsgs_to_userid` (`privmsgs_to_userid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbprivmsgs`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbprivmsgs_text`
-- 

CREATE TABLE `nuke_bbprivmsgs_text` (
  `privmsgs_text_id` mediumint(8) unsigned NOT NULL default '0',
  `privmsgs_bbcode_uid` varchar(10) NOT NULL default '0',
  `privmsgs_text` text,
  PRIMARY KEY  (`privmsgs_text_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbprivmsgs_text`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbranks`
-- 

CREATE TABLE `nuke_bbranks` (
  `rank_id` smallint(5) unsigned NOT NULL auto_increment,
  `rank_title` varchar(50) NOT NULL default '',
  `rank_min` mediumint(8) NOT NULL default '0',
  `rank_max` mediumint(8) NOT NULL default '0',
  `rank_special` tinyint(1) default '0',
  `rank_image` varchar(255) default NULL,
  PRIMARY KEY  (`rank_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `nuke_bbranks`
-- 

INSERT INTO `nuke_bbranks` (`rank_id`, `rank_title`, `rank_min`, `rank_max`, `rank_special`, `rank_image`) VALUES (1, 'Site Admin', -1, -1, 1, 'modules/Forums/images/ranks/6stars.gif'),
(2, 'Member', 1, 0, 0, 'modules/Forums/images/ranks/1star.gif');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsearch_results`
-- 

CREATE TABLE `nuke_bbsearch_results` (
  `search_id` int(11) unsigned NOT NULL default '0',
  `session_id` varchar(32) NOT NULL default '',
  `search_array` text NOT NULL,
  `search_time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`search_id`),
  KEY `session_id` (`session_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbsearch_results`
-- 

INSERT INTO `nuke_bbsearch_results` (`search_id`, `session_id`, `search_array`, `search_time`) VALUES (637973085, '3432bcc439489e8f47d374e002fa1ce4', 'a:7:{s:14:"search_results";s:0:"";s:17:"total_match_count";i:0;s:12:"split_search";N;s:7:"sort_by";i:0;s:8:"sort_dir";s:4:"DESC";s:12:"show_results";s:6:"topics";s:12:"return_chars";i:200;}', 1146831907);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsearch_wordlist`
-- 

CREATE TABLE `nuke_bbsearch_wordlist` (
  `word_text` varchar(50) NOT NULL default '',
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word_common` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_text`),
  KEY `word_id` (`word_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbsearch_wordlist`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsearch_wordmatch`
-- 

CREATE TABLE `nuke_bbsearch_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `title_match` tinyint(1) NOT NULL default '0',
  KEY `word_id` (`word_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbsearch_wordmatch`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsessions`
-- 

CREATE TABLE `nuke_bbsessions` (
  `session_id` char(32) NOT NULL default '',
  `session_user_id` mediumint(8) NOT NULL default '0',
  `session_start` int(11) NOT NULL default '0',
  `session_time` int(11) NOT NULL default '0',
  `session_ip` char(8) NOT NULL default '0',
  `session_page` int(11) NOT NULL default '0',
  `session_logged_in` tinyint(1) NOT NULL default '0',
  `session_admin` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbsessions`
-- 

INSERT INTO `nuke_bbsessions` (`session_id`, `session_user_id`, `session_start`, `session_time`, `session_ip`, `session_page`, `session_logged_in`, `session_admin`) VALUES ('bc61303853a8b5dcb9317067d9f4b51e', 1, 1170230792, 1170230792, 'c0a80001', 0, 0, 0),
('ea23853b9bf9d067704a158026d20f59', 1, 1170235334, 1170235334, 'c0a80002', 0, 0, 0),
('0f9295c4737f96a68e6c3e26615013d9', 1, 1170235335, 1170235335, 'c0a80002', 0, 0, 0),
('d825b1bb4edf01f139bd7713b54c5c50', 1, 1170235335, 1170235335, 'c0a80002', 0, 0, 0),
('137e476d5e000a8943a597d3e25e822c', 1, 1170235339, 1170235339, 'c0a80002', 0, 0, 0),
('30cf935c60911c4c1b50c3b35d0764f5', 1, 1170235371, 1170235371, 'c0a80002', 0, 0, 0),
('801240803ea8959495f2ecfc79df1d27', 1, 1170235383, 1170235383, 'c0a80002', 0, 0, 0),
('10f697c1df4a1fa41b951665058a73d2', 1, 1170235383, 1170235383, 'c0a80002', 0, 0, 0),
('2809d4974c53aacd246c221de82b4785', 1, 1170235387, 1170235387, 'c0a80002', 0, 0, 0),
('7ae996d260de0e66620daeb4f2a7bbe8', 1, 1170235471, 1170235471, 'c0a80002', 0, 0, 0),
('4b0884b183e744f06fdc94bc321994b2', 1, 1170235477, 1170235477, 'c0a80002', 0, 0, 0),
('9545142e06ef9dd351471294e1b9c0e9', 1, 1170235513, 1170235513, 'c0a80002', 0, 0, 0),
('8515d9211b860a13bd12b1dd5f182715', 1, 1170235529, 1170235529, 'c0a80002', 0, 0, 0),
('00b73e9f0ab529a84dfbf36b25b94955', 1, 1170235572, 1170235572, 'c0a80002', 0, 0, 0),
('c793136439409eddd1e721e0254aedf5', 1, 1170235574, 1170235574, 'c0a80002', 0, 0, 0),
('f5850f8aaed2b5b0f78686783f81c72e', 1, 1170235577, 1170235577, 'c0a80002', 0, 0, 0),
('ac583eb8ba3687056f357080008edd29', 1, 1170235580, 1170235580, 'c0a80002', 0, 0, 0),
('59a60d966f51d2da1658b72499759a49', 1, 1170235585, 1170235585, 'c0a80002', 0, 0, 0),
('5252f77ed52da103579fd998110c2b07', 1, 1170235588, 1170235588, 'c0a80002', 0, 0, 0),
('b65fee5f32fc96bf31df62a968a8f067', 1, 1170235592, 1170235592, 'c0a80002', 0, 0, 0),
('aa7a82b30d67d4b62401907298352e4c', 1, 1170235603, 1170235603, 'c0a80002', 0, 0, 0),
('30b8beec2ec88bcfbf7240b7a27282cd', 1, 1170235613, 1170235613, 'c0a80002', 0, 0, 0),
('a1cfa5ea8f9d44675b7e2c9e71d5d4a8', 1, 1170235615, 1170235615, 'c0a80002', 0, 0, 0),
('70db9b31458875a04ed7cb93a2f271f5', 1, 1170235628, 1170235628, 'c0a80002', 0, 0, 0),
('db92a0a42d379b2936f1a31e5ac18265', 1, 1170235675, 1170235675, 'c0a80002', 0, 0, 0),
('63453a1780cfc456a31bd29d04e972dc', 1, 1170235679, 1170235679, 'c0a80002', 0, 0, 0),
('8296e6fee8c21b6a6183246b1406758b', 1, 1170235691, 1170235691, 'c0a80002', -8, 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsessions_keys`
-- 

CREATE TABLE `nuke_bbsessions_keys` (
  `key_id` varchar(32) NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `last_ip` varchar(8) NOT NULL default '0',
  `last_login` int(11) NOT NULL default '0',
  PRIMARY KEY  (`key_id`,`user_id`),
  KEY `last_login` (`last_login`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbsessions_keys`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbsmilies`
-- 

CREATE TABLE `nuke_bbsmilies` (
  `smilies_id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) default NULL,
  `smile_url` varchar(100) default NULL,
  `emoticon` varchar(75) default NULL,
  PRIMARY KEY  (`smilies_id`)
) TYPE=MyISAM AUTO_INCREMENT=45 ;

-- 
-- Дамп данных таблицы `nuke_bbsmilies`
-- 

INSERT INTO `nuke_bbsmilies` (`smilies_id`, `code`, `smile_url`, `emoticon`) VALUES (1, ':D', 'icon_biggrin.gif', 'Very Happy'),
(2, ':-D', 'icon_biggrin.gif', 'Very Happy'),
(3, ':grin:', 'icon_biggrin.gif', 'Very Happy'),
(4, ':)', 'icon_smile.gif', 'Smile'),
(5, ':-)', 'icon_smile.gif', 'Smile'),
(6, ':smile:', 'icon_smile.gif', 'Smile'),
(7, ':(', 'icon_sad.gif', 'Sad'),
(8, ':-(', 'icon_sad.gif', 'Sad'),
(9, ':sad:', 'icon_sad.gif', 'Sad'),
(10, ':o', 'icon_surprised.gif', 'Surprised'),
(11, ':-o', 'icon_surprised.gif', 'Surprised'),
(12, ':eek:', 'icon_surprised.gif', 'Surprised'),
(13, '8O', 'icon_eek.gif', 'Shocked'),
(14, '8-O', 'icon_eek.gif', 'Shocked'),
(15, ':shock:', 'icon_eek.gif', 'Shocked'),
(16, ':?', 'icon_confused.gif', 'Confused'),
(17, ':-?', 'icon_confused.gif', 'Confused'),
(18, ':???:', 'icon_confused.gif', 'Confused'),
(19, '8)', 'icon_cool.gif', 'Cool'),
(20, '8-)', 'icon_cool.gif', 'Cool'),
(21, ':cool:', 'icon_cool.gif', 'Cool'),
(22, ':lol:', 'icon_lol.gif', 'Laughing'),
(23, ':x', 'icon_mad.gif', 'Mad'),
(24, ':-x', 'icon_mad.gif', 'Mad'),
(25, ':mad:', 'icon_mad.gif', 'Mad'),
(26, ':P', 'icon_razz.gif', 'Razz'),
(27, ':-P', 'icon_razz.gif', 'Razz'),
(28, ':razz:', 'icon_razz.gif', 'Razz'),
(29, ':oops:', 'icon_redface.gif', 'Embarassed'),
(30, ':cry:', 'icon_cry.gif', 'Crying or Very sad'),
(31, ':evil:', 'icon_evil.gif', 'Evil or Very Mad'),
(32, ':twisted:', 'icon_twisted.gif', 'Twisted Evil'),
(33, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes'),
(34, ':wink:', 'icon_wink.gif', 'Wink'),
(35, ';)', 'icon_wink.gif', 'Wink'),
(36, ';-)', 'icon_wink.gif', 'Wink'),
(37, ':!:', 'icon_exclaim.gif', 'Exclamation'),
(38, ':?:', 'icon_question.gif', 'Question'),
(39, ':idea:', 'icon_idea.gif', 'Idea'),
(40, ':arrow:', 'icon_arrow.gif', 'Arrow'),
(41, ':|', 'icon_neutral.gif', 'Neutral'),
(42, ':-|', 'icon_neutral.gif', 'Neutral'),
(43, ':neutral:', 'icon_neutral.gif', 'Neutral'),
(44, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbthemes`
-- 

CREATE TABLE `nuke_bbthemes` (
  `themes_id` mediumint(8) unsigned NOT NULL auto_increment,
  `template_name` varchar(30) NOT NULL default '',
  `style_name` varchar(30) NOT NULL default '',
  `head_stylesheet` varchar(100) default NULL,
  `body_background` varchar(100) default NULL,
  `body_bgcolor` varchar(6) default NULL,
  `body_text` varchar(6) default NULL,
  `body_link` varchar(6) default NULL,
  `body_vlink` varchar(6) default NULL,
  `body_alink` varchar(6) default NULL,
  `body_hlink` varchar(6) default NULL,
  `tr_color1` varchar(6) default NULL,
  `tr_color2` varchar(6) default NULL,
  `tr_color3` varchar(6) default NULL,
  `tr_class1` varchar(25) default NULL,
  `tr_class2` varchar(25) default NULL,
  `tr_class3` varchar(25) default NULL,
  `th_color1` varchar(6) default NULL,
  `th_color2` varchar(6) default NULL,
  `th_color3` varchar(6) default NULL,
  `th_class1` varchar(25) default NULL,
  `th_class2` varchar(25) default NULL,
  `th_class3` varchar(25) default NULL,
  `td_color1` varchar(6) default NULL,
  `td_color2` varchar(6) default NULL,
  `td_color3` varchar(6) default NULL,
  `td_class1` varchar(25) default NULL,
  `td_class2` varchar(25) default NULL,
  `td_class3` varchar(25) default NULL,
  `fontface1` varchar(50) default NULL,
  `fontface2` varchar(50) default NULL,
  `fontface3` varchar(50) default NULL,
  `fontsize1` tinyint(4) default NULL,
  `fontsize2` tinyint(4) default NULL,
  `fontsize3` tinyint(4) default NULL,
  `fontcolor1` varchar(6) default NULL,
  `fontcolor2` varchar(6) default NULL,
  `fontcolor3` varchar(6) default NULL,
  `span_class1` varchar(25) default NULL,
  `span_class2` varchar(25) default NULL,
  `span_class3` varchar(25) default NULL,
  `img_size_poll` smallint(5) unsigned default NULL,
  `img_size_privmsg` smallint(5) unsigned default NULL,
  PRIMARY KEY  (`themes_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_bbthemes`
-- 

INSERT INTO `nuke_bbthemes` (`themes_id`, `template_name`, `style_name`, `head_stylesheet`, `body_background`, `body_bgcolor`, `body_text`, `body_link`, `body_vlink`, `body_alink`, `body_hlink`, `tr_color1`, `tr_color2`, `tr_color3`, `tr_class1`, `tr_class2`, `tr_class3`, `th_color1`, `th_color2`, `th_color3`, `th_class1`, `th_class2`, `th_class3`, `td_color1`, `td_color2`, `td_color3`, `td_class1`, `td_class2`, `td_class3`, `fontface1`, `fontface2`, `fontface3`, `fontsize1`, `fontsize2`, `fontsize3`, `fontcolor1`, `fontcolor2`, `fontcolor3`, `span_class1`, `span_class2`, `span_class3`, `img_size_poll`, `img_size_privmsg`) VALUES (1, 'subSilver', 'subSilver', 'subSilver.css', '', '0E3259', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, ''Courier New'', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', '', '', '', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbthemes_name`
-- 

CREATE TABLE `nuke_bbthemes_name` (
  `themes_id` smallint(5) unsigned NOT NULL default '0',
  `tr_color1_name` char(50) default NULL,
  `tr_color2_name` char(50) default NULL,
  `tr_color3_name` char(50) default NULL,
  `tr_class1_name` char(50) default NULL,
  `tr_class2_name` char(50) default NULL,
  `tr_class3_name` char(50) default NULL,
  `th_color1_name` char(50) default NULL,
  `th_color2_name` char(50) default NULL,
  `th_color3_name` char(50) default NULL,
  `th_class1_name` char(50) default NULL,
  `th_class2_name` char(50) default NULL,
  `th_class3_name` char(50) default NULL,
  `td_color1_name` char(50) default NULL,
  `td_color2_name` char(50) default NULL,
  `td_color3_name` char(50) default NULL,
  `td_class1_name` char(50) default NULL,
  `td_class2_name` char(50) default NULL,
  `td_class3_name` char(50) default NULL,
  `fontface1_name` char(50) default NULL,
  `fontface2_name` char(50) default NULL,
  `fontface3_name` char(50) default NULL,
  `fontsize1_name` char(50) default NULL,
  `fontsize2_name` char(50) default NULL,
  `fontsize3_name` char(50) default NULL,
  `fontcolor1_name` char(50) default NULL,
  `fontcolor2_name` char(50) default NULL,
  `fontcolor3_name` char(50) default NULL,
  `span_class1_name` char(50) default NULL,
  `span_class2_name` char(50) default NULL,
  `span_class3_name` char(50) default NULL,
  PRIMARY KEY  (`themes_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbthemes_name`
-- 

INSERT INTO `nuke_bbthemes_name` (`themes_id`, `tr_color1_name`, `tr_color2_name`, `tr_color3_name`, `tr_class1_name`, `tr_class2_name`, `tr_class3_name`, `th_color1_name`, `th_color2_name`, `th_color3_name`, `th_class1_name`, `th_class2_name`, `th_class3_name`, `td_color1_name`, `td_color2_name`, `td_color3_name`, `td_class1_name`, `td_class2_name`, `td_class3_name`, `fontface1_name`, `fontface2_name`, `fontface3_name`, `fontsize1_name`, `fontsize2_name`, `fontsize3_name`, `fontcolor1_name`, `fontcolor2_name`, `fontcolor3_name`, `span_class1_name`, `span_class2_name`, `span_class3_name`) VALUES (1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbtopics`
-- 

CREATE TABLE `nuke_bbtopics` (
  `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(8) unsigned NOT NULL default '0',
  `topic_title` char(60) NOT NULL default '',
  `topic_poster` mediumint(8) NOT NULL default '0',
  `topic_time` int(11) NOT NULL default '0',
  `topic_views` mediumint(8) unsigned NOT NULL default '0',
  `topic_replies` mediumint(8) unsigned NOT NULL default '0',
  `topic_status` tinyint(3) NOT NULL default '0',
  `topic_vote` tinyint(1) NOT NULL default '0',
  `topic_type` tinyint(3) NOT NULL default '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbtopics`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbtopics_watch`
-- 

CREATE TABLE `nuke_bbtopics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `notify_status` tinyint(1) NOT NULL default '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_status` (`notify_status`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbtopics_watch`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbuser_group`
-- 

CREATE TABLE `nuke_bbuser_group` (
  `group_id` mediumint(8) NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `user_pending` tinyint(1) default NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbuser_group`
-- 

INSERT INTO `nuke_bbuser_group` (`group_id`, `user_id`, `user_pending`) VALUES (1, -1, 0),
(3, 5, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbvote_desc`
-- 

CREATE TABLE `nuke_bbvote_desc` (
  `vote_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_text` text NOT NULL,
  `vote_start` int(11) NOT NULL default '0',
  `vote_length` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vote_id`),
  KEY `topic_id` (`topic_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbvote_desc`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbvote_results`
-- 

CREATE TABLE `nuke_bbvote_results` (
  `vote_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_option_id` tinyint(4) unsigned NOT NULL default '0',
  `vote_option_text` varchar(255) NOT NULL default '',
  `vote_result` int(11) NOT NULL default '0',
  KEY `vote_option_id` (`vote_option_id`),
  KEY `vote_id` (`vote_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbvote_results`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbvote_voters`
-- 

CREATE TABLE `nuke_bbvote_voters` (
  `vote_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_user_id` mediumint(8) NOT NULL default '0',
  `vote_user_ip` char(8) NOT NULL default '',
  KEY `vote_id` (`vote_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_bbvote_voters`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_bbwords`
-- 

CREATE TABLE `nuke_bbwords` (
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word` char(100) NOT NULL default '',
  `replacement` char(100) NOT NULL default '',
  PRIMARY KEY  (`word_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_bbwords`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_blocks`
-- 

CREATE TABLE `nuke_blocks` (
  `bid` int(10) NOT NULL auto_increment,
  `bkey` varchar(15) NOT NULL default '',
  `title` varchar(60) NOT NULL default '',
  `content` text NOT NULL,
  `url` varchar(200) NOT NULL default '',
  `bposition` char(1) NOT NULL default '',
  `weight` int(10) NOT NULL default '1',
  `active` int(1) NOT NULL default '1',
  `refresh` int(10) NOT NULL default '0',
  `time` varchar(14) NOT NULL default '0',
  `blanguage` varchar(30) NOT NULL default '',
  `blockfile` varchar(255) NOT NULL default '',
  `view` int(1) NOT NULL default '0',
  `expire` varchar(14) NOT NULL default '0',
  `action` char(1) NOT NULL default '',
  `subscription` int(1) NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `bid` (`bid`),
  KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Дамп данных таблицы `nuke_blocks`
-- 

INSERT INTO `nuke_blocks` (`bid`, `bkey`, `title`, `content`, `url`, `bposition`, `weight`, `active`, `refresh`, `time`, `blanguage`, `blockfile`, `view`, `expire`, `action`, `subscription`) VALUES (1, '', 'Навигация', '', '', 'l', 2, 0, 0, '', '', 'block-Modules.php', 0, '0', 'd', 0),
(2, 'admin', 'Администрация', '<strong>·</strong> <a href="admin.php">Администрация</a><br>\r\n<strong>·</strong> <a href="admin.php?op=adminStory">Новости</a><br>\r\n<strong>·</strong> <a href="admin.php?op=create">Опросы</a><br>\r\n<strong>·</strong> <a href="admin.php?op=content">Контент</a><br>\r\n<strong>·</strong> <a href="admin.php?op=logout">Выход</a>', '', 'l', 1, 0, 0, '985591188', '', '', 2, '0', 'd', 0),
(3, '', 'Сколько на сайте', '', '', 'l', 3, 0, 0, '', '', 'block-Who_is_Online.php', 0, '0', 'd', 0),
(4, '', 'Поиск', '', '', 'r', 3, 0, 0, '', '', 'block-Search.php', 0, '0', 'd', 0),
(5, '', 'Языки', '', '', 'r', 4, 0, 0, '', '', 'block-Languages.php', 0, '0', 'd', 0),
(6, 'userbox', 'Блок пользователя', '', '', 'r', 1, 0, 0, '', '', '', 1, '0', 'd', 0),
(7, '', 'Темы новостей', '', '', 'r', 5, 0, 0, '', '', 'block-Categories.php', 0, '0', 'd', 0),
(8, '', 'Наш опрос', '', '', 'r', 6, 0, 0, '', '', 'block-Survey.php', 0, '0', 'd', 0),
(9, '', 'Пользователи', '', '', 'r', 7, 0, 0, '', '', 'block-User_Info.php', 0, '0', 'd', 0),
(10, '', 'Лучшая новость', '', '', 'r', 8, 0, 0, '', '', 'block-Big_Story_of_Today.php', 0, '0', 'd', 0),
(11, '', 'Архив', '', '', 'r', 9, 0, 0, '', '', 'block-Old_Articles.php', 0, '0', 'd', 0),
(12, '', 'Информация', '<div align="center"><br></div><div align="center"><a href="http://phpnuke.org"><img width="88" height="31" bordertitle="Powered by PHP-Nuke" alt="Powered by PHP-Nuke" src="images/powered/powered8.jpg"></a><br><br>\r\n\r\n<a href="http://rus-phpnuke.com"><img width="88" height="31" bordertitle="PHP-Nuke по-русски" alt="PHP-Nuke по-русски" src="images/powered/rus-nuke.gif"></a><br><br>\r\n\r\n\r\n<a href="http://validator.w3.org/check/referer"><img width="88" height="31" bordertitle="Valid HTML 4.01!" alt="Valid HTML 4.01!" src="images/html401.gif"></a><br><br><a href="http://jigsaw.w3.org/css-validator"><img width="88" height="31" bordertitle="Valid CSS!" alt="Valid CSS!" src="images/css.gif"></a><br><br>\r\n</div>\r\n\r\n', '', 'r', 2, 0, 0, '', '', '', 0, '0', 'd', 0),
(13, '', 'Всего хитов', '', '', 'l', 4, 0, 0, '', '', 'block-Total_Hits.php', 0, '0', 'd', 0),
(14, '', 'Новое на форумах', '', '', 'd', 1, 0, 0, '', '', 'block-Universalforums.php', 0, '0', 'd', 0),
(15, '', 'Статьи', '', '', 'l', 5, 1, 0, '', 'russian', 'block-Content.php', 0, '0', 'd', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_cities`
-- 

CREATE TABLE `nuke_cities` (
  `id` mediumint(4) NOT NULL default '0',
  `local_id` mediumint(3) NOT NULL default '0',
  `city` varchar(65) NOT NULL default '',
  `cc` char(2) NOT NULL default '',
  `country` varchar(35) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_cities`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_comments`
-- 

CREATE TABLE `nuke_comments` (
  `tid` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  `name` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `url` varchar(60) default NULL,
  `host_name` varchar(60) default NULL,
  `subject` varchar(85) NOT NULL default '',
  `comment` text NOT NULL,
  `score` tinyint(4) NOT NULL default '0',
  `reason` tinyint(4) NOT NULL default '0',
  `last_moderation_ip` varchar(15) default '0',
  PRIMARY KEY  (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_comments_moderated`
-- 

CREATE TABLE `nuke_comments_moderated` (
  `tid` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  `name` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `url` varchar(60) default NULL,
  `host_name` varchar(60) default NULL,
  `subject` varchar(85) NOT NULL default '',
  `comment` text NOT NULL,
  `score` tinyint(4) NOT NULL default '0',
  `reason` tinyint(4) NOT NULL default '0',
  `last_moderation_ip` varchar(15) default '0',
  PRIMARY KEY  (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_comments_moderated`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_config`
-- 

CREATE TABLE `nuke_config` (
  `sitename` varchar(255) NOT NULL default '',
  `nukeurl` varchar(255) NOT NULL default '',
  `site_logo` varchar(255) NOT NULL default '',
  `slogan` varchar(255) NOT NULL default '',
  `startdate` varchar(50) NOT NULL default '',
  `adminmail` varchar(255) NOT NULL default '',
  `anonpost` tinyint(1) NOT NULL default '0',
  `Default_Theme` varchar(255) NOT NULL default '',
  `foot1` text NOT NULL,
  `foot2` text NOT NULL,
  `foot3` text NOT NULL,
  `commentlimit` int(9) NOT NULL default '4096',
  `anonymous` varchar(255) NOT NULL default '',
  `minpass` tinyint(1) NOT NULL default '5',
  `pollcomm` tinyint(1) NOT NULL default '1',
  `articlecomm` tinyint(1) NOT NULL default '1',
  `broadcast_msg` tinyint(1) NOT NULL default '1',
  `my_headlines` tinyint(1) NOT NULL default '1',
  `top` int(3) NOT NULL default '10',
  `storyhome` int(2) NOT NULL default '10',
  `user_news` tinyint(1) NOT NULL default '1',
  `oldnum` int(2) NOT NULL default '30',
  `ultramode` tinyint(1) NOT NULL default '0',
  `banners` tinyint(1) NOT NULL default '1',
  `backend_title` varchar(255) NOT NULL default '',
  `backend_language` varchar(10) NOT NULL default '',
  `language` varchar(100) NOT NULL default '',
  `locale` varchar(10) NOT NULL default '',
  `multilingual` tinyint(1) NOT NULL default '0',
  `useflags` tinyint(1) NOT NULL default '0',
  `notify` tinyint(1) NOT NULL default '0',
  `notify_email` varchar(255) NOT NULL default '',
  `notify_subject` varchar(255) NOT NULL default '',
  `notify_message` varchar(255) NOT NULL default '',
  `notify_from` varchar(255) NOT NULL default '',
  `moderate` tinyint(1) NOT NULL default '0',
  `admingraphic` tinyint(1) NOT NULL default '1',
  `httpref` tinyint(1) NOT NULL default '1',
  `httprefmax` int(5) NOT NULL default '1000',
  `CensorMode` tinyint(1) NOT NULL default '3',
  `CensorReplace` varchar(10) NOT NULL default '',
  `copyright` text NOT NULL,
  `Version_Num` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`sitename`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_config`
-- 

INSERT INTO `nuke_config` (`sitename`, `nukeurl`, `site_logo`, `slogan`, `startdate`, `adminmail`, `anonpost`, `Default_Theme`, `foot1`, `foot2`, `foot3`, `commentlimit`, `anonymous`, `minpass`, `pollcomm`, `articlecomm`, `broadcast_msg`, `my_headlines`, `top`, `storyhome`, `user_news`, `oldnum`, `ultramode`, `banners`, `backend_title`, `backend_language`, `language`, `locale`, `multilingual`, `useflags`, `notify`, `notify_email`, `notify_subject`, `notify_message`, `notify_from`, `moderate`, `admingraphic`, `httpref`, `httprefmax`, `CensorMode`, `CensorReplace`, `copyright`, `Version_Num`) VALUES ('Orto-premier', 'http://orto/', 'logo.gif', 'Save your smile :)', 'Январь 2007', 'kivdent@yandex.ru', 0, 'RusNuke2003', '', 'All logos and trademarks in this site are property of their respective owner. The comments are property of their posters, all the rest © 2006 by me.', 'You can syndicate our news using the file <a href="backend.php">backend.php</a> or <a href="ultramode.txt">ultramode.txt</a>', 4096, 'Гость', 5, 1, 1, 0, 1, 10, 10, 0, 10, 1, 1, 'MySite.com News', 'ru-ru', 'russian', 'ru-Ru', 1, 1, 0, 'admin@MySite.com', 'NEWS for MySite.com', 'Hey! You got a new submission for MySite.com.', 'webmaster', 1, 1, 1, 1000, 3, '*****', '<a href="http://phpnuke.org"><font class="footmsg_l">PHP-Nuke</font></a> Copyright &copy; 2006 by Francisco Burzi. This is free software, and you may redistribute it under the <a href="http://phpnuke.org/files/gpl.txt"><font class="footmsg_l">GPL</font></a>. PHP-Nuke comes with absolutely no warranty, for details, see the <a href="http://phpnuke.org/files/gpl.txt"><font class="footmsg_l">license</font></a>.\r\n<br>\r\nThe Russian localization - project <a href="http://rus-phpnuke.com/">Rus-PhpNuke.com</a>', '7.9');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_confirm`
-- 

CREATE TABLE `nuke_confirm` (
  `confirm_id` char(32) NOT NULL default '',
  `session_id` char(32) NOT NULL default '',
  `code` char(6) NOT NULL default '',
  PRIMARY KEY  (`session_id`,`confirm_id`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_confirm`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_counter`
-- 

CREATE TABLE `nuke_counter` (
  `type` varchar(80) NOT NULL default '',
  `var` varchar(80) NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_counter`
-- 

INSERT INTO `nuke_counter` (`type`, `var`, `count`) VALUES ('total', 'hits', 1),
('browser', 'WebTV', 0),
('browser', 'Lynx', 0),
('browser', 'MSIE', 1),
('browser', 'Opera', 0),
('browser', 'Konqueror', 0),
('browser', 'Netscape', 0),
('browser', 'FireFox', 0),
('browser', 'Bot', 0),
('browser', 'Other', 0),
('os', 'Windows', 1),
('os', 'Linux', 0),
('os', 'Mac', 0),
('os', 'FreeBSD', 0),
('os', 'SunOS', 0),
('os', 'IRIX', 0),
('os', 'BeOS', 0),
('os', 'OS/2', 0),
('os', 'AIX', 0),
('os', 'Other', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_categories`
-- 

CREATE TABLE `nuke_downloads_categories` (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `cdescription` text NOT NULL,
  `parentid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`),
  KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_downloads_categories`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_downloads`
-- 

CREATE TABLE `nuke_downloads_downloads` (
  `lid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime default NULL,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  `submitter` varchar(60) NOT NULL default '',
  `downloadratingsummary` double(6,4) NOT NULL default '0.0000',
  `totalvotes` int(11) NOT NULL default '0',
  `totalcomments` int(11) NOT NULL default '0',
  `filesize` int(11) NOT NULL default '0',
  `version` varchar(10) NOT NULL default '',
  `homepage` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_downloads_downloads`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_editorials`
-- 

CREATE TABLE `nuke_downloads_editorials` (
  `downloadid` int(11) NOT NULL default '0',
  `adminid` varchar(60) NOT NULL default '',
  `editorialtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `editorialtext` text NOT NULL,
  `editorialtitle` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`downloadid`),
  KEY `downloadid` (`downloadid`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_downloads_editorials`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_modrequest`
-- 

CREATE TABLE `nuke_downloads_modrequest` (
  `requestid` int(11) NOT NULL auto_increment,
  `lid` int(11) NOT NULL default '0',
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `modifysubmitter` varchar(60) NOT NULL default '',
  `brokendownload` int(3) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `version` varchar(10) NOT NULL default '',
  `homepage` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`requestid`),
  UNIQUE KEY `requestid` (`requestid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_downloads_modrequest`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_newdownload`
-- 

CREATE TABLE `nuke_downloads_newdownload` (
  `lid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `submitter` varchar(60) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `version` varchar(10) NOT NULL default '',
  `homepage` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_downloads_newdownload`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_downloads_votedata`
-- 

CREATE TABLE `nuke_downloads_votedata` (
  `ratingdbid` int(11) NOT NULL auto_increment,
  `ratinglid` int(11) NOT NULL default '0',
  `ratinguser` varchar(60) NOT NULL default '',
  `rating` int(11) NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingcomments` text NOT NULL,
  `ratingtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ratingdbid`),
  KEY `ratingdbid` (`ratingdbid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_downloads_votedata`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_encyclopedia`
-- 

CREATE TABLE `nuke_encyclopedia` (
  `eid` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `elanguage` varchar(30) NOT NULL default '',
  `active` int(1) NOT NULL default '0',
  PRIMARY KEY  (`eid`),
  KEY `eid` (`eid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_encyclopedia`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_encyclopedia_text`
-- 

CREATE TABLE `nuke_encyclopedia_text` (
  `tid` int(10) NOT NULL auto_increment,
  `eid` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `counter` int(10) NOT NULL default '0',
  PRIMARY KEY  (`tid`),
  KEY `tid` (`tid`),
  KEY `eid` (`eid`),
  KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_encyclopedia_text`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_faqanswer`
-- 

CREATE TABLE `nuke_faqanswer` (
  `id` tinyint(4) NOT NULL auto_increment,
  `id_cat` tinyint(4) NOT NULL default '0',
  `question` varchar(255) default NULL,
  `answer` text,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `id_cat` (`id_cat`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_faqanswer`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_faqcategories`
-- 

CREATE TABLE `nuke_faqcategories` (
  `id_cat` tinyint(3) NOT NULL auto_increment,
  `categories` varchar(255) default NULL,
  `flanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id_cat`),
  KEY `id_cat` (`id_cat`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_faqcategories`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_groups`
-- 

CREATE TABLE `nuke_groups` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `points` int(10) NOT NULL default '0',
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_groups`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_groups_points`
-- 

CREATE TABLE `nuke_groups_points` (
  `id` int(10) NOT NULL auto_increment,
  `points` int(10) NOT NULL default '0',
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=22 ;

-- 
-- Дамп данных таблицы `nuke_groups_points`
-- 

INSERT INTO `nuke_groups_points` (`id`, `points`) VALUES (1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(18, 0),
(19, 0),
(20, 0),
(21, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_headlines`
-- 

CREATE TABLE `nuke_headlines` (
  `hid` int(11) NOT NULL auto_increment,
  `sitename` varchar(30) NOT NULL default '',
  `headlinesurl` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`hid`),
  KEY `hid` (`hid`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;

-- 
-- Дамп данных таблицы `nuke_headlines`
-- 

INSERT INTO `nuke_headlines` (`hid`, `sitename`, `headlinesurl`) VALUES (16, 'rus-phpnuke.com', 'http://rus-phpnuke.com/backend.php'),
(17, 'NukeScripts(tm)', 'http://www.nukescripts.net/backend.php'),
(18, 'NukeFixes', 'http://nukefixes.com/backend.php'),
(19, 'NukeResources', 'http://www.nukeresources.com/backend.php'),
(22, 'PHP-Nuke', 'http://phpnuke.org/backend.php');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_journal`
-- 

CREATE TABLE `nuke_journal` (
  `jid` int(11) NOT NULL auto_increment,
  `aid` varchar(30) NOT NULL default '',
  `title` varchar(80) default NULL,
  `bodytext` text NOT NULL,
  `mood` varchar(48) NOT NULL default '',
  `pdate` varchar(48) NOT NULL default '',
  `ptime` varchar(48) NOT NULL default '',
  `status` varchar(48) NOT NULL default '',
  `mtime` varchar(48) NOT NULL default '',
  `mdate` varchar(48) NOT NULL default '',
  PRIMARY KEY  (`jid`),
  KEY `jid` (`jid`),
  KEY `aid` (`aid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_journal`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_journal_comments`
-- 

CREATE TABLE `nuke_journal_comments` (
  `cid` int(11) NOT NULL auto_increment,
  `rid` varchar(48) NOT NULL default '',
  `aid` varchar(30) NOT NULL default '',
  `comment` text NOT NULL,
  `pdate` varchar(48) NOT NULL default '',
  `ptime` varchar(48) NOT NULL default '',
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`),
  KEY `aid` (`aid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_journal_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_journal_stats`
-- 

CREATE TABLE `nuke_journal_stats` (
  `id` int(11) NOT NULL auto_increment,
  `joid` varchar(48) NOT NULL default '',
  `nop` varchar(48) NOT NULL default '',
  `ldp` varchar(24) NOT NULL default '',
  `ltp` varchar(24) NOT NULL default '',
  `micro` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_journal_stats`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_categories`
-- 

CREATE TABLE `nuke_links_categories` (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `cdescription` text NOT NULL,
  `parentid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_links_categories`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_editorials`
-- 

CREATE TABLE `nuke_links_editorials` (
  `linkid` int(11) NOT NULL default '0',
  `adminid` varchar(60) NOT NULL default '',
  `editorialtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `editorialtext` text NOT NULL,
  `editorialtitle` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`linkid`),
  KEY `linkid` (`linkid`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_links_editorials`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_links`
-- 

CREATE TABLE `nuke_links_links` (
  `lid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime default NULL,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  `submitter` varchar(60) NOT NULL default '',
  `linkratingsummary` double(6,4) NOT NULL default '0.0000',
  `totalvotes` int(11) NOT NULL default '0',
  `totalcomments` int(11) NOT NULL default '0',
  PRIMARY KEY  (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_links_links`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_modrequest`
-- 

CREATE TABLE `nuke_links_modrequest` (
  `requestid` int(11) NOT NULL auto_increment,
  `lid` int(11) NOT NULL default '0',
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `modifysubmitter` varchar(60) NOT NULL default '',
  `brokenlink` int(3) NOT NULL default '0',
  PRIMARY KEY  (`requestid`),
  UNIQUE KEY `requestid` (`requestid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_links_modrequest`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_newlink`
-- 

CREATE TABLE `nuke_links_newlink` (
  `lid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `submitter` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_links_newlink`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_links_votedata`
-- 

CREATE TABLE `nuke_links_votedata` (
  `ratingdbid` int(11) NOT NULL auto_increment,
  `ratinglid` int(11) NOT NULL default '0',
  `ratinguser` varchar(60) NOT NULL default '',
  `rating` int(11) NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingcomments` text NOT NULL,
  `ratingtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ratingdbid`),
  KEY `ratingdbid` (`ratingdbid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_links_votedata`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_main`
-- 

CREATE TABLE `nuke_main` (
  `main_module` varchar(255) NOT NULL default ''
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_main`
-- 

INSERT INTO `nuke_main` (`main_module`) VALUES ('News');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_message`
-- 

CREATE TABLE `nuke_message` (
  `mid` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `content` text NOT NULL,
  `date` varchar(14) NOT NULL default '',
  `expire` int(7) NOT NULL default '0',
  `active` int(1) NOT NULL default '1',
  `view` int(1) NOT NULL default '1',
  `mlanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`mid`),
  UNIQUE KEY `mid` (`mid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_message`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_modules`
-- 

CREATE TABLE `nuke_modules` (
  `mid` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `custom_title` varchar(255) NOT NULL default '',
  `active` int(1) NOT NULL default '0',
  `view` int(1) NOT NULL default '0',
  `inmenu` tinyint(1) NOT NULL default '1',
  `mod_group` int(10) default '0',
  `admins` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mid`),
  KEY `mid` (`mid`),
  KEY `title` (`title`),
  KEY `custom_title` (`custom_title`)
) TYPE=MyISAM AUTO_INCREMENT=51 ;

-- 
-- Дамп данных таблицы `nuke_modules`
-- 

INSERT INTO `nuke_modules` (`mid`, `title`, `custom_title`, `active`, `view`, `inmenu`, `mod_group`, `admins`) VALUES (2, 'Content', 'Контент сайта', 1, 0, 1, 0, ''),
(3, 'Downloads', 'Каталог файлов', 0, 0, 1, 0, ''),
(4, 'Encyclopedia', 'Энциклопедия', 0, 0, 1, 0, ''),
(7, 'Forums', 'Наши форумы', 1, 0, 1, 0, ''),
(8, 'Journal', 'Личный журнал', 0, 0, 1, 0, ''),
(10, 'News', 'Новости', 1, 0, 1, 0, ''),
(11, 'Private_Messages', 'Личные сообщения', 0, 1, 1, 0, ''),
(12, 'Recommend_Us', 'Рекомендовать нас', 0, 0, 1, 0, ''),
(13, 'Reviews', 'Рецензии', 0, 0, 1, 0, ''),
(14, 'Search', 'Поиск', 1, 0, 1, 0, ''),
(15, 'Statistics', 'Статистика сайта', 1, 2, 1, 0, ''),
(16, 'Stories_Archive', 'Архив новостей', 0, 0, 1, 0, ''),
(17, 'Submit_News', 'Добавить новость', 0, 1, 1, 0, ''),
(18, 'Surveys', 'Наш опрос', 0, 0, 1, 0, ''),
(19, 'Top', 'Топ 10', 0, 0, 1, 0, ''),
(20, 'Topics', 'Темы новостей', 1, 0, 1, 0, ''),
(6, 'Feedback', 'Обратная связь', 0, 0, 1, 0, ''),
(5, 'FAQ', 'ЧаВО', 1, 0, 1, 0, ''),
(9, 'Members_List', 'Список пользователей', 0, 1, 1, 0, ''),
(22, 'Your_Account', 'Личный кабинет', 1, 0, 1, 0, ''),
(21, 'Web_Links', 'Каталог ссылок', 0, 0, 1, 0, ''),
(1, 'AvantGo', 'Заголовки новостей', 1, 0, 1, 0, ''),
(50, 'Advertising', 'Реклама на сайте', 0, 0, 1, 0, '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_optimize_gain`
-- 

CREATE TABLE `nuke_optimize_gain` (
  `gain` decimal(10,3) default NULL
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_optimize_gain`
-- 

INSERT INTO `nuke_optimize_gain` (`gain`) VALUES (4.445);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_pages`
-- 

CREATE TABLE `nuke_pages` (
  `pid` int(10) NOT NULL auto_increment,
  `cid` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `subtitle` varchar(255) NOT NULL default '',
  `active` int(1) NOT NULL default '0',
  `page_header` text NOT NULL,
  `text` text NOT NULL,
  `page_footer` text NOT NULL,
  `signature` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `counter` int(10) NOT NULL default '0',
  `clanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `pid` (`pid`),
  KEY `cid` (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `nuke_pages`
-- 

INSERT INTO `nuke_pages` (`pid`, `cid`, `title`, `subtitle`, `active`, `page_header`, `text`, `page_footer`, `signature`, `date`, `counter`, `clanguage`) VALUES (1, 1, 'Депофорез', '', 1, '<div class="Section1"><font size="3"><font face="Times New Roman">Н<span>U</span>М<span>ANC</span>Н<span>E</span>М<span>IE </span></font></font><strong><font size="3"><font face="Times New Roman">ИНСТРУКЦИЯ по эксплуатации прибора ДЛЯ депофореза &quot;ОРИГИНАЛ 11&quot;</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Уважаемые коллеги, </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">мы поздравляем Вас с покупкой нового при бора для депофореза &quot;ОРИГИНАЛ 11&quot;. Вы приняли решение в пользу высококачественного продукта, в основе которого лежит испытанная, &laquo;Know-how&quot; и современная техника. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">&quot;ОРИГИНАЛ 11&quot; существенно облегчает работу зубного врача. Оригинальное числовое устройство, регистрирующее количество миллиампер Х минут, оказывает помощь при определении необходимой пациенту длительности лечебной процедуры, обусловленной потребностью снятия с прибора количества электр~чества минимум 5 мА Х мин. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При этом сила тока во время сеанса может любым образом изменяться, не приводя к неправильному результату. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">&quot;ОРИГИНАЛ Н&quot; питается энергией от 4 штук 9 - вольтовых блочных батареек, которые вставляются с обратной стороны корпуса. Три батарейки служат для снабжения током лечебного процесса и датчика, показывающего мА Х мин (1&shy;ая, 2-ая и 3-я батарейки, считая от места подключения наконечника). 4-ая батарейка питает указатель мА. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Мы желаем Вам успешных результатов лечения и удовольствия от работы с прибором &quot;ОРИГИНАЛ 11&quot;. Мы просим Вас перед тем, как впервый раз приступить к лечению пациента, внимательно ознакомится с этой инструкцией. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прибор для депофореза нельзя открывать ни до, ни после окончания срока гарантии. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Подготовка к сеансу лечения: </font></p><strong><font size="3"><font face="Times New Roman">Подключение электродов:</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Хинч-штекер кабеля вставить в гнездо &quot;Выход&quot; на передней панели прибора. Голубой штекер кабеля вставить в гнездо на конце наконечника. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При оттягивании пружины, находящейся на переднем конце наконечника, появляется кулачок. В него вставляют иголочный электрод. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Наконечник с кабелем к передней панели, в перерывах между работой можно поместить на держатели на боковой стороне прибора. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Красный штекер кабеля вставляют в отверстие на конце зажимного электрода напротив контактной поверхности. Электрод по желанию может <span>&nbsp;</span>устанавливаться с обеих сторон. Маленькие штекеры целесообразно слегка покрыть жиром. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Лечение должно проводиться только в соответствии с инструкцией &quot;Методика эндодонтического лечения депофорезом гидроокиси меди&shy;кальция (новое название &laquo;f&#39;упрал&reg;&quot;). </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Перед размещением электродов в ротовой полости пациента следует убедиться в том, что прибор для депофореза полностью выключен! </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прибор для депофореза и соединительный кабель обычным щадящим образом дезинфицируют. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Электроды и наконечник стерилизуют в автоклавах при температvре максимум 134 С<sup>О</sup>. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Наконечник нельзя погружать в жидкость! </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Обычно появляющееся анодное окисление на контактной поверхности зажимного электрода может быть удалено с помощью резинового полирователя. Осторожно на границе изоляции! </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Примечание: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Иголочный электрод имеет небольшой запас провода. При поломке кончика электрода провод &middot;может быть плоскогубцами вытащен из стержня до необходимой длины. Если после поломки отсутствует возможность взять провод плоскогубцами, то его можно продвинуть с обратной стороны подходящим для этого приспособлением. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Вместо зажимного электрода можно использовать входящий в комплект крюкообразный электрод (решение принимается исключительно исходя из удобства для врача и пациента). Для этого следует вставить маленький красный штекер кабеля в отверстие на прямом конце крюкообразного электрода. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При этом должно быть учтено следующее: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Крюкообразный электрод укладывают пациенту глубоко за щеку таким образом, чтобы загнутый конец электрода находился в слюне. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Чтобы не допустить перегрева тканей, особенно в области слизистой оболочки губы, а также прямого контакта крюкообразного электрода с металлическими коронками или металлическими пломбами живых зубов, электрод следует обернуть влажной марлей или чем-либо аналогичным (в этом случае в виде исключения для увлажнения можно использовать проточную воду). </font></p><strong><font face="Times New Roman" size="3">&nbsp;</font></strong><strong><font size="3"><font face="Times New Roman">Работа прибора:</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">1. Вращающаяся кнопка: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При помощи этой ручки включают прибор поворотом вправо и регулируют лечебный ток путем постепенного очень медленного плавного вращения.&middot; После выключения прибора указатель мА х мин возвращается на 0,0. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Во время сеанса необходимо избегать резких вращательных движений ручкой! </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">2. Зеленый световой диод </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Зеленый световой диод сигнализирует, что прибор вкпючен. Он светится независимо от того, проводится ли в данный момент лечебная процедура или нет. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">З. Показание mA: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Имеющийся в данный момент лечебный ток регистрируется в миллиамперах с двумя десятичными знаками после запятой. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Максимальная величина тока ограничена 10,00 тА </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">4. Показатель мА Х мин: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Указатель МА Х мин показывает степень выполнения процедуры, которая соответствует формуле &quot;Сила тока х время&quot; и выражается в миллиамперах Х минут с 1 десятичным знаком после запятой. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Депофорез необходимо проводить пока не пройдет количество электричества 5 мА х мин при проведении депофореза в 3 сеанса или 7,5 мА х мин - при проведении депофореза в 2 сеанса (см. &laquo;Методику эндодонтического лечения депофорезом ... &raquo; ). </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После достижения в процессе сеанса величины количества электричества в 7,5 мА Х мин (это происходит при проведении метода Депофорез в два сеанса) автоматически прекращается подача тока и прибор для Депофореза IIОригинал&shy;11&quot; выкпючается. Дополнительно раздаётся длительный звуковой сигнал. Несмотря на то, что ток при этом на выходе при бора отсутствует, прибор во избежание быстрого израсходования батарей следует отключить до следующего сеанса путём вращения поворотной ручки. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При отсутствии контакта (прерывание тока во время лечения) указатель мА Х мин остается на достигнутом значении. При восстановлении контакта и тока счетчик продолжает отсчет &quot;МД Х мин&quot;. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Чтобы компенсировать небольшие ошибки в дозировке, возникающие, например при появлении поперчных токов, показатель мА х мин содержит 15% добавку на надежность. </font></p><strong><font size="3"><font face="Times New Roman">Проверка батареек</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для питания Вашего прибора для депофореза Вы должны использовать искпючительно щелочные батареи. Емкость обычной щелочной батарейки /400 mAh/ достаточна для проведения около 1.500 процедур депофореза /при около 5 мА Х мин на одну процедуру/. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При использовании щелочно-марганцевых батареек с 600 mAh емкость увеличивается на 30%. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Применение батареек 9 Volt - Nickel - Metallhybrid - Akkus хотя и возможно, но не рекомендуется поскольку заряда этой батарейки достаточно на очень небольшое число процедур. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Смена батареек производится, если: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">1. указатель &quot;мА&quot; теряет яркость (4-ая батарейка, считая от места подкпючения наконечника) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">2. указатель &quot;мА Х мин&quot; теряет яркость или в состоянии короткого замыкания (например, если соединить электроды или маленькие штекеры кабеля) не дает возможности получить электрический ток 10,00 мА. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Если при включенном приборе возникает продолжительный звуковой сигнал, причиной таюке является разрядка батареек, или минимум 1 батарейка неправильно или не полностью вставлена в прибор. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Указание: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для экономного расходования батареек прибор для депофореза необходимо выключать после каждой процедуры, поскольку он потребляет ток и в состоянии готовности к работе /включен, но без прохождения электрического тока. </font></p><font face="Times New Roman" size="3">&nbsp;</font><strong><font size="3"><font face="Times New Roman">Обслуживание, ремонт и гарантия</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">На прибор для депофореза &quot;ОРИГИНАЛ 11&quot; и наконечник дается гарантия 2 года от даты, указанной в счете на оплату прибора. Однако гарантия не распространяется на батарейки, электроды и кабель. Гарантия действует только при правильном применении прибора. Удовлетворение других требований возмещения убытков исключается. Гарантийным талоном является счет на оплату прибора. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Гарантия не предоставляется в случаях, если прибор был открыт или удалено гарантийное опечатывание. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прибор для депофореза не нуждается в обслуживании, за исключением смены батареек. Необходимый ремонт производится нашей фирмой. Для этого следует прислать прибор, тщательно и надежно его упаковав. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Технические данные </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Размеры: Высота х Ширина х Глубина мм </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>250 х 90 х 210 <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>/ширина, включая держатели для </font></font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">наконечника) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Вес: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">0,5 кг </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">включая батарейки/ </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Напряжение батареек: 4 х 9 вольт /вход </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Выходное напряжение: 24 вольт </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Сила тока при проведении лечения: - около 1 О мА при плавной ре гул ировке. </font></p></div><span style="font-size: 12pt; font-family: &#39;Times New Roman&#39;"><br /></span><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">HUМANCHEMIE </font></p><strong><font size="3"><font face="Times New Roman">Методика эндодонтического лечения депофорезом гидроокиси меди-кальция (новое название &quot;купрал&reg;&quot;)</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">&bull; Перманентная стерильность всей канальной системы </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">&bull; Стимулирование костной обтурации отверстий </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">&bull; Физиологичное излечение остающегося в челюсти стерильного корня </font></p><strong><font size="3"><font face="Times New Roman">1. Обоснование метода </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Депофорез с гидроокисью меди-кальция (в дальнейшем называемой купрал) основан на совершенно ином принципе, чем традиционное лечение корня, а именно: создании перманентно стерильной канальной системы, включая корневой дентин, и стимуляции костной обтурации многочисленных отверстий. Благодаря этому в челюсти сохраняется физиологически излеченный корень, не ослабленный никакой механической &laquo;подготовкой&raquo;, не содержащий бактерий и продуктов их жизнедеятельности. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Указанный принцип реализуется благодаря уникальным бактерицидным и физико&shy;химическим свойствам купрала, и в связи с этим многие требования традиционной </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">эндодонтии теряют свою значимость, а иногда даже отрицательно сказываются на ходе и результатах лечения. На это обстоятельство врачи должны обратить серьезное внимание! </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman">Принцип купрал депофореза, т. е. создание закрытой перманентно стерильной канальной <span>&nbsp;</span></font></font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">системы, строго доказан научно и подтвержден многолетней клинической практикой. Метод депофореза позволяет добиться гораздо большей эффективности лечения, чем это возможно при использовании традиционных подходов. Купрал-депофорез - это единственный метод, для которого представлены результаты бактериологических исследований, свидетельствующие о достижении перманентной стерильности канальной системы. </font></p><strong><font size="3"><font face="Times New Roman">2. Показания к применению </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Девитализированные зубы с любыми типами корней, в том числе с обширными апикальными процессами, с облитерированными каналами, покрытые коронками, а также ранее подвергавшиеся эндодонтическому лечению. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Внимание: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">А) зубы имеющие остатки витальной пульпы, например после витальной экстирпации, сначала должны быть девитализированы (см. П. 4 .Особые случаи и п. 5. Проблемы при проведении депофореза) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Б) Лечение фронтальных зубов см. п. 4. Особые случаи. </font></p><strong><font size="3"><font face="Times New Roman">3. Практическое осуществление метода </font></font></strong><strong><font size="3"><font face="Times New Roman">3. 1 Подготовка корневого канала </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При каждо&#39;мсеансе лечения депофорезом обработке подвергаются все каналы зуба непосредственно один за другим. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Корневой канал несколько расширяют (около 150 30) максимум на протяжении 2/3 длины (но ни в коем случае не ближе, чем 3 мм до отверстия). Результаты терапии нисколько не ухудшатся, если канал пройден менее, чем на 2/3, так как под действием электрического поля купрал проникает и в механически недостижимые части канала. Коронарная часть может быть расширена несколько больше, чем 180 30, для создания депо купрала, а таюке для обнаружения дополнительных параллельных каналов. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Промывание канала следует проводить дистиллированной водой или 5-10% взвесью &laquo;гидроокиси кальция высокодисперсной&raquo; (фирмы &laquo;Humanchemie&quot;) в дистиллированной воде. </font></p><strong><font size="3"><font face="Times New Roman">3.2 Заполнение канала купралом </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для предотвращения поперечных токов, коронка зуба, который подвергают лечению, должна быть сухой (см. п. 3.3). С помощью каналонаполнителя лентуло или минипипеткой в верхнюю треть канала вносят купрал, имеющий консистенцию жидкой сметаны. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Поскольку при прохождении тока температура в канале несколько повышается, может произойти высыхание купрала. Его следует прямо в канале разбавить дистиллированной водой. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Ни в коем случае не пытайтесь плотно заполнить канал. Перемещение купрала в нижнюю часть канала происходит только под действием электрического поля. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Во избежание появления болевых ощущений у пациента нельзя допускать попадания купрала в периапикальную область. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Примечание: При некоторых обстоятельствах (например загрязнении дентина полости) купрал может вызвать окрашивание зуба. Чтобы избежать окрашивания, следует тщательно протереть стенки полости взвесью гидкоокиси кальция высокодисперсной. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При проведении депофореза на фронтальных зубах рекомендуется использовать смесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной (см. п. 4 &laquo;Особые случаи&raquo; ). </font></p><strong><font size="3"><font face="Times New Roman">3. 3 Работа с прибором для депофореза</font></font></strong> <p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Следуйте также указаниям &laquo;Инструкции по эксплуатации прибора для депофореза&raquo;. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Положительный зажимный электрод или крюкообразный электрод помещаются во рту на удобной для врача стороне: </font></p><em><font size="3"><font face="Times New Roman">А) Закрепление зажимного электрода </font></font></em><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Не покрытая лаком металлическая внутренняя поверхность должна располагаться на влажной слизистой щеки. Часто является достаточным перед началом лечения смочить проточной водой контактную поверхность зажимного электрода. Между контактной поверхностью электрода и слизистой щеки рекомендуется проложить кусок марли, смоченной проточной водой, для того, чтобы исключить ожог слизистой. </font></p><em><font size="3"><font face="Times New Roman">Б) Расположение крюкообразного электрода </font></font></em><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Короткая изогнутая часть электрода должна располагаться в слюне переходной складки, а длинная прямая - за пределами ротовой полости, в направлении вниз. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Чтобы избежать контакта электрода с металлическими пломбами или коронками и предотвратить нагревание слизистой, короткую часть электрода, находящуюся во рту, следует обернуть марлей, смоченной проточной водой. </font></p><em><font size="3"><font face="Times New Roman">В) Применение отрицательного иголочного электрода </font></font></em><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Отрицательный электрод, закрепляют в наконечнике. До включения при бора электрод неглубоко (около 3-5 мм!) погружают в купрал, который был предварительно внесен в канал. ЧтоБЬJ предотвратить возникновение поперечных токов, рабочее поле вокруг канала следует содержать сухим, например периодически обдувая струей воздуха. Поперечные токи являются частью токов, которые идут через десну и слюну к положительному электроду, не попадая в канал. Они также регистрируются прибором для депофЬреза и могут иногда достигать значительной части регистрируемого прибором тока, что Mo~eT привести к недодозированию купрала инедолечению. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При лечении депофорезом каждый канал необходимо обработать количеством электричества 15 мА х минут. Это количество может быть разделено на 2 или 3 сеанса. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">а) При лечении в 3 сеанса каждый канал за 1 сеанс должен быть обработан количеством электричества 5 мА х мин, если работа проводится с прибором &laquo;Оригинал 1/&raquo;. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При использовании прибора &laquo;Комфорт 1&raquo; сеанс продолжается до показания 1 00%. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При работе с прибором &laquo;Комфорт 11&raquo; лечение проводится до показателя &laquo;Программа 1 &raquo;. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">б) При проведении депофореза прибором &laquo;Оригинал 11&raquo; в 2 сеанса каналы каждый раз обрабатывают количеством электричества 7,5 мА х мин. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При приборе &laquo;Комфорт 1&quot;&#39;= 100% + еще 50%. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">При использовании &laquo;Комфорта 1/&raquo; = Программа 2. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После размещения электродов включают прибор для депофореза и медленно увеличивают силу тока пока ощущение тепла в области корня зуба не станет пациенту неприятным. Обычно это наблюдается при величине тока от 0,8 мА до максимум 1,5 мА. Ток следует немного уменьшить (до исчезновения дискомфорта) и проводить сеанс. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После проведения приблизительно половины сеанса силу тока уменьшают до О, не выключая прибор, иначе будет стерто уже достигнутое значение количества электричества. Из канала следует извлечь купрал (насколько это возможно). Канал не промывать. Внести свежую порцию купрала. Это чрезвычайно важно! При извлечении первоначальной порции купрала удаляются TalOКe чужеродные ионы, проникшие в канал из периапикальной области. Эти ионы приводят к повышению величины тока, однако не оказывают лечебного действия. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После внесения новой порции купрала продолжают сеанс депофореза. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Во время проведения депофореза вследствие электроосмоса из канала выделяется жидкость, обычно пенообразная. Эту пену следует постоянно удалять, например ватным тампончиком, так как она может привести к появлению поперечных токов (см. выше). Необходимо отметить, что если пациент при величине тока 1,5 мА не отмечает значительного потепления в области корня, это свидетельствует скорее всего о наличии значительных поперечных токов (см. также п. 4. Особые случаи и п. 5. Проблемы при проведении депофореза). </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Каждый канал должен быть обработан суммарным количеством электричества не менее 15 мА х мин (за 2 или 3 сеанса), в противном случае успешность лечения, достигающая обычно почти 100%, может существенно снизиться. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Суммарное время лечения одного канала составляет обычно около 15 минут. Это значительно меньше, чем время, необходимое для лечения традиционным способом. При депофорезе многие виды работ могут быть поручены ассистенту врача. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После окончания сеанса прибор выключают и из канала извлекают отрицательный электрод. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Из канала механически удаляют доступную часть купрала (канал не промывать!). Затем канал заполняют свежей порцией купрала (так, как обычно делают вкладки лекарственных препаратов). Канал оставляют открытым или закрывают временной пломбой, сделав отверстие для входа в канал. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Обоснование: Опасность реинфекции в глубине канала исключительно мала, так как из-за очень малой растворимости купрала после депофореза в канале всегда имеется его насыщенный раствор, обладающий мощным бактерицидным действием. При открытом канале благодаря оттоку экссудата и&middot;свободному выделению газов значительно снижается давление, и следовательно, уменьшается вероятность появления болей. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Второй (или третий сеанс) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Во время второго сеанса, который обычно проводится через 8-14 дней, извлекают ранее вложенный купрал. Вносят новую порцию купрала и проводят сеанс депофореза. Третий сеанс проводят таким же образом итаюке спустя 8-14 дней. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">После проведения последнего сеанса механически удаляют легко извлекаемый отработанный купрал (канал не промывать!). </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Не внося никакого лекарственного препарата, пломбируют канал атацамитом &shy;цементом для пломбирования канала (см. следующий раздел). </font></p><strong><font size="3"><font face="Times New Roman">3.4 Пломбирование канала </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Во время последнего посещения сразу после проведения сеанса депофореза канал пломбируют щелочным цементом - атацамитом (фирмы &laquo;Humanchemie&raquo;). Атацамит необходимо размешивать на пластине минимум 1 минуту. Размешав до консистенции сметаны, цемент вносят в канал с помощью каналонаполнителя. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Важное примечание: Заполнение атацамитом производится на одну-две трети длины канала (ни в коем случае не глубже, чем 3 мм до апекса). </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Атацамит ни в коем случае не должен быть выведен за пределы канала, так как это может вызвать сильную реакцию со стороны периапикальных тканей. Следует принципиально отказаться от пломбирования нижней части канала, которая после депофореза становится стерильной. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Боли, появившиеся в результате выведения купрала или атацамита за верхушку корня, через несколько дней проходят. Не следует делать резекцию или удалять зуб. Можно назначить обезболивающие препараты. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Атацамит имеет небольшую твердость и поэтому, например при необходимости повторного проведения лечения, может быть легко извлечен. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для фиксации штифта атацамит не пригоден. Поэтому при штифтовании зуба часть атацамита удаляют. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для пломбирования канала после депофореза ни в коем случае не следует с самого начала использовать фосфатный цемент или какой-либо другой пломбировочный материал, поскольку атацамит оказывает важное терапевтическое действие. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Важное указание: Протеолиз, благодаря которому происходит растворение органического содержимого и стерилизация всей канальной системы, т. е то,.что обеспечивает лечение, при правильном проведении депофореза, затрагивает также небольшие участки периапикальной области вокруг многочисленных отверстий, а не только возле главного отверстия, как при традиционных эндодонтических методах. Поэтому следствием такого воздействия (абактериального раздражения) может быть возникновение чувствительности зуба при постукивании и накусывании. В связи с этим в первое время после лечения следует стараться не подвергать зуб нагрузке. После уменьшения дискомфорта наступает действительное физиологичное излечение. Указанные временные явления раздражения тканей периапикальной области следует отличать от острого Paгodontitis apicalis, который нуждается в лечении. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Реоссификация,В том числе крупных очагов, наблюдаемая, как правило, после депофореза, приблизительно уже через 6 месяцев, в зависимости от возраста пациентов, выявляется рентгенологически. Через 18 месяцев обычно реоссифицируют даже обширные очаги. </font></p><strong><font face="Times New Roman" size="3">&nbsp;</font></strong><strong><font size="3"><font face="Times New Roman">4. Особые случаи </font></font></strong><strong><font size="3"><font face="Times New Roman">4.1 Предварительное лечение при наличии остатков витальной пульпы, например, после витальной экстирпации </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">(проявляется непереносимостью самых малых токов, менее 0,3 мА) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Вариант А. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Зуб девитализируют обычным образом. Только после этого начинают лечение депофорезом. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Если через 4 недели после девитализации по-пржнему сохраняется витальность, например при пrjохой доступности канала, тогда следуют рекомендациям в варианте Б. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Вариант Б. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Депофорез проводят как обычно, но под анестезией. Однако в этому случае мы рекомендуем проводить 3 сеанса (см. п. 3.3 Работа с прибором для депофореза) при величине тока максимум 1,0 мА. </font></p><strong><font size="3"><font face="Times New Roman">4.2 Фронтальные зубы </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Для избежания окрашивания зубов фронтальной области вместо купрала необходимо использовать смесь, состоящую из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной. </font></p><strong><font size="3"><font face="Times New Roman">4.3 Наличие обострения </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">В большинстве случаев в результате электроосмотического освобождения периапикальной области от экссудата наблюдается мгновенное улучшение состояния. </font></p><strong><font size="3"><font face="Times New Roman">4.4 Кровоточивость канала </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Перед проведением депофореза кровь следует остановить, поскольку в крови содержатся . различные чужеродные ионы, которые могут повлиять на эффективность депофореза. </font></p><strong><font size="3"><font face="Times New Roman">4.5 Лишь частично проходимые каналы </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Такие каналы можно вполне успешно лечить, если в вехнюю часть несколько расширенного канала удастся внести немного купрала. В этих случаях депофорез обычно продолжается несколько дольше, так как не удается достичь большой величины тока. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Однако возможен и другой подход - после одного сеанса депофореза с использованием прибора в каналах установить гальванические штифты, которые обеспечивают длительный депофорез. Излечение проходит столь же успешно, как и при проведении депофореза обычным образом. </font></p><strong><font size="3"><font face="Times New Roman">4.6 Каналы зуба не удается электрически изолировать друг от друга <span>&nbsp;&nbsp;&nbsp;&nbsp; </span></font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman">Рекомендуется в каналы ввести какие-либо штифты. Заполнить полость пломбировочным <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>, <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></font></font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">материалом (например, композитом). После того, как материал слегка отвердеет, извлечь штифты. Таким образом, входы в каналы будут надежно отделены друг от друга. Отсутствующие стенки полости могут быть таким же образом восстановлены временным реставрационным материалом. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman"><strong>4.7 Ревизия после ранее проведенного лечения корневых каналов</strong> </font></font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Перед проведением депофореза следует насколько это возможно удалить прежний пломбировочный материал. Даже при наличии остатков этого материала как правило, удается получить хорошие результаты лечения, поскольку ток проходит по боковым канальцам. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Примечание: Во всех случаях, когда имеется серьезная опасность выведения купрала в периапикальную область (например, широкое отверстие или зубы, подвергавшиеся резекции) рекомендуется вместо чистого купрала использовать смесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной). Смесь следует осторожно внести вращательными движениями только в верхнюю часть канала. Таким образом удается предотвратить боли, которые могут возникнуть при выведении купрала за верхушку. </font></p><strong><font size="3"><font face="Times New Roman">4.8 Зубы, покрытые коронкой </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Следует пройти бором коронку и далее действовать, как описано в п. 4.7. 8 этом случае иголочный электрод может быть погруженнесколько глубже, чем обычно. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Решающее значение имеет минимирование поперечных токов через край коронки. Чтобы предотвратить возникновение прямого контакта иголочного электрода и коронки, изолирующую трубочку электрода вдвигают вместе с ним в окошко коронки. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Электрод можно таюке покрыть изолирующим лаком, не доходя 2 мм до кончика. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Ни в коем случае нельзя допускать возникновения пленки влаги между корневым каналом и коронкой. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Если пациент при величине тока более 1,0 мА не ощущает никакого потепления в канале, это является достоверным признаком наличия поперечных токов. </font></p><strong><font size="3"><font face="Times New Roman">4.9 Молочные зубы </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Проводить лечение молочных зубов депофорезом не рекомендуется. Однако в качестве лекарственной вкладки хорошо зарекомендовала себя взвесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной. </font></p><strong><font size="3"><font face="Times New Roman">4.10 Кисты </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Многие врачи успешно лечат радикулярные кисты, используя депофорез. В клиниках обычно используют следующую методику: </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Канал подготавливают до апекса. Рекомендуется при возможности несколько расширить апикальное отверстие. Ток устанавливают большей величины, чем обычно (например, 5 мА) (в зависимости от размеров кисты) и каждый канал обрабатывает большим количеством электричества (&gt;30 мА х мин). Необходимо провести 3 сеанса, подавая на каждый канал минимум 30 мА х мин (проведение расчетов см. в п. 3.3. сноска 1). </font></p><strong><font size="3"><font face="Times New Roman">4. 11 Водитель ритма сердца </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Купрал-депофорез не нарушает функцию водителя ритма сердца (IMICH, Dtsch. ArztebIatt, Ausg. А 37, S. 2957, 1992). Приборы с ручными электродами использовать нельзя. </font></p><strong><font size="3"><font face="Times New Roman">5. Проблемы в процессе лечения<span>&nbsp; </span></font></font></strong><strong><font size="3"><font face="Times New Roman">5.1 Несмотря на установку на приборе максимальной величины тока, она остается ниже 0,4 мА </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Это обычно объясняется большим сопротивлением канала. Депофорез все равно рекомендуется проводить. После одного сеанса работы с прибором для депофореза лечение можно продолжить, используя гальванические штифты. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">В некоторых случаях невозможность достигнуть оптимальной величины тока связана с разрядкой батареек (см. инструкцию по эксплуатации соответствующего прибора для депофореза). </font></p><strong><font size="3"><font face="Times New Roman">5.2 Сила тока падает во время сеанса депофореза </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Причина: Тепло, образующееся при прохождении тока, высушивает купрал, содержащий недостаточное количество влаги. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Коррекция: Внести в канал жидко разведенный купрал. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Другие возможные причины: разрядка батареек (см. инструкцию по эксплуатации соответствующего прибора для депофореза). </font></p><strong><font size="3"><font face="Times New Roman">5.3 Непереносимость даже слабых токов </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Причиной является наличие в боковых каналах витальных остатков пульпы. Следует поступать, как описано в п. 4.1. </font></p><strong><font size="3"><font face="Times New Roman">5.4 Пациент не ощущает существенного потепления в канале при силе тока 1,0 - 1,5 мА </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Это явный показатель наличия поперечных токов. Лишь очень немногие пациенты обладают столь низкой чувствительностью, что не замечают увеличения тепла при указанных величинах тока. Поперечные токи следует убрать (например, струей воздуха) (см. таюке п. 3). </font></p><strong><font size="3"><font face="Times New Roman">6. Проблемы, встречающиеся после лечения </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman"><strong>6. 1 Боли, возникающие через несколько часов после проведения депофореза </strong>Причиной обычно является механическое проталкивание купрала или корневого цемента атацамита в периапикальную область. Необходимо свести к минимуму нагрузки на зуб! Обычно через несколько дней боли стихают. Можно назначить обезболивающее средство. Ни в коем случае не удалять зуб. </font></font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font size="3"><font face="Times New Roman"><strong>6.2 Боли в более отдаленном периоде после лечения (минимум через 1 день)</strong> Причиной является возникновение давления внутри канала в результате образования секретов и газов, если канал не был оставлен открытым или оставленное в пломбе отверстие забил ось остатками пищи. Необходимо освободить вход в канал. Как показала практика, закрытие полости зуба ватой не целесообразно. </font></font></p><strong><font size="3"><font face="Times New Roman">6.3 Рецидивы </font></font></strong><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Эти чрезвычайно редкие случаи, в основном, являются следствием недодозирования действующего количества электричества в результате возникновения поперечных токов. Необходимо заново тщательно провести депофорез (2 или 3 сеанса), предварительно удалив из канала атацамит. Это не сложно, так как атацамит имеет низкую твердость. Следует при этом обратить внимание на наличие параллельных каналов, которые, возможно, не были обнаруженны в ходе ранее проведенного лечения. </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">7. Как избежать ошибок при про ведении депофореза </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Токи, проходящие не через корневой канал, а через коронку зуба (поперечные токи) </font></p><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">следует убирать, лучше всего путем периодического обдувания зуба струей воздуха. Тонкие пленки слюны на зубной коронк е, часто невидимые, обладают большой электропроводностью и поэтому приводят К образованию сильных поперечных токов.</font></p><p style="margin: 0cm 0cm 0pt 36pt; text-indent: -18pt; tab-stops: list 36.0pt" class="MsoNormal"><span style="font-family: Wingdings"><span><font size="3">&Oslash;</font><span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman" size="3">Поскольку электрическое сопротивление заполненного купралом канала редко бывает меньше 20 ка, а чаще всего больше, чем 30 ка, иногда даже достигает порядка 70 ка, то токи, превышающие 1,5 мА (при полном повороте ручки регулятора напряжения прибора), содержат скорее всего бесполезные поперечные токи. <span>&nbsp;</span>Следствие: недодозирование действующей субстанции. </font></p><p style="margin: 0cm 0cm 0pt 36pt; text-indent: -18pt; tab-stops: list 36.0pt" class="MsoNormal"><span style="font-family: Wingdings"><span><font size="3">&Oslash;</font><span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman" size="3">Еще ОДНОЙ причиной слишком больших величин тока является электроосмос серозной ЖИДКОСТИ из периапикальной области через апикальную дельту. Эта жидкость обнаруживается у отрицательного электрода. Она имеет гораздо большую электропроводность, чем купрал. Это при водит К значительному возрастанию силы тока в процессе депофореза. Носителями этой части тока являются преимущественно анионы хлора. Поэтому количество переносимых действующих ионов значительно снижается. Для предотвращения этой очень серьезной ошибки необходимо через некоторое время после начала сеанса (самое позднее на половине сеанса) остановить депофорез, извлечь из канал купрал и заменить его новой порцией препарата. После этого продолжить депофорез. </font></p><p style="margin: 0cm 0cm 0pt 36pt; text-indent: -18pt; tab-stops: list 36.0pt" class="MsoNormal"><span style="font-family: Wingdings"><span><font size="3">&Oslash;</font><span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman" size="3">Согласно данным врачей - членов стоматологической научной группы Гамбургского университета, после депофореза (при правильном проведении методики) боли не возникают. Болевые ощущения в результате абактериального раздражения (через день после сеанса) появляются только, если купрал выведен непосредственно в периапикальную область с живыми тканями. Поэтому и при наличии витальных остатков пульпы, например, после так называемой вительной экстирпации, депофорез следует проводить только после надежной девитализации пульпы. </font></p><p style="margin: 0cm 0cm 0pt 36pt; text-indent: -18pt; tab-stops: list 36.0pt" class="MsoNormal"><span style="font-family: Wingdings"><span><font size="3">&Oslash;</font><span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman" size="3">При выведении значительного количества купрала или атацамита за пределы отверстия могут возникнуть боли и даже отечность. Согласно нашему опыту, это абактериальное воспаление постепенно самопроизвольно прекращается. </font></p>', '', '', '', '2007-01-31 16:17:35', 7, 'russian');
INSERT INTO `nuke_pages` (`pid`, `cid`, `title`, `subtitle`, `active`, `page_header`, `text`, `page_footer`, `signature`, `date`, `counter`, `clanguage`) VALUES (2, 4, 'Инструкция по программе', '', 1, '', '<span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span><span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span><span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span><span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span><span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span><span style="font-size: 16pt"><font face="Times New Roman">ДЕНТ &ndash; Система управления стоматологической клиникой</font></span><font face="Times New Roman" size="2">&nbsp;</font> <p style="margin: 0cm 0cm 0pt" class="MsoBodyText"><font face="Times New Roman" size="2">Руководство пользователя. Часть 2.</font></p><font face="Times New Roman" size="2">&nbsp;</font> <h1 style="margin: 0cm 0cm 0pt; text-align: center" align="center"><span style="font-size: 14pt"><font face="Times New Roman">Работа регистратуры и лечебный процесс</font></span></h1><span style="font-size: 14pt; font-family: &#39;Times New Roman&#39;"><br /></span><h1 style="margin: 0cm 0cm 0pt; text-align: center" align="center"><span style="font-size: 14pt"><font face="Times New Roman">&nbsp;</font></span></h1><h1 style="margin: 0cm 0cm 0pt; text-align: justify"><span style="font-size: 10pt"><font face="Times New Roman">Во второй части инструкции описывается работа с блоками &laquo;Регистратура&raquo; и &laquo;Лечебный процесс&raquo;. Описаны процедуры заведения личных карточек пациентов, назначения пациентов на прием, заведение лечебных процедур при различных вариантах лечения. Описаны процедуры работы с деньгами &ndash; прием долгов, кредитов, залогов с рабочих мест врача и регистратора. Так же описаны действия регистраторов при различных внештатных ситуациях.</font></span></h1><font face="Times New Roman" size="3">&nbsp;</font><font face="Times New Roman" size="3">&nbsp;</font><span style="font-size: 12pt; font-family: &#39;Times New Roman&#39;"><br /></span><span style="font-size: 14pt"><font face="Times New Roman">ОГЛАВЛЕНИЕ</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;</font></span> <table border="0" cellspacing="0" cellpadding="0" class="MsoNormalTable" style="border-collapse: collapse"><tbody><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><font face="Times New Roman" size="3">&nbsp;</font></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h4 style="margin: 0cm 0cm 0pt"><span style="font-size: 12pt"><font face="Times New Roman">Введение</font></span></h4></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">7</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h4 style="margin: 0cm 0cm 0pt"><span style="font-size: 12pt"><font face="Times New Roman">Работа регистратора</font></span></h4></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">8</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прогнозное расписание</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">9</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.1.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Назначение пациента на прием</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">15</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.1.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Назначение пациента на несколько приемов. Работа с буфером</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">16</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Блокнот врача</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">17</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Блокнот кабинета</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">19</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Оперативная коррекция</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">21</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.4.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Оперативная коррекция на уровне смены</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">21</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.4.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Операции с приемами</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">25</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><font size="3"><font face="Times New Roman">1.5<span></span></font></font></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Картотека пациентов</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">27</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Личная карточка пациентов (Информация о пациенте)</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">30</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прием долга</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">32</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прием залога</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">36</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Прием кредита (аванса)</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">37</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.5</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Денежные дела пациента</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">38</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.6</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Выборки из картотеки</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">41</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.5.7</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Заведение страховых полисов пациента</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">43</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.6</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Работа с назначениями на контрольный осмотр</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">47</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><font size="3"><font face="Times New Roman">1.7<span></span></font></font></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; tab-stops: 35.4pt" class="MsoFooter"><font face="Times New Roman" size="3">Вспомогательные функции регистратора</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">49</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.7.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><font size="3"><font face="Times New Roman">Контроль явки персонала<span></span></font></font></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">49</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">1.7.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Продажа товаров и услуг в регистратуре</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">50</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span><font size="3"><font face="Times New Roman">1.7.3</font></font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Регистрация клиентов, пользующихся льготой</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">52</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><font size="3"><font face="Times New Roman">1.7.<span>4</span></font></font></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Закрытие года</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">53</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Лечебный процесс</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">54</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Выбор пациентов, назначенных на прием</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">55</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Рабочее место врача</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">57</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Терапевтическое лечение</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">62</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Заполнение формы 43 &ndash; Первичный осмотр пациента.</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">62</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Мастер 43-ей формы. Составление плана терапевтического лечения</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">64</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Простановка диагнозов на зубы</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">67</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Описание формы занесения информации о лечении</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">69</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.5</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Выбор клише к поставленному диагнозу</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">74</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.6</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Занесение информации о лечении</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">76</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.3.7</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Эндодонтическая карта зуба</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">77</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Ортопедическое лечение</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">81</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.4.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Этап 1. Проектирование конструкции</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">82</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-weight: normal; font-style: normal"><font size="3"><font face="Times New Roman">Описание экранной формы построения конструкции</font></font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">82</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-style: normal"><font size="3"><font face="Times New Roman">Работа с формой построения конструкции</font></font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">86</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.4.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Этап 2. Составление план протезирования</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">88</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Описание экранной формы составления плана</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">88</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Работа с формой составления плана</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">90</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.4.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; tab-stops: 35.4pt" class="MsoFooter"><font face="Times New Roman" size="3">Этап 3. Выполнение манипуляции из плана</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">92</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Описание экранной формы</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">92</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Занесение информации о выполнении</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">96</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.5</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Ортодонтическое лечение</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">97</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.5.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Заполнение ортодонтического приложения к стоматологической карте пациента</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">97</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Лист 1. Общая информация</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">99</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Лист 2. Клиническое обследование</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">101</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">Лист 3. Специальные методы исследования</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">103</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">&nbsp;</font></span></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><span style="font-size: 11pt"><font face="Times New Roman">План лечения</font></span></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">108</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.5.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Ведение дневника ортодонтического пациента</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">112</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.6</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Пародонтологическая карта</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">114</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.7</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Работа со снимками</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">117</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.8</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Назначение пациента на повторный прием, контрольный осмотр</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">120</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.9</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Дополнительные функции программы в лечебном процессе</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">122</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.9.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Заполнение дополнительной информации и установка отметок о риске</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">122</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">2.9.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Установка отметки о санации</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">122</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt" class="MsoNormal"><font face="Times New Roman" size="3">Работа с мусорной корзиной</font></p></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">124</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Отчёты для врача и регистратора</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">126</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.1</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Ведомость за день для врача</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">126</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.2</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Сведения о назначенных на КОС</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">127</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.3</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Сводка по полученным суммам</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">127</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.4</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Финансовый отчет за день</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">128</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.5</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Сводка за день по врачам</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">130</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.6</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Отчет о размерах залогов на настоящий момент</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 2cm; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: center" class="MsoNormal" align="center"><font face="Times New Roman" size="3">130</font></p></td></tr><tr><td width="46" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 34.8pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><p style="margin: 0cm 0cm 0pt; text-align: right" class="MsoNormal" align="right"><font face="Times New Roman" size="3">4.7</font></p></td><td width="539" valign="top" style="padding-right: 5.4pt; padding-left: 5.4pt; padding-bottom: 0cm; width: 403.95pt; padding-top: 0cm; background-color: transparent; border: #ece9d8"><h6><span style="font-weight: normal; font-size: 12pt"><font face="Times New Roman">Справка по залогам за период</font></span></h6></td><td width="76" valign="top" style="padding-right: 5.4pt; padding-le', '', '', '2007-01-31 16:56:31', 4, 'russian');
INSERT INTO `nuke_pages` (`pid`, `cid`, `title`, `subtitle`, `active`, `page_header`, `text`, `page_footer`, `signature`, `date`, `counter`, `clanguage`) VALUES (3, 1, 'Основные характеристики и практическое применение коффердама', '', 1, '<span style="font-size: 10pt"><font face="Times New Roman">Аспект безопасности и стремление к оптимальным результатам в лечении зубов с использованием адгезивной техники, а также в эндодонтии являются основой применения коффердама в стоматологической практике. Коффердам является conditio sine gua non при фиксации керамических и композитных вкладок, вкладок из золота, композитных пломб в области боковых зубов, а также адгезивных мостов. Из соображений гигиены для медицинского персонала и пациента, для защиты слизистой оболочки полости рта пациента от раздражающего действия химических субстанций при промывании корневых каналов и применении методов отбеливания, для ретракции десны и для защиты мягких тканей щек и губ также следует рекомендовать коффердам. Рациональное применение коффердама обеспечивает вдобавок выигрыш во времени, облегчение работы, а также достаточный обзор всего рабочего поля. Каждый стоматолог знаком с коффердамом, а приемы работы с ним должны быть освоены еще в процессе обучения. Правда, в Германии коффердам систематически используется 5-15% стоматологов. В таких странах, как США, Швейцария и скандинавские государства, коффердам применяется в 5-7 раз чаще. В качестве оснований для отказа от коффердама стоматологами Германии выдвигаются аргументы - затраты времени на наложение и сложное применение. J.K.Jngle этот аргумент описал следующим образом: &laquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&raquo;. Причины же кроются по большей мере в недостаточных знаниях, а также в недостаточных навыках по технике наложения коффердама. Коффердам является&nbsp;простейшим, но действенным вспомогательным средством, которое должно помогать, а не обременять.&nbsp;Преимущества его применения должны больше, чем&nbsp; дополнительных&nbsp;затраты. Проблема состоит в том, чтобы минимизировать затраты времени пациента на аппликацию коффердама. Это возможно только при использовании описанных ниже простых методов коффердам-техники и постоянной тренировке. Для этого предлагаются соответствующие курсы и информационные материалы. Фирма Hager-Werken организует курсы по технике коффердама, ею создан видео-фильм и выпущена информационная брошюра о коффердаме, что несомненно способствует дальнейшему распространению метода абсолютной изоляции. После основательной переработки 1-го издания в свет вышла вторая брошюра о фит-коффердаме. Начинающаяся с исторического аспекта, она приводит преимущества и недостатки, описывает составные части набора коффердама. Подробно и систематизировано освещены отдельные основные варианты техники применения коффердама.&nbsp; Описание дополнено иллюстративным материалом. Благодаря доступному изложению, а также хорошим иллюстрациям информационная брошюра вносит весьма ценный вклад в широкое и быстрое распространение техники коффердама.</font></span>', '<span style="font-size: 10pt"><font face="Times New Roman">&nbsp;</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Основные характеристики и практическое применение коффердама.</span></strong><span style="font-size: 10pt; color: black"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Предисловие</span></strong></font></span><span style="font-size: 10pt"><font face="Times New Roman">Аспект безопасности и стремление к оптимальным результатам в лечении зубов с использованием адгезивной техники, а также в эндодонтии являются основой применения коффердама в стоматологической практике. Коффердам является conditio sine gua non при фиксации керамических и композитных вкладок, вкладок из золота, композитных пломб в области боковых зубов, а также адгезивных мостов. Из соображений гигиены для медицинского персонала и пациента, для защиты слизистой оболочки полости рта пациента от раздражающего действия химических субстанций при промывании корневых каналов и применении методов отбеливания, для ретракции десны и для защиты мягких тканей щек и губ также следует рекомендовать коффердам. Рациональное применение коффердама обеспечивает вдобавок выигрыш во времени, облегчение работы, а также достаточный обзор всего рабочего поля. Каждый стоматолог знаком с коффердамом, а приемы работы с ним должны быть освоены еще в процессе обучения. Правда, в Германии коффердам систематически используется 5-15% стоматологов. В таких странах, как США, Швейцария и скандинавские государства, коффердам применяется в 5-7 раз чаще. В качестве оснований для отказа от коффердама стоматологами Германии выдвигаются аргументы - затраты времени на наложение и сложное применение. J.K.Jngle этот аргумент описал следующим образом: &laquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&raquo;. Причины же кроются по большей мере в недостаточных знаниях, а также в недостаточных навыках по технике наложения коффердама. Коффердам является&nbsp;простейшим, но действенным вспомогательным средством, которое должно помогать, а не обременять.&nbsp;Преимущества его применения должны больше, чем&nbsp; дополнительных&nbsp;затраты. Проблема состоит в том, чтобы минимизировать затраты времени пациента на аппликацию коффердама. Это возможно только при использовании описанных ниже простых методов коффердам-техники и постоянной тренировке. Для этого предлагаются соответствующие курсы и информационные материалы. Фирма Hager-Werken организует курсы по технике коффердама, ею создан видео-фильм и выпущена информационная брошюра о коффердаме, что несомненно способствует дальнейшему распространению метода абсолютной изоляции. После основательной переработки 1-го издания в свет вышла вторая брошюра о фит-коффердаме. Начинающаяся с исторического аспекта, она приводит преимущества и недостатки, описывает составные части набора коффердама. Подробно и систематизировано освещены отдельные основные варианты техники применения коффердама.&nbsp; Описание дополнено иллюстративным материалом. Благодаря доступному изложению, а также хорошим иллюстрациям информационная брошюра вносит весьма ценный вклад в широкое и быстрое распространение техники коффердама.</font></span><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;</font></span></strong><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Фит в коффердам-технике</span></strong><span style="font-size: 10pt"></span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изобретатель коффердама.</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">В 1883 году д-р La Roche (Франция) заявил об использовании им коффердама уже с 1857 года, поэтому его считают первым изобретателем этой техники, несмотря на то, что Sanford Christi Barnym (1836-1885) &ndash; нью-йоркский&nbsp;зубной врач &ndash; 15.03.1864 впервые применил коффердам. Уже в июне 1864 года на заседании общества дантистов в Нью-Йорке им была устроена демонстрация использования коффердама перед коллегами. В августе 1864 г. было опубликовано первое сообщение. И уже в&nbsp;1867 году техника коффердама получила&nbsp;широкое распространение.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Значение и цель использования коффердама</span></strong><span style="font-size: 10pt"> </span></font><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">Преимущества для врача и персонала </font></span></strong><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Защита</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-от проглатывания </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-от аспирации </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Исключение повреждения слизистой оболочки жидкостями для промывания или </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">дезинфицирующими средствами </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Защита врача и персонала от инфекции </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Ретракция мягких тканей (десна, губы, щеки, язык) </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Облегчение работы</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Рабочее поле остается сухим </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Рабочее поле длительное время дезинфицировано </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Хороший обзор </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Стерильный способ работы </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<u><span style="color: black">-Выигрыш во времени около 20% </span></u></font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><u><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;-Рот постоянно открыт </font></span></u><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><u><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;-Дискуссия с пациентом прерывается </font></span></u><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><u><span style="font-size: 10pt; color: black">&nbsp;-Отсутствие необходимости прополаскивать </span></u><span style="font-size: 10pt">полость рта </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Отсутствие необходимости в замене ватных валиков </font></span><font face="Times New Roman"><strong><u><span style="font-size: 10pt">Для пациента&nbsp;наибольшее преимущество состоит в комфорте</span></u></strong><span style="font-size: 10pt">, так как он чувствует, что лечение происходит вне полости рта. При этом ощущение пересушенной слизистой оболочки возникает не в большей степени, чем при интенсивном применении слюноотсоса или ватных валиков. Это же относится к ощущению дискомфорта при опоре пальцев врача. Уменьшается также раздражение от удушья и рвотного рефлекса. Благодаря изоляции содержимое полости рта остается обычным и пациент может глотать и дышать.</span></font><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">Недостатки коффердама</font></span></strong><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Потеря осевых ориентиров при препарировании входа в полость зуба </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Возможно травмирование межзубного сосочка </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Большие требования при рентгенографии </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Возможная аллергия (помощь: использование силиконовых пластин, фирма Roeko) </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важные цитаты </span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&ldquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&rdquo; (J.I. Ingle)</font></span><span style="font-size: 10pt"><font face="Times New Roman">&laquo;При наличии навыка в обычном случае лечения возможно наложить коффердам в течение примерно&nbsp;1 минуты (максимум двух минут)&raquo; (J.I.Ingle)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Для чего и почему коффердам?</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Короче и точнее всех на этот вопрос ответил G.V.Black (1908). Он писал: &laquo;Коффердам служит для того, чтобы содержать операционное поле при работе на зубах чистым, сухим и в случае необходимости асептичным. Последнее особенно желательно при&nbsp;лечении корневых каналов. (G.V.Black 1908)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-продукты и их свойства</span></strong><span style="font-size: 10pt"> </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt">Коффердам</span></strong><span style="font-size: 10pt">-пластина из натурального латекса поступает в продажу в рулоне или в виде салфетки размером 15х15 см. Коффердам обладает очень высокой эластичностью, которая необходима для его&nbsp;применения. К сожалению, его оптимальные свойства не безграничны (около 9 месяцев), потом он разрушается, что означает: он становится ломким, благодаря чему очень быстро рвется и недостаточно плотно прилегает. Если латекс поместить в холодильник или даже в сильно охлажденный ящик, он может сохранять свои свойства в течение более длительного времени (при описанном хранении &ndash; около 1 года).</span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Проверка</span></strong><span style="font-size: 10pt"> </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Испытание качества</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Если латекс можно растянуть между руками до абсолютной прозрачности, его свойства оптимальны для использованя вне зависимости от его возраста.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Цвета коффердама и качественные свойства (толщина).</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Цвета:</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-<strong>светло-бежевый:</strong> благодаря своей прозрачности используется преимущественно при эндодонтическом&nbsp;лечении. Нежелательно использовать при работе с композитами (плохое изображение контуров)</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-<strong>коричневый или темно-серый:</strong> хороший цветовой контраст, исключение отражения света</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong>-зеленый</strong>: приятный, дружелюбный, успокаивающий цветной тон образует хороший цветовой контраст контуров, отсутствие эффекта диафрагмы под светом люминисцентной лампы (исключение/отсутствие отражения света),&nbsp;пахнет мятой, что делает его весьма приятным для пациентов</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt">Другие цвета</span></strong><span style="font-size: 10pt">: синий, светло-синий, розовый, сиреневый, как альтернатива для выше перечисленных светлых, темных и зеленых цветов</span></font><span style="font-size: 10pt"><font face="Times New Roman">Пять разновидностей коффердама по качеству (толщине)</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-тонкий (thin) 0,13-0,18 мм &ndash; тончайший коффердам, чем легче его апплицировать, тем быстрее его разорвать и плотность его прилегания не такая хорошая, как у более толстого </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-средний (medium) 0,18-0,23 мм &ndash;&nbsp;для использования он подходит более всего, так как особенно прост в обращении, также удобен при натягивании коффердама и, конечно, при консервативном лечении </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-толстый (heavy) 0,23-0,29 мм &ndash; благодаря его применению достигается хорошая ретракция десны. Кроме того, он практически не рвется </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-экстра толстый (xheavy) 0,29-0,34 мм&nbsp;- не рвется при экстремальных условиях и позволяет достичь максимальной ретракции десны, но в то же время его очень трудно адаптировать&nbsp; </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-толстый специальный (spheavy) 0,34-0,39 мм &ndash; этот коффердам накладывается только в тех случаях, когда непременно необходимо достичь особой защиты тканей. </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;Значения толщины коффердама пересекаются, указано наибольшее значение измерения по спецификации, которое одновременно является наименьшим значением для следующей, более высокой спецификации.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Пользователь коффердама обычно сам&nbsp;&laquo;чувствует&raquo; эти малые различия в измерении</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Резюме</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">При выполнении композитной реставрации под коффердамом необходимо провести определение цвета перед его наложением, так как поверхность изолированных зубов очень быстро и в значительной степени высыхает, что делает невозможным правильный выбор цвета. </font></span><span style="font-size: 10pt"><font face="Times New Roman">На этапе первых шагов работы с коффердамом можно вначале использовать тонкий коффердам с учетом свойств, приведенных в описании материала. С течением времени по мере приобретения более совершенных навыков рекомендуется переходить на работу с коффердамом большей толщины. В повседневной практике используются обычно две разновидности коффердама. Вначале следует переходить от тонкого к среднему и толстому, позднее &ndash; к экстра толстому.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важно</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Коффердам имеет гладкую и припудренную поверхность. Гладкая поверхность всегда прилежит к поверхности полости рта пациента, а припудренная таким образом обращена к врачу.&nbsp;Это правило необходимо соблюдать из двух соображений: </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-гладкая поверхность легче скользит по поверхности изолируемых зубов (преимущество для накладывающего коффердам) и</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-при соприкосновении коффердама с языком на последнем не остается рисовой или кукурузной муки (комфорт для пациента)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-шаблон для маркировки местоположения отверстий</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Он изготовлен из белого винила и делает возможной точную маркировку положения зуба на коффердаме, причем коффердам накладывается своей гладкой стороной на шаблон и на припудренной поверхности&nbsp;наложения отмечается с помощью карандаша (таким образом, чтобы маркировка не прошла на обратную сторону). Преимуществом использования шаблона является то, что отмечается только положение изолируемых зубов. Отсюда следует, то при наложении коффердама легче ориентироваться в полости рта, так как на его поверхности нет других отметок.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-штемпель</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">С его помощью на поверхность коффердама могут быть нанесены дополнительные дуги, на которые в случае необходимости легко нанести стандартные положения зубов.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы-перфоратор для коффердама</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Снабжены диском с 5 или 6 сквозными отверстиями разных размеров, что делает всегда возможным&nbsp;получение в коффердаме отверстий правильной формы.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Назначение отверстий в перфораторе ainsworth:</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 5 </span></strong><span style="font-size: 10pt">(largest-самое большое) &ndash; рекомендуется для кламмерных зубов ( в конце зубной дуги) </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 4 </span></strong><span style="font-size: 10pt">(large-большое) &ndash; универсальное для моляров </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 3 </span></strong><span style="font-size: 10pt">(medium-среднее) &ndash; для клыков и премоляров верхней и нижней челюсти </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 2 </span></strong><span style="font-size: 10pt">(small-маленькие) &ndash; для фронтальных зубов верхней челюсти </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 1 </span></strong><span style="font-size: 10pt">(smallest-самое маленькое) &ndash; для очень тонких нижних фронтальных зубов </span></font><span style="font-size: 10pt"><font face="Times New Roman">Варьирование по выше приведенной схеме размеров отверстий гарантирует абсолютно плотное прилегание коффердама, предотвращающее проникновение влаги к рабочей поверхности зуба.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы-перфоратор для фит</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">С помощью фит-перфоратора можно в любом случае получить ровное чистое отверстие в коффердаме. Подвижной щит-штамп всегда охватывает весь режущий край одновременно и образует таким образом отверстие без разрывов.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы получить ровное отверстие, пластину коффердама необходимо натянуть между большим и безымянным, а также указательным и средним пальцами&nbsp;левой руки (исключение складок и вследствие этого отсутствие нежелательной дополнительной перфорации). Лишь теперь пластину с отверстиями неповрежденных острых щипцов подвести под коффердам, щипцы закрываются и шип при этом вдавливается в выбранное отверстие в диске, так чтобы получить абсолютно круглое отверстие. Если при осмотре отверстия обнаруживаются надрывы, разрывы в форме&nbsp;зубцов, то это говорит о том, что при попытке натянуть коффердам на зубы в местах неполных отверстий он рвется. Если же перфорация абсолютно круглая, то при растяжении коффердама его&nbsp;можно наложить легко и без разрывов</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-кламмеры</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Принципиально различают две основные формы кламмеров. Они соответствуют различным методам наложения коффердама. Различают бескрылые кламмеры и кламмеры с крыльями.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Бескрылые кламмеры</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Их бока короткие и закругленные. При использовании этого вида кламмеров сначала на зуб помещается кламмер, потом накладывается коффердам, в заключение ставятся рамки. Литер&nbsp; W (wingless-бескрылый) перед номером означает кламмер без крыльев.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Кламмер с крыльями</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Их бока&nbsp;имеют выступающие вперед крылья. Крылья вводятся в отверстие в коффердаме и потом кламмер вместе с ним помещается на зуб.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">контактный пункт центральное </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;крыло </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">перфорация&nbsp;рука </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">боковина&nbsp;переднее&nbsp;кламмера </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">вырезка&nbsp;крыло </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;контактный пункт&nbsp; </font></span><span style="font-size: 10pt"><font face="Times New Roman">Из методических и практических соображений рассмотрим более подробно широко используемые&nbsp;отдельные кламмера.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 14А </span></strong><span style="font-size: 10pt">&ndash; особенно рекомендуется для неполностью прорезавшихся, недоразвитых или неполностью сформированнных моляров. Кламмер фиксируется на зубах благодаря контакту в 4-х пунктах, наклоненных вниз боковин. Уменьшенная дуга отличает этот кламмер.&nbsp;Этой форме соответствует&nbsp;№ 14, хотя используются и большие. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 7 </span></strong><span style="font-size: 10pt">&ndash; отличный кламмер для нижних моляров. Повреждения десны исключаются благодаря плоской форме боковин. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 2 </span></strong><span style="font-size: 10pt">&ndash; стандартный кламмер для больших премоляров преимущественно нижней челюсти. Его плоские боковины исключают повреждения десны. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 9 </span></strong><span style="font-size: 10pt">&ndash; универсальный кламмер с двойной дугой и крыльями&nbsp; для губных полостей во фронтальных зубах и премолярах (эндодонтическое лечение). </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 00 &ndash; </span></strong><span style="font-size: 10pt">для очень маленьких премоляров и резцов верхней и нижней челюсти. Отличаются благодаря очень высокой дуге и укороченным боковинам. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 5 &ndash; </span></strong><span style="font-size: 10pt">универсальный кламмер для больших моляров верхней челюсти, особенно для зубов округлой формы. Кламмер хорошо прилегает к десневому краю&nbsp;своими углубленными боковинами, что исключает ротацию. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 8А &ndash; </span></strong><span style="font-size: 10pt">маленькие моляры верхней и нижней челюсти, которые неполностью прорезались или недоформировались. Чтобы не повредить ткани под десну вводятся 4 шипа. Благодаря наклоненным вниз боковинам возможно наложение коффердама ниже десневого края. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 212 &ndash; </span></strong><span style="font-size: 10pt">цервикальный кламмер (=ретракция тканей) для пришеечных полостей (5 класс кариозных дефектов) во всех зубах. Для этого показания используется экстра-толстый коффердам, чтобы достичь&nbsp;возможно большей ретракции десны. Важно ч отверстие для реставрируемого зуба ввести более цервикально (около 2 мм) в противоположность соседним&nbsp;зубам. Рекомендуется также выполнить это отверстие на один номер больше, чем другие. Для стабилизации кламмера&nbsp;используется масса KERR или штамповочная масса. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 214 &ndash; </span></strong><span style="font-size: 10pt">цервикальный кламмер Hatch. Две большие подвижные дуги&nbsp;образуют маленькую боковину и накладываются вестибулярно или лабиально, так чтобы десна была отодвинута в желательном положении, винт затягивается&nbsp;и&nbsp;кламмер фиксируется. Большая боковина неподвижна и располагается палатинально или лингвально. </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Губные кламмеры &ndash; кламмеры с двойными дугами</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Для эндодонтии во всех случаях важно изолировать только зуб, подвергаемый лечению. Для однокорневых зубов предлагаются представленные здесь кламмеры с двойными дугами . </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 210 &ndash; </span></strong><span style="font-size: 10pt">предназначены для губных полостей во фронтальных зубах, также в премолярах и вторых молярах нижней челюсти. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 211</span></strong><span style="font-size: 10pt"> &ndash; исключительный кламмер для губных полостей во фронтальных зубах нижней челюсти. </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Быстрое ориентирование в кламмерах</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Кламмер&nbsp;Группа зубов</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 9, 214 (Hatch)&nbsp;Фронтальные зубы </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">(0, 00, 210, 211) </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 2, 1 (0, 00)&nbsp;Премоляры </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 7, 8, 8А, 14А&nbsp;Моляры </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 7 Универсальный для нижних моляров </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 8&nbsp;Универсальный для верхних моляров </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 8А&nbsp;Маленькие моляры, не полностью прорезавшиеся </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 14А&nbsp;Большие моляры, не полностью прорезавшиеся, глубоко пораженные или частично ретенированные </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы для коффердам-кламмеров</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Щипцы для коффердам-кламмеров захватывают каждую кламмерную дугу в правильном положении, без опрокидывания, благодаря ретенции. Они делают также возможной адаптацию кламмера на зубе. Щипцы служат, таким образом, для разведения и наложения кламмера, а также для его удаления.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Рамки для коффердама</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы сохранить натяжение коффердама вместо специальных гирь сейчас используются рамки, которые благодаря отдельно рационально расположенным, хорошо захватывающим шипам очень быстро и успешно обеспечивают фиксацию коффердама. Рамки для коффердама сегодня выпускаются из металла и пластмассы. На среднем рисунке представлены&nbsp;клапанные рамки из пластмассы, существенно облегчающие доступ к рабочему полю и поэтому особенно подходящие для эндодонтического лечения.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Рамки для Фит-коффердама по Young</font></span><span style="font-size: 10pt"><font face="Times New Roman">U-образные рамки для коффердама, нержавеющие и гибкие, с небольшими, рационально расположенными, хорошо захватывающими цилиндрическими шипами для фиксации резины.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Клапанные рамки для Фит по Saveur</font></span><span style="font-size: 10pt"><font face="Times New Roman">Клапанные рамки, предназначенные для эндодонтии, изготовлены из автоклавируемой пластмассы (пропускающей рентгеновские лучи) и снабжены срединным шарниром. Они используются как обычные рамки для коффердама. В то же время возможно закрыть половину так,&nbsp;чтобы достичь хорошего положения для контрольного рентгеновского исследования. Преимуществом рамки является хорошая ориентация, она всегда направлена к подбородку.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Короткий экскурс в историю</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Натяжение коффердама&nbsp;с помощью специальных гирь для коффердама требовало большого навыка, чтобы всегда быть успешным. Верхние прищепки&nbsp; натягивают коффердам благодаря резиновой тяге вокруг головы пациента, а на нижних прищепках закреплены гирьки</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важные принадлежности!</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Межзубные клинья</font></span><span style="font-size: 10pt"><font face="Times New Roman">Для фиксации матриц, а также для фиксации коффердама в полости рта пациента. Клинья изготавливают из клена (древесина) или нейлона (пластмасса). Отличная адаптация к зубу возможна благодаря анатомически идеальной форме клина. Чтобы ткани и коффердам отдавить в апикальном направлении, а также&nbsp;предупредить разрыв коффердама и, как следствие, обмотку его вокруг бора, особенно при распространяющихся по шейке зуба&nbsp;дефектах, апроксимально помещаются кленовые клинья.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Латексная нить (wedjets)</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Этот шнур для стабилизации коффердама представляет собой продукт одноразового использования из натуральной резины и выпускается двух размеров, длиной 2,14 м:</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;желтого цвета &ndash; тонкий </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;оранжевого цвета &ndash; толстый </font></span><span style="font-size: 10pt"><font face="Times New Roman">Различными производителями предлагаются базовые комплекты основных приспособлений. Однако, все отдельные части и специальные кламмера , а также принадлежности могут приобретаться отдельно.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Салфетки для коффердама</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Показаны для использования у пациентов с аллергией на латекс. (Это целесообразно для врача и очень комфортабельно для пациента, если салфетки для коффердама, прежде всего при длительном лечении, неподвижны. Коффердам затем одевается через отверстие в салфетке и натягивается на рамки.&nbsp;Она абсорбирует слюну, воду и пот.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Зубной шелк</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Шелк занимает первое место как испытанное средство для очистки межзубных пространств. Кроме того, это выдающееся вспомогательное средство, если коффердам накладывается на труднодоступные контактные поверхности. Лигатура из зубного шелка часто очень помогает закрепить коффердам на зубе (особенно на временных молярах и временных клыках). Лигатуры должны быть зафиксированы щечно при помощи хирургического узла.&nbsp;Желательно использовать длинную лигатуру, так как она облегчает манипуляции в глубине и снятие. Если&nbsp;возникает проблема, что кламмер плохо сидит, повреждает слизистую или наблюдается подтекание, то&nbsp; закрепляется&nbsp;одинарная или двойная лигатура из зубного шелка, или в большинстве случаев, петля из зубного шелка, которая проводится через&nbsp;контактный пункт и там остается. Слабое натяжение коффердама нивелируется введением в межзубной промежуток шелка, чем достигается отличная фиксация.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Шпатель Хайдеманна</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Незаменим для кратковременной сепарации контактных пунктов, а также для адаптирования коффердама вокруг шейки зуба (подворачивание). Благодаря дополнительному постоянному потоку воздуха в направлении десневого желобка подворачивание легко осуществляется вручную.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">&nbsp;Примеры использования коффердама при различных показаниях</span></strong><span style="font-size: 10pt"></span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изоляция от слюны в эндодонтии</span></strong><span style="font-size: 10pt"> = изоляция отдельного зуба с помощью коффердама и кламмера для коффердама, которые накладываются на изолируемый зуб одновременно, т.е. используется подходящий кламмер с крыльями, например, для&nbsp;эндодонтической изоляции верхних фронтальных зубов &ndash; кламмер № 210. В этом случае в перфорацию со стороны припудренной поверхности вводится одно крылышко. Перфорация немного расширяется, так чтобы было можно ввести второе крылышко и кламмер&nbsp;расположился на припудренной поверхности, а крылышки &ndash; на&nbsp;обратной гладкой поверхности. Перфорация в коффердаме раскрывается крылышками таким образом, чтобы можно было хорошо увидеть зуб, на который надо наложить коффердам. Кламмер в некоторой степени под контролем зрения накладывается.&nbsp; В практике это означает, что зафиксированный в коффердаме кламмер при этом поднимается щипцами для кламмеров.</span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Внимание ! Кламмерные щипцы действуют как телескопические щипцы.</span></strong></font></span><span style="font-size: 10pt"><font face="Times New Roman">Таким образом, бранши открываются при давлении, соответственно, закрываются при фиксации. При этом кламмер можно без проблем наложить на зуб и после лечения также снять. В случае эндодонтической изоляции во фронтальном отделе верхней челюсти&nbsp;кламмер рекомендуется накладывать вестибулярно под десневой край, а с небной поверхности использовать мощный ретенционный пункт зуба в виде бугорка. Кламмерные щипцы отвести в сторону, наложить коффердам и кламмер.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Кламмерные щипцы наложены и кламмер с коффердамом введены в полость рта в рабочем направлении. При этом соответствующий зуб виден между боковинами кламмера, кламмер раскрывается и потом накладывается на зуб.</font></span><span style="font-size: 10pt"><font face="Times New Roman">С помощью шпателя Хайдеманна можно очень легко расположить коффердам на краю дугообразной стороны, отодвинуть его в стороны от крылышек кламмера, затем коффердам скользит&nbsp;под боковины кламмера и ложится на зуб. </font></span><span style="font-size: 10pt"><font face="Times New Roman">Для натяжения коффердама он протягивается через отверстие&nbsp;клапанной рамки Фит и фиксируется на ней с помощью удобно расположенных удерживающих шипов. Если десневая жидкость выступает на поверхность коффердама, это свидетельствует о недостаточном его проскальзывании под боковины кламмера. Для устранения этого недостатка с палатинальной стороны за кламмером вводится провощенная нить из зубного шелка длиной около 30 см. Оба конца остаются под дугами кламмера и проскальзывают в соответствующие межзубные пространства.&nbsp;Теперь шелк выводится вестибулярно под соответствующую боковину кламмера , концы нити перекрещиваются и тщательно фиксируются. Коффердам лежит полностью на десневом крае, так что абсолютная изоляция от влаги достигнута. Концы нитей обрезаются или полностью выводятся. Можно начинать соответствующее эндодонтическое лечение после окончательного наложения коффердама, при этом при раскрытии канала под водяным охлаждением помощнику врача рекомендуется&nbsp; удалять образующийся спрэй-туман с помощью аспиратора, используя при этом широкий и интактный пелот. (Внимание! Образование острого края на пелоте может вести к разрыву коффердама.) Слюну пациент может почти нормально проглатывать. Лечение продолжается так долго, что можно проводить контрольное рентгенологическое исследование , это возможно благодаря клапанным рамкам Фит.</font></span><span style="font-size: 10pt"><font face="Times New Roman">В качестве вспомогательного средства предлагается держатель пленки emmenix или артериальный зажим (очень хорош также тонкий crown clipper П).</font></span><span style="font-size: 10pt"><font face="Times New Roman">Как правило, в случае эндодонтического лечения необходима полная изоляция зуба от влаги. Поэтому эндодонтические случаи особенно подходят для того, чтобы подружиться с коффердамом. В конце лечения посещения кламмер прежде всего снова зажимается в кламмерных щипцах. Наиболее быстро и просто это удается, если кламмерные щипцы&nbsp;с ретенционными цапфами вначале ввести в видимую перфорацию кламмера, щипцы немного раскрыть&nbsp;и при этом повернуть над зубом, чтобы можно было ввести вторую ретенционную цапфу во вторую перфорацию кламмера. Кламмерные щипцы сжимаются, благодаря чему кламмер раскрывается&nbsp;и без проблем удаляется с зуба. При изоляции одного зуба пациенту можно сказать, что коффердам и рамки удаляются при стягивании. Щадяще и без уколов с этим можно справиться, если правый большой большой палец поместить вестибулярно под коффердам и рамки, правый указательный палец под режущий край зуба, на коффердам наложить средний палец лежит на коффердаме, в это же время безымянный палец и мизинец согнуты под рамкой. Теперь рамка снимается перед лицом пациента, чтобы можно было без уколов снять коффердам с режущего края.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изоляция от влаги области фронтальных зубов верхней челюсти</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы не сужать видимое и рабочее поле, рекомендуется во время работы во фронтальном участке верхней челюсти накладывать коффердам таким образом, чтобы изолировать зубы 13-24. Кроме того, в этом случае помощник врача в свободное от приема пациентов время должен подготовить пластину коффердама (отметить положение зубов и выполнить перфорации) и поместить ее в холодильник. <strong><span style="color: black">Одномоментная техника </span></strong>при названном выше показании приводит пользователя к особо быстрому достижению желаемой цели &ndash; абсолютной изоляции&nbsp;от влаги, поэтому коффердам, кламмер для коффердама и рамки накладываются одновременно. Берут перфорированную от 13 до 24 пластину коффердама (припудренной стороной наверх) в левую руку, большую металлическую рамку для коффердама накладывают сверху, отступя на 1,5 см от левого края, при этом верхние концы рамки должны находиться на уровне верхнего края. Коффердам и рамка находятся таким образом в левой руке, затем правой рукой коффердам натягивается так, чтобы зафиксировать его на цилиндрических удерживающих шипах рамки. Правая рука теперь удерживает коффердам и рамку, в это время левой рукой коффердам надевается на левую сторону и также фиксируется на удерживающие щипы. Избытки коффердама слева, справа, и с нижнего края можно также&nbsp;сложить в виде маленького кармана. Он может быть полезен во время препарирования для сбора воды, а также для улавливания частей пломб. Зафиксированная пластина должна затем быть сложена с более длинной стороны, так чтобы эта сторона рамки была окутана коффердамом. Рука, в которой находится складываемая сторона, охватывает рамку у нижнего угла, так, чтобы складка не могла развернуться назад. Коффердам&nbsp;и рамка находятся только в этой руке. Свободной рукой захватывают одеваемый конец далее и натягивают его так высоко, чтобы зафиксировать эту сторону на верхнем краю рамки. После этого перечисленные шаги проводятся с противоположной стороны. Так как карман, получившийся в результате сильного натягивания, может ограничивать поле видимости, на середине его верхнего края захватывается кончик коффердама и фиксируется на цилиндрический удерживающий шип, расположенный на середине поперечного крепления. Теперь для зуба 24 берется подходящий кламмер с крыльями для премоляров (например №№ 2, 2А, 209 или 206), фиксируется в кламмерных щипцах и вводится своими медиальными крылышками в четвертое перфорационное отверстие таким образом, чтобы его дистальная дуга была обращена дистально (для первоначального облегчения ориентации можно также отмечать 25. Дуга располагается над этой вспомогательной линией, так что при внесении в полость рта пациента все в порядке). Кламмер накладывается с щечной стороны у десневого края. под легким давлением рабочей руки на щипцы кламмер легко открывается, надевается на окклюзионную поверхность и экватор зуба, после давление прекращается, щипцы фиксируются и кламмер осторожно накладывается также палатинально. Кламмерный зуб 24 располагается теперь уже снаружи коффердама, кламмерные щипцы &ndash; с обеих его сторон. Обе руки накладывающего коффердам натягивают последний так, чтобы можно было отвесно установить его в межзубное пространство (как разделительную пластинку). Теперь через перфорацию натянуть коффердам на угол&nbsp;и режущий край и ввести его следующий межзубной промежуток. Вновь латекс со следующим перфорационным отверстием насколько возможно&nbsp;установить&nbsp;отвесно в межзубном промежутке и надеть его через перфорацию на угол и режущий край. И так повторять до тех пор, пока все изолируемые зубы не будут находиться снаружи коффердама. В области 13 коффердам фиксируется с помощью зубного клина, гуттаперчевой нити, петли из зубного шелка, лигатуры или на 13 также накладывается кламмер. Если еще просачивается десневая жидкость и зубы поэтому увлажняются необходимо дополнительно на последнем этапе присоединить так называемую инверсию. Это означает, что края коффердама подворачиваются вокруг шейки зуба. Во-первых они могут так гарантировать абсолютную плотность против влаги. Врач инвертирует&nbsp;с помощью края изогнутой стороны шпателя Хайдеманна таким образом, что эта сторона инструмента подводится под перфорацию и осторожно накладывается на десну. В это же время помощник направляет равномерный поток воздуха в область десневого желобка. Если теперь врач указательным и средним пальцами левой руки легко прижмет коффердам к верхней губе/области десны, используя эффект надувания, и при этом шпатель снова извлечет,&nbsp;край коффердама легко загнется. Если врач предпочитает проводить инверсию с помощью зубного шелка, он протягивает провощенную нить зубного шелка около 30-40 см длиной с обеих сторон в межзубном пространстве, так чтобы она&nbsp;хорошо легла у десневого края с небной стороны. Оба конца нити теперь еще вестибулярно перекрещиваются и легко натягиваются. При этом коффердам подворачивается. Во время инвертирования припудренная сторона коффердама лежит на соответствующем зубе.Если&nbsp;теперь&nbsp;крылышки кламмера&nbsp;на 24 вывести на поверхность коффердама,&nbsp;абсолютная изоляция достигнута. Маленький головчатый штопфер или шпатель Хайдеманна своей, на этот раз поверхностью изогнутой стороны, помещается между латексом и кламмером.&nbsp;Инструмент легко поворачивается влево, затем вправо между пальцами, благодаря чему коффердам, как по мановению волшебной руки, находит свой путь под кламмер.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">1-наложение кламмера вместе с рамкой </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;2-коффердам одевается </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;3-кламмер выводится на поверхность коффердама </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;4-инвертирование (можно только с помощью нитей) </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Изоляция от влаги</span></strong></font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-зафиксированных мостовидных протезов</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-при запечатывании фиссур в постоянных молярах у детей</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-для удаления амальгамы</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black"><font face="Times New Roman">Для этих показаний хорошо использовать третью технику. Перед началом необходимо принять во внимание следующее: чем туже выбирается коффердам, тем лучше он прилежит. При наличии мостовидных протезов нет никаких шансов ввести коффердам в межзубные промежутки, в этих случаях применяется так называемое длинное отверстие. Также при запечатывании фиссур под коффердамом приемлемо использование длинного отверстия. Пластина коффердама накладывается своей гладкой стороной на шаблон, а на припудренной поверхности отмечается область, подлежащая изоляции. Затем в этой зоне с помощью отверстия № 2 щипцами-перфоратором создается длинное отверстие. У детей следует рекомендовать прежде всего следующий метод. Сначала пластина коффердама натягивается на изолируемые зубы. Затем дистально перед последним изолируемым зубом втягивается отрезок коффердама, дам зафиксирован на этой стороне. Затем он должен быть подвернут/закручен вниз через потягивание от 1-2 зубов, в то же время его надо подтянуть вверх. Помощник в это же время должен уже зафиксировать в кламмерных щипцах кламмер для моляра (например: № 7, 8, 200 или 18). С помощью этого метода от слюны изолируется не каждый отдельный зуб, а зафиксированный мостовидный протез или достигается изоляция от, например, 26, 27 для запечатывания фиссур, наиболее желательно накладывать коффердам через перфорацию в виде длинного отверстия дистально на 27 и тянуть медиально до 25, так чтобы в этом длинном отверстии на поверхности коффердама находились 27, 26, 25. Отрезок коффердама втягивается медиально перед 25 для фиксации его на этой стороне. Кламмер для моляров для окончательной фиксации накладывается на 27. В области моляров для лучшей видимости чаще всего желательно кламмер вначале накладывать палатинально у десневого края.&nbsp;Затем рабочей рукой производится давление на щипцы,&nbsp; чтобы раскрытый кламмер наложить через окклюзионную поверхность и экватор зуба до десневого края со щечной стороны. Коффердам зафиксирован и теперь свисающая перед полостью рта пластина должна&nbsp;быть натянута на рамку. Если не получается сложить коффердам в виде кармашка, врачу о', '', '', '2007-02-05 10:04:34', 1, 'russian');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_pages_categories`
-- 

CREATE TABLE `nuke_pages_categories` (
  `cid` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `nuke_pages_categories`
-- 

INSERT INTO `nuke_pages_categories` (`cid`, `title`, `description`) VALUES (1, 'Статьи по терапевтической стоматологии', ''),
(4, 'Общая информация', ''),
(3, 'Статьи по ортодонтии', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_poll_check`
-- 

CREATE TABLE `nuke_poll_check` (
  `ip` varchar(20) NOT NULL default '',
  `time` varchar(14) NOT NULL default '',
  `pollID` int(10) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_poll_check`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_poll_data`
-- 

CREATE TABLE `nuke_poll_data` (
  `pollID` int(11) NOT NULL default '0',
  `optionText` char(50) NOT NULL default '',
  `optionCount` int(11) NOT NULL default '0',
  `voteID` int(11) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_poll_data`
-- 

INSERT INTO `nuke_poll_data` (`pollID`, `optionText`, `optionCount`, `voteID`) VALUES (1, 'Очень плохо', 0, 1),
(1, 'Посредственно', 0, 2),
(1, 'Хорошо', 0, 3),
(1, 'Отлично!', 0, 4),
(1, 'А что это такое?', 0, 5),
(1, '', 0, 6),
(1, '', 0, 7),
(1, '', 0, 8),
(1, '', 0, 9),
(1, '', 0, 10),
(1, '', 0, 11),
(1, '', 0, 12);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_poll_desc`
-- 

CREATE TABLE `nuke_poll_desc` (
  `pollID` int(11) NOT NULL auto_increment,
  `pollTitle` varchar(100) NOT NULL default '',
  `timeStamp` int(11) NOT NULL default '0',
  `voters` mediumint(9) NOT NULL default '0',
  `planguage` varchar(30) NOT NULL default '',
  `artid` int(10) NOT NULL default '0',
  `comments` int(11) default '0',
  PRIMARY KEY  (`pollID`),
  KEY `pollID` (`pollID`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_poll_desc`
-- 

INSERT INTO `nuke_poll_desc` (`pollID`, `pollTitle`, `timeStamp`, `voters`, `planguage`, `artid`, `comments`) VALUES (1, 'Ваша оценка системы PHP-Nuke?', 961405160, 0, 'russian', 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_pollcomments`
-- 

CREATE TABLE `nuke_pollcomments` (
  `tid` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `pollID` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  `name` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `url` varchar(60) default NULL,
  `host_name` varchar(60) default NULL,
  `subject` varchar(60) NOT NULL default '',
  `comment` text NOT NULL,
  `score` tinyint(4) NOT NULL default '0',
  `reason` tinyint(4) NOT NULL default '0',
  `last_moderation_ip` varchar(15) default '0',
  PRIMARY KEY  (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `pollID` (`pollID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_pollcomments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_pollcomments_moderated`
-- 

CREATE TABLE `nuke_pollcomments_moderated` (
  `tid` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `pollID` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  `name` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `url` varchar(60) default NULL,
  `host_name` varchar(60) default NULL,
  `subject` varchar(60) NOT NULL default '',
  `comment` text NOT NULL,
  `score` tinyint(4) NOT NULL default '0',
  `reason` tinyint(4) NOT NULL default '0',
  `last_moderation_ip` varchar(15) default '0',
  PRIMARY KEY  (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `pollID` (`pollID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_pollcomments_moderated`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_public_messages`
-- 

CREATE TABLE `nuke_public_messages` (
  `mid` int(10) NOT NULL auto_increment,
  `content` varchar(255) NOT NULL default '',
  `date` varchar(14) default NULL,
  `who` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`mid`),
  KEY `mid` (`mid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_public_messages`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_queue`
-- 

CREATE TABLE `nuke_queue` (
  `qid` smallint(5) unsigned NOT NULL auto_increment,
  `uid` mediumint(9) NOT NULL default '0',
  `uname` varchar(40) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `story` text,
  `storyext` text NOT NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `topic` varchar(20) NOT NULL default '',
  `alanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`qid`),
  KEY `qid` (`qid`),
  KEY `uid` (`uid`),
  KEY `uname` (`uname`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_queue`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_referer`
-- 

CREATE TABLE `nuke_referer` (
  `rid` int(11) NOT NULL auto_increment,
  `url` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`rid`),
  KEY `rid` (`rid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_referer`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_related`
-- 

CREATE TABLE `nuke_related` (
  `rid` int(11) NOT NULL auto_increment,
  `tid` int(11) NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `url` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`rid`),
  KEY `rid` (`rid`),
  KEY `tid` (`tid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_related`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_reviews`
-- 

CREATE TABLE `nuke_reviews` (
  `id` int(10) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `title` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  `reviewer` varchar(20) default NULL,
  `email` varchar(60) default NULL,
  `score` int(10) NOT NULL default '0',
  `cover` varchar(100) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `url_title` varchar(50) NOT NULL default '',
  `hits` int(10) NOT NULL default '0',
  `rlanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_reviews`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_reviews_add`
-- 

CREATE TABLE `nuke_reviews_add` (
  `id` int(10) NOT NULL auto_increment,
  `date` date default NULL,
  `title` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  `reviewer` varchar(20) NOT NULL default '',
  `email` varchar(60) default NULL,
  `score` int(10) NOT NULL default '0',
  `url` varchar(100) NOT NULL default '',
  `url_title` varchar(50) NOT NULL default '',
  `rlanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_reviews_add`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_reviews_comments`
-- 

CREATE TABLE `nuke_reviews_comments` (
  `cid` int(10) NOT NULL auto_increment,
  `rid` int(10) NOT NULL default '0',
  `userid` varchar(25) NOT NULL default '',
  `date` datetime default NULL,
  `comments` text,
  `score` int(10) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_reviews_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_reviews_comments_moderated`
-- 

CREATE TABLE `nuke_reviews_comments_moderated` (
  `cid` int(10) NOT NULL auto_increment,
  `rid` int(10) NOT NULL default '0',
  `userid` varchar(25) NOT NULL default '',
  `date` datetime default NULL,
  `comments` text,
  `score` int(10) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_reviews_comments_moderated`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_reviews_main`
-- 

CREATE TABLE `nuke_reviews_main` (
  `title` varchar(100) default NULL,
  `description` text
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_reviews_main`
-- 

INSERT INTO `nuke_reviews_main` (`title`, `description`) VALUES ('Reviews Section Title', 'Reviews Section Long Description');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_session`
-- 

CREATE TABLE `nuke_session` (
  `uname` varchar(25) NOT NULL default '',
  `time` varchar(14) NOT NULL default '',
  `host_addr` varchar(48) NOT NULL default '',
  `guest` int(1) NOT NULL default '0',
  KEY `time` (`time`),
  KEY `guest` (`guest`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_session`
-- 

INSERT INTO `nuke_session` (`uname`, `time`, `host_addr`, `guest`) VALUES ('kivdent', '1170645395', '192.168.0.1', 0),
('192.168.0.4', '1170643484', '192.168.0.4', 1),
('192.168.0.3', '1170644881', '192.168.0.3', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stats_date`
-- 

CREATE TABLE `nuke_stats_date` (
  `year` smallint(6) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `date` tinyint(4) NOT NULL default '0',
  `hits` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_stats_date`
-- 

INSERT INTO `nuke_stats_date` (`year`, `month`, `date`, `hits`) VALUES (2007, 1, 1, 0),
(2007, 1, 2, 0),
(2007, 1, 3, 0),
(2007, 1, 4, 0),
(2007, 1, 5, 0),
(2007, 1, 6, 0),
(2007, 1, 7, 0),
(2007, 1, 8, 0),
(2007, 1, 9, 0),
(2007, 1, 10, 0),
(2007, 1, 11, 0),
(2007, 1, 12, 0),
(2007, 1, 13, 0),
(2007, 1, 14, 0),
(2007, 1, 15, 0),
(2007, 1, 16, 0),
(2007, 1, 17, 0),
(2007, 1, 18, 0),
(2007, 1, 19, 0),
(2007, 1, 20, 0),
(2007, 1, 21, 0),
(2007, 1, 22, 0),
(2007, 1, 23, 0),
(2007, 1, 24, 0),
(2007, 1, 25, 0),
(2007, 1, 26, 0),
(2007, 1, 27, 0),
(2007, 1, 28, 0),
(2007, 1, 29, 0),
(2007, 1, 30, 0),
(2007, 1, 31, 1),
(2007, 2, 1, 0),
(2007, 2, 2, 0),
(2007, 2, 3, 0),
(2007, 2, 4, 0),
(2007, 2, 5, 0),
(2007, 2, 6, 0),
(2007, 2, 7, 0),
(2007, 2, 8, 0),
(2007, 2, 9, 0),
(2007, 2, 10, 0),
(2007, 2, 11, 0),
(2007, 2, 12, 0),
(2007, 2, 13, 0),
(2007, 2, 14, 0),
(2007, 2, 15, 0),
(2007, 2, 16, 0),
(2007, 2, 17, 0),
(2007, 2, 18, 0),
(2007, 2, 19, 0),
(2007, 2, 20, 0),
(2007, 2, 21, 0),
(2007, 2, 22, 0),
(2007, 2, 23, 0),
(2007, 2, 24, 0),
(2007, 2, 25, 0),
(2007, 2, 26, 0),
(2007, 2, 27, 0),
(2007, 2, 28, 0),
(2007, 3, 1, 0),
(2007, 3, 2, 0),
(2007, 3, 3, 0),
(2007, 3, 4, 0),
(2007, 3, 5, 0),
(2007, 3, 6, 0),
(2007, 3, 7, 0),
(2007, 3, 8, 0),
(2007, 3, 9, 0),
(2007, 3, 10, 0),
(2007, 3, 11, 0),
(2007, 3, 12, 0),
(2007, 3, 13, 0),
(2007, 3, 14, 0),
(2007, 3, 15, 0),
(2007, 3, 16, 0),
(2007, 3, 17, 0),
(2007, 3, 18, 0),
(2007, 3, 19, 0),
(2007, 3, 20, 0),
(2007, 3, 21, 0),
(2007, 3, 22, 0),
(2007, 3, 23, 0),
(2007, 3, 24, 0),
(2007, 3, 25, 0),
(2007, 3, 26, 0),
(2007, 3, 27, 0),
(2007, 3, 28, 0),
(2007, 3, 29, 0),
(2007, 3, 30, 0),
(2007, 3, 31, 0),
(2007, 4, 1, 0),
(2007, 4, 2, 0),
(2007, 4, 3, 0),
(2007, 4, 4, 0),
(2007, 4, 5, 0),
(2007, 4, 6, 0),
(2007, 4, 7, 0),
(2007, 4, 8, 0),
(2007, 4, 9, 0),
(2007, 4, 10, 0),
(2007, 4, 11, 0),
(2007, 4, 12, 0),
(2007, 4, 13, 0),
(2007, 4, 14, 0),
(2007, 4, 15, 0),
(2007, 4, 16, 0),
(2007, 4, 17, 0),
(2007, 4, 18, 0),
(2007, 4, 19, 0),
(2007, 4, 20, 0),
(2007, 4, 21, 0),
(2007, 4, 22, 0),
(2007, 4, 23, 0),
(2007, 4, 24, 0),
(2007, 4, 25, 0),
(2007, 4, 26, 0),
(2007, 4, 27, 0),
(2007, 4, 28, 0),
(2007, 4, 29, 0),
(2007, 4, 30, 0),
(2007, 5, 1, 0),
(2007, 5, 2, 0),
(2007, 5, 3, 0),
(2007, 5, 4, 0),
(2007, 5, 5, 0),
(2007, 5, 6, 0),
(2007, 5, 7, 0),
(2007, 5, 8, 0),
(2007, 5, 9, 0),
(2007, 5, 10, 0),
(2007, 5, 11, 0),
(2007, 5, 12, 0),
(2007, 5, 13, 0),
(2007, 5, 14, 0),
(2007, 5, 15, 0),
(2007, 5, 16, 0),
(2007, 5, 17, 0),
(2007, 5, 18, 0),
(2007, 5, 19, 0),
(2007, 5, 20, 0),
(2007, 5, 21, 0),
(2007, 5, 22, 0),
(2007, 5, 23, 0),
(2007, 5, 24, 0),
(2007, 5, 25, 0),
(2007, 5, 26, 0),
(2007, 5, 27, 0),
(2007, 5, 28, 0),
(2007, 5, 29, 0),
(2007, 5, 30, 0),
(2007, 5, 31, 0),
(2007, 6, 1, 0),
(2007, 6, 2, 0),
(2007, 6, 3, 0),
(2007, 6, 4, 0),
(2007, 6, 5, 0),
(2007, 6, 6, 0),
(2007, 6, 7, 0),
(2007, 6, 8, 0),
(2007, 6, 9, 0),
(2007, 6, 10, 0),
(2007, 6, 11, 0),
(2007, 6, 12, 0),
(2007, 6, 13, 0),
(2007, 6, 14, 0),
(2007, 6, 15, 0),
(2007, 6, 16, 0),
(2007, 6, 17, 0),
(2007, 6, 18, 0),
(2007, 6, 19, 0),
(2007, 6, 20, 0),
(2007, 6, 21, 0),
(2007, 6, 22, 0),
(2007, 6, 23, 0),
(2007, 6, 24, 0),
(2007, 6, 25, 0),
(2007, 6, 26, 0),
(2007, 6, 27, 0),
(2007, 6, 28, 0),
(2007, 6, 29, 0),
(2007, 6, 30, 0),
(2007, 7, 1, 0),
(2007, 7, 2, 0),
(2007, 7, 3, 0),
(2007, 7, 4, 0),
(2007, 7, 5, 0),
(2007, 7, 6, 0),
(2007, 7, 7, 0),
(2007, 7, 8, 0),
(2007, 7, 9, 0),
(2007, 7, 10, 0),
(2007, 7, 11, 0),
(2007, 7, 12, 0),
(2007, 7, 13, 0),
(2007, 7, 14, 0),
(2007, 7, 15, 0),
(2007, 7, 16, 0),
(2007, 7, 17, 0),
(2007, 7, 18, 0),
(2007, 7, 19, 0),
(2007, 7, 20, 0),
(2007, 7, 21, 0),
(2007, 7, 22, 0),
(2007, 7, 23, 0),
(2007, 7, 24, 0),
(2007, 7, 25, 0),
(2007, 7, 26, 0),
(2007, 7, 27, 0),
(2007, 7, 28, 0),
(2007, 7, 29, 0),
(2007, 7, 30, 0),
(2007, 7, 31, 0),
(2007, 8, 1, 0),
(2007, 8, 2, 0),
(2007, 8, 3, 0),
(2007, 8, 4, 0),
(2007, 8, 5, 0),
(2007, 8, 6, 0),
(2007, 8, 7, 0),
(2007, 8, 8, 0),
(2007, 8, 9, 0),
(2007, 8, 10, 0),
(2007, 8, 11, 0),
(2007, 8, 12, 0),
(2007, 8, 13, 0),
(2007, 8, 14, 0),
(2007, 8, 15, 0),
(2007, 8, 16, 0),
(2007, 8, 17, 0),
(2007, 8, 18, 0),
(2007, 8, 19, 0),
(2007, 8, 20, 0),
(2007, 8, 21, 0),
(2007, 8, 22, 0),
(2007, 8, 23, 0),
(2007, 8, 24, 0),
(2007, 8, 25, 0),
(2007, 8, 26, 0),
(2007, 8, 27, 0),
(2007, 8, 28, 0),
(2007, 8, 29, 0),
(2007, 8, 30, 0),
(2007, 8, 31, 0),
(2007, 9, 1, 0),
(2007, 9, 2, 0),
(2007, 9, 3, 0),
(2007, 9, 4, 0),
(2007, 9, 5, 0),
(2007, 9, 6, 0),
(2007, 9, 7, 0),
(2007, 9, 8, 0),
(2007, 9, 9, 0),
(2007, 9, 10, 0),
(2007, 9, 11, 0),
(2007, 9, 12, 0),
(2007, 9, 13, 0),
(2007, 9, 14, 0),
(2007, 9, 15, 0),
(2007, 9, 16, 0),
(2007, 9, 17, 0),
(2007, 9, 18, 0),
(2007, 9, 19, 0),
(2007, 9, 20, 0),
(2007, 9, 21, 0),
(2007, 9, 22, 0),
(2007, 9, 23, 0),
(2007, 9, 24, 0),
(2007, 9, 25, 0),
(2007, 9, 26, 0),
(2007, 9, 27, 0),
(2007, 9, 28, 0),
(2007, 9, 29, 0),
(2007, 9, 30, 0),
(2007, 10, 1, 0),
(2007, 10, 2, 0),
(2007, 10, 3, 0),
(2007, 10, 4, 0),
(2007, 10, 5, 0),
(2007, 10, 6, 0),
(2007, 10, 7, 0),
(2007, 10, 8, 0),
(2007, 10, 9, 0),
(2007, 10, 10, 0),
(2007, 10, 11, 0),
(2007, 10, 12, 0),
(2007, 10, 13, 0),
(2007, 10, 14, 0),
(2007, 10, 15, 0),
(2007, 10, 16, 0),
(2007, 10, 17, 0),
(2007, 10, 18, 0),
(2007, 10, 19, 0),
(2007, 10, 20, 0),
(2007, 10, 21, 0),
(2007, 10, 22, 0),
(2007, 10, 23, 0),
(2007, 10, 24, 0),
(2007, 10, 25, 0),
(2007, 10, 26, 0),
(2007, 10, 27, 0),
(2007, 10, 28, 0),
(2007, 10, 29, 0),
(2007, 10, 30, 0),
(2007, 10, 31, 0),
(2007, 11, 1, 0),
(2007, 11, 2, 0),
(2007, 11, 3, 0),
(2007, 11, 4, 0),
(2007, 11, 5, 0),
(2007, 11, 6, 0),
(2007, 11, 7, 0),
(2007, 11, 8, 0),
(2007, 11, 9, 0),
(2007, 11, 10, 0),
(2007, 11, 11, 0),
(2007, 11, 12, 0),
(2007, 11, 13, 0),
(2007, 11, 14, 0),
(2007, 11, 15, 0),
(2007, 11, 16, 0),
(2007, 11, 17, 0),
(2007, 11, 18, 0),
(2007, 11, 19, 0),
(2007, 11, 20, 0),
(2007, 11, 21, 0),
(2007, 11, 22, 0),
(2007, 11, 23, 0),
(2007, 11, 24, 0),
(2007, 11, 25, 0),
(2007, 11, 26, 0),
(2007, 11, 27, 0),
(2007, 11, 28, 0),
(2007, 11, 29, 0),
(2007, 11, 30, 0),
(2007, 12, 1, 0),
(2007, 12, 2, 0),
(2007, 12, 3, 0),
(2007, 12, 4, 0),
(2007, 12, 5, 0),
(2007, 12, 6, 0),
(2007, 12, 7, 0),
(2007, 12, 8, 0),
(2007, 12, 9, 0),
(2007, 12, 10, 0),
(2007, 12, 11, 0),
(2007, 12, 12, 0),
(2007, 12, 13, 0),
(2007, 12, 14, 0),
(2007, 12, 15, 0),
(2007, 12, 16, 0),
(2007, 12, 17, 0),
(2007, 12, 18, 0),
(2007, 12, 19, 0),
(2007, 12, 20, 0),
(2007, 12, 21, 0),
(2007, 12, 22, 0),
(2007, 12, 23, 0),
(2007, 12, 24, 0),
(2007, 12, 25, 0),
(2007, 12, 26, 0),
(2007, 12, 27, 0),
(2007, 12, 28, 0),
(2007, 12, 29, 0),
(2007, 12, 30, 0),
(2007, 12, 31, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stats_hour`
-- 

CREATE TABLE `nuke_stats_hour` (
  `year` smallint(6) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `date` tinyint(4) NOT NULL default '0',
  `hour` tinyint(4) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_stats_hour`
-- 

INSERT INTO `nuke_stats_hour` (`year`, `month`, `date`, `hour`, `hits`) VALUES (2007, 1, 31, 0, 0),
(2007, 1, 31, 1, 0),
(2007, 1, 31, 2, 0),
(2007, 1, 31, 3, 0),
(2007, 1, 31, 4, 0),
(2007, 1, 31, 5, 0),
(2007, 1, 31, 6, 0),
(2007, 1, 31, 7, 0),
(2007, 1, 31, 8, 0),
(2007, 1, 31, 9, 0),
(2007, 1, 31, 10, 0),
(2007, 1, 31, 11, 0),
(2007, 1, 31, 12, 0),
(2007, 1, 31, 13, 0),
(2007, 1, 31, 14, 0),
(2007, 1, 31, 15, 1),
(2007, 1, 31, 16, 0),
(2007, 1, 31, 17, 0),
(2007, 1, 31, 18, 0),
(2007, 1, 31, 19, 0),
(2007, 1, 31, 20, 0),
(2007, 1, 31, 21, 0),
(2007, 1, 31, 22, 0),
(2007, 1, 31, 23, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stats_month`
-- 

CREATE TABLE `nuke_stats_month` (
  `year` smallint(6) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `hits` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_stats_month`
-- 

INSERT INTO `nuke_stats_month` (`year`, `month`, `hits`) VALUES (2007, 1, 1),
(2007, 2, 0),
(2007, 3, 0),
(2007, 4, 0),
(2007, 5, 0),
(2007, 6, 0),
(2007, 7, 0),
(2007, 8, 0),
(2007, 9, 0),
(2007, 10, 0),
(2007, 11, 0),
(2007, 12, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stats_year`
-- 

CREATE TABLE `nuke_stats_year` (
  `year` smallint(6) NOT NULL default '0',
  `hits` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `nuke_stats_year`
-- 

INSERT INTO `nuke_stats_year` (`year`, `hits`) VALUES (2007, 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stories`
-- 

CREATE TABLE `nuke_stories` (
  `sid` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `aid` varchar(30) NOT NULL default '',
  `title` varchar(80) default NULL,
  `time` datetime default NULL,
  `hometext` text,
  `bodytext` text NOT NULL,
  `comments` int(11) default '0',
  `counter` mediumint(8) unsigned default NULL,
  `topic` int(3) NOT NULL default '1',
  `informant` varchar(20) NOT NULL default '',
  `notes` text NOT NULL,
  `ihome` int(1) NOT NULL default '0',
  `alanguage` varchar(30) NOT NULL default '',
  `acomm` int(1) NOT NULL default '0',
  `haspoll` int(1) NOT NULL default '0',
  `pollID` int(10) NOT NULL default '0',
  `score` int(10) NOT NULL default '0',
  `ratings` int(10) NOT NULL default '0',
  `rating_ip` varchar(15) default '0',
  `associated` text NOT NULL,
  PRIMARY KEY  (`sid`),
  KEY `sid` (`sid`),
  KEY `catid` (`catid`),
  KEY `counter` (`counter`),
  KEY `topic` (`topic`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `nuke_stories`
-- 

INSERT INTO `nuke_stories` (`sid`, `catid`, `aid`, `title`, `time`, `hometext`, `bodytext`, `comments`, `counter`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `haspoll`, `pollID`, `score`, `ratings`, `rating_ip`, `associated`) VALUES (2, 0, 'kivdent', 'Депофорез', '2007-02-02 19:37:42', 'НUМANCНEМIE ИНСТРУКЦИЯ по эксплуатации прибора ДЛЯ депофореза "ОРИГИНАЛ 11" \r\nУважаемые коллеги, \r\n\r\nмы поздравляем Вас с покупкой нового при бора для депофореза "ОРИГИНАЛ 11". Вы приняли решение в пользу высококачественного продукта, в основе которого лежит испытанная, «Know-how" и современная техника. \r\n', 'НUМANCНEМIE ИНСТРУКЦИЯ по эксплуатации прибора ДЛЯ депофореза "ОРИГИНАЛ 11" \r\nУважаемые коллеги, \r\n\r\nмы поздравляем Вас с покупкой нового при бора для депофореза "ОРИГИНАЛ 11". Вы приняли решение в пользу высококачественного продукта, в основе которого лежит испытанная, «Know-how" и современная техника. \r\n\r\n"ОРИГИНАЛ 11" существенно облегчает работу зубного врача. Оригинальное числовое устройство, регистрирующее количество миллиампер Х минут, оказывает помощь при определении необходимой пациенту длительности лечебной процедуры, обусловленной потребностью снятия с прибора количества электр~чества минимум 5 мА Х мин. \r\n\r\nПри этом сила тока во время сеанса может любым образом изменяться, не приводя к неправильному результату. \r\n\r\n"ОРИГИНАЛ Н" питается энергией от 4 штук 9 - вольтовых блочных батареек, которые вставляются с обратной стороны корпуса. Три батарейки служат для снабжения током лечебного процесса и датчика, показывающего мА Х мин (1­ая, 2-ая и 3-я батарейки, считая от места подключения наконечника). 4-ая батарейка питает указатель мА. \r\n\r\nМы желаем Вам успешных результатов лечения и удовольствия от работы с прибором "ОРИГИНАЛ 11". Мы просим Вас перед тем, как впервый раз приступить к лечению пациента, внимательно ознакомится с этой инструкцией. \r\n\r\nПрибор для депофореза нельзя открывать ни до, ни после окончания срока гарантии. \r\n\r\nПодготовка к сеансу лечения: \r\n\r\nПодключение электродов: \r\nХинч-штекер кабеля вставить в гнездо "Выход" на передней панели прибора. Голубой штекер кабеля вставить в гнездо на конце наконечника. \r\n\r\nПри оттягивании пружины, находящейся на переднем конце наконечника, появляется кулачок. В него вставляют иголочный электрод. \r\n\r\nНаконечник с кабелем к передней панели, в перерывах между работой можно поместить на держатели на боковой стороне прибора. \r\n\r\nКрасный штекер кабеля вставляют в отверстие на конце зажимного электрода напротив контактной поверхности. Электрод по желанию может  устанавливаться с обеих сторон. Маленькие штекеры целесообразно слегка покрыть жиром. \r\n\r\nЛечение должно проводиться только в соответствии с инструкцией "Методика эндодонтического лечения депофорезом гидроокиси меди­кальция (новое название «f''упрал®"). \r\n\r\nПеред размещением электродов в ротовой полости пациента следует убедиться в том, что прибор для депофореза полностью выключен! \r\n\r\nПрибор для депофореза и соединительный кабель обычным щадящим образом дезинфицируют. \r\n\r\nЭлектроды и наконечник стерилизуют в автоклавах при температvре максимум 134 СО. \r\n\r\nНаконечник нельзя погружать в жидкость! \r\n\r\nОбычно появляющееся анодное окисление на контактной поверхности зажимного электрода может быть удалено с помощью резинового полирователя. Осторожно на границе изоляции! \r\n\r\nПримечание: \r\n\r\nИголочный электрод имеет небольшой запас провода. При поломке кончика электрода провод ·может быть плоскогубцами вытащен из стержня до необходимой длины. Если после поломки отсутствует возможность взять провод плоскогубцами, то его можно продвинуть с обратной стороны подходящим для этого приспособлением. \r\n\r\nВместо зажимного электрода можно использовать входящий в комплект крюкообразный электрод (решение принимается исключительно исходя из удобства для врача и пациента). Для этого следует вставить маленький красный штекер кабеля в отверстие на прямом конце крюкообразного электрода. \r\n\r\nПри этом должно быть учтено следующее: \r\n\r\nКрюкообразный электрод укладывают пациенту глубоко за щеку таким образом, чтобы загнутый конец электрода находился в слюне. \r\n\r\nЧтобы не допустить перегрева тканей, особенно в области слизистой оболочки губы, а также прямого контакта крюкообразного электрода с металлическими коронками или металлическими пломбами живых зубов, электрод следует обернуть влажной марлей или чем-либо аналогичным (в этом случае в виде исключения для увлажнения можно использовать проточную воду). \r\n\r\n Работа прибора: \r\n1. Вращающаяся кнопка: \r\n\r\nПри помощи этой ручки включают прибор поворотом вправо и регулируют лечебный ток путем постепенного очень медленного плавного вращения.· После выключения прибора указатель мА х мин возвращается на 0,0. \r\n\r\nВо время сеанса необходимо избегать резких вращательных движений ручкой! \r\n\r\n2. Зеленый световой диод \r\n\r\nЗеленый световой диод сигнализирует, что прибор вкпючен. Он светится независимо от того, проводится ли в данный момент лечебная процедура или нет. \r\n\r\nЗ. Показание mA: \r\n\r\nИмеющийся в данный момент лечебный ток регистрируется в миллиамперах с двумя десятичными знаками после запятой. \r\n\r\nМаксимальная величина тока ограничена 10,00 тА \r\n\r\n4. Показатель мА Х мин: \r\n\r\nУказатель МА Х мин показывает степень выполнения процедуры, которая соответствует формуле "Сила тока х время" и выражается в миллиамперах Х минут с 1 десятичным знаком после запятой. \r\n\r\nДепофорез необходимо проводить пока не пройдет количество электричества 5 мА х мин при проведении депофореза в 3 сеанса или 7,5 мА х мин - при проведении депофореза в 2 сеанса (см. «Методику эндодонтического лечения депофорезом ... » ). \r\n\r\nПосле достижения в процессе сеанса величины количества электричества в 7,5 мА Х мин (это происходит при проведении метода Депофорез в два сеанса) автоматически прекращается подача тока и прибор для Депофореза IIОригинал­11" выкпючается. Дополнительно раздаётся длительный звуковой сигнал. Несмотря на то, что ток при этом на выходе при бора отсутствует, прибор во избежание быстрого израсходования батарей следует отключить до следующего сеанса путём вращения поворотной ручки. \r\n\r\nПри отсутствии контакта (прерывание тока во время лечения) указатель мА Х мин остается на достигнутом значении. При восстановлении контакта и тока счетчик продолжает отсчет "МД Х мин". \r\n\r\nЧтобы компенсировать небольшие ошибки в дозировке, возникающие, например при появлении поперчных токов, показатель мА х мин содержит 15% добавку на надежность. \r\n\r\nПроверка батареек \r\nДля питания Вашего прибора для депофореза Вы должны использовать искпючительно щелочные батареи. Емкость обычной щелочной батарейки /400 mAh/ достаточна для проведения около 1.500 процедур депофореза /при около 5 мА Х мин на одну процедуру/. \r\n\r\nПри использовании щелочно-марганцевых батареек с 600 mAh емкость увеличивается на 30%. \r\n\r\nПрименение батареек 9 Volt - Nickel - Metallhybrid - Akkus хотя и возможно, но не рекомендуется поскольку заряда этой батарейки достаточно на очень небольшое число процедур. \r\n\r\nСмена батареек производится, если: \r\n\r\n1. указатель "мА" теряет яркость (4-ая батарейка, считая от места подкпючения наконечника) \r\n\r\n2. указатель "мА Х мин" теряет яркость или в состоянии короткого замыкания (например, если соединить электроды или маленькие штекеры кабеля) не дает возможности получить электрический ток 10,00 мА. \r\n\r\nЕсли при включенном приборе возникает продолжительный звуковой сигнал, причиной таюке является разрядка батареек, или минимум 1 батарейка неправильно или не полностью вставлена в прибор. \r\n\r\nУказание: \r\n\r\nДля экономного расходования батареек прибор для депофореза необходимо выключать после каждой процедуры, поскольку он потребляет ток и в состоянии готовности к работе /включен, но без прохождения электрического тока. \r\n\r\n Обслуживание, ремонт и гарантия \r\nНа прибор для депофореза "ОРИГИНАЛ 11" и наконечник дается гарантия 2 года от даты, указанной в счете на оплату прибора. Однако гарантия не распространяется на батарейки, электроды и кабель. Гарантия действует только при правильном применении прибора. Удовлетворение других требований возмещения убытков исключается. Гарантийным талоном является счет на оплату прибора. \r\n\r\nГарантия не предоставляется в случаях, если прибор был открыт или удалено гарантийное опечатывание. \r\n\r\nПрибор для депофореза не нуждается в обслуживании, за исключением смены батареек. Необходимый ремонт производится нашей фирмой. Для этого следует прислать прибор, тщательно и надежно его упаковав. \r\n\r\nТехнические данные \r\n\r\nРазмеры: Высота х Ширина х Глубина мм \r\n\r\n            250 х 90 х 210           /ширина, включая держатели для \r\n\r\nнаконечника) \r\n\r\nВес: \r\n\r\n0,5 кг \r\n\r\nвключая батарейки/ \r\n\r\nНапряжение батареек: 4 х 9 вольт /вход \r\n\r\nВыходное напряжение: 24 вольт \r\n\r\nСила тока при проведении лечения: - около 1 О мА при плавной ре гул ировке. \r\n\r\n\r\n\r\nHUМANCHEMIE \r\n\r\nМетодика эндодонтического лечения депофорезом гидроокиси меди-кальция (новое название "купрал®") \r\n• Перманентная стерильность всей канальной системы \r\n\r\n• Стимулирование костной обтурации отверстий \r\n\r\n• Физиологичное излечение остающегося в челюсти стерильного корня \r\n\r\n1. Обоснование метода \r\nДепофорез с гидроокисью меди-кальция (в дальнейшем называемой купрал) основан на совершенно ином принципе, чем традиционное лечение корня, а именно: создании перманентно стерильной канальной системы, включая корневой дентин, и стимуляции костной обтурации многочисленных отверстий. Благодаря этому в челюсти сохраняется физиологически излеченный корень, не ослабленный никакой механической «подготовкой», не содержащий бактерий и продуктов их жизнедеятельности. \r\n\r\nУказанный принцип реализуется благодаря уникальным бактерицидным и физико­химическим свойствам купрала, и в связи с этим многие требования традиционной \r\n\r\nэндодонтии теряют свою значимость, а иногда даже отрицательно сказываются на ходе и результатах лечения. На это обстоятельство врачи должны обратить серьезное внимание! \r\n\r\nПринцип купрал депофореза, т. е. создание закрытой перманентно стерильной канальной  \r\n\r\nсистемы, строго доказан научно и подтвержден многолетней клинической практикой. Метод депофореза позволяет добиться гораздо большей эффективности лечения, чем это возможно при использовании традиционных подходов. Купрал-депофорез - это единственный метод, для которого представлены результаты бактериологических исследований, свидетельствующие о достижении перманентной стерильности канальной системы. \r\n\r\n2. Показания к применению \r\nДевитализированные зубы с любыми типами корней, в том числе с обширными апикальными процессами, с облитерированными каналами, покрытые коронками, а также ранее подвергавшиеся эндодонтическому лечению. \r\n\r\nВнимание: \r\n\r\nА) зубы имеющие остатки витальной пульпы, например после витальной экстирпации, сначала должны быть девитализированы (см. П. 4 .Особые случаи и п. 5. Проблемы при проведении депофореза) \r\n\r\nБ) Лечение фронтальных зубов см. п. 4. Особые случаи. \r\n\r\n3. Практическое осуществление метода 3. 1 Подготовка корневого канала \r\nПри каждо''мсеансе лечения депофорезом обработке подвергаются все каналы зуба непосредственно один за другим. \r\n\r\nКорневой канал несколько расширяют (около 150 30) максимум на протяжении 2/3 длины (но ни в коем случае не ближе, чем 3 мм до отверстия). Результаты терапии нисколько не ухудшатся, если канал пройден менее, чем на 2/3, так как под действием электрического поля купрал проникает и в механически недостижимые части канала. Коронарная часть может быть расширена несколько больше, чем 180 30, для создания депо купрала, а таюке для обнаружения дополнительных параллельных каналов. \r\n\r\nПромывание канала следует проводить дистиллированной водой или 5-10% взвесью «гидроокиси кальция высокодисперсной» (фирмы «Humanchemie") в дистиллированной воде. \r\n\r\n3.2 Заполнение канала купралом \r\nДля предотвращения поперечных токов, коронка зуба, который подвергают лечению, должна быть сухой (см. п. 3.3). С помощью каналонаполнителя лентуло или минипипеткой в верхнюю треть канала вносят купрал, имеющий консистенцию жидкой сметаны. \r\n\r\nПоскольку при прохождении тока температура в канале несколько повышается, может произойти высыхание купрала. Его следует прямо в канале разбавить дистиллированной водой. \r\n\r\nНи в коем случае не пытайтесь плотно заполнить канал. Перемещение купрала в нижнюю часть канала происходит только под действием электрического поля. \r\n\r\nВо избежание появления болевых ощущений у пациента нельзя допускать попадания купрала в периапикальную область. \r\n\r\nПримечание: При некоторых обстоятельствах (например загрязнении дентина полости) купрал может вызвать окрашивание зуба. Чтобы избежать окрашивания, следует тщательно протереть стенки полости взвесью гидкоокиси кальция высокодисперсной. \r\n\r\nПри проведении депофореза на фронтальных зубах рекомендуется использовать смесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной (см. п. 4 «Особые случаи» ). \r\n\r\n3. 3 Работа с прибором для депофореза \r\nСледуйте также указаниям «Инструкции по эксплуатации прибора для депофореза». \r\n\r\nПоложительный зажимный электрод или крюкообразный электрод помещаются во рту на удобной для врача стороне: \r\n\r\nА) Закрепление зажимного электрода \r\nНе покрытая лаком металлическая внутренняя поверхность должна располагаться на влажной слизистой щеки. Часто является достаточным перед началом лечения смочить проточной водой контактную поверхность зажимного электрода. Между контактной поверхностью электрода и слизистой щеки рекомендуется проложить кусок марли, смоченной проточной водой, для того, чтобы исключить ожог слизистой. \r\n\r\nБ) Расположение крюкообразного электрода \r\nКороткая изогнутая часть электрода должна располагаться в слюне переходной складки, а длинная прямая - за пределами ротовой полости, в направлении вниз. \r\n\r\nЧтобы избежать контакта электрода с металлическими пломбами или коронками и предотвратить нагревание слизистой, короткую часть электрода, находящуюся во рту, следует обернуть марлей, смоченной проточной водой. \r\n\r\nВ) Применение отрицательного иголочного электрода \r\nОтрицательный электрод, закрепляют в наконечнике. До включения при бора электрод неглубоко (около 3-5 мм!) погружают в купрал, который был предварительно внесен в канал. ЧтоБЬJ предотвратить возникновение поперечных токов, рабочее поле вокруг канала следует содержать сухим, например периодически обдувая струей воздуха. Поперечные токи являются частью токов, которые идут через десну и слюну к положительному электроду, не попадая в канал. Они также регистрируются прибором для депофЬреза и могут иногда достигать значительной части регистрируемого прибором тока, что Mo~eT привести к недодозированию купрала инедолечению. \r\n\r\nПри лечении депофорезом каждый канал необходимо обработать количеством электричества 15 мА х минут. Это количество может быть разделено на 2 или 3 сеанса. \r\n\r\nа) При лечении в 3 сеанса каждый канал за 1 сеанс должен быть обработан количеством электричества 5 мА х мин, если работа проводится с прибором «Оригинал 1/». \r\n\r\nПри использовании прибора «Комфорт 1» сеанс продолжается до показания 1 00%. \r\n\r\nПри работе с прибором «Комфорт 11» лечение проводится до показателя «Программа 1 ». \r\n\r\nб) При проведении депофореза прибором «Оригинал 11» в 2 сеанса каналы каждый раз обрабатывают количеством электричества 7,5 мА х мин. \r\n\r\nПри приборе «Комфорт 1"''= 100% + еще 50%. \r\n\r\nПри использовании «Комфорта 1/» = Программа 2. \r\n\r\nПосле размещения электродов включают прибор для депофореза и медленно увеличивают силу тока пока ощущение тепла в области корня зуба не станет пациенту неприятным. Обычно это наблюдается при величине тока от 0,8 мА до максимум 1,5 мА. Ток следует немного уменьшить (до исчезновения дискомфорта) и проводить сеанс. \r\n\r\nПосле проведения приблизительно половины сеанса силу тока уменьшают до О, не выключая прибор, иначе будет стерто уже достигнутое значение количества электричества. Из канала следует извлечь купрал (насколько это возможно). Канал не промывать. Внести свежую порцию купрала. Это чрезвычайно важно! При извлечении первоначальной порции купрала удаляются TalOКe чужеродные ионы, проникшие в канал из периапикальной области. Эти ионы приводят к повышению величины тока, однако не оказывают лечебного действия. \r\n\r\nПосле внесения новой порции купрала продолжают сеанс депофореза. \r\n\r\nВо время проведения депофореза вследствие электроосмоса из канала выделяется жидкость, обычно пенообразная. Эту пену следует постоянно удалять, например ватным тампончиком, так как она может привести к появлению поперечных токов (см. выше). Необходимо отметить, что если пациент при величине тока 1,5 мА не отмечает значительного потепления в области корня, это свидетельствует скорее всего о наличии значительных поперечных токов (см. также п. 4. Особые случаи и п. 5. Проблемы при проведении депофореза). \r\n\r\nКаждый канал должен быть обработан суммарным количеством электричества не менее 15 мА х мин (за 2 или 3 сеанса), в противном случае успешность лечения, достигающая обычно почти 100%, может существенно снизиться. \r\n\r\nСуммарное время лечения одного канала составляет обычно около 15 минут. Это значительно меньше, чем время, необходимое для лечения традиционным способом. При депофорезе многие виды работ могут быть поручены ассистенту врача. \r\n\r\nПосле окончания сеанса прибор выключают и из канала извлекают отрицательный электрод. \r\n\r\nИз канала механически удаляют доступную часть купрала (канал не промывать!). Затем канал заполняют свежей порцией купрала (так, как обычно делают вкладки лекарственных препаратов). Канал оставляют открытым или закрывают временной пломбой, сделав отверстие для входа в канал. \r\n\r\nОбоснование: Опасность реинфекции в глубине канала исключительно мала, так как из-за очень малой растворимости купрала после депофореза в канале всегда имеется его насыщенный раствор, обладающий мощным бактерицидным действием. При открытом канале благодаря оттоку экссудата и·свободному выделению газов значительно снижается давление, и следовательно, уменьшается вероятность появления болей. \r\n\r\nВторой (или третий сеанс) \r\n\r\nВо время второго сеанса, который обычно проводится через 8-14 дней, извлекают ранее вложенный купрал. Вносят новую порцию купрала и проводят сеанс депофореза. Третий сеанс проводят таким же образом итаюке спустя 8-14 дней. \r\n\r\nПосле проведения последнего сеанса механически удаляют легко извлекаемый отработанный купрал (канал не промывать!). \r\n\r\nНе внося никакого лекарственного препарата, пломбируют канал атацамитом ­цементом для пломбирования канала (см. следующий раздел). \r\n\r\n3.4 Пломбирование канала \r\nВо время последнего посещения сразу после проведения сеанса депофореза канал пломбируют щелочным цементом - атацамитом (фирмы «Humanchemie»). Атацамит необходимо размешивать на пластине минимум 1 минуту. Размешав до консистенции сметаны, цемент вносят в канал с помощью каналонаполнителя. \r\n\r\nВажное примечание: Заполнение атацамитом производится на одну-две трети длины канала (ни в коем случае не глубже, чем 3 мм до апекса). \r\n\r\nАтацамит ни в коем случае не должен быть выведен за пределы канала, так как это может вызвать сильную реакцию со стороны периапикальных тканей. Следует принципиально отказаться от пломбирования нижней части канала, которая после депофореза становится стерильной. \r\n\r\nБоли, появившиеся в результате выведения купрала или атацамита за верхушку корня, через несколько дней проходят. Не следует делать резекцию или удалять зуб. Можно назначить обезболивающие препараты. \r\n\r\nАтацамит имеет небольшую твердость и поэтому, например при необходимости повторного проведения лечения, может быть легко извлечен. \r\n\r\nДля фиксации штифта атацамит не пригоден. Поэтому при штифтовании зуба часть атацамита удаляют. \r\n\r\nДля пломбирования канала после депофореза ни в коем случае не следует с самого начала использовать фосфатный цемент или какой-либо другой пломбировочный материал, поскольку атацамит оказывает важное терапевтическое действие. \r\n\r\nВажное указание: Протеолиз, благодаря которому происходит растворение органического содержимого и стерилизация всей канальной системы, т. е то,.что обеспечивает лечение, при правильном проведении депофореза, затрагивает также небольшие участки периапикальной области вокруг многочисленных отверстий, а не только возле главного отверстия, как при традиционных эндодонтических методах. Поэтому следствием такого воздействия (абактериального раздражения) может быть возникновение чувствительности зуба при постукивании и накусывании. В связи с этим в первое время после лечения следует стараться не подвергать зуб нагрузке. После уменьшения дискомфорта наступает действительное физиологичное излечение. Указанные временные явления раздражения тканей периапикальной области следует отличать от острого Paгodontitis apicalis, который нуждается в лечении. \r\n\r\nРеоссификация,В том числе крупных очагов, наблюдаемая, как правило, после депофореза, приблизительно уже через 6 месяцев, в зависимости от возраста пациентов, выявляется рентгенологически. Через 18 месяцев обычно реоссифицируют даже обширные очаги. \r\n\r\n 4. Особые случаи 4.1 Предварительное лечение при наличии остатков витальной пульпы, например, после витальной экстирпации \r\n(проявляется непереносимостью самых малых токов, менее 0,3 мА) \r\n\r\nВариант А. \r\n\r\nЗуб девитализируют обычным образом. Только после этого начинают лечение депофорезом. \r\n\r\nЕсли через 4 недели после девитализации по-пржнему сохраняется витальность, например при пrjохой доступности канала, тогда следуют рекомендациям в варианте Б. \r\n\r\nВариант Б. \r\n\r\nДепофорез проводят как обычно, но под анестезией. Однако в этому случае мы рекомендуем проводить 3 сеанса (см. п. 3.3 Работа с прибором для депофореза) при величине тока максимум 1,0 мА. \r\n\r\n4.2 Фронтальные зубы \r\nДля избежания окрашивания зубов фронтальной области вместо купрала необходимо использовать смесь, состоящую из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной. \r\n\r\n4.3 Наличие обострения \r\nВ большинстве случаев в результате электроосмотического освобождения периапикальной области от экссудата наблюдается мгновенное улучшение состояния. \r\n\r\n4.4 Кровоточивость канала \r\nПеред проведением депофореза кровь следует остановить, поскольку в крови содержатся . различные чужеродные ионы, которые могут повлиять на эффективность депофореза. \r\n\r\n4.5 Лишь частично проходимые каналы \r\nТакие каналы можно вполне успешно лечить, если в вехнюю часть несколько расширенного канала удастся внести немного купрала. В этих случаях депофорез обычно продолжается несколько дольше, так как не удается достичь большой величины тока. \r\n\r\nОднако возможен и другой подход - после одного сеанса депофореза с использованием прибора в каналах установить гальванические штифты, которые обеспечивают длительный депофорез. Излечение проходит столь же успешно, как и при проведении депофореза обычным образом. \r\n\r\n4.6 Каналы зуба не удается электрически изолировать друг от друга      \r\nРекомендуется в каналы ввести какие-либо штифты. Заполнить полость пломбировочным         ,           \r\n\r\nматериалом (например, композитом). После того, как материал слегка отвердеет, извлечь штифты. Таким образом, входы в каналы будут надежно отделены друг от друга. Отсутствующие стенки полости могут быть таким же образом восстановлены временным реставрационным материалом. \r\n\r\n4.7 Ревизия после ранее проведенного лечения корневых каналов \r\n\r\nПеред проведением депофореза следует насколько это возможно удалить прежний пломбировочный материал. Даже при наличии остатков этого материала как правило, удается получить хорошие результаты лечения, поскольку ток проходит по боковым канальцам. \r\n\r\nПримечание: Во всех случаях, когда имеется серьезная опасность выведения купрала в периапикальную область (например, широкое отверстие или зубы, подвергавшиеся резекции) рекомендуется вместо чистого купрала использовать смесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной). Смесь следует осторожно внести вращательными движениями только в верхнюю часть канала. Таким образом удается предотвратить боли, которые могут возникнуть при выведении купрала за верхушку. \r\n\r\n4.8 Зубы, покрытые коронкой \r\nСледует пройти бором коронку и далее действовать, как описано в п. 4.7. 8 этом случае иголочный электрод может быть погруженнесколько глубже, чем обычно. \r\n\r\nРешающее значение имеет минимирование поперечных токов через край коронки. Чтобы предотвратить возникновение прямого контакта иголочного электрода и коронки, изолирующую трубочку электрода вдвигают вместе с ним в окошко коронки. \r\n\r\nЭлектрод можно таюке покрыть изолирующим лаком, не доходя 2 мм до кончика. \r\n\r\nНи в коем случае нельзя допускать возникновения пленки влаги между корневым каналом и коронкой. \r\n\r\nЕсли пациент при величине тока более 1,0 мА не ощущает никакого потепления в канале, это является достоверным признаком наличия поперечных токов. \r\n\r\n4.9 Молочные зубы \r\nПроводить лечение молочных зубов депофорезом не рекомендуется. Однако в качестве лекарственной вкладки хорошо зарекомендовала себя взвесь из 1 части купрала и 9 частей гидроокиси кальция высокодисперсной. \r\n\r\n4.10 Кисты \r\nМногие врачи успешно лечат радикулярные кисты, используя депофорез. В клиниках обычно используют следующую методику: \r\n\r\nКанал подготавливают до апекса. Рекомендуется при возможности несколько расширить апикальное отверстие. Ток устанавливают большей величины, чем обычно (например, 5 мА) (в зависимости от размеров кисты) и каждый канал обрабатывает большим количеством электричества (>30 мА х мин). Необходимо провести 3 сеанса, подавая на каждый канал минимум 30 мА х мин (проведение расчетов см. в п. 3.3. сноска 1). \r\n\r\n4. 11 Водитель ритма сердца \r\nКупрал-депофорез не нарушает функцию водителя ритма сердца (IMICH, Dtsch. ArztebIatt, Ausg. А 37, S. 2957, 1992). Приборы с ручными электродами использовать нельзя. \r\n\r\n5. Проблемы в процессе лечения  5.1 Несмотря на установку на приборе максимальной величины тока, она остается ниже 0,4 мА \r\nЭто обычно объясняется большим сопротивлением канала. Депофорез все равно рекомендуется проводить. После одного сеанса работы с прибором для депофореза лечение можно продолжить, используя гальванические штифты. \r\n\r\nВ некоторых случаях невозможность достигнуть оптимальной величины тока связана с разрядкой батареек (см. инструкцию по эксплуатации соответствующего прибора для депофореза). \r\n\r\n5.2 Сила тока падает во время сеанса депофореза \r\nПричина: Тепло, образующееся при прохождении тока, высушивает купрал, содержащий недостаточное количество влаги. \r\n\r\nКоррекция: Внести в канал жидко разведенный купрал. \r\n\r\nДругие возможные причины: разрядка батареек (см. инструкцию по эксплуатации соответствующего прибора для депофореза). \r\n\r\n5.3 Непереносимость даже слабых токов \r\nПричиной является наличие в боковых каналах витальных остатков пульпы. Следует поступать, как описано в п. 4.1. \r\n\r\n5.4 Пациент не ощущает существенного потепления в канале при силе тока 1,0 - 1,5 мА \r\nЭто явный показатель наличия поперечных токов. Лишь очень немногие пациенты обладают столь низкой чувствительностью, что не замечают увеличения тепла при указанных величинах тока. Поперечные токи следует убрать (например, струей воздуха) (см. таюке п. 3). \r\n\r\n6. Проблемы, встречающиеся после лечения \r\n6. 1 Боли, возникающие через несколько часов после проведения депофореза Причиной обычно является механическое проталкивание купрала или корневого цемента атацамита в периапикальную область. Необходимо свести к минимуму нагрузки на зуб! Обычно через несколько дней боли стихают. Можно назначить обезболивающее средство. Ни в коем случае не удалять зуб. \r\n\r\n6.2 Боли в более отдаленном периоде после лечения (минимум через 1 день) Причиной является возникновение давления внутри канала в результате образования секретов и газов, если канал не был оставлен открытым или оставленное в пломбе отверстие забил ось остатками пищи. Необходимо освободить вход в канал. Как показала практика, закрытие полости зуба ватой не целесообразно. \r\n\r\n6.3 Рецидивы \r\nЭти чрезвычайно редкие случаи, в основном, являются следствием недодозирования действующего количества электричества в результате возникновения поперечных токов. Необходимо заново тщательно провести депофорез (2 или 3 сеанса), предварительно удалив из канала атацамит. Это не сложно, так как атацамит имеет низкую твердость. Следует при этом обратить внимание на наличие параллельных каналов, которые, возможно, не были обнаруженны в ходе ранее проведенного лечения. \r\n\r\n7. Как избежать ошибок при про ведении депофореза \r\n\r\nТоки, проходящие не через корневой канал, а через коронку зуба (поперечные токи) \r\n\r\nследует убирать, лучше всего путем периодического обдувания зуба струей воздуха. Тонкие пленки слюны на зубной коронк е, часто невидимые, обладают большой электропроводностью и поэтому приводят К образованию сильных поперечных токов.\r\n\r\n&#216;      Поскольку электрическое сопротивление заполненного купралом канала редко бывает меньше 20 ка, а чаще всего больше, чем 30 ка, иногда даже достигает порядка 70 ка, то токи, превышающие 1,5 мА (при полном повороте ручки регулятора напряжения прибора), содержат скорее всего бесполезные поперечные токи.  Следствие: недодозирование действующей субстанции. \r\n\r\n&#216;      Еще ОДНОЙ причиной слишком больших величин тока является электроосмос серозной ЖИДКОСТИ из периапикальной области через апикальную дельту. Эта жидкость обнаруживается у отрицательного электрода. Она имеет гораздо большую электропроводность, чем купрал. Это при водит К значительному возрастанию силы тока в процессе депофореза. Носителями этой части тока являются преимущественно анионы хлора. Поэтому количество переносимых действующих ионов значительно снижается. Для предотвращения этой очень серьезной ошибки необходимо через некоторое время после начала сеанса (самое позднее на половине сеанса) остановить депофорез, извлечь из канал купрал и заменить его новой порцией препарата. После этого продолжить депофорез. \r\n\r\n&#216;      Согласно данным врачей - членов стоматологической научной группы Гамбургского университета, после депофореза (при правильном проведении методики) боли не возникают. Болевые ощущения в результате абактериального раздражения (через день после сеанса) появляются только, если купрал выведен непосредственно в периапикальную область с живыми тканями. Поэтому и при наличии витальных остатков пульпы, например, после так называемой вительной экстирпации, депофорез следует проводить только после надежной девитализации пульпы. \r\n\r\n&#216;      При выведении значительного количества купрала или атацамита за пределы отверстия могут возникнуть боли и даже отечность. Согласно нашему опыту, это абактериальное воспаление постепенно самопроизвольно прекращается. \r\n\r\n', 0, 3, 23, 'kivdent', '', 0, 'russian', 0, 0, 0, 0, 0, '0', '22-');
INSERT INTO `nuke_stories` (`sid`, `catid`, `aid`, `title`, `time`, `hometext`, `bodytext`, `comments`, `counter`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `haspoll`, `pollID`, `score`, `ratings`, `rating_ip`, `associated`) VALUES (3, 0, 'kivdent', 'Основные характеристики и практическое применение коффердама', '2007-02-05 10:06:06', '<span style="font-size: 10pt"><font face="Times New Roman">Аспект безопасности и стремление к оптимальным результатам в лечении зубов с использованием адгезивной техники, а также в эндодонтии являются основой применения коффердама в стоматологической практике. Коффердам является conditio sine gua non при фиксации керамических и композитных вкладок, вкладок из золота, композитных пломб в области боковых зубов, а также адгезивных мостов. Из соображений гигиены для медицинского персонала и пациента, для защиты слизистой оболочки полости рта пациента от раздражающего действия химических субстанций при промывании корневых каналов и применении методов отбеливания, для ретракции десны и для защиты мягких тканей щек и губ также следует рекомендовать коффердам. Рациональное применение коффердама обеспечивает вдобавок выигрыш во времени, облегчение работы, а также достаточный обзор всего рабочего поля. Каждый стоматолог знаком с коффердамом, а приемы работы с ним должны быть освоены еще в процессе обучения. Правда, в Германии коффердам систематически используется 5-15% стоматологов. В таких странах, как США, Швейцария и скандинавские государства, коффердам применяется в 5-7 раз чаще. В качестве оснований для отказа от коффердама стоматологами Германии выдвигаются аргументы - затраты времени на наложение и сложное применение. J.K.Jngle этот аргумент описал следующим образом: &laquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&raquo;. Причины же кроются по большей мере в недостаточных знаниях, а также в недостаточных навыках по технике наложения коффердама. Коффердам является&nbsp;простейшим, но действенным вспомогательным средством, которое должно помогать, а не обременять.&nbsp;Преимущества его применения должны больше, чем&nbsp; дополнительных&nbsp;затраты. Проблема состоит в том, чтобы минимизировать затраты времени пациента на аппликацию коффердама. Это возможно только при использовании описанных ниже простых методов коффердам-техники и постоянной тренировке. Для этого предлагаются соответствующие курсы и информационные материалы. Фирма Hager-Werken организует курсы по технике коффердама, ею создан видео-фильм и выпущена информационная брошюра о коффердаме, что несомненно способствует дальнейшему распространению метода абсолютной изоляции. После основательной переработки 1-го издания в свет вышла вторая брошюра о фит-коффердаме. Начинающаяся с исторического аспекта, она приводит преимущества и недостатки, описывает составные части набора коффердама. Подробно и систематизировано освещены отдельные основные варианты техники применения коффердама.&nbsp; Описание дополнено иллюстративным материалом. Благодаря доступному изложению, а также хорошим иллюстрациям информационная брошюра вносит весьма ценный вклад в широкое и быстрое распространение техники коффердама.</font></span>', '<span style="font-size: 10pt"><font face="Times New Roman">&nbsp;</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Основные характеристики и практическое применение коффердама.</span></strong><span style="font-size: 10pt; color: black"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Предисловие</span></strong></font></span><span style="font-size: 10pt"><font face="Times New Roman">Аспект безопасности и стремление к оптимальным результатам в лечении зубов с использованием адгезивной техники, а также в эндодонтии являются основой применения коффердама в стоматологической практике. Коффердам является conditio sine gua non при фиксации керамических и композитных вкладок, вкладок из золота, композитных пломб в области боковых зубов, а также адгезивных мостов. Из соображений гигиены для медицинского персонала и пациента, для защиты слизистой оболочки полости рта пациента от раздражающего действия химических субстанций при промывании корневых каналов и применении методов отбеливания, для ретракции десны и для защиты мягких тканей щек и губ также следует рекомендовать коффердам. Рациональное применение коффердама обеспечивает вдобавок выигрыш во времени, облегчение работы, а также достаточный обзор всего рабочего поля. Каждый стоматолог знаком с коффердамом, а приемы работы с ним должны быть освоены еще в процессе обучения. Правда, в Германии коффердам систематически используется 5-15% стоматологов. В таких странах, как США, Швейцария и скандинавские государства, коффердам применяется в 5-7 раз чаще. В качестве оснований для отказа от коффердама стоматологами Германии выдвигаются аргументы - затраты времени на наложение и сложное применение. J.K.Jngle этот аргумент описал следующим образом: &laquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&raquo;. Причины же кроются по большей мере в недостаточных знаниях, а также в недостаточных навыках по технике наложения коффердама. Коффердам является&nbsp;простейшим, но действенным вспомогательным средством, которое должно помогать, а не обременять.&nbsp;Преимущества его применения должны больше, чем&nbsp; дополнительных&nbsp;затраты. Проблема состоит в том, чтобы минимизировать затраты времени пациента на аппликацию коффердама. Это возможно только при использовании описанных ниже простых методов коффердам-техники и постоянной тренировке. Для этого предлагаются соответствующие курсы и информационные материалы. Фирма Hager-Werken организует курсы по технике коффердама, ею создан видео-фильм и выпущена информационная брошюра о коффердаме, что несомненно способствует дальнейшему распространению метода абсолютной изоляции. После основательной переработки 1-го издания в свет вышла вторая брошюра о фит-коффердаме. Начинающаяся с исторического аспекта, она приводит преимущества и недостатки, описывает составные части набора коффердама. Подробно и систематизировано освещены отдельные основные варианты техники применения коффердама.&nbsp; Описание дополнено иллюстративным материалом. Благодаря доступному изложению, а также хорошим иллюстрациям информационная брошюра вносит весьма ценный вклад в широкое и быстрое распространение техники коффердама.</font></span><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;</font></span></strong><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Фит в коффердам-технике</span></strong><span style="font-size: 10pt"></span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изобретатель коффердама.</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">В 1883 году д-р La Roche (Франция) заявил об использовании им коффердама уже с 1857 года, поэтому его считают первым изобретателем этой техники, несмотря на то, что Sanford Christi Barnym (1836-1885) &ndash; нью-йоркский&nbsp;зубной врач &ndash; 15.03.1864 впервые применил коффердам. Уже в июне 1864 года на заседании общества дантистов в Нью-Йорке им была устроена демонстрация использования коффердама перед коллегами. В августе 1864 г. было опубликовано первое сообщение. И уже в&nbsp;1867 году техника коффердама получила&nbsp;широкое распространение.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Значение и цель использования коффердама</span></strong><span style="font-size: 10pt"> </span></font><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">Преимущества для врача и персонала </font></span></strong><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Защита</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-от проглатывания </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-от аспирации </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Исключение повреждения слизистой оболочки жидкостями для промывания или </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">дезинфицирующими средствами </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Защита врача и персонала от инфекции </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Ретракция мягких тканей (десна, губы, щеки, язык) </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Облегчение работы</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Рабочее поле остается сухим </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Рабочее поле длительное время дезинфицировано </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Хороший обзор </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Стерильный способ работы </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<u><span style="color: black">-Выигрыш во времени около 20% </span></u></font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><u><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;-Рот постоянно открыт </font></span></u><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><u><span style="font-size: 10pt; color: black"><font face="Times New Roman">&nbsp;-Дискуссия с пациентом прерывается </font></span></u><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><u><span style="font-size: 10pt; color: black">&nbsp;-Отсутствие необходимости прополаскивать </span></u><span style="font-size: 10pt">полость рта </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Отсутствие необходимости в замене ватных валиков </font></span><font face="Times New Roman"><strong><u><span style="font-size: 10pt">Для пациента&nbsp;наибольшее преимущество состоит в комфорте</span></u></strong><span style="font-size: 10pt">, так как он чувствует, что лечение происходит вне полости рта. При этом ощущение пересушенной слизистой оболочки возникает не в большей степени, чем при интенсивном применении слюноотсоса или ватных валиков. Это же относится к ощущению дискомфорта при опоре пальцев врача. Уменьшается также раздражение от удушья и рвотного рефлекса. Благодаря изоляции содержимое полости рта остается обычным и пациент может глотать и дышать.</span></font><strong><span style="font-size: 10pt; color: black"><font face="Times New Roman">Недостатки коффердама</font></span></strong><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Потеря осевых ориентиров при препарировании входа в полость зуба </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Возможно травмирование межзубного сосочка </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Большие требования при рентгенографии </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-Возможная аллергия (помощь: использование силиконовых пластин, фирма Roeko) </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важные цитаты </span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&ldquo;Наибольшая потеря времени при использовании коффердама заключается в том, чтобы убедить коллег в его преимуществах и безотказности&rdquo; (J.I. Ingle)</font></span><span style="font-size: 10pt"><font face="Times New Roman">&laquo;При наличии навыка в обычном случае лечения возможно наложить коффердам в течение примерно&nbsp;1 минуты (максимум двух минут)&raquo; (J.I.Ingle)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Для чего и почему коффердам?</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Короче и точнее всех на этот вопрос ответил G.V.Black (1908). Он писал: &laquo;Коффердам служит для того, чтобы содержать операционное поле при работе на зубах чистым, сухим и в случае необходимости асептичным. Последнее особенно желательно при&nbsp;лечении корневых каналов. (G.V.Black 1908)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-продукты и их свойства</span></strong><span style="font-size: 10pt"> </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt">Коффердам</span></strong><span style="font-size: 10pt">-пластина из натурального латекса поступает в продажу в рулоне или в виде салфетки размером 15х15 см. Коффердам обладает очень высокой эластичностью, которая необходима для его&nbsp;применения. К сожалению, его оптимальные свойства не безграничны (около 9 месяцев), потом он разрушается, что означает: он становится ломким, благодаря чему очень быстро рвется и недостаточно плотно прилегает. Если латекс поместить в холодильник или даже в сильно охлажденный ящик, он может сохранять свои свойства в течение более длительного времени (при описанном хранении &ndash; около 1 года).</span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Проверка</span></strong><span style="font-size: 10pt"> </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Испытание качества</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Если латекс можно растянуть между руками до абсолютной прозрачности, его свойства оптимальны для использованя вне зависимости от его возраста.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Цвета коффердама и качественные свойства (толщина).</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Цвета:</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-<strong>светло-бежевый:</strong> благодаря своей прозрачности используется преимущественно при эндодонтическом&nbsp;лечении. Нежелательно использовать при работе с композитами (плохое изображение контуров)</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-<strong>коричневый или темно-серый:</strong> хороший цветовой контраст, исключение отражения света</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong>-зеленый</strong>: приятный, дружелюбный, успокаивающий цветной тон образует хороший цветовой контраст контуров, отсутствие эффекта диафрагмы под светом люминисцентной лампы (исключение/отсутствие отражения света),&nbsp;пахнет мятой, что делает его весьма приятным для пациентов</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt">Другие цвета</span></strong><span style="font-size: 10pt">: синий, светло-синий, розовый, сиреневый, как альтернатива для выше перечисленных светлых, темных и зеленых цветов</span></font><span style="font-size: 10pt"><font face="Times New Roman">Пять разновидностей коффердама по качеству (толщине)</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-тонкий (thin) 0,13-0,18 мм &ndash; тончайший коффердам, чем легче его апплицировать, тем быстрее его разорвать и плотность его прилегания не такая хорошая, как у более толстого </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-средний (medium) 0,18-0,23 мм &ndash;&nbsp;для использования он подходит более всего, так как особенно прост в обращении, также удобен при натягивании коффердама и, конечно, при консервативном лечении </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-толстый (heavy) 0,23-0,29 мм &ndash; благодаря его применению достигается хорошая ретракция десны. Кроме того, он практически не рвется </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-экстра толстый (xheavy) 0,29-0,34 мм&nbsp;- не рвется при экстремальных условиях и позволяет достичь максимальной ретракции десны, но в то же время его очень трудно адаптировать&nbsp; </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-толстый специальный (spheavy) 0,34-0,39 мм &ndash; этот коффердам накладывается только в тех случаях, когда непременно необходимо достичь особой защиты тканей. </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;Значения толщины коффердама пересекаются, указано наибольшее значение измерения по спецификации, которое одновременно является наименьшим значением для следующей, более высокой спецификации.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Пользователь коффердама обычно сам&nbsp;&laquo;чувствует&raquo; эти малые различия в измерении</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Резюме</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">При выполнении композитной реставрации под коффердамом необходимо провести определение цвета перед его наложением, так как поверхность изолированных зубов очень быстро и в значительной степени высыхает, что делает невозможным правильный выбор цвета. </font></span><span style="font-size: 10pt"><font face="Times New Roman">На этапе первых шагов работы с коффердамом можно вначале использовать тонкий коффердам с учетом свойств, приведенных в описании материала. С течением времени по мере приобретения более совершенных навыков рекомендуется переходить на работу с коффердамом большей толщины. В повседневной практике используются обычно две разновидности коффердама. Вначале следует переходить от тонкого к среднему и толстому, позднее &ndash; к экстра толстому.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важно</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Коффердам имеет гладкую и припудренную поверхность. Гладкая поверхность всегда прилежит к поверхности полости рта пациента, а припудренная таким образом обращена к врачу.&nbsp;Это правило необходимо соблюдать из двух соображений: </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-гладкая поверхность легче скользит по поверхности изолируемых зубов (преимущество для накладывающего коффердам) и</font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;-при соприкосновении коффердама с языком на последнем не остается рисовой или кукурузной муки (комфорт для пациента)</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-шаблон для маркировки местоположения отверстий</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Он изготовлен из белого винила и делает возможной точную маркировку положения зуба на коффердаме, причем коффердам накладывается своей гладкой стороной на шаблон и на припудренной поверхности&nbsp;наложения отмечается с помощью карандаша (таким образом, чтобы маркировка не прошла на обратную сторону). Преимуществом использования шаблона является то, что отмечается только положение изолируемых зубов. Отсюда следует, то при наложении коффердама легче ориентироваться в полости рта, так как на его поверхности нет других отметок.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-штемпель</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">С его помощью на поверхность коффердама могут быть нанесены дополнительные дуги, на которые в случае необходимости легко нанести стандартные положения зубов.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы-перфоратор для коффердама</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Снабжены диском с 5 или 6 сквозными отверстиями разных размеров, что делает всегда возможным&nbsp;получение в коффердаме отверстий правильной формы.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Назначение отверстий в перфораторе ainsworth:</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 5 </span></strong><span style="font-size: 10pt">(largest-самое большое) &ndash; рекомендуется для кламмерных зубов ( в конце зубной дуги) </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 4 </span></strong><span style="font-size: 10pt">(large-большое) &ndash; универсальное для моляров </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 3 </span></strong><span style="font-size: 10pt">(medium-среднее) &ndash; для клыков и премоляров верхней и нижней челюсти </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 2 </span></strong><span style="font-size: 10pt">(small-маленькие) &ndash; для фронтальных зубов верхней челюсти </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие № 1 </span></strong><span style="font-size: 10pt">(smallest-самое маленькое) &ndash; для очень тонких нижних фронтальных зубов </span></font><span style="font-size: 10pt"><font face="Times New Roman">Варьирование по выше приведенной схеме размеров отверстий гарантирует абсолютно плотное прилегание коффердама, предотвращающее проникновение влаги к рабочей поверхности зуба.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы-перфоратор для фит</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">С помощью фит-перфоратора можно в любом случае получить ровное чистое отверстие в коффердаме. Подвижной щит-штамп всегда охватывает весь режущий край одновременно и образует таким образом отверстие без разрывов.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Отверстие</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы получить ровное отверстие, пластину коффердама необходимо натянуть между большим и безымянным, а также указательным и средним пальцами&nbsp;левой руки (исключение складок и вследствие этого отсутствие нежелательной дополнительной перфорации). Лишь теперь пластину с отверстиями неповрежденных острых щипцов подвести под коффердам, щипцы закрываются и шип при этом вдавливается в выбранное отверстие в диске, так чтобы получить абсолютно круглое отверстие. Если при осмотре отверстия обнаруживаются надрывы, разрывы в форме&nbsp;зубцов, то это говорит о том, что при попытке натянуть коффердам на зубы в местах неполных отверстий он рвется. Если же перфорация абсолютно круглая, то при растяжении коффердама его&nbsp;можно наложить легко и без разрывов</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Коффердам-кламмеры</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Принципиально различают две основные формы кламмеров. Они соответствуют различным методам наложения коффердама. Различают бескрылые кламмеры и кламмеры с крыльями.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Бескрылые кламмеры</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Их бока короткие и закругленные. При использовании этого вида кламмеров сначала на зуб помещается кламмер, потом накладывается коффердам, в заключение ставятся рамки. Литер&nbsp; W (wingless-бескрылый) перед номером означает кламмер без крыльев.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Кламмер с крыльями</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Их бока&nbsp;имеют выступающие вперед крылья. Крылья вводятся в отверстие в коффердаме и потом кламмер вместе с ним помещается на зуб.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">контактный пункт центральное </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;крыло </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">перфорация&nbsp;рука </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">боковина&nbsp;переднее&nbsp;кламмера </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">вырезка&nbsp;крыло </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;контактный пункт&nbsp; </font></span><span style="font-size: 10pt"><font face="Times New Roman">Из методических и практических соображений рассмотрим более подробно широко используемые&nbsp;отдельные кламмера.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 14А </span></strong><span style="font-size: 10pt">&ndash; особенно рекомендуется для неполностью прорезавшихся, недоразвитых или неполностью сформированнных моляров. Кламмер фиксируется на зубах благодаря контакту в 4-х пунктах, наклоненных вниз боковин. Уменьшенная дуга отличает этот кламмер.&nbsp;Этой форме соответствует&nbsp;№ 14, хотя используются и большие. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 7 </span></strong><span style="font-size: 10pt">&ndash; отличный кламмер для нижних моляров. Повреждения десны исключаются благодаря плоской форме боковин. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 2 </span></strong><span style="font-size: 10pt">&ndash; стандартный кламмер для больших премоляров преимущественно нижней челюсти. Его плоские боковины исключают повреждения десны. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 9 </span></strong><span style="font-size: 10pt">&ndash; универсальный кламмер с двойной дугой и крыльями&nbsp; для губных полостей во фронтальных зубах и премолярах (эндодонтическое лечение). </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 00 &ndash; </span></strong><span style="font-size: 10pt">для очень маленьких премоляров и резцов верхней и нижней челюсти. Отличаются благодаря очень высокой дуге и укороченным боковинам. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 5 &ndash; </span></strong><span style="font-size: 10pt">универсальный кламмер для больших моляров верхней челюсти, особенно для зубов округлой формы. Кламмер хорошо прилегает к десневому краю&nbsp;своими углубленными боковинами, что исключает ротацию. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 8А &ndash; </span></strong><span style="font-size: 10pt">маленькие моляры верхней и нижней челюсти, которые неполностью прорезались или недоформировались. Чтобы не повредить ткани под десну вводятся 4 шипа. Благодаря наклоненным вниз боковинам возможно наложение коффердама ниже десневого края. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 212 &ndash; </span></strong><span style="font-size: 10pt">цервикальный кламмер (=ретракция тканей) для пришеечных полостей (5 класс кариозных дефектов) во всех зубах. Для этого показания используется экстра-толстый коффердам, чтобы достичь&nbsp;возможно большей ретракции десны. Важно ч отверстие для реставрируемого зуба ввести более цервикально (около 2 мм) в противоположность соседним&nbsp;зубам. Рекомендуется также выполнить это отверстие на один номер больше, чем другие. Для стабилизации кламмера&nbsp;используется масса KERR или штамповочная масса. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 214 &ndash; </span></strong><span style="font-size: 10pt">цервикальный кламмер Hatch. Две большие подвижные дуги&nbsp;образуют маленькую боковину и накладываются вестибулярно или лабиально, так чтобы десна была отодвинута в желательном положении, винт затягивается&nbsp;и&nbsp;кламмер фиксируется. Большая боковина неподвижна и располагается палатинально или лингвально. </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Губные кламмеры &ndash; кламмеры с двойными дугами</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Для эндодонтии во всех случаях важно изолировать только зуб, подвергаемый лечению. Для однокорневых зубов предлагаются представленные здесь кламмеры с двойными дугами . </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 210 &ndash; </span></strong><span style="font-size: 10pt">предназначены для губных полостей во фронтальных зубах, также в премолярах и вторых молярах нижней челюсти. </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">№ 211</span></strong><span style="font-size: 10pt"> &ndash; исключительный кламмер для губных полостей во фронтальных зубах нижней челюсти. </span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Быстрое ориентирование в кламмерах</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Кламмер&nbsp;Группа зубов</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 9, 214 (Hatch)&nbsp;Фронтальные зубы </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">(0, 00, 210, 211) </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 2, 1 (0, 00)&nbsp;Премоляры </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 7, 8, 8А, 14А&nbsp;Моляры </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 7 Универсальный для нижних моляров </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 8&nbsp;Универсальный для верхних моляров </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 8А&nbsp;Маленькие моляры, не полностью прорезавшиеся </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">№ 14А&nbsp;Большие моляры, не полностью прорезавшиеся, глубоко пораженные или частично ретенированные </font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Щипцы для коффердам-кламмеров</span></strong><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt"><font face="Times New Roman">Щипцы для коффердам-кламмеров захватывают каждую кламмерную дугу в правильном положении, без опрокидывания, благодаря ретенции. Они делают также возможной адаптацию кламмера на зубе. Щипцы служат, таким образом, для разведения и наложения кламмера, а также для его удаления.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Рамки для коффердама</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы сохранить натяжение коффердама вместо специальных гирь сейчас используются рамки, которые благодаря отдельно рационально расположенным, хорошо захватывающим шипам очень быстро и успешно обеспечивают фиксацию коффердама. Рамки для коффердама сегодня выпускаются из металла и пластмассы. На среднем рисунке представлены&nbsp;клапанные рамки из пластмассы, существенно облегчающие доступ к рабочему полю и поэтому особенно подходящие для эндодонтического лечения.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Рамки для Фит-коффердама по Young</font></span><span style="font-size: 10pt"><font face="Times New Roman">U-образные рамки для коффердама, нержавеющие и гибкие, с небольшими, рационально расположенными, хорошо захватывающими цилиндрическими шипами для фиксации резины.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Клапанные рамки для Фит по Saveur</font></span><span style="font-size: 10pt"><font face="Times New Roman">Клапанные рамки, предназначенные для эндодонтии, изготовлены из автоклавируемой пластмассы (пропускающей рентгеновские лучи) и снабжены срединным шарниром. Они используются как обычные рамки для коффердама. В то же время возможно закрыть половину так,&nbsp;чтобы достичь хорошего положения для контрольного рентгеновского исследования. Преимуществом рамки является хорошая ориентация, она всегда направлена к подбородку.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Короткий экскурс в историю</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Натяжение коффердама&nbsp;с помощью специальных гирь для коффердама требовало большого навыка, чтобы всегда быть успешным. Верхние прищепки&nbsp; натягивают коффердам благодаря резиновой тяге вокруг головы пациента, а на нижних прищепках закреплены гирьки</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Важные принадлежности!</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Межзубные клинья</font></span><span style="font-size: 10pt"><font face="Times New Roman">Для фиксации матриц, а также для фиксации коффердама в полости рта пациента. Клинья изготавливают из клена (древесина) или нейлона (пластмасса). Отличная адаптация к зубу возможна благодаря анатомически идеальной форме клина. Чтобы ткани и коффердам отдавить в апикальном направлении, а также&nbsp;предупредить разрыв коффердама и, как следствие, обмотку его вокруг бора, особенно при распространяющихся по шейке зуба&nbsp;дефектах, апроксимально помещаются кленовые клинья.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Латексная нить (wedjets)</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Этот шнур для стабилизации коффердама представляет собой продукт одноразового использования из натуральной резины и выпускается двух размеров, длиной 2,14 м:</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;желтого цвета &ndash; тонкий </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;оранжевого цвета &ndash; толстый </font></span><span style="font-size: 10pt"><font face="Times New Roman">Различными производителями предлагаются базовые комплекты основных приспособлений. Однако, все отдельные части и специальные кламмера , а также принадлежности могут приобретаться отдельно.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Салфетки для коффердама</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Показаны для использования у пациентов с аллергией на латекс. (Это целесообразно для врача и очень комфортабельно для пациента, если салфетки для коффердама, прежде всего при длительном лечении, неподвижны. Коффердам затем одевается через отверстие в салфетке и натягивается на рамки.&nbsp;Она абсорбирует слюну, воду и пот.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Зубной шелк</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Шелк занимает первое место как испытанное средство для очистки межзубных пространств. Кроме того, это выдающееся вспомогательное средство, если коффердам накладывается на труднодоступные контактные поверхности. Лигатура из зубного шелка часто очень помогает закрепить коффердам на зубе (особенно на временных молярах и временных клыках). Лигатуры должны быть зафиксированы щечно при помощи хирургического узла.&nbsp;Желательно использовать длинную лигатуру, так как она облегчает манипуляции в глубине и снятие. Если&nbsp;возникает проблема, что кламмер плохо сидит, повреждает слизистую или наблюдается подтекание, то&nbsp; закрепляется&nbsp;одинарная или двойная лигатура из зубного шелка, или в большинстве случаев, петля из зубного шелка, которая проводится через&nbsp;контактный пункт и там остается. Слабое натяжение коффердама нивелируется введением в межзубной промежуток шелка, чем достигается отличная фиксация.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Шпатель Хайдеманна</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Незаменим для кратковременной сепарации контактных пунктов, а также для адаптирования коффердама вокруг шейки зуба (подворачивание). Благодаря дополнительному постоянному потоку воздуха в направлении десневого желобка подворачивание легко осуществляется вручную.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">&nbsp;Примеры использования коффердама при различных показаниях</span></strong><span style="font-size: 10pt"></span></font><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изоляция от слюны в эндодонтии</span></strong><span style="font-size: 10pt"> = изоляция отдельного зуба с помощью коффердама и кламмера для коффердама, которые накладываются на изолируемый зуб одновременно, т.е. используется подходящий кламмер с крыльями, например, для&nbsp;эндодонтической изоляции верхних фронтальных зубов &ndash; кламмер № 210. В этом случае в перфорацию со стороны припудренной поверхности вводится одно крылышко. Перфорация немного расширяется, так чтобы было можно ввести второе крылышко и кламмер&nbsp;расположился на припудренной поверхности, а крылышки &ndash; на&nbsp;обратной гладкой поверхности. Перфорация в коффердаме раскрывается крылышками таким образом, чтобы можно было хорошо увидеть зуб, на который надо наложить коффердам. Кламмер в некоторой степени под контролем зрения накладывается.&nbsp; В практике это означает, что зафиксированный в коффердаме кламмер при этом поднимается щипцами для кламмеров.</span></font><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Внимание ! Кламмерные щипцы действуют как телескопические щипцы.</span></strong></font></span><span style="font-size: 10pt"><font face="Times New Roman">Таким образом, бранши открываются при давлении, соответственно, закрываются при фиксации. При этом кламмер можно без проблем наложить на зуб и после лечения также снять. В случае эндодонтической изоляции во фронтальном отделе верхней челюсти&nbsp;кламмер рекомендуется накладывать вестибулярно под десневой край, а с небной поверхности использовать мощный ретенционный пункт зуба в виде бугорка. Кламмерные щипцы отвести в сторону, наложить коффердам и кламмер.</font></span><span style="font-size: 10pt"><font face="Times New Roman">Кламмерные щипцы наложены и кламмер с коффердамом введены в полость рта в рабочем направлении. При этом соответствующий зуб виден между боковинами кламмера, кламмер раскрывается и потом накладывается на зуб.</font></span><span style="font-size: 10pt"><font face="Times New Roman">С помощью шпателя Хайдеманна можно очень легко расположить коффердам на краю дугообразной стороны, отодвинуть его в стороны от крылышек кламмера, затем коффердам скользит&nbsp;под боковины кламмера и ложится на зуб. </font></span><span style="font-size: 10pt"><font face="Times New Roman">Для натяжения коффердама он протягивается через отверстие&nbsp;клапанной рамки Фит и фиксируется на ней с помощью удобно расположенных удерживающих шипов. Если десневая жидкость выступает на поверхность коффердама, это свидетельствует о недостаточном его проскальзывании под боковины кламмера. Для устранения этого недостатка с палатинальной стороны за кламмером вводится провощенная нить из зубного шелка длиной около 30 см. Оба конца остаются под дугами кламмера и проскальзывают в соответствующие межзубные пространства.&nbsp;Теперь шелк выводится вестибулярно под соответствующую боковину кламмера , концы нити перекрещиваются и тщательно фиксируются. Коффердам лежит полностью на десневом крае, так что абсолютная изоляция от влаги достигнута. Концы нитей обрезаются или полностью выводятся. Можно начинать соответствующее эндодонтическое лечение после окончательного наложения коффердама, при этом при раскрытии канала под водяным охлаждением помощнику врача рекомендуется&nbsp; удалять образующийся спрэй-туман с помощью аспиратора, используя при этом широкий и интактный пелот. (Внимание! Образование острого края на пелоте может вести к разрыву коффердама.) Слюну пациент может почти нормально проглатывать. Лечение продолжается так долго, что можно проводить контрольное рентгенологическое исследование , это возможно благодаря клапанным рамкам Фит.</font></span><span style="font-size: 10pt"><font face="Times New Roman">В качестве вспомогательного средства предлагается держатель пленки emmenix или артериальный зажим (очень хорош также тонкий crown clipper П).</font></span><span style="font-size: 10pt"><font face="Times New Roman">Как правило, в случае эндодонтического лечения необходима полная изоляция зуба от влаги. Поэтому эндодонтические случаи особенно подходят для того, чтобы подружиться с коффердамом. В конце лечения посещения кламмер прежде всего снова зажимается в кламмерных щипцах. Наиболее быстро и просто это удается, если кламмерные щипцы&nbsp;с ретенционными цапфами вначале ввести в видимую перфорацию кламмера, щипцы немного раскрыть&nbsp;и при этом повернуть над зубом, чтобы можно было ввести вторую ретенционную цапфу во вторую перфорацию кламмера. Кламмерные щипцы сжимаются, благодаря чему кламмер раскрывается&nbsp;и без проблем удаляется с зуба. При изоляции одного зуба пациенту можно сказать, что коффердам и рамки удаляются при стягивании. Щадяще и без уколов с этим можно справиться, если правый большой большой палец поместить вестибулярно под коффердам и рамки, правый указательный палец под режущий край зуба, на коффердам наложить средний палец лежит на коффердаме, в это же время безымянный палец и мизинец согнуты под рамкой. Теперь рамка снимается перед лицом пациента, чтобы можно было без уколов снять коффердам с режущего края.</font></span><font face="Times New Roman"><strong><span style="font-size: 10pt; color: black">Изоляция от влаги области фронтальных зубов верхней челюсти</span></strong><span style="font-size: 10pt"></span></font><span style="font-size: 10pt"><font face="Times New Roman">Чтобы не сужать видимое и рабочее поле, рекомендуется во время работы во фронтальном участке верхней челюсти накладывать коффердам таким образом, чтобы изолировать зубы 13-24. Кроме того, в этом случае помощник врача в свободное от приема пациентов время должен подготовить пластину коффердама (отметить положение зубов и выполнить перфорации) и поместить ее в холодильник. <strong><span style="color: black">Одномоментная техника </span></strong>при названном выше показании приводит пользователя к особо быстрому достижению желаемой цели &ndash; абсолютной изоляции&nbsp;от влаги, поэтому коффердам, кламмер для коффердама и рамки накладываются одновременно. Берут перфорированную от 13 до 24 пластину коффердама (припудренной стороной наверх) в левую руку, большую металлическую рамку для коффердама накладывают сверху, отступя на 1,5 см от левого края, при этом верхние концы рамки должны находиться на уровне верхнего края. Коффердам и рамка находятся таким образом в левой руке, затем правой рукой коффердам натягивается так, чтобы зафиксировать его на цилиндрических удерживающих шипах рамки. Правая рука теперь удерживает коффердам и рамку, в это время левой рукой коффердам надевается на левую сторону и также фиксируется на удерживающие щипы. Избытки коффердама слева, справа, и с нижнего края можно также&nbsp;сложить в виде маленького кармана. Он может быть полезен во время препарирования для сбора воды, а также для улавливания частей пломб. Зафиксированная пластина должна затем быть сложена с более длинной стороны, так чтобы эта сторона рамки была окутана коффердамом. Рука, в которой находится складываемая сторона, охватывает рамку у нижнего угла, так, чтобы складка не могла развернуться назад. Коффердам&nbsp;и рамка находятся только в этой руке. Свободной рукой захватывают одеваемый конец далее и натягивают его так высоко, чтобы зафиксировать эту сторону на верхнем краю рамки. После этого перечисленные шаги проводятся с противоположной стороны. Так как карман, получившийся в результате сильного натягивания, может ограничивать поле видимости, на середине его верхнего края захватывается кончик коффердама и фиксируется на цилиндрический удерживающий шип, расположенный на середине поперечного крепления. Теперь для зуба 24 берется подходящий кламмер с крыльями для премоляров (например №№ 2, 2А, 209 или 206), фиксируется в кламмерных щипцах и вводится своими медиальными крылышками в четвертое перфорационное отверстие таким образом, чтобы его дистальная дуга была обращена дистально (для первоначального облегчения ориентации можно также отмечать 25. Дуга располагается над этой вспомогательной линией, так что при внесении в полость рта пациента все в порядке). Кламмер накладывается с щечной стороны у десневого края. под легким давлением рабочей руки на щипцы кламмер легко открывается, надевается на окклюзионную поверхность и экватор зуба, после давление прекращается, щипцы фиксируются и кламмер осторожно накладывается также палатинально. Кламмерный зуб 24 располагается теперь уже снаружи коффердама, кламмерные щипцы &ndash; с обеих его сторон. Обе руки накладывающего коффердам натягивают последний так, чтобы можно было отвесно установить его в межзубное пространство (как разделительную пластинку). Теперь через перфорацию натянуть коффердам на угол&nbsp;и режущий край и ввести его следующий межзубной промежуток. Вновь латекс со следующим перфорационным отверстием насколько возможно&nbsp;установить&nbsp;отвесно в межзубном промежутке и надеть его через перфорацию на угол и режущий край. И так повторять до тех пор, пока все изолируемые зубы не будут находиться снаружи коффердама. В области 13 коффердам фиксируется с помощью зубного клина, гуттаперчевой нити, петли из зубного шелка, лигатуры или на 13 также накладывается кламмер. Если еще просачивается десневая жидкость и зубы поэтому увлажняются необходимо дополнительно на последнем этапе присоединить так называемую инверсию. Это означает, что края коффердама подворачиваются вокруг шейки зуба. Во-первых они могут так гарантировать абсолютную плотность против влаги. Врач инвертирует&nbsp;с помощью края изогнутой стороны шпателя Хайдеманна таким образом, что эта сторона инструмента подводится под перфорацию и осторожно накладывается на десну. В это же время помощник направляет равномерный поток воздуха в область десневого желобка. Если теперь врач указательным и средним пальцами левой руки легко прижмет коффердам к верхней губе/области десны, используя эффект надувания, и при этом шпатель снова извлечет,&nbsp;край коффердама легко загнется. Если врач предпочитает проводить инверсию с помощью зубного шелка, он протягивает провощенную нить зубного шелка около 30-40 см длиной с обеих сторон в межзубном пространстве, так чтобы она&nbsp;хорошо легла у десневого края с небной стороны. Оба конца нити теперь еще вестибулярно перекрещиваются и легко натягиваются. При этом коффердам подворачивается. Во время инвертирования припудренная сторона коффердама лежит на соответствующем зубе.Если&nbsp;теперь&nbsp;крылышки кламмера&nbsp;на 24 вывести на поверхность коффердама,&nbsp;абсолютная изоляция достигнута. Маленький головчатый штопфер или шпатель Хайдеманна своей, на этот раз поверхностью изогнутой стороны, помещается между латексом и кламмером.&nbsp;Инструмент легко поворачивается влево, затем вправо между пальцами, благодаря чему коффердам, как по мановению волшебной руки, находит свой путь под кламмер.</font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">1-наложение кламмера вместе с рамкой </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;2-коффердам одевается </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;3-кламмер выводится на поверхность коффердама </font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;4-инвертирование (можно только с помощью нитей) </font></span><span style="font-size: 10pt"><font face="Times New Roman">&nbsp;<strong><span style="color: black">Изоляция от влаги</span></strong></font></span><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-зафиксированных мостовидных протезов</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-при запечатывании фиссур в постоянных молярах у детей</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black; font-family: Symbol"><span>&middot;<span style="font: 7pt &#39;Times New Roman&#39;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><font face="Times New Roman"><span style="font-size: 10pt; color: black">-для удаления амальгамы</span><span style="font-size: 10pt"> </span></font><span style="font-size: 10pt; color: black"><font face="Times New Roman">Для этих показаний хорошо использовать третью технику. Перед началом необходимо принять во внимание следующее: чем туже выбирается коффердам, тем лучше он прилежит. При наличии мостовидных протезов нет никаких шансов ввести коффердам в межзубные промежутки, в этих случаях применяется так называемое длинное отверстие. Также при запечатывании фиссур под коффердамом приемлемо использование длинного отверстия. Пластина коффердама накладывается своей гладкой стороной на шаблон, а на припудренной поверхности отмечается область, подлежащая изоляции. Затем в этой зоне с помощью отверстия № 2 щипцами-перфоратором создается длинное отверстие. У детей следует рекомендовать прежде всего следующий метод. Сначала пластина коффердама натягивается на изолируемые зубы. Затем дистально перед последним изолируемым зубом втягивается отрезок коффердама, дам зафиксирован на этой стороне. Затем он должен быть подвернут/закручен вниз через потягивание от 1-2 зубов, в то же время его надо подтянуть вверх. Помощник в это же время должен уже зафиксировать в кламмерных щипцах кламмер для моляра (например: № 7, 8, 200 или 18). С помощью этого метода от слюны изолируется не каждый отдельный зуб, а зафиксированный мостовидный протез или достигается изоляция от, например, 26, 27 для запечатывания фиссур, наиболее желательно накладывать коффердам через перфорацию в виде длинного отверстия дистально на 27 и тянуть медиально до 25, так чтобы в этом длинном отверстии на поверхности коффердама находились 27, 26, 25. Отрезок коффердама втягивается медиально перед 25 для фиксации его на этой стороне. Кламмер для моляров для окончательной фиксации накладывается на 27. В области моляров для лучшей видимости чаще всего желательно кламмер вначале накладывать палатинально у десневого края.&nbsp;Затем рабочей рукой производится давление на щипцы,&nbsp; чтобы раскрытый кламмер наложить через окклюзионную поверхность и экватор зуба до десневого края со щечной стороны. Коффердам зафиксирован и теперь свисающая перед полостью рта пластина должна&nbsp;быть натянута на рамку. Если не получается сложить коффердам в виде кармашка, врачу о', 0, 1, 23, 'kivdent', '', 0, 'russian', 0, 0, 0, 0, 0, '0', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_stories_cat`
-- 

CREATE TABLE `nuke_stories_cat` (
  `catid` int(11) NOT NULL auto_increment,
  `title` varchar(20) NOT NULL default '',
  `counter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`catid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `nuke_stories_cat`
-- 

INSERT INTO `nuke_stories_cat` (`catid`, `title`, `counter`) VALUES (1, 'Новости', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_subscriptions`
-- 

CREATE TABLE `nuke_subscriptions` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) default '0',
  `subscription_expire` varchar(50) NOT NULL default '',
  KEY `id` (`id`,`userid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_subscriptions`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_topics`
-- 

CREATE TABLE `nuke_topics` (
  `topicid` int(3) NOT NULL auto_increment,
  `topicname` varchar(20) default NULL,
  `topicimage` varchar(100) NOT NULL default '',
  `topictext` varchar(40) default NULL,
  `counter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`topicid`),
  KEY `topicid` (`topicid`)
) TYPE=MyISAM AUTO_INCREMENT=26 ;

-- 
-- Дамп данных таблицы `nuke_topics`
-- 

INSERT INTO `nuke_topics` (`topicid`, `topicname`, `topicimage`, `topictext`, `counter`) VALUES (23, 'терапия', 'tooth.jpg', 'Стстьи по терапии', 1),
(22, 'Общая информация', 'tooth.jpg', 'Общая информация', 1),
(24, 'ортодонтия', 'tooth.jpg', 'Статьи по ортодонтии', 1),
(25, 'ортопедия', 'tooth.jpg', 'Статьи по ортопедии', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_users`
-- 

CREATE TABLE `nuke_users` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `user_email` varchar(255) NOT NULL default '',
  `femail` varchar(255) NOT NULL default '',
  `user_website` varchar(255) NOT NULL default '',
  `user_avatar` varchar(255) NOT NULL default '',
  `user_regdate` varchar(20) NOT NULL default '',
  `user_icq` varchar(15) default NULL,
  `user_occ` varchar(100) default NULL,
  `user_from` varchar(100) default NULL,
  `user_interests` varchar(150) NOT NULL default '',
  `user_sig` varchar(255) default NULL,
  `user_viewemail` tinyint(2) default NULL,
  `user_theme` int(3) default NULL,
  `user_aim` varchar(18) default NULL,
  `user_yim` varchar(25) default NULL,
  `user_msnm` varchar(25) default NULL,
  `user_password` varchar(40) NOT NULL default '',
  `storynum` tinyint(4) NOT NULL default '10',
  `umode` varchar(10) NOT NULL default '',
  `uorder` tinyint(1) NOT NULL default '0',
  `thold` tinyint(1) NOT NULL default '0',
  `noscore` tinyint(1) NOT NULL default '0',
  `bio` tinytext NOT NULL,
  `ublockon` tinyint(1) NOT NULL default '0',
  `ublock` tinytext NOT NULL,
  `theme` varchar(255) NOT NULL default '',
  `commentmax` int(11) NOT NULL default '4096',
  `counter` int(11) NOT NULL default '0',
  `newsletter` int(1) NOT NULL default '0',
  `user_posts` int(10) NOT NULL default '0',
  `user_attachsig` int(2) NOT NULL default '0',
  `user_rank` int(10) NOT NULL default '0',
  `user_level` int(10) NOT NULL default '1',
  `broadcast` tinyint(1) NOT NULL default '1',
  `popmeson` tinyint(1) NOT NULL default '0',
  `user_active` tinyint(1) default '1',
  `user_session_time` int(11) NOT NULL default '0',
  `user_session_page` smallint(5) NOT NULL default '0',
  `user_lastvisit` int(11) NOT NULL default '0',
  `user_timezone` tinyint(4) NOT NULL default '10',
  `user_style` tinyint(4) default NULL,
  `user_lang` varchar(255) NOT NULL default 'english',
  `user_dateformat` varchar(14) NOT NULL default 'D M d, Y g:i a',
  `user_new_privmsg` smallint(5) unsigned NOT NULL default '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL default '0',
  `user_last_privmsg` int(11) NOT NULL default '0',
  `user_emailtime` int(11) default NULL,
  `user_allowhtml` tinyint(1) default '1',
  `user_allowbbcode` tinyint(1) default '1',
  `user_allowsmile` tinyint(1) default '1',
  `user_allowavatar` tinyint(1) NOT NULL default '1',
  `user_allow_pm` tinyint(1) NOT NULL default '1',
  `user_allow_viewonline` tinyint(1) NOT NULL default '1',
  `user_notify` tinyint(1) NOT NULL default '0',
  `user_notify_pm` tinyint(1) NOT NULL default '0',
  `user_popup_pm` tinyint(1) NOT NULL default '0',
  `user_avatar_type` tinyint(4) NOT NULL default '3',
  `user_sig_bbcode_uid` varchar(10) default NULL,
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(32) default NULL,
  `points` int(10) default '0',
  `last_ip` varchar(15) NOT NULL default '0',
  `karma` tinyint(1) default '0',
  PRIMARY KEY  (`user_id`),
  KEY `uid` (`user_id`),
  KEY `uname` (`username`),
  KEY `user_session_time` (`user_session_time`),
  KEY `karma` (`karma`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `nuke_users`
-- 

INSERT INTO `nuke_users` (`user_id`, `name`, `username`, `user_email`, `femail`, `user_website`, `user_avatar`, `user_regdate`, `user_icq`, `user_occ`, `user_from`, `user_interests`, `user_sig`, `user_viewemail`, `user_theme`, `user_aim`, `user_yim`, `user_msnm`, `user_password`, `storynum`, `umode`, `uorder`, `thold`, `noscore`, `bio`, `ublockon`, `ublock`, `theme`, `commentmax`, `counter`, `newsletter`, `user_posts`, `user_attachsig`, `user_rank`, `user_level`, `broadcast`, `popmeson`, `user_active`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_timezone`, `user_style`, `user_lang`, `user_dateformat`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_avatar_type`, `user_sig_bbcode_uid`, `user_actkey`, `user_newpasswd`, `points`, `last_ip`, `karma`) VALUES (1, '', 'Anonymous', '', '', '', 'blank.gif', 'Mar 18, 2006', '', '', '', '', '', 0, 0, '', '', '', '', 10, '', 0, 0, 0, '', 0, '', '', 4096, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'russian', 'D M d, Y g:i a', 0, 0, 0, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 0, 3, NULL, NULL, NULL, 0, '0', 0),
(2, '', 'kivdent', 'kivdent@yandex.ru', '', '', 'gallery/blank.gif', 'Jan 31, 2007', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '597cb1c46559ed712d13061c0e80e6af', 10, '', 0, 0, 0, '', 0, '', '', 4096, 0, 0, 0, 0, 0, 2, 1, 0, 1, 0, 0, 0, 10, NULL, 'russian', 'D M d, Y g:i a', 0, 0, 0, NULL, 1, 1, 1, 1, 1, 1, 0, 0, 0, 3, NULL, NULL, NULL, 0, '192.168.0.1', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `nuke_users_temp`
-- 

CREATE TABLE `nuke_users_temp` (
  `user_id` int(10) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL default '',
  `user_email` varchar(255) NOT NULL default '',
  `user_password` varchar(40) NOT NULL default '',
  `user_regdate` varchar(20) NOT NULL default '',
  `check_num` varchar(50) NOT NULL default '',
  `time` varchar(14) NOT NULL default '',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `nuke_users_temp`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `patpay`
-- 

CREATE TABLE `patpay` (
  `payID` int(11) NOT NULL auto_increment,
  `sirName` varchar(20) NOT NULL default '',
  `payd` int(11) NOT NULL default '0',
  `dolg` int(11) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`payID`)
) TYPE=MyISAM COMMENT='таблица долгов' AUTO_INCREMENT=7 ;

-- 
-- Дамп данных таблицы `patpay`
-- 

INSERT INTO `patpay` (`payID`, `sirName`, `payd`, `dolg`, `date`, `time`) VALUES (1, 'Иванов', 1500, 0, '0000-00-00', '00:00:00'),
(2, 'Петров', 1500, 1500, '0000-00-00', '00:00:00'),
(3, 'Сидоров', 5000, 120, '0000-00-00', '00:00:00'),
(4, 'Никоноров', 1204, 42, '0000-00-00', '00:00:00'),
(5, 'иванов', 100, 1000, '2007-02-08', '00:00:20'),
(6, 'Петров', 1500, 500, '2007-02-08', '00:00:20');

-- --------------------------------------------------------

-- 
-- Структура таблицы `polzov`
-- 

CREATE TABLE `polzov` (
  `login` varchar(20) NOT NULL default '',
  `pass` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`login`),
  KEY `pass` (`pass`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `polzov`
-- 

INSERT INTO `polzov` (`login`, `pass`) VALUES ('admin', '732588');

-- --------------------------------------------------------

-- 
-- Структура таблицы `skidka`
-- 

CREATE TABLE `skidka` (
  `id` int(11) NOT NULL auto_increment,
  `naimenov` varchar(20) NOT NULL default '',
  `uslov` text NOT NULL,
  `proc` char(2) NOT NULL default '',
  `uslugi` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `naimenov` (`naimenov`)
) TYPE=MyISAM COMMENT='Crblrb yf eckeub' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `skidka`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `sotr`
-- 

CREATE TABLE `sotr` (
  `id` int(11) NOT NULL auto_increment,
  `surname` varchar(25) NOT NULL default '',
  `name` varchar(15) NOT NULL default '',
  `otch` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `surname` (`surname`)
) TYPE=MyISAM COMMENT='Сотрудники' AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `sotr`
-- 

INSERT INTO `sotr` (`id`, `surname`, `name`, `otch`) VALUES (1, 'Корчемный', 'Владимир', 'Маркович'),
(2, 'Черненко', 'Сергей', 'Владимирович');

-- --------------------------------------------------------

-- 
-- Структура таблицы `users`
-- 

CREATE TABLE `users` (
  `login` varchar(30) NOT NULL default '',
  `pass` varchar(40) NOT NULL default '',
  `UsarPrava` varchar(20) NOT NULL default '',
  `sotr` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`login`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `users`
-- 

INSERT INTO `users` (`login`, `pass`, `UsarPrava`, `sotr`) VALUES ('admin', '732588', 'administrator', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `usersprava`
-- 

CREATE TABLE `usersprava` (
  `id` int(11) NOT NULL auto_increment,
  `Nazv` varchar(15) NOT NULL default '',
  `alias` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Дамп данных таблицы `usersprava`
-- 

INSERT INTO `usersprava` (`id`, `Nazv`, `alias`) VALUES (1, 'administrator', 'Администратор'),
(2, 'terapevt', ''),
(3, 'ortoped', ''),
(4, 'ortodont', ''),
(5, 'registrator', ''),
(6, 'buhg', ''),
(7, 'stms', '');
