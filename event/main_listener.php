<?php
/**
 *
 * PM Restrictions. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\pmrestrictions\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * PM Restrictions event listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var ContainerInterface */
	protected $container;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpbb_root_path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                    $auth
	 * @param ContainerInterface                  $container
	 * @param \phpbb\db\driver\driver_interface   $db
	 * @param \phpbb\user                         $user
	 * @param string                              $root_path
	 * @param string                              $php_ext
	 */
	public function __construct(\phpbb\auth\auth $auth, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->container = $container;
		$this->db = $db;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'acp_board_config_edit_add',

			'core.message_list_actions'	=> 'message_list_actions',

			'core.user_setup'	=> 'user_setup',
		);
	}

	public function acp_board_config_edit_add($event)
	{
		if ($event['mode'] == 'message')
		{
			$display_vars = $event['display_vars'];

			$config_vars = array(
				'pm_post_limit'	=> array('lang' => 'PM_POST_LIMIT', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config_vars, array('after' => 'pm_max_recipients'));

			$event['display_vars'] = $display_vars;
		}
	}

	public function message_list_actions($event)
	{
		$address_list = $event['address_list'];
		$error = $event['error'];

		$status = $this->container->get('kinerity.pmrestrictions.functions')->pm_posts_check();

		// Grab an array of user_id's with admin permissions
		$admin = $this->auth->acl_get_list(false, 'a_', false);
		$admin = (!empty($admin[0]['a_'])) ? $admin[0]['a_'] : array();

		// Grab an array of user id's with global mod permissions
		$mod = $this->auth->acl_get_list(false, 'm_', false);
		$mod = (!empty($mod[0]['m_'])) ? $mod[0]['m_'] : array();

		$team = array_unique(array_merge($admin, $mod));

		if ($status != 'allowed' && $address_list)
		{
			$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', array_keys($address_list['u'])) . '
					AND user_id <> ' . $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			$removed = false;
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!in_array($row['user_id'], $team))
				{
					$removed = true;
					unset($address_list['u'][$row['user_id']]);
				}
			}
			$this->db->sql_freeresult($result);

			// Print a notice telling the user that they may not PM non team members
			if ($removed)
			{
				$error[] = $this->user->lang('PM_TEAM_MEMBERS', append_sid($this->root_path . 'memberlist.' . $this->php_ext, 'mode=leaders'));
			}
		}

		$event['address_list'] = $address_list;
		$event['error'] = $error;
	}

	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'kinerity/pmrestrictions',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
