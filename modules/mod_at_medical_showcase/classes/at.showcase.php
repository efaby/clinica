<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
if(class_exists('ASLayout') != true)
{
	class ASLayout
	{
		//get columns
		public static function getshowcase($params)
		{
				return $params->get('showcase');
		}
		//get columns
		public static function getprimaryColumns($params)
		{
				return $params->get('primaryColumns');
		}
		public static function getsecondaryColumns($params)
		{
				return $params->get('secondaryColumns');
		}
		public static function getprimaryCount($params)
		{
				return $params->get('primaryCount');
		}
		public static function getreadmoreIcon($params)
		{
				return $params->get('readmoreIcon');
		}
		public static function getreadmoreBtn($params)
		{
				return $params->get('readmoreBtn');
		}
		public static function getimgLightboxIcon($params)
		{
				return $params->get('imgLightboxIcon');
		}
		public static function getitem_heading($params)
		{
				return $params->get('item_heading');
		}
		public static function getreadmoreText($params)
		{
				return $params->get('readmoreText');
		}
	}
}
?>