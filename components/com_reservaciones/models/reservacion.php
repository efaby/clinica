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
 * Modelo Reservacion
 *
 */
class ReservacionesModelReservacion extends JModelItem
{
	protected function populateState()
	{
		$app = JFactory::getApplication('com_reservaciones');
	
		// Load state from the request userState on edit or from the passed variable on default
		if (JFactory::getApplication()->input->get('layout') == 'edit')
		{
			$id = JFactory::getApplication()->getUserState('com_reservaciones.edit.reservacion.id');
		}
		else
		{
			$id = JFactory::getApplication()->input->get('id');
			JFactory::getApplication()->setUserState('com_reservaciones.edit.reservacion.id', $id);
		}
	
		$this->setState('reservacion.id', $id);
	
		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();
	
		if (isset($params_array['item_id']))
		{
			$this->setState('reservacion.id', $params_array['item_id']);
		}
	
		$this->setState('params', $params);
	}
	
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;
	
			if (empty($id))
			{
				$id = $this->getState('reservacion.id');
			}
	
			$db    = $this->getDbo();
			$query = $db->getQuery(true);
			
			$query->select(
					$this->getState(
							'list.select', ' a.*, b.name, c.nombres, c.apellidos, c.numero_ficha, e.nombre as especialidad, d.nombre as dia '
							)
					);
			
			$query->from('`#__reservaciones_reservacion` AS a')
			->join('INNER', $db->quoteName('#__reservaciones_cliente', 'c') . ' ON (' . $db->quoteName('a.cliente_id') . ' = ' . $db->quoteName('c.id') . ')')
			->join('INNER', $db->quoteName('#__reservaciones_turno', 't') . ' ON (' . $db->quoteName('a.turno_id') . ' = ' . $db->quoteName('t.id') . ')')
			->join('INNER', $db->quoteName('#__reservaciones_dia', 'd') . ' ON (' . $db->quoteName('t.dia_id') . ' = ' . $db->quoteName('d.id') . ')')
			->join('INNER', $db->quoteName('#__reservaciones_doctor', 'dr') . ' ON (' . $db->quoteName('t.doctor_id') . ' = ' . $db->quoteName('dr.id') . ')')
			->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('dr.id_user') . ' = ' . $db->quoteName('b.id') . ')')
			->join('INNER', $db->quoteName('#__reservaciones_especialidad', 'e') . ' ON (' . $db->quoteName('dr.especialidad_id') . ' = ' . $db->quoteName('e.id') . ')')
			
			->where('a.id = '.$id);
			
			$db->setQuery($query);
			
			$this->_item = $db->loadObjectList();
		}
	
		
	
		return $this->_item;
	}
	
	public function saveReservacion($data,$user){
		try{

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
					$db->quoteName('estado_id') . ' = '.$data['estado'],
					$db->quoteName('observaciones') . ' = concat('.$db->quoteName('observaciones').',"<br>'.$data['observaciones'].'")',
					$db->quoteName('fecha_atencion') . ' = "'.date('Y-m-d').'"',
					$db->quoteName('id_usuario_atencion') . ' = '.$user,
			);
			$conditions = array($db->quoteName('id') . ' = '.$data['id']);
			$query->update($db->quoteName('#__reservaciones_reservacion'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
		
			return false;
		}
		return true;
	}
	
}
