<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */
defined('_JEXEC') or die();
class JFormFieldAtComLoader extends JFormField
{
	protected $type = 'atcomloader';

	 public function getInput() 
	 {
	 	$options = array(
	 					'default' => 'Joomla Content'
					);
		if(file_exists(JPATH_ADMINISTRATOR.'/components/com_k2/k2.php')) {
			$options['k2'] = 'K2 Content';
		}		
		
	 	$selectOptions = array();
		
		foreach ($options as $value => $text)
		{
			$selectOptions[] = JHTML::_('select.option', $value, $text);
		} 
		return $html = JHtml::_('select.genericlist', $selectOptions, $this->name, '', 'value', 'text', $this->value);
	 }
}

?>