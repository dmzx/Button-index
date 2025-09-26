<?php
/**
*
* @package phpBB Extension - Button Index
* @copyright (c) 2025 dmzx - https://www.dmzx-web.net/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\migrations;

class buttonindex_v103 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\buttonindex\migrations\buttonindex_install',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['buttonindex_version', '1.0.3']],
			['config.add',    ['buttonindex_enable', 0]],
			['config.add',    ['buttonindex_style_enable', 0]],
			['config.add',    ['buttonindex_ucp_enable', 0]],
			['config.add',    ['buttonindex_box_enable', 0]],
			['config.add',    ['buttonindex_collapse_enable', 0]],
			['config.add',    ['buttonindex_image_enable', 0]],
			['config.add',    ['buttonindex_image_folder', 'sites']],
			['config.add',    ['buttonindex_image_file', 0]],
		];
	}
}
