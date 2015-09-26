<?php
/**
*
* Language [Russian]
*
* @package Topic Articles
* @copyright (c) 2014 Anvar
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'TOPIC_ARTICLE'			=> 'Статья',
	'TOPIC_ARTICLE_POST'	=> '<a href="http://bb3.mobi/forum/viewtopic.php?t=41" title="Статьи форума бесплатно"><span>Статья форума</span></a>',
	'TOPIC_ARTICLE_LINK'	=> 'Сcылка',
	'TOPIC_ARTICLE_BBCODE'	=> 'BBCode',
	'TOPIC_ARTICLE_HTML'	=> 'HTML',
	'ACL_F_ARTICLE'			=> 'Может назначать темы в качестве статьи',
));
