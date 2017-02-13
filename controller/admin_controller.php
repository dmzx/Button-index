<?php
/**
*
* @package phpBB Extension - Button index
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\controller;

class admin_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $buttonindex_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config											$config
	 * @param \phpbb\template\template										$template
	 * @param \\phpbb\log\log_interface										$log
	 * @param \phpbb\user													$user
	 * @param \phpbb\db\driver\driver_interface								$db
	 * @param \phpbb\request\request										$request
	 * @param string														$buttonindex_table
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\log\log_interface $log,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		$buttonindex_table
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->buttonindex_table 	= $buttonindex_table;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		add_form_key('acp_buttonindex');

		$this->user->add_lang_ext('dmzx/buttonindex', 'acp_buttonindex');

		$sql = 'SELECT *
			FROM '. $this->buttonindex_table;
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if (!empty($row['buttonindex']))
			{
				$this->template->assign_block_vars('buttonindex', array(
					'BUTTONINDEX'		=> $row['buttonindex'],
					'BUTTONINDEX_TEXT'	=> $row['buttonindex_text'],
				));
			};
		};

		if (empty($row['buttonindex']))
		{
			$this->template->assign_block_vars('buttonindex', array(
				'BUTTONINDEX' => '',
			));
		};

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_buttonindex'))
			{
				trigger_error('FORM_INVALID');
			}

			$this->db->sql_query('TRUNCATE TABLE ' . $this->buttonindex_table);

			if (!$row['buttonindex_id'])
			{
				$sql_arr_id = array(
					'buttonindex_id' => '1',
				);
				$sql = 'INSERT INTO ' . $this->buttonindex_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr_id);
				$this->db->sql_query($sql);
			};

			$buttonindex 		= $this->request->variable('buttonindex', array('' => ''),true);
			$buttonindex_text 	= $this->request->variable('buttonindex_text', array('' => ''),true);
			$buttonindex			= array_merge(array_filter($buttonindex));

			$i = 0;
			while ($i < count($buttonindex))
			{
				$buttonindex[$i] = $buttonindex[$i];

				$sql_ary1 = array(
					'buttonindex' 		=> $buttonindex[$i],
					'buttonindex_text' 	=> $buttonindex_text[$i],
				);
				$this->db->sql_multi_insert($this->buttonindex_table, $sql_ary1);
				$i++;
			}

			$sql_ary_block = array(
				'buttonindex_enable' => $this->request->variable('buttonindex_enable', ''),
			);

			$this->db->sql_query('UPDATE ' . $this->buttonindex_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary_block) . "
				WHERE buttonindex_id =	1"
			);

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BUTTONINDEX_SAVE');

			trigger_error($this->user->lang('BUTTONINDEX_SAVED') . adm_back_link($this->u_action));
		}

		$sql = 'SELECT buttonindex_enable
			FROM ' . $this->buttonindex_table . "
			WHERE buttonindex_id =	1";
		$result = $this->db->sql_query($sql);
		$buttonindex_data = $this->db->sql_fetchrow($result);

		$this->template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'BUTTONINDEX_ENABLE'	=> $buttonindex_data['buttonindex_enable'],
			'BUTTONINDEX_VERSION'	=> $this->config['buttonindex_version'],
		));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
