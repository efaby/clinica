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

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

use Joomla\Utilities\ArrayHelper;
/**
 * Modelo Turno
 *
 */
class ReservacionesModelTurno extends JModelItem
{
	public function getTable($type = 'Turno', $prefix = 'ReservacionesTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_reservaciones/tables');
	
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function publish($id, $state)
	{
		$table = $this->getTable();
		$table->load($id);
		$table->state = $state;
	
		return $table->store();
	}

}
