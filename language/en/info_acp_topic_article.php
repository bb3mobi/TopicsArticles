<?php
/**
*
* Language [English]
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
	'L_TOPIC_ARTICLE'	=> 'Article',
	'ACL_F_ARTICLE'		=> 'Can assign topics as Article',
));
