<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */
defined('_JEXEC') or die();
class JFormFieldatmodloader extends JFormField
{
	protected $type = 'atmodloader';

	 public function getInput() 
	 {
	 	jimport( 'joomla.application.module.helper' );
	 	$module = JModuleHelper::getModule();
		var_dump($module);
	 	$options = array(
	 					'none' => ''
					);		
		
	 	$selectOptions = array();
		
		foreach ($options as $value => $text)
		{
			$selectOptions[] = JHTML::_('select.option', $value, $text);
		} 
		return $html = JHtml::_('select.genericlist', $selectOptions, $this->name, '', 'value', 'text', $this->value);
	 }
}

?>