<?php/** * @copyright	http://www.amazing-templates.com * @author		Tran Nam Chung * @link		http://www.amazing-templates.com * @license		License GNU General Public License version 2 or later * @package		Amazing-Templates Framework Template */
// no direct access
defined('_JEXEC') or die('Restricted Access');

// import joomla's filesystem classes
jimport('joomla.filesystem.folder');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'defined.php' );

// create a folder inside your images folder
//JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'ae_social_icons');
//JFolder::move(AVATAR_DIR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'ae_social_icons',JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'ae_social_icons', '',TRUE);

class mod_at_social_linksInstallerScript
{
        /**
         * Constructor
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         */
        public function __construct(JAdapterInstance $adapter){
        	return true;
        }
 
        /**
         * Called before any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function preflight($route, JAdapterInstance $adapter){
        	return true;
		}
 
        /**
         * Called after any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function postflight($route, JAdapterInstance $adapter){
        	JFolder::copy(AVATAR_DIR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'at_social_icons',JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'at_social_icons', '',TRUE);
        }
 
        /**
         * Called on installation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function install(JAdapterInstance $adapter){
        	return true;
        }
 
        /**
         * Called on update
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function update(JAdapterInstance $adapter){
        	return true;
        }
 
        /**
         * Called on uninstallation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         */
        public function uninstall(JAdapterInstance $adapter){
        	return true;
        }
}
?>