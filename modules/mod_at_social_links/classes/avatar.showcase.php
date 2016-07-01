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
		public static function getnumColumns($params)
		{
				return $params->get('numColumns');
		}
		public static function getreadmoreIcon($params)
		{
				return $params->get('readmoreIcon');
		}
		public static function getbgOpacity($params)
		{
				return $params->get('bgOpacity');
		}
		public static function getimageHeight($params)
		{
				return $params->get('imageHeight');
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
		public static function getcolor($params)
		{
				return $params->get('color');
		}
		public static function gettitleColor($params)
		{
				return $params->get('titleColor');
		}
		public static function getintrotextColor($params)
		{
				return $params->get('introtextColor');
		}
		public static function getreadmoreColor($params)
		{
				return $params->get('readmoreColor');
		}
		public static function getdesbgColor($params)
		{
				return $params->get('desbgColor');
		}
		public static function getdesbgOpacity($params)
		{
				return $params->get('desbgOpacity');
		}
	}
}
?>