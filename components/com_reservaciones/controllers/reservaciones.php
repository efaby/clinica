<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Contolador Reservaciones
 *
 */
class ReservacionesControllerReservaciones extends ReservacionesController
{

	public function &getModel($name = 'Reservaciones', $prefix = 'ReservacionesModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
	
	public function modal(){
	
		$turnoId = JFactory::getApplication()->input->get('turnoId', 0);	
		$model = $this->getModel('reservaciones');
		$view = $this->getView( 'reservaciones', 'html' );
		$view->setLayout('modal');
		$datos = $model->getDatosTurno($turnoId);
		$view->datosTurno = (count($datos)>0)?$datos[0]:null;
		$view->display();
	}
}
