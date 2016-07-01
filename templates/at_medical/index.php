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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'core/avatar.php';
Avatar::loadFrameWork();
$template = Avatar::getTemplate($this);
echo $template->render();
$template->optimize();


