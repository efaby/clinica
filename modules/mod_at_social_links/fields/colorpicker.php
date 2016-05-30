<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die( 'Restricted access' );
require_once dirname(__FILE__).'/defined.php';
class JFormFieldcolorpicker extends JFormField
{
    protected $type = 'colorpicker';

    protected function getInput()
    {
        $document = JFactory::getDocument();
        $base_path = JURI::root(true).'/modules/'.AVATAR_NAME.'/assets/';
        $color_code = '[255,0,0]';

        $document->addScript($base_path.'js/mooRainbow.js');
        $document->addStyleSheet($base_path.'css/mooRainbow.css');
        
        if(strlen($this->value) == 7 && substr($this->value, 0, 1) == '#') 
        {
            $color_code = '['
                          .hexdec(substr($this->value, 1, 2))
                          .','
                          .hexdec(substr($this->value, 3, 2))
                          .','
                          .hexdec(substr($this->value, 5, 2))
                          .']';
        }
        
        $control_code =  'window.addEvent("domready", function() { '
                        .'new MooRainbow("'.$this->id.'", {'
                        .' id: "'.$this->id.'", '
                        .' startColor: "'.$color_code.'", '
                        .' imgPath: "'.$base_path.'images/", '
                        .'onChange: function(color) {'
                        .'    this.element.value = color.hex;'
                        .'}, '
                        .'}); '
                        .'});';

        $document->addScriptDeclaration($control_code);
            
        $html_code = '<input id="'.$this->id.'" name="'.$this->name.'" type="text" class="text_area" size="9" value="'.$this->value.'"/>';
          
        return $html_code;
    }
}

?>