<?php
/**
*
* @package Topics Articles
* @copyright (c) Anvar (bb3.mobi)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\TopicsArticles\migrations;


class v_1_0_0 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['topic_articles']) && version_compare($this->config['topic_articles'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\bb3mobi\TopicsArticles\migrations\v_0_0_1');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('topic_articles', '1.0.0')),
		);
	}
}
