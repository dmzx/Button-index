<?php
/**
*
* @package phpBB Extension - Button Index
* @copyright (c) 2025 dmzx - https://www.dmzx-web.net/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\migrations;

class buttonindex_install extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\dev'];
	}

	public function update_data()
	{
		return [

			['config.add', ['buttonindex_version', '1.0.0']],

			// Add upload directory
			['custom', [[$this, 'upload_directory']]],

			// Add ACP extension category
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BUTTONINDEX_TITLE'
			]],
			// Add ACP module
			['module.add', [
				'acp',
				'ACP_BUTTONINDEX_TITLE',
				[
					'module_basename'	=> '\dmzx\buttonindex\acp\acp_buttonindex_module',
				],
			]],
		];
	}

	public function upload_directory()
	{
		$directory = 'images/sites';
		if (!is_dir($this->phpbb_root_path . $directory))
		{
			@mkdir($this->phpbb_root_path . $directory, 0755);
			@chmod($this->phpbb_root_path . $directory, 0755);
			if (!is_dir($this->phpbb_root_path . $directory))
			{
				$directory = 'sites';
			}
		}
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'buttonindex'	=> [
					'COLUMNS' => [
						'buttonindex_id'		=> ['UINT', null, 'auto_increment'],
						'buttonindex_enable' 	=> ['UINT', '0'],
						'buttonindex'			=> ['VCHAR', ''],
						'buttonindex_text'	    => ['VCHAR', ''],
						'buttonindex_fav'		=> ['VCHAR', ''],
					],
					'PRIMARY_KEY'	=> 'buttonindex_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return 	[
			'drop_tables' => [
				$this->table_prefix . 'buttonindex',
			],
		];
	}
}
