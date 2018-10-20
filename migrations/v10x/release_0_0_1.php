<?php
/**
 *
 * PM Restrictions. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\pmrestrictions\migrations\v10x;

class release_0_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v32x\v324');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('pm_post_limit', '5')),
		);
	}
}
