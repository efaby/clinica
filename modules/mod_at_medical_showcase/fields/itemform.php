<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

// no direct access
defined('_JEXEC') or die ;
if(!file_exists(JPATH_ADMINISTRATOR.'/components/com_k2/k2.php')) {
	class JFormFielditemform extends JFormField
	{
		protected $type = 'itemorm';

		 public function getInput() 
		 {
 			return "<p style='color:red;margin-top: 5px;'>K2 Component is not installed<p>";
		 }
	}
}
else{
	
	class K2ElementItemForm extends K2Element
	{
	    function fetchElement($name, $value, &$node, $control_name)
	    { 	
			require_once (JPATH_ADMINISTRATOR.'/components/com_k2/elements/base.php');
	        $document = JFactory::getDocument();
	        $document->addScriptDeclaration("
				window.addEvent('domready', function() {
					if($('request-options')) {
						$$('.panel')[0].setStyle('display', 'none');
					}
					if($('jform_browserNav')) {
						$('jform_browserNav').setProperty('value', 2);
						$('jform_browserNav').getElements('option')[0].destroy();
					}
					if($('browserNav')) {
						$('browserNav').setProperty('value', 2);
						options = $('browserNav').getElements('option');
						if(options.length == 3) {
							options[0].remove();
						}
					}				
				});
			");
	        return '';
	    }
	
	    function fetchTooltip($label, $description, &$node, $control_name, $name)
	    {
	        return '';
	    }
	
	}
	
	class JFormFielditemform extends K2ElementItemForm
	{
	    var $type = 'itemform';
	}
	
	class JElementitemform extends K2ElementItemForm
	{
	    var $_name = 'itemform';
	}
}