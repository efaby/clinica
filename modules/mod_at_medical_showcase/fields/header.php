<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die ;
if (!file_exists(JPATH_ROOT .DIRECTORY_SEPARATOR. 'components' .DIRECTORY_SEPARATOR. 'com_k2'.DIRECTORY_SEPARATOR.'k2.php'))
{
	return;
}

require_once (JPATH_ADMINISTRATOR.'/components/com_k2/elements/base.php');

class K2ElementHeader extends K2Element
{
    public function fetchElement($name, $value, &$node, $control_name)
    {

        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root(true).'/media/k2/assets/css/k2.modules.css?v=2.6.8');
        if (K2_JVERSION == '15')
        {
            return '<div class="paramHeaderContainer15"><div class="paramHeaderContent">'.JText::_($value).'</div><div class="k2clr"></div></div>';
        }
        else
        {
            return '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_($value).'</div><div class="k2clr"></div></div>';

        }
    }

    public function fetchTooltip($label, $description, &$node, $control_name, $name)
    {
        return NULL;
    }

}

class JFormFieldHeader extends K2ElementHeader
{
    var $type = 'header';
}

class JElementHeader extends K2ElementHeader
{
    var $_name = 'header';
}
