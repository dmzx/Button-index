<?php
/**
*
* @package phpBB Extension - Button Index
* @copyright (c) 2025 dmzx - https://www.dmzx-web.net/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\buttonindex\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\extension\manager */
	protected $extension_manager;

	/** @var Container */
	protected $phpbb_container;

	/** @var string */
	protected $buttonindex_table;

	/**
	* Constructor
	*
	* @param \phpbb\config\config					$config
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\db\driver\driver_interface 		$db
	* @param \phpbb\request\request					$request
	* @param \phpbb\extension\manager 				$extension_manager
	* @param Container 								$phpbb_container
	* @param string									$buttonindex_table
	*/
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		\phpbb\extension\manager $extension_manager,
		Container $phpbb_container,
		$buttonindex_table, 
                \phpbb\collapsiblecategories\operator\operator $operator = null
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->extension_manager 	= $extension_manager;
		$this->phpbb_container 		= $phpbb_container;
		$this->buttonindex_table 	= $buttonindex_table;
		$this->operator             = $operator;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.page_header' 	          => 'page_header',
			'core.user_setup'	          => 'load_language_on_setup',
			'core.page_header_after'      => 'collapse',
		];
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'dmzx/buttonindex',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		if ($this->config['buttonindex_enable'])
		{
			$sql = 'SELECT *
				FROM ' . $this->buttonindex_table . '
				ORDER BY buttonindex_id ASC';
			$result	 = $this->db->sql_query($sql);

			$last_users = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$last_users[] = $row;
			}

			$this->db->sql_freeresult($result);

			foreach ($last_users as $row)
			{
				if (!empty($row['buttonindex']))
				{
					$this->template->assign_block_vars('buttonindex', [
						'BUTTONINDEX'			=> $row['buttonindex'],
						'BUTTONINDEX_TEXT'	    => $row['buttonindex_text'],
						'BUTTONINDEX_FAV'		=> $row['buttonindex_fav'],
					]);
				};
			}

			if ($this->phpbb_container->has('dmzx.youtubegallery.listener'))
			{
				$this->template->assign_var('S_BUTTONINDEX_YOUTUBEGALLERY', true);
			}

			if ($this->phpbb_container->has('dmzx.imageupload.listener'))
			{
				$this->template->assign_var('S_BUTTONINDEX_IMAGEUPLOAD', true);
			}

			if ($this->phpbb_container->has('dmzx.mchat.settings'))
			{
				$this->template->assign_var('S_BUTTONINDEX_MCHAT', true);
			}

			if ($this->phpbb_container->has('dmzx.donation.listener'))
			{
				$this->template->assign_var('S_BUTTONINDEX_DONATION', true);
			}

			if ($this->phpbb_container->has('dmzx.fileupload.listener'))
			{
				$this->template->assign_var('S_BUTTONINDEX_FILEUPLOAD', true);
			}

			if ($this->phpbb_container->has('dmzx.keylisted.listener'))
			{
				$this->template->assign_var('S_BUTTONINDEX_KEYLISTED', true);
			}

			$this->assign_authors();

			$this->template->assign_vars([
				'BUTTONINDEX_ENABLE'			=> $this->config['buttonindex_enable'],
				'BUTTONINDEX_STYLE_ENABLE'		=> $this->config['buttonindex_style_enable'],
				'BUTTONINDEX_UCP_ENABLE'		=> $this->config['buttonindex_ucp_enable'],
				'BUTTONINDEX_BOX_ENABLE'		=> $this->config['buttonindex_box_enable'],
				'BUTTONINDEX_COLLAPSE_ENABLE'	=> $this->config['buttonindex_collapse_enable'],
				'BUTTONINDEX_IMAGE_ENABLE'		=> $this->config['buttonindex_image_enable'],
				'BUTTONINDEX_IMAGE_FOLDER'		=> $this->config['buttonindex_image_folder'],
				'BUTTONINDEX_FOOTER_VIEW'		=> true,
			]);
		}
	}
	
	public function collapse($event)
        {
            if ($this->operator !== null)
            {
            $fid = 'butonindex';
            $this->template->assign_vars(array(
                'S_BUTTONINDEX_HIDDEN' => $this->operator->is_collapsed($fid),
                'U_BUTTONINDEX_COLLAPSE_URL' => $this->operator->get_collapsible_link($fid),
            ));
            }
        }

	function assign_authors()
	{
		$md_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/buttonindex', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = [];
		$author_homepages = [];

		foreach ($meta['authors'] as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}

		$this->template->assign_vars([
			'BUTTONINDEX_DISPLAY_NAME'		        => $meta['extra']['display-name'],
			'BUTTONINDEX_AUTHOR_NAMES'		        => implode(' &amp; ', $author_names),
			'BUTTONINDEX_AUTHOR_HOMEPAGES'			=> implode(' &amp; ', $author_homepages),
			'BUTTONINDEX_VERSION'			        => $this->config['buttonindex_version'],
		]);
	}
}
