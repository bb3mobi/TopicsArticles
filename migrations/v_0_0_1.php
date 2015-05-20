<?php
/**
*
* @package Topics Articles
* @copyright (c) Anvar (bb3.mobi)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\TopicsArticles\migrations;


class v_0_0_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['topic_articles']) && version_compare($this->config['topic_articles'], '0.0.1', '>=');
	}

	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return 	array(
			'add_columns' => array(
				$this->table_prefix . 'topics' => array(
					'topic_type_article' => array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_columns'	=> array(
				$this->table_prefix . 'topics' => array('topic_type_article'),
			),
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('topic_articles', '0.0.1')),
			// Add permissions
			array('permission.add', array('f_article', false)),
			// Set permissions
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_article')),
		);
	}
}
