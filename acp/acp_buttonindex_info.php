<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\acp;

class acp_buttonindex_info
{
	function module()
	{
		return array(
			'filename'	=> '\dmzx\buttonindex\acp\acp_buttonindex_module',
			'title'		=> 'ACP_BUTTONINDEX_TITLE',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_BUTTONINDEX_CONFIG', 'auth' => 'ext_dmzx/buttonindex && acl_a_board', 'cat'	=> array('ACP_BUTTONINDEX_CONFIG')),
			),
		);
	}
}
