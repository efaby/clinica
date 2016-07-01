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

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

use Joomla\Utilities\ArrayHelper;
/**
 * Modelo Reservacion Formulario
 *
 */
class ReservacionesModelReservacionForm extends JModelForm
{
	private $item = null;

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
		if ($this->item === null)
		{
			$this->item = false;

			if (empty($id))
			{
				$id = $this->getState('reservacion.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table !== false && $table->load($id))
			{
				$user = JFactory::getUser();
				$id   = $table->id;
				$canEdit = $user->authorise('core.edit', 'com_reservaciones') || $user->authorise('core.create', 'com_reservaciones');

				if (!$canEdit && $user->authorise('core.edit.own', 'com_reservaciones'))
				{
					$canEdit = $user->id == $table->created_by;
				}

				if (!$canEdit)
				{
					throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 500);
				}

				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published)
					{
						return $this->item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties  = $table->getProperties(1);
				$this->item = ArrayHelper::toObject($properties, 'JObject');
			}
		}

		return $this->item;
	}

	public function getTable($type = 'Reservacion', $prefix = 'ReservacionesTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_reservaciones/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItemIdByAlias($alias)
	{
		$table = $this->getTable();

		$table->load(array('alias' => $alias));

		return $table->id;
	}

	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('reservacion.id');

		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
	}

	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('reservacion.id');

		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = JFactory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_reservaciones.reservacion', 'reservacionform', array(
			'control'   => 'jform',
			'load_data' => $loadData
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.reservacion.data', array());

		if (empty($data))
		{
			$data = $this->getData();
		}

		

		return $data;
	}

	public function save($data)
	{
		$id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('reservacion.id');
		$state = (!empty($data['state'])) ? 1 : 0;
		$user  = JFactory::getUser();

		if ($id)
		{
			// Check the user can edit this item
			$authorised = $user->authorise('core.edit', 'com_reservaciones') || $authorised = $user->authorise('core.edit.own', 'com_reservaciones');
		}
		else
		{
			// Check the user can create new items in this section
			$authorised = $user->authorise('core.create', 'com_reservaciones');
		}

		if ($authorised !== true)
		{
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$table = $this->getTable();

		if ($table->save($data) === true)
		{
			return $table->id;
		}
		else
		{
			return false;
		}
	}

	public function delete($data)
	{
		$id = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('reservacion.id');

		if (JFactory::getUser()->authorise('core.delete', 'com_reservaciones') !== true)
		{
			throw new Exception(403, JText::_('JERROR_ALERTNOAUTHOR'));
		}

		$table = $this->getTable();

		if ($table->delete($data['id']) === true)
		{
			return $id;
		}
		else
		{
			return false;
		}
	}

	public function getCanSave()
	{
		$table = $this->getTable();

		return $table !== false;
	}
	
	// metodos propios
	
	public function getLoadCliente($item, $cedula = true){
		$db = JFactory::getDbo();
		if($cedula){
			$db->setQuery("SELECT id, CONCAT(nombres,' ',apellidos)  AS `nombre` FROM #__reservaciones_cliente where cedula = '" . $item. "'");
		} else {
			$db->setQuery("SELECT cedula as id, CONCAT(nombres,apellidos)  AS `nombre` FROM #__reservaciones_cliente where id = " . $item);
		}
	
		$list =  $db->loadObjectList();
		$options = null;
		foreach ($list as $option) {
			$options["nombre"] = $option->nombre;
			$options["id"] = $option->id;
		}
		return $options;
	}
	
	public function getLoadDoctor($item){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT a.id, concat(a.hora_inicio,':',LPAD(minuto_inicio,2,'0'),' a ',hora_fin,':',LPAD(minuto_fin,2,'0')) as label,d.nombre, a.id, d.id as dia, a.numero_personas
						FROM #__reservaciones_turno as a
						inner join #__reservaciones_dia as d on a.dia_id = d.id
						where a.state = 1 and a.doctor_id = ". $item);
		$list =  $db->loadObjectList();
		$year = date('Y');
		$week = date('W');
		$fechaInicioSemana  = date('Y-m-d', strtotime($year . 'W' . str_pad($week , 2, '0', STR_PAD_LEFT)));
		$diaActual =date('N');
		$arrayDias =  array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fecha = date('Y-m-d');
		$options = null;
		foreach ($list as $option) {
			$dias = $option->dia - 1;
			if($option->dia < $diaActual){
				$dias = $dias + 7;
			}
			$fecha = date('Y-m-d', strtotime("$fechaInicioSemana + $dias days"));
			$numero = $this->obtenerTurnosEntregados($db, $fecha, $option->id);
			$numero = $option->numero_personas -  $numero;
			if($numero > 0){
				$fechas =  explode("-", $fecha);
				$options[$option->id."_".$fecha] = $option->nombre." ".$fechas[2]. " de ".$arrayDias[$fechas[1]-1]." del ".$fechas[0]." ".$option->label." Turnos Disponibles: ".$numero;
			}
		}
		return $options;
	}
	
	private function obtenerTurnosEntregados($db, $fecha, $turnoId){
		$db->setQuery("SELECT count(a.id) as numero
						FROM #__reservaciones_reservacion as a
						where a.fecha_reservacion = '". $fecha."' and a.estado_id = 1 and a.turno_id =  ".$turnoId);
	
		return $db->loadResult();
	}
	
	public function cambioEstado($pks, $estado_id){
		try{
			foreach ($pks as $i => $pk)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$fields = array($db->quoteName('estado_id') . ' = '.$estado_id);
				$conditions = array($db->quoteName('id') . ' = '.$pk);
				$query->update($db->quoteName('#__reservaciones_reservacion'))->set($fields)->where($conditions);
				$db->setQuery($query);
				$db->execute();
			}
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
	
			return false;
		}
		return true;
	}
}
