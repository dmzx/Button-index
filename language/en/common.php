<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	//ACP
	'ACP_BUTTONINDEX_TITLE'				=> 'Button index',
	'ACP_BUTTONINDEX_CONFIG'			=> 'Settings',
	'BUTTONINDEX_ENABLE'				=> 'Enable Button index',
	'BUTTONINDEX_ENABLE_EXPLAIN'		=> 'Enable the Button on index extension.',
	'BUTTONINDEX_PLACEHOLDER'			=> 'http://www.google.com',
	'BUTTONINDEX_PLACEHOLDER_NAME'		=> 'Button name',
	'BUTTONINDEX_REPOSITORY'			=> 'Set URL',
	'BUTTONINDEX_REPOSITORY_EXPLAIN'	=> 'Add the URL and button name.<br /> URL can be relative like <em>viewforum.php?f=2</em>',
	'BUTTONINDEX_REPOSITORY_TEXT'		=> 'Button name',
	'BUTTONINDEX_MORE_LINKS'			=> 'Add button',
	'LOG_BUTTONINDEX_SAVE'				=> '<strong>Settings Button index changed</strong>' ,
	'BUTTONINDEX_SAVED'					=> 'Button index settings saved',
	'BUTTONINDEX_VERSION'				=> 'Version',
	'BUTTONINDEX_VERSION_CHECK'			=> 'Button index Version Check',
	'BUTTONINDEX_AUTHOR'				=> 'Authors',
	'BUTTONINDEX_ANNOUNCEMENT_TOPIC'	=> 'Release Announcement',
	'BUTTONINDEX_CURRENT_VERSION'		=> 'Current Version',
	'BUTTONINDEX_VERSION'				=> 'Version',
	'BUTTONINDEX_DOWNLOAD_LATEST'		=> 'Download Latest Version',
	'BUTTONINDEX_DOWNLOAD'				=> 'Download',
	'BUTTONINDEX_LATEST_VERSION'		=> 'Latest Version',
	'BUTTONINDEX_NOT_UP_TO_DATE'		=> '%s is not up to date',
	'BUTTONINDEX_RELEASE_ANNOUNCEMENT'	=> 'Announcement Topic',
	'BUTTONINDEX_UP_TO_DATE'			=> '%s is up to date',
));
