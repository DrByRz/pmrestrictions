<?php
/**
 *
 * PM Restrictions. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
$lang = array_merge($lang, array(
	'PM_POST_LIMIT'			=> 'Gereken gönderi',
	'PM_POST_LIMIT_EXPLAIN'	=> 'Bir kullanıcının diğer kullanıcılara ÖM gönderebilmeden önce sahip olması gereken gönderi sayısı. Değeri 0 ayarlamak bu özelliği kapatır.',
	'PM_TEAM_MEMBERS'		=> 'Bu sitedeki kısıtlama nedeniyle yalnızca <a href="%s">takım üyelerine</a> ÖM gönderebilirsiniz.',
	/*'PM_POST_LIMIT_ERROR'	=> array(
		1	=> 'Bu sitedeki kısıtlama nedeniyle kullanıcılar en az %d gönderiye sahip olmalı ve kayıt tarihi üzerinden 24 saatten daha fazla zaman geçmiş olması gerekmekte. Halen Takım Üyelerine ÖM <strong>gönderebilirsiniz</strong>.',
		2	=> 'Bu sitedeki kısıtlama nedeniyle kullanıcılar en az %d gönderiye sahip olmalı ve kayıt tarihi üzerinden 24 saatten daha fazla zaman geçmiş olması gerekmekte. Halen Takım Üyelerine ÖM <strong>gönderebilirsiniz</strong>.',
	),*/
));
