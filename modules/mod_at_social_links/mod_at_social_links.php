<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'defined.php' );

$list = mod_ae_social_linksHelper::getSocial($params);
$effect= mod_ae_social_linksHelper::getEffect($params);
$height = mod_ae_social_linksHelper::getIconHeight($params);
$width = mod_ae_social_linksHelper::getIconWidth($params);
$id=uniqid();
$document = JFactory::getDocument();
$document->addStyleSheet("modules/".AVATAR_NAME."/assets/css/at.social.css");
$document->addStyleSheet("modules/".AVATAR_NAME."/assets/css/".$effect."/".$effect.".css");
?>
<div class="at-social-links">
<?php
if($effect != 'true')
	require JModuleHelper::getLayoutPath(AVATAR_NAME,$effect);
else 
	require JModuleHelper::getLayoutPath(AVATAR_NAME,'nolayout');
?>
</div>