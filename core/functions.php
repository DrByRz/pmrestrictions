<?php
/**
 *
 * PM Restrictions. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\pmrestrictions\core;

/**
 * Common global functions
 */
class functions
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                     $auth
	 * @param \phpbb\config\config                 $config
	 * @param \phpbb\user                          $user
	 * @access public
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->user = $user;
	}

	public function pm_posts_check()
	{
		// This is only for registered users
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			return;
		}

		// Default status is allowed
		$status = 'allowed';

		// Don't check team members
		if ($this->auth->acl_gets('a_', 'm_') || $this->auth->acl_getf_global('m_'))
		{
			return $status;
		}

		if ($this->user->data['user_posts'] < $this->config['pm_post_limit'])
		{
			$status = 'disallowed';
		}

		return $status;
	}
}
