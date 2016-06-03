<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Controlador Estado.
 *
 */
class ReservacionesControllerEstado extends JControllerForm
{

	public function __construct()
	{
		$this->view_list = 'estados';
		parent::__construct();
	}
}
