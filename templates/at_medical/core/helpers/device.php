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
class AvatarDevice {
	public static function detectDevice()
	{
		if (preg_match("/(alcatel|
	    					amoi|android|avantgo|
	    					blackberry|benq|
	    					cell|cricket|
	    					docomo|
	    					elaine|
	    					htc|
	    					iemobile|iphone|ipad|ipaq|ipod|
	    					j2me|java|
	    					midp|mini|mmp|mobi|motorola|
	    					nec-|nokia|
	    					palm|panasonic|philips|phone|
	    					sagem|sharp|sie-|smartphone|sony|symbian|
	    					t-mobile|telus|
	    					up\.browser|up\.link|
	    					vodafone|
	    					wap|webos|wireless
	    					|xda|xoom|
	    					zte
	    					)/i", $_SERVER['HTTP_USER_AGENT'])) {
	        return true;
	 	}
	        return false;
	}
}