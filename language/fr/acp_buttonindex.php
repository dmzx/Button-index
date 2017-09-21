<?php
/**
 *
 * Button index. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 dmzx <http://www.dmzx-web.net>
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'BUTTONINDEX_ENABLE'				=> 'Activer « Boutons sur l’index »',
	'BUTTONINDEX_ENABLE_EXPLAIN'		=> 'Permet d’activer l’affichage des boutons sur la page de l’index du forum.',
	'BUTTONINDEX_PLACEHOLDER'			=> 'Adresse URL, telle que : http://www.siteweb.fr',
	'BUTTONINDEX_PLACEHOLDER_NAME'		=> 'Texte du nom du bouton',
	'BUTTONINDEX_REPOSITORY'			=> 'Adresse URL',
	'BUTTONINDEX_REPOSITORY_EXPLAIN'	=> 'Permet de saisir l’adresse URL du bouton.<br /> L’adresse URL peut être relative, telle que : <em>viewforum.php?f=2</em>.',
	'BUTTONINDEX_REPOSITORY_TEXT'		=> 'Nom du bouton',
	'BUTTONINDEX_MORE_LINKS'			=> 'Créer ce bouton',
	'BUTTONINDEX_SAVED'					=> 'Les paramètres de « Boutons sur l’index » ont été sauvegardés avec succès !',
	'BUTTONINDEX_VERSION'				=> 'Version',
));
