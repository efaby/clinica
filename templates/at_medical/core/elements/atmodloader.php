<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */
defined('_JEXEC') or die();
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
class JFormFieldatmodloader extends JFormField
{
	protected $type = 'atmodloader';

	 public function getInput() 
	 {
	 	//jimport( 'joomla.application.module.helper' );
	 	//$module = JModuleHelper::getModule('full-1');
		//var_dump($module);
		$db = JFactory::getDBO();
		$query = 'SELECT m.title, m.id, m.position
		          FROM #__modules AS m
		          WHERE m.published = 1';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
	 	$options = array();		
		if($items != null){
			foreach ( $items as $item ) {
				$options[$item->id] = $item->id.' - '.$item->title.' - '.$item->position;
			}
		}
	 	$selectOptions = array();
		
		foreach ($options as $value => $text)
		{
			$selectOptions[] = JHTML::_('select.option', $value, $text);
		}
		$html = JHtml::_('select.genericlist', $selectOptions, $this->name,'multiple class="chzn-done"', 'value', 'text', $this->value);
		return $html;
	 }
}

?>