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

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldAvatarAbout extends JFormField
{
	protected $type = 'AvatarAbout';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 * @since   11.1
	 */
	protected function getInput()
	{
		return '';
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 * @since   11.1
	 */
	protected function getLabel()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(dirname(JURI::base()).'/templates/'.$this->element['template'].'/core/assets/css/admin.css');
		// Initialise variables.
		$label = '';

		$label .= '<h1><a title="Amazing-Templates Framework - easy to build a website" target="_blank" href="http://www.amazing-templates.com">'. $this->element['fullname'] .' '. $this->element['version'] . ' ' . $this->element['edition'] . '</a></h1>';
		$label .= '<p>All of our templates are packed with:</p>';
		$label .= '<ul>';
		$label .= '<li>Extensions - These are modules/plugins/component to use on this template.</li>';
		$label .= '<li>Template - This is only the template install file</li>';
		$label .= '<li>Quickstart - This is your main quickstart package, it will help you to rebuild demo.</li>';
		$label .= '<li>Documentation</li>';
		$label .= '</ul>'; 
		$label .= '<p>If this template is not downloaded directly from <a title="Amazing-Templates Framework - easy to build a website" target="_blank" href="http://www.amazing-templates.com">amazing-templates.com</a>. Please, go to our website and download full template pakage.</p>';
		// $label .= '<li><a title="Amazing-Templates.com" href="http://www.amazing-templates.com" target="_blank">Home Page</a></li>';
		// $label .= '<li><a title="Support, services, and Joomla!" href="http://www.amazing-templates.com/forum/" target="_blank">Forum</a></li>';
		// $label .= '<li><a title="Support, services, and Joomla!" href="http://www.amazing-templates.com/amember/helpdesk" target="_blank">Help Desk</a></li>';
		// $label .= '<li><a title="Like us on Facebook" href="https://www.facebook.com/AmazingWebTemplates" target="_blank">Facebook</a></li>';
		// $label .= '<li><a title="Connect to us on Twitter" href="https://twitter.com/AmazingTemplate" target="_blank">Twitter</a></li>';
		// $label .= '<li><a title="Connect to us on Google Plus" href="https://twitter.com/AmazingTemplate" target="_blank">Google +</a></li>';
		// $label .= '</ul>';

		return $label;
	}

	/**
	 * Method to get the field title.
	 *
	 * @return  string  The field title.
	 * @since   11.1
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
