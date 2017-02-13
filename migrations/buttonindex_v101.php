<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\migrations;

class buttonindex_v101 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\buttonindex\migrations\buttonindex_install',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('buttonindex_version', '1.0.1')),
		);
	}
}
