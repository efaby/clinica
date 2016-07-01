<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

// No direct access
defined('_JEXEC') or die;

class AvatarParam extends JObject {
	
	public static function template($id) 
	{
		$db		= JFactory::getDbo();
		$result	= false;
		
		// Get the template information.
		$db->setQuery(
			'SELECT *' .
			' FROM #__template_styles' .
			' WHERE id = '.(int) $id
		);
		
		$result = $db->loadObject();
		
		if ($result->params) {
			return json_decode($result->params);
		}
		
		return false;
	}
}
	