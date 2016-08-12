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
class AvatarCompressCSS extends JObject {
	public $_path;
	/**
	 * compress content
	 */	
	public function compress($path, $file) {
		$this->_path = dirname($path);
		$content = file_get_contents($file);
		return preg_replace_callback('/url\(\s*[\'"]?(?![a-z]+:|\/+)([^\'")]+)[\'"]?\s*\)/i', array($this, 'rewriteURL'), $content);
	}
	
	/**
	 * rewrite url that used in css file.
	 */
	public function rewriteURL($matches) 
	{
		$path = $this->_path.$matches[1];
        $last = '';

        while ($path != $last) {
            $last = $path;
            $path = preg_replace('`(^|/)(?!\.\./)([^/]+)/\.\./`', '', $path);
        }

        return 'url("'.$path.'")';
	}
}