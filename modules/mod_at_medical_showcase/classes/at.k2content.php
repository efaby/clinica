<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
if (!file_exists(JPATH_ROOT .DIRECTORY_SEPARATOR. 'components' .DIRECTORY_SEPARATOR. 'com_k2'.DIRECTORY_SEPARATOR.'k2.php'))
{
	return;
}
require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');
require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'utilities.php');

if(class_exists('at_k2content') != true)
{
	class at_k2content
	{
		public static function getcati(&$params){
			$cid = $params->get('category_id', NULL);
			$db = JFactory::getDBO();
			$cati = NULL;
			if ($params->get('catfilter'))
				{
					if (!is_null($cid))
					{
						if (count($cid) == 1)
						{
							$query = "SELECT c.id AS categoryid, c.alias AS categoryalias FROM #__k2_categories as c WHERE c.id = ".$cid[0];
							$db->setQuery($query);
							$cati = $db->loadObject();
						}
					}
				}
			return($cati);
			
		}
		public static function getItems(&$params, $format = 'html')
		{
			jimport('joomla.filesystem.file');
			$mainframe = JFactory::getApplication();
			$limit = $params->get('itemcount');
			$cid = $params->get('category_id', NULL);
			$ordering = $params->get('itemsOrdering', '');
			$componentParams = JComponentHelper::getParams('com_k2');
			$limitstart = JRequest::getInt('limitstart');
	
			$user = JFactory::getUser();
			$aid = $user->get('aid');
			$db = JFactory::getDBO();
	
			$jnow = JFactory::getDate();
			$now = $jnow->toSQL();
			$nullDate = $db->getNullDate();
	
			if ($params->get('source') == 'specific')
			{
	
				$value = $params->get('items');
				$current = array();
				if (is_string($value) && !empty($value))
					$current[] = $value;
				if (is_array($value))
					$current = $value;
	
				$items = array();
	
				foreach ($current as $id)
				{
	
					$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams 
					FROM #__k2_items as i 
					LEFT JOIN #__k2_categories c ON c.id = i.catid 
					WHERE i.published = 1 ";
					$query .= " AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
					$query .= " AND i.trash = 0 AND c.published = 1 ";
					$query .= " AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
					$query .= " AND c.trash = 0 
					AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." ) 
					AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." ) 
					AND i.id={$id}";
					if ($mainframe->getLanguageFilter())
					{
						$languageTag = JFactory::getLanguage()->getTag();
						$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
					}
					$db->setQuery($query);
					$item = $db->loadObject();
					if ($item)
						$items[] = $item;
	
				}
			}
	
			else
			{
				$query = "SELECT i.*, CASE WHEN i.modified = 0 THEN i.created ELSE i.modified END as lastChanged, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";
	
				if ($ordering == 'best')
					$query .= ", (r.rating_sum/r.rating_count) AS rating";
	
				if ($ordering == 'comments')
					$query .= ", COUNT(comments.id) AS numOfComments";
	
				$query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";
	
				if ($ordering == 'best')
					$query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";
	
				if ($ordering == 'comments')
					$query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";
	
					$query .= " WHERE i.published = 1 AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND i.trash = 0 AND c.published = 1 AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).")  AND c.trash = 0";
	
				$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
				$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";
	
				if ($params->get('catfilter'))
				{
					if (!is_null($cid))
					{
						if (is_array($cid))
						{
							if ($params->get('getChildren'))
							{
								require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'itemlist.php');
								$categories = K2ModelItemlist::getCategoryTree($cid);
								$sql = @implode(',', $categories);
								$query .= " AND i.catid IN ({$sql})";
	
							}
							else
							{
								JArrayHelper::toInteger($cid);
								$query .= " AND i.catid IN(".implode(',', $cid).")";
							}
	
						}
						else
						{
							if ($params->get('getChildren'))
							{
								require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'itemlist.php');
								$categories = K2ModelItemlist::getCategoryTree($cid);
								$sql = @implode(',', $categories);
								$query .= " AND i.catid IN ({$sql})";
							}
							else
							{
								$query .= " AND i.catid=".(int)$cid;
							}
	
						}
					}
				}
	
				if ($params->get('FeaturedItems') == '0')
					$query .= " AND i.featured != 1";
	
				if ($params->get('FeaturedItems') == '2')
					$query .= " AND i.featured = 1";
	
				if ($ordering == 'comments')
					$query .= " AND comments.published = 1";
	
				if ($mainframe->getLanguageFilter())
				{
					$languageTag = JFactory::getLanguage()->getTag();
					$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
				}
	
				switch ($ordering)
				{
	
					case 'date' :
						$orderby = 'i.created ASC';
						break;
	
					case 'rdate' :
						$orderby = 'i.created DESC';
						break;
	
					case 'alpha' :
						$orderby = 'i.title';
						break;
	
					case 'ralpha' :
						$orderby = 'i.title DESC';
						break;
	
					case 'order' :
						if ($params->get('FeaturedItems') == '2')
							$orderby = 'i.featured_ordering';
						else
							$orderby = 'i.ordering';
						break;
	
					case 'rorder' :
						if ($params->get('FeaturedItems') == '2')
							$orderby = 'i.featured_ordering DESC';
						else
							$orderby = 'i.ordering DESC';
						break;
	
					case 'hits' :
						if ($params->get('popularityRange'))
						{
							$datenow = JFactory::getDate();
							$date = $datenow->toMySQL();
							$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
						}
						$orderby = 'i.hits DESC';
						break;
	
					case 'rand' :
						$orderby = 'RAND()';
						break;
	
					case 'best' :
						$orderby = 'rating DESC';
						break;
	
					case 'comments' :
						if ($params->get('popularityRange'))
						{
							$datenow = JFactory::getDate();
							$date = $datenow->toMySQL();
							$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
						}
						$query .= " GROUP BY i.id ";
						$orderby = 'numOfComments DESC';
						break;
	
					case 'modified' :
						$orderby = 'lastChanged DESC';
						break;
	
					case 'publishUp' :
						$orderby = 'i.publish_up DESC';
						break;
	
					default :
						$orderby = 'i.id DESC';
						break;
				}
	
				$query .= " ORDER BY ".$orderby;
				$db->setQuery($query, 0, $limit);
				$items = $db->loadObjectList();
			}
	
			require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'item.php');
			$model = new K2ModelItem;
	
			if (count($items))
			{
	
				foreach ($items as $item)
				{
	
					//Clean title
					$item->title = JFilterOutput::ampReplace($item->title);
	
					//Images
					$date = JFactory::getDate($item->modified);
					$timestamp = '?t='.$date->toUnix();
					
					if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'.jpg'))
						{
							$item->imageOriginal = JURI::base(true).'/media/k2/items/src/'.md5("Image".$item->id).'.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageOriginal .= $timestamp;
							}
						}
					if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_XS.jpg'))
						{
							$item->imageXSmall = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XS.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageXSmall .= $timestamp;
							}
						}
	
						if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_S.jpg'))
						{
							$item->imageSmall = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageSmall .= $timestamp;
							}
						}
	
						if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_M.jpg'))
						{
							$item->imageMedium = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageMedium .= $timestamp;
							}
						}
	
						if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_L.jpg'))
						{
							$item->imageLarge = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_L.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageLarge .= $timestamp;
							}
						}
	
						if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_XL.jpg'))
						{
							$item->imageXLarge = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageXLarge .= $timestamp;
							}
						}
	
						if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_Generic.jpg'))
						{
							$item->imageGeneric = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_Generic.jpg';
							if ($componentParams->get('imageTimestamp'))
							{
								$item->imageGeneric .= $timestamp;
							}
						}
					
					$image = 'image'.$params->get('itemImgSize', 'Small');
					if (isset($item->$image))
					{
						$item->image = $item->$image;
					}
					else 
					{
						$item->image = 0;
					}
					//Read more link
					$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
					$rows[] = $item;
				}
	
				return $rows;
			}
		}
	}
}
?>