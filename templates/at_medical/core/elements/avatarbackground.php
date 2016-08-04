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

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since       11.1
 */
class JFormFieldAvatarBackground extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'AvatarBackGround';

	protected function getInput()
	{
		// Initialize variables.
		$uri = JFactory::getURI();
		$url = $uri->root().'templates/'.$this->element['template'].'/backgrounds/';
		$path = JPATH_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->element['template'].DIRECTORY_SEPARATOR;
		$allowedExtensions = array('jpg','png','gif','jpeg');
		$allowedExtensions = array_merge($allowedExtensions, array_map('strtoupper', $allowedExtensions));
	    // Build the filter. Will return something like: "jpg|png|JPG|PNG|gif|GIF"
	    $filter = implode('|',$allowedExtensions);
	    $filter = "^.*\.(" . implode('|',$allowedExtensions) .")$";
		$images = JFolder::files($path.'backgrounds', $filter, false);
		
		if (version_compare(JVERSION, '3.0.0', '<')) {
			$html = '<script>
					var bgURL = " '.htmlspecialchars($url).'";
					function changeBackground(selector) 
					{
						el = $(selector);
						var value = el.value;
						$("background-preview").setStyle("background-image", "url(" +bgURL+value+")");
					}
	
					window.addEvent("domready", function() {
					    $("background-preview").setStyle("background-image", "url(" +bgURL+"'.htmlspecialchars($this->value).'"+")");
					});
				</script>';
		} 
		else 
		{
			$html = '<script>
					var bgURL = " '.htmlspecialchars($url).'";
					function changeBackground(selector) 
					{
						el = jQuery(selector);
						var value = el.val();
						jQuery("#background-preview").css("background-image", "url(" +bgURL+value+")");
					}
	
					(function($){
						$(document).ready(function(){
					    	$("#background-preview").css("background-image", "url(" +bgURL+"'.htmlspecialchars($this->value).'"+")");
						});
					})(jQuery);
				</script>';
		}
		
		
		$html .= '<div style="position: relative;"><select name="jform[params][template_background]" class="at_template_background_select" onchange="changeBackground(this);">';
		$html .= '<option '.(($this->value == 0) ? 'selected="selected"' : '').' value="">'.JText::_('JOPTION_USE_DEFAULT').'</option>';
		if (count($images)) 
		{
			
			foreach ($images as $image) {
				$html .= '<option '.(($this->value == $image) ? 'selected="selected"' : '').' value='.htmlspecialchars($image).'>'.$image.'</option>';
			}
		} 
		
		$html .= '</select><div id="background-preview" style="width: 220px; height: 50px; box-shadow: inset 0 0 3px #CCC;"></div></div>';
		
		return $html;
	}
	
}
