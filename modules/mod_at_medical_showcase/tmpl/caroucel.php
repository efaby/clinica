<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die;
switch ($jquery) {
	case 'unload':	
		break;
	case 'latest':
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
		$document->addScriptDeclaration('jQuery.noConflict();');
		break;
	default:
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.$jquery.'/jquery.min.js');
		$document->addScriptDeclaration('jQuery.noConflict();');
		break;
}
$document->addScript(JURI::base()."modules/".AT_NAME."/assets/js/slick.min.js");
$document->addScript(JURI::base()."modules/".AT_NAME."/assets/js/jquery-migrate-1.2.1.min.js");
$document->addStyleSheet("modules/".AT_NAME."/assets/css/slick.css");
?>
<div class="at-showcase-caroucel-container">
<?php
require( "modules/".AT_NAME."/tmpl/caroucel/".$params->get('caroucelEffect').".php");
?>
</div>