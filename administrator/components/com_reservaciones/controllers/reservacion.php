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
 * Controlador Reservacion
 *
 */
class ReservacionesControllerReservacion extends JControllerForm
{

	public function __construct()
	{
		$this->view_list = 'reservaciones';
		parent::__construct();
	}
	
	public function loadCliente()
	{
		$jinput = JFactory::getApplication()->input;
		$cliente = $jinput->get('clienteId');
		$model = $this->getModel();
		echo json_encode($model->getLoadCliente($cliente));
		exit();
	}
	
	public function loadTurno()
	{
		$jinput = JFactory::getApplication()->input;
		$doctor = $jinput->get('doctorId');
		$model = $this->getModel();
		echo json_encode($model->getLoadDoctor($doctor));
		exit();
	}
	
	
	
	
}
