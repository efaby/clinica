<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

if(class_exists('at_articles') != true)
{
	class at_articles
	{
		public static function getarticleTitle($params){
			return $params->get('articleTitle');
		}
		
		public static function getarticleIntro($params){
			return $params->get('articleIntro');
		}
		
		public static function getnewTab($params){
			return $params->get('newTab');
		}
		
		public static function getarticleLink($params){
			return $params->get('itemLink');
		}
		public static function getintroLength($params){
			return $params->get('introLength');
		}
		public static function getcati(&$params){
			$cid = $params->get('catid', NULL);
			if (!is_null($cid))
			{
				if (count($cid) == 1)
				{
					return($cid[0]);
				}
			}
			else {
				return(NULL);
			}
			
			
		}
		public static function getList(&$params)
		{
			// Get an instance of the generic articles model
			$articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
	
			// Set application parameters in model
			$app = JFactory::getApplication();
			$appParams = $app->getParams();
			$articles->setState('params', $appParams);
	
			// Set the filters based on the module params
			$articles->setState('list.start', 0);
			$articles->setState('list.limit', (int) $params->get('itemcount', 3));
			$articles->setState('filter.published', 1);
	
			// Access filter
			$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
			$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
			$articles->setState('filter.access', $access);
	
			// Prep for Normal or Dynamic Modes
			$mode = $params->get('mode', 'normal');
			switch ($mode)
			{
				case 'dynamic':
					$option = JRequest::getCmd('option');
					$view = JRequest::getCmd('view');
					if ($option === 'com_content') {
						switch($view)
						{
							case 'category':
								$catids = array(JRequest::getInt('id'));
								break;
							case 'categories':
								$catids = array(JRequest::getInt('id'));
								break;
							case 'article':
								if ($params->get('show_on_article_page', 1)) {
									$article_id = JRequest::getInt('id');
									$catid = JRequest::getInt('catid');
	
									if (!$catid) {
										// Get an instance of the generic article model
										$article = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));
	
										$article->setState('params', $appParams);
										$article->setState('filter.published', 1);
										$article->setState('article.id', (int) $article_id);
										$item = $article->getItem();
	
										$catids = array($item->catid);
									}
									else {
										$catids = array($catid);
									}
								}
								else {
									// Return right away if show_on_article_page option is off
									return;
								}
								break;
	
							case 'featured':
							default:
								// Return right away if not on the category or article views
								return;
						}
					}
					else {
						// Return right away if not on a com_content page
						return;
					}
	
					break;
	
				case 'normal':
				default:
					$catids = $params->get('catid');
					$articles->setState('filter.category_id.include', (bool) $params->get('category_filtering_type', 1));
					break;
			}
			// Category filter
			if ($catids) {
				if ($params->get('show_child_category_articles', 0) && (int) $params->get('levels', 0) > 0) {
					// Get an instance of the generic categories model
					$categories = JModelLegacy::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
					$categories->setState('params', $appParams);
					$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
					$categories->setState('filter.get_children', $levels);
					$categories->setState('filter.published', 1);
					$categories->setState('filter.access', $access);
					$additional_catids = array();
	
					foreach($catids as $catid)
					{
						$categories->setState('filter.parentId', $catid);
						$recursive = true;
						$items = $categories->getItems($recursive);
	
						if ($items)
						{
							foreach($items as $category)
							{
								$condition = (($category->level - $categories->getParent()->level) <= $levels);
								if ($condition) {
									$additional_catids[] = $category->id;
								}
	
							}
						}
					}
	
					$catids = array_unique(array_merge($catids, $additional_catids));
				}
	
				$articles->setState('filter.category_id', $catids);
			}
			//var_dump($catids);die();
			// Ordering
			$articles->setState('list.ordering', $params->get('article_ordering', 'a.ordering'));
			$articles->setState('list.direction', $params->get('article_ordering_direction', 'ASC'));
	
			// New Parameters
			$articles->setState('filter.featured', $params->get('show_front', 'show'));
			$articles->setState('filter.author_id', $params->get('created_by', ""));
			$articles->setState('filter.author_id.include', $params->get('author_filtering_type', 1));
			$articles->setState('filter.author_alias', $params->get('created_by_alias', ""));
			$articles->setState('filter.author_alias.include', $params->get('author_alias_filtering_type', 1));
			$excluded_articles = $params->get('excluded_articles', '');
	
			if ($excluded_articles) {
				$excluded_articles = explode("\r\n", $excluded_articles);
				$articles->setState('filter.article_id', $excluded_articles);
				$articles->setState('filter.article_id.include', false); // Exclude
			}
	
			$date_filtering = $params->get('date_filtering', 'off');
			if ($date_filtering !== 'off') {
				$articles->setState('filter.date_filtering', $date_filtering);
				$articles->setState('filter.date_field', $params->get('date_field', 'a.created'));
				$articles->setState('filter.start_date_range', $params->get('start_date_range', '1000-01-01 00:00:00'));
				$articles->setState('filter.end_date_range', $params->get('end_date_range', '9999-12-31 23:59:59'));
				$articles->setState('filter.relative_date', $params->get('relative_date', 30));
			}
	
			// Filter by language
			$articles->setState('filter.language', $app->getLanguageFilter());
	
			$items = $articles->getItems();
	
			// Display options
			$show_date = $params->get('show_date', 0);
			$show_date_field = $params->get('show_date_field', 'created');
			$show_date_format = $params->get('show_date_format', 'Y-m-d H:i:s');
			$show_category = $params->get('show_category', 0);
			$show_hits = $params->get('show_hits', 0);
			$show_author = $params->get('show_author', 0);
			$show_introtext = $params->get('show_introtext', 0);
			$introtext_limit = $params->get('introtext_limit', 100);
	
			// Find current Article ID if on an article page
			$option = JRequest::getCmd('option');
			$view = JRequest::getCmd('view');
	
			if ($option === 'com_content' && $view === 'article') {
				$active_article_id = JRequest::getInt('id');
			}
			else {
				$active_article_id = 0;
			}
	
			// Prepare data for display using display options
			foreach ($items as &$item)
			{
				$item->slug = $item->id.':'.$item->alias;
				$item->catslug = $item->catid ? $item->catid .':'.$item->category_alias : $item->catid;
	
				if ($access || in_array($item->access, $authorised)) {
					// We know that user has the privilege to view the article
					$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->language));
				}
				 else {
					// Angie Fixed Routing
					$app	= JFactory::getApplication();
					$menu	= $app->getMenu();
					$menuitems	= $menu->getItems('link', 'index.php?option=com_users&view=login');
				if(isset($menuitems[0])) {
						$Itemid = $menuitems[0]->id;
					} elseif (JRequest::getInt('Itemid') > 0) { //use Itemid from requesting page only if there is no existing menu
						$Itemid = JRequest::getInt('Itemid');
					}
	
					$item->link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$Itemid);
					}
	
				// Used for styling the active article
				$item->active = $item->id == $active_article_id ? 'active' : '';
	
				$item->displayDate = '';
				if ($show_date) {
					$item->displayDate = JHTML::_('date', $item->$show_date_field, $show_date_format);
				}
	
				if ($item->catid) {
					$item->displayCategoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
					$item->displayCategoryTitle = $show_category ? '<a href="'.$item->displayCategoryLink.'">'.$item->category_title.'</a>' : '';
				}
				else {
					$item->displayCategoryTitle = $show_category ? $item->category_title : '';
				}
	
				$item->displayHits = $show_hits ? $item->hits : '';
				$item->displayAuthorName = $show_author ? $item->author : '';
				if ($show_introtext) {
					$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_category.content');
					$item->introtext = self::_cleanIntrotext($item->introtext);
				}
				$item->displayIntrotext = $show_introtext ? self::truncate($item->introtext, $introtext_limit) : '';
				$item->displayReadmore = $item->alternative_readmore;
	
			}
	
			return $items;
		}
	}
}
?>