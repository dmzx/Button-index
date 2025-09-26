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
	'BUTTONINDEX_ENABLE'                   => 'Enable Button index',
	'BUTTONINDEX_ENABLE_EXPLAIN'           => 'Enable the button index buttons.',
	'BUTTONINDEX_NAME'                     => 'Button menu name',
	'BUTTONINDEX_URL'                      => 'Set URL',
	'BUTTONINDEX_URL_EXPLAIN'              => 'Add the URL.',
	'BUTTONINDEX_FAV'                      => 'Add the favicon name',
	'BUTTONINDEX_FAV_EXPLAIN'              => 'Enter favicon name here.',
	'BUTTONINDEX_EDIT'                     => 'Edit button',
	'BUTTONINDEX_ADD'                      => 'Add button',
	'BUTTONINDEX_ADDED'                    => 'Added button',
	'BUTTONINDEX_UPDATED'                  => 'Updated button index buttons',
	'BUTTONINDEX_ERROR'                    => 'Error, fill all fields',
	'BUTTONINDEX_NO_BUTTON'                => 'No Buttons menu yet',
	'BUTTONINDEX_SAVED'                    => 'Button menu saved',
	'BUTTONINDEX_URL_ACP'                  => 'Url entered',
	'BUTTONINDEX_FAV_ACP'                  => 'Favicon entered',
	'BUTTONINDEX_STYLE_ENABLE'             => 'Enable fancy styled buttons',
	'BUTTONINDEX_STYLE_ENABLE_EXPLAIN'     => 'Gives all buttons a fancy border radius.',
	'BUTTONINDEX_UCP_ENABLE'               => 'Enable ucp buttons',
	'BUTTONINDEX_UCP_ENABLE_EXPLAIN'       => 'Enables ucp buttons with an animated fade to site buttons.',
	'BUTTONINDEX_IMAGE_ENABLE'             => 'Enable images in site buttons',
	'BUTTONINDEX_IMAGE_ENABLE_EXPLAIN'     => 'Enable to show images instead of icons in the site buttons.',
	'BUTTONINDEX_IMAGE_ERROR'              => 'The file %s failed to upload.',
	'BUTTONINDEX_IMAGE_FILE_ERROR'         => 'The file %s failed.',
	'BUTTONINDEX_IMAGE_DELETED'            => 'Deleted image',
	'BUTTONINDEX_IMAGES_SECTION'           => 'Image section',
	'BUTTONINDEX_IMAGE_UPLOAD'             => 'Upload image/icon',
	'BUTTONINDEX_IMAGE_UPLOAD_EXPLAIN'     => 'Allowed: %s',
	'BUTTONINDEX_IMAGE_FOLDER'             => 'Image folder',
	'BUTTONINDEX_IMAGE_FOLDER_EXPLAIN'     => 'Change image folder.',
	'BUTTONINDEX_FLAGS'                    => 'Find flags here',
	'BUTTONINDEX_BOX_ENABLE'               => 'Enable forabg wrapper',
	'BUTTONINDEX_BOX_ENABLE_EXPLAIN'       => 'Wraps the buttons in a forabg class div.',
	'BUTTONINDEX_COLLAPSE_ENABLE'          => 'Enable buttons collapse',
	'BUTTONINDEX_COLLAPSE_ENABLE_EXPLAIN'  => 'Collapse the buttons in the wrapper.',
]);
