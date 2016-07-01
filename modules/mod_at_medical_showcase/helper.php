<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
class mod_at_arrowzex_showcaseHelper
{
	public static function getcontentSource($params){
			return $params->get('contentSource');
	}
	public static function getBannerLoop($params){
			return $params->get('bannerLoop');
	}
	public static function getBannerNav($params){
			return $params->get('bannerNav');
	}
	public static function getBannerAdaptiveHeight($params){
			return $params->get('bannerAdaptiveHeight');
	}
	public static function getBannerNavClick($params){
			return $params->get('bannerNavClick');
	}
	public static function getBannerAuto($params){
			return $params->get('bannerAuto');
	}
}
?>