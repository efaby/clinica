<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) 
{
	if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) 
	{
		$file = realpath(base64_decode($_SERVER['QUERY_STRING']));
			
		if (is_file($file)) 
		{
			if ($type = trim(strtolower(pathinfo($file, PATHINFO_EXTENSION)))) 
			{
				if ($type == 'css' || $type == 'js') 
				{
					if ($type == 'css') header('Content-type: text/css; charset=UTF-8');
					if ($type == 'js') header('Content-type: application/x-javascript');
					header('Cache-Control: max-age=86400');
					header('Content-Encoding: gzip');
					echo gzencode(@file_get_contents($file));	
				}
			}
		}
	}	
}
