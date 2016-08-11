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

jimport('joomla.application.component.view');

/**
 * Vista Reservaciones
 *
 */
class ReservacionesViewReservaciones extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	protected $params;
	
	protected $doctores;
	public $datosTurno;
	public $doctor = false;

	public function display($tpl = null)
	{
		$app = JFactory::getApplication();

		$this->state      = $this->get('State');
		$this->params     = $app->getParams('com_reservaciones');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		
		$this->doctores = $this->get('Doctores');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}
		
		$user = JFactory::getUser();
		$grupos = $user->get('groups');
		$parameters = JFactory::getApplication()->getParams();
		if(in_array((int)$parameters->get('grupo_id'),$grupos)){
			$this->doctor = true;
		}
		
		$document = JFactory::getDocument();
		$document->setName('reporte');		
		
		parent::display('pdf');
	}

	

	public function getState($state)
	{
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}
}
