<?php
/**
*
* @package phpBB Extension - Button Index
* @copyright (c) 2025 dmzx - https://www.dmzx-web.net/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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

$lang = array_merge($lang, [
	'UCP_SHORT'			    => 'UCP',
	'UCP_MAIN'			    => 'Overview',
	'UCP_PROFILE'			=> 'Profile',
	'UCP_PREFS'			    => 'Board Prferences',
	'UCP_PRIVAT_MESSAGE'	=> 'Private Messages',
	'UCP_USER_GROUPS'		=> 'Usergroups',
	'UCP_FECKTURDS'			=> 'Friends & Foes',
	'UCP_VIDEO'			    => 'Video Gallery',
	'UCP_UPLOADED'			=> 'Uploaded Images',
	'UCP_MCHAT'			    => 'Mchat',
	'UCP_DISABLED'			=> 'Options Disabled',
	'BUTTONINDEX_VERSION'	=> 'Version',
	'LISTED_KEY'			=> 'Listed Keys',
	'UCP_USER_FILES'		=> 'Uploaded Files',
	'UCP_DONATION'			=> 'Donations',
	'LINKS_INFO'            => 'Button index',
]);
