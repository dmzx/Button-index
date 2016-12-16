<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\migrations;

class buttonindex_install extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('buttonindex_version', '1.0.0')),

			// Add ACP extension category
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BUTTONINDEX_TITLE'
			)),
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_BUTTONINDEX_TITLE',
				array(
					'module_basename'	=> '\dmzx\buttonindex\acp\acp_buttonindex_module',
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'buttonindex'	=> array(
					'COLUMNS' => array(
						'buttonindex_id'		=> array('UINT', null, 'auto_increment'),
						'buttonindex_enable' 	=> array('UINT', '0'),
						'buttonindex'			=> array('VCHAR', ''),
						'buttonindex_text'		=> array('VCHAR', ''),
					),
					'PRIMARY_KEY'	=> 'buttonindex_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'buttonindex',
			),
		);
	}
}
