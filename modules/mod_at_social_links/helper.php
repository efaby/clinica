<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
class social{
	public $icon;
	public $link;
}
class mod_ae_social_linksHelper
{
	public static function getSocial($params){
		$socials = array();
		for($n = 0,$m = 0; $n < 20; $n++){
			$tmp = new social;
			$tmp->icon = $params->get('social_icon_'.$n);
			$tmp->link = $params->get('social_link_'.$n);
			if ($tmp->icon != NULL && $tmp->link != NULL ){
				$socials[$m] = $tmp;
				$m++;
			}
		}
		return $socials;
	}
	public static function getEffect($params){
		return $params->get('effect');
	}
	public static function getIconWidth($params){
		return $params->get('iconWidth');
	}
	public static function getIconHeight($params){
		return $params->get('iconHeight');
	}
}
?>