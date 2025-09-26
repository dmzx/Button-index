<?php
/**
*
* @package phpBB Extension - Button Index
* @copyright (c) 2025 dmzx - https://www.dmzx-web.net/
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

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string */
	protected $buttonindex_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\template\template				$template
	 * @param \\phpbb\log\log_interface				$log
	 * @param \phpbb\user							$user
	 * @param \phpbb\db\driver\driver_interface		$db
	 * @param \phpbb\request\request				$request
	 * @param \phpbb\path_helper 					$path_helper
	 * @param string								$root_path
	 * @param string								$buttonindex_table
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\log\log_interface $log,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		\phpbb\path_helper $path_helper,
		string $root_path,
		$buttonindex_table
	)
	{
		$this->config 				    = $config;
		$this->template 			    = $template;
		$this->log 				        = $log;
		$this->user 				    = $user;
		$this->db 				        = $db;
		$this->request 				    = $request;
		$this->path_helper 			    = $path_helper;
		$this->root_path 			    = $root_path;
		$this->buttonindex_table 		= $buttonindex_table;
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

		// Create an array to collect errors that will be output to the user
		$errors = [];

		// Determine board url - we may need it later
		$board_url = generate_board_url() . '/';
		$corrected_path = $this->path_helper->get_web_root_path();
		$image_path = ((defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $corrected_path) . 'images/' . $this->config['buttonindex_image_folder'] . '/';

		if (!is_dir($image_path))
		{
			$this->recursive_mkdir($image_path, 0775);
		}

		$this->user->add_lang_ext('dmzx/buttonindex', 'acp_buttonindex');

		$submit_buttons 		        = $this->request->is_set_post('submit');
		$submit_settings 		        = $this->request->is_set_post('enable_submit');
		$submit_images 			        = $this->request->is_set_post('submit_images');
		$edit_id 			            = $this->request->variable('edit', 0);
		$buttonindex_enable 		    = $this->request->variable('buttonindex_enable', 0);
		$buttonindex_style_enable       = $this->request->variable('buttonindex_style_enable', 0);
		$buttonindex_ucp_enable 	    = $this->request->variable('buttonindex_ucp_enable', 0);
		$buttonindex_box_enable 	    = $this->request->variable('buttonindex_box_enable', 0);
		$buttonindex_collapse_enable    = $this->request->variable('buttonindex_collapse_enable', 0);
		$buttonindex_image_enable       = $this->request->variable('buttonindex_image_enable', 0);

		// Handle image deletion
		$delete_image = $this->request->variable('delete_image', '');
		if ($delete_image)
		{
			$image_to_delete = $image_path . basename($delete_image);
			if (file_exists($image_to_delete))
			{
				unlink($image_to_delete);
				meta_refresh(1, append_sid($this->u_action));
				trigger_error($this->user->lang['BUTTONINDEX_IMAGE_DELETED'] . adm_back_link($this->u_action));
			}
		}

		// Is the form settings being submitted to us?
		if ($submit_settings)
		{
			if (!check_form_key('acp_buttonindex'))
			{
				$errors[] = $this->user->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				$this->config->set('buttonindex_enable', $buttonindex_enable);
				$this->config->set('buttonindex_style_enable', $buttonindex_style_enable);
				$this->config->set('buttonindex_ucp_enable', $buttonindex_ucp_enable);
				$this->config->set('buttonindex_box_enable', $buttonindex_box_enable);
				$this->config->set('buttonindex_collapse_enable', $buttonindex_collapse_enable);
				$this->config->set('buttonindex_image_enable', $buttonindex_image_enable);

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_BUTTONINDEX_SETTINGS');

				meta_refresh(1, append_sid($this->u_action));
				trigger_error($this->user->lang['BUTTONINDEX_SAVED'] . adm_back_link($this->u_action));
			}
		}

		// Is the form buttons being submitted to us?
		if ($submit_buttons)
		{
			if (!check_form_key('acp_buttonindex'))
			{
				$errors[] = $this->user->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				$name = $this->db->sql_escape($this->request->variable('name', '', true));
				$url = $this->db->sql_escape($this->request->variable('url', ''));
				$fav = $this->db->sql_escape($this->request->variable('fav', ''));

				if ($name && $url && !$edit_id)
				{
					$sql_array = [
						'buttonindex_text' 		=> $name,
						'buttonindex'			=> $url,
						'buttonindex_fav'		=> $fav
					];

					$sql = 'INSERT INTO ' . $this->buttonindex_table . ' ' . $this->db->sql_build_array('INSERT', $sql_array);
					$this->db->sql_query($sql);

					// Add option settings change action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_BUTTONINDEX_ADDED_BUTTON');

					meta_refresh(1, append_sid($this->u_action));
					trigger_error($this->user->lang['BUTTONINDEX_ADDED'] . adm_back_link($this->u_action));
				}
				elseif ($name && $url && $edit_id)
				{
					$sql_array = [
						'buttonindex_text' 		=> $name,
						'buttonindex'	 		=> $url,
						'buttonindex_fav'	 	=> $fav
					];

					$sql = 'UPDATE ' . $this->buttonindex_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_array) . ' WHERE buttonindex_id = ' . (int) $edit_id;
					$this->db->sql_query($sql);

					// Add option settings change action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_BUTTONINDEX_UPDATED_BUTTON');

					meta_refresh(1, append_sid($this->u_action));
					trigger_error($this->user->lang['BUTTONINDEX_UPDATED'] . adm_back_link($this->u_action));
				}
				else
				{
					meta_refresh(1, append_sid($this->u_action));
					trigger_error($this->user->lang['BUTTONINDEX_ERROR'] . adm_back_link($this->u_action . '&amp;action=add'), E_USER_WARNING);
				}
			}
		}

		$action = $this->request->variable('action', '');
		$buttonindex_id = $this->request->variable('id', 0);

		// Actions edit/delete buttons
		if ($action && $buttonindex_id != 0)
		{
			switch ($action)
			{
				case 'edit':
				$sql = 'SELECT *
						FROM ' . $this->buttonindex_table . '
						WHERE buttonindex_id = ' . (int) $buttonindex_id;
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);

				$this->template->assign_vars([
					'BUTTONINDEX_TEXT'		    => $row['buttonindex_text'],
					'BUTTONINDEX'				=> $row['buttonindex'],
					'BUTTONINDEX_FAV'			=> $row['buttonindex_fav'],
					'BUTTONINDEX_ID'			=> $row['buttonindex_id']
				]);
				$this->db->sql_freeresult($result);
				break;

				case 'delete':
				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $this->buttonindex_table . ' WHERE buttonindex_id = ' . (int) $buttonindex_id;
					$this->db->sql_query($sql);
					redirect($this->u_action);
				}
				else
				{
					confirm_box(false, $this->user->lang['CONFIRM_OPERATION'], build_hidden_fields([
						'action' => $action,
						'id'	 => $buttonindex_id
					]));
				}
				break;
			}
		}

		// Is the form images being submitted to us?
		if ($submit_images)
		{
			if (!check_form_key('acp_buttonindex'))
			{
				$errors[] = $this->user->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				// Upload images/logo
				$file = $this->request->file('buttonindex_image_logo_upload');
				if ($file['error'] == UPLOAD_ERR_OK)
				{
					$destination = $image_path;
					if (!$this->upload($file, $destination))
					{
						meta_refresh(1, append_sid($this->u_action));
						trigger_error($this->user->lang('BUTTONINDEX_IMAGE_ERROR', $file['name']) . adm_back_link($this->u_action), E_USER_WARNING);
					}
				}
				else if ($file['error'] != UPLOAD_ERR_NO_FILE)
				{
					meta_refresh(1, append_sid($this->u_action));
					trigger_error($this->user->lang('BUTTONINDEX_IMAGE_FILE_ERROR', $file['name']) . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_BUTTONINDEX_IMAGES');

				meta_refresh(1, append_sid($this->u_action));
				trigger_error($this->user->lang['BUTTONINDEX_SAVED'] . adm_back_link($this->u_action));
			}
		}

		// Get the buttons
		$sql = 'SELECT *
			FROM '. $this->buttonindex_table . '
				ORDER BY buttonindex_id ASC';
		$result = $this->db->sql_query($sql);

		$row_count = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('buttonindex', [
				'BUTTONINDEX_ID'		=> $row['buttonindex_id'],
				'BUTTONINDEX'			=> $row['buttonindex'],
				'BUTTONINDEX_TEXT'	    => $row['buttonindex_text'],
				'BUTTONINDEX_FAV'		=> $row['buttonindex_fav'],
				'U_EDIT'			    => $this->u_action . "&amp;id=" . $row['buttonindex_id'] . "&amp;action=edit",
				'U_DELETE'			    => $this->u_action . "&amp;id=" . $row['buttonindex_id'] . "&amp;action=delete"
			]);
			$row_count++;
		};
		$this->db->sql_freeresult($result);

		$s_errors = !empty($errors);

		// Get the image files from the folder
		$image_files = [];
		if (is_dir($image_path))
		{
			$files = scandir($image_path);
			foreach ($files as $file)
			{
				if ($this->allowedExtension($file))
				{
					$image_files[] = [
						'name' => $file,
						'path' => $image_path . $file,
					];
				}
			}
		}

		// Set the allowed extensions for display in the template
		$allowed_extensions = implode(', ', $this->allowedExtension(''));

		// Set output variables for display in the template
		$this->template->assign_vars([
			'S_ERROR'				            => $s_errors,
			'ERROR_MSG'				            => $s_errors ? implode('<br />', $errors) : '',
			'S_ROW_COUNT'				        => $row_count,
			'S_BUTTONINDEX_ENABLE'			    => $this->config['buttonindex_enable'],
			'S_BUTTONINDEX_STYLE_ENABLE'		=> $this->config['buttonindex_style_enable'],
			'S_BUTTONINDEX_UCP_ENABLE'		    => $this->config['buttonindex_ucp_enable'],
			'S_BUTTONINDEX_BOX_ENABLE'		    => $this->config['buttonindex_box_enable'],
			'S_BUTTONINDEX_COLLAPSE_ENABLE'	    => $this->config['buttonindex_collapse_enable'],
			'S_BUTTONINDEX_IMAGE_ENABLE'		=> $this->config['buttonindex_image_enable'],
			'BUTTONINDEX_VERSION'			    => $this->config['buttonindex_version'],
			'BUTTONINDEX_IMAGE_FOLDER'		    => $this->config['buttonindex_image_folder'],
			'IMAGE_FILES'				        => $image_files,
			'U_DELETE_IMAGE'			        => $this->u_action . "&amp;delete_image=",
			'BUTTONINDEX_ALLOWED_EXTENSIONS'	=> sprintf($this->user->lang['BUTTONINDEX_IMAGE_UPLOAD_EXPLAIN'], $allowed_extensions)
		]);
	}

	public function rename_folder()
	{
		$buttonindex_image_folder = $this->request->variable('buttonindex_image_folder', 'sites');

		if (strpbrk($buttonindex_image_folder, "\\/?%*:|\"<>") === false)
		{
			rename ($this->root_path . 'images/' . $this->config['buttonindex_image_folder'], $this->root_path . 'images/' . $buttonindex_image_folder);
			chmod($this->root_path . 'images/' . $buttonindex_image_folder, 0775);
			$this->config->set('buttonindex_image_folder', $buttonindex_image_folder);
		}
	}

	protected function recursive_mkdir($path, $mode = false)
	{
		if (!$mode)
		{
			$mode = 0755;
		}

		$dirs = explode('/', $path);
		$count = sizeof($dirs);
		$path = '.';
		for ($i = 0; $i < $count; $i++)
		{
			$path .= '/' . $dirs[$i];

			if (!is_dir($path))
			{
				@mkdir($path, $mode);
				@chmod($path, $mode);

				if (!is_dir($path))
				{
					return false;
				}
			}
		}
		return true;
	}

	protected function upload($fp, $location)
	{
		if ($this->allowedExtension($fp['name']) && $this->allowedSize($fp['size']))
		{
			$destination = $location . basename($fp['name']);
			if (move_uploaded_file($fp['tmp_name'], $destination))
			{
				return true;
			}
		}
		return false;
	}

	protected function allowedExtension($filename)
	{
		if (!$filename)
		{
			return ['gif', 'jpeg', 'jpg', 'png', 'svg', 'ico'];
		}
		return in_array($this->getExtension($filename), ['gif', 'jpeg', 'jpg', 'png', 'svg', 'ico'], true);
	}

	protected function allowedSize($filesize)
	{
		return ($filesize < ((int) ini_get('upload_max_filesize')) * 1000000);
	}

	protected function getExtension($filename)
	{
		if (strpos($filename, '.') === false)
		{
			return '';
		}

		$parts = explode('.', $filename);
		return strtolower(array_pop($parts));
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
