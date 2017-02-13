<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $buttonindex_table;

	/**
	* Constructor
	*
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\db\driver\driver_interface 		$db
	* @param \phpbb\request\request					$request
	* @param string									$buttonindex_table
	*/
	public function __construct(
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		$buttonindex_table
	)
	{
		$this->template 			= $template;
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->buttonindex_table 	= $buttonindex_table;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.page_header' 	=> 'page_header',
		);
	}

	public function page_header($event)
	{
		$sql = 'SELECT *
			FROM ' . $this->buttonindex_table;
		$result	 = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		if ($row['buttonindex_enable'])
		{
			$this->template->assign_vars(array(
				'BUTTONINDEX_ENABLE'	=> $row['buttonindex_enable'],
			));

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!empty($row['buttonindex']))
				{
					$this->template->assign_block_vars('buttonindex', array(
						'BUTTONINDEX'		=> $row['buttonindex'],
						'BUTTONINDEX_TEXT'	=> $row['buttonindex_text'],
					));
				};
			}
		}
		$this->db->sql_freeresult($result);
	}
}
