<?php
/**
*
* @package Topics Articles
* @copyright (c) 2014 Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\TopicsArticles\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $db;
	protected $template;
	protected $request;
	protected $user;
	protected $auth;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\request\request $request, \phpbb\user $user, \phpbb\auth\auth $auth)
	{
		$this->db = $db;
		$this->template = $template;
		$this->request = $request;
		$this->user = $user;
		$this->auth = $auth;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end'				=> 'submit_post_end',
			'core.posting_modify_template_vars'	=> 'posting_modify_template_vars',
			'core.viewtopic_modify_page_title'	=> 'viewtopic_article_type',
			'core.viewforum_modify_topicrow'	=> 'modify_icon_viewtopic',
		);
	}

	public function submit_post_end($event)
	{
		$data = $event['data'];
		$mode = $event['mode'];
		if (($mode == 'edit' && $data['post_id'] == $data['topic_first_post_id']) || $mode == 'post')
		{
			global $post_data;

			$topic_type_article = (!$this->request->variable('topic_type_article', 1)) ? 1 : 0;
			$post_data_article = (isset($post_data['topic_type_article'])) ? $post_data['topic_type_article'] : 0;
			if ($topic_type_article != $post_data_article && $this->auth->acl_get('f_article', $data['forum_id']))
			{
				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_type_article = ' . $topic_type_article . '
					WHERE topic_id = ' . $data['topic_id'];
				$this->db->sql_query($sql);
			}
		}
	}

	public function posting_modify_template_vars($event)
	{
		$post_data = $event['post_data'];
		$forum_id = $event['forum_id'];
		$post_id = $event['post_id'];
		$mode = $event['mode'];

		if ($this->auth->acl_get('f_article', $forum_id) && ($mode == 'post' || ($mode == 'edit' && $post_id == $post_data['topic_first_post_id'])))
		{
			$this->user->add_lang_ext('bb3mobi/TopicsArticles', 'info_acp_topic_article');
			$this->template->assign_vars(array(
				'L_TOPIC_ARTICLE'			=> $this->user->lang['L_TOPIC_ARTICLE'],
				'S_TOPIC_ARTICLES_CHECKED'	=> (!empty($post_data['topic_type_article'])) ? ' checked="checked"' : '')
			);
		}
	}

	public function viewtopic_article_type($event)
	{
		$topic_data = $event['topic_data'];
		if ($topic_data['topic_type_article'])
		{
			$this->user->add_lang_ext('bb3mobi/TopicsArticles', 'info_acp_topic_article');
			$this->template->assign_var('L_TOPIC_ARTICLE', $this->user->lang['L_TOPIC_ARTICLE']);
		}
	}

	public function modify_icon_viewtopic($event)
	{
		$row = $event['row'];
		if (!empty($row['topic_type_article']))
		{
			$topic_row = $event['topic_row'];
			$topic_img_style = str_replace(array("topic_", "announce_", "sticky_"), " article_", $topic_row['TOPIC_IMG_STYLE']);
			if ($topic_row['TOPIC_IMG_STYLE'] != $topic_img_style)
			{
				$topic_row['TOPIC_IMG_STYLE'] .= $topic_img_style;
				$event['topic_row'] = $topic_row;
			}
		}
	}
}
