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

jimport('joomla.application.component.modeladmin');

/**
 * Reservaciones model.
 *
 * @since  1.6
 */
class ReservacionesModelReservacion extends JModelAdmin
{
	protected $text_prefix = 'COM_RESERVACIONES';
	public $typeAlias = 'com_reservaciones.reservacion';
	protected $item = null;
	
	public function getTable($type = 'Reservacion', $prefix = 'ReservacionesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
	
		// Get the form.
		$form = $this->loadForm(
				'com_reservaciones.reservacion', 'reservacion',
				array('control' => 'jform',
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
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.reservacion.data', array());
	
		if (empty($data))
		{
			if ($this->item === null)
			{
				$this->item = $this->getItem();
			}
	
			$data = $this->item;
		}
	
		return $data;
	}
	
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			// Do any procesing on fields here if needed
			
		}
	
		return $item;
	}
	
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
	
		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__reservaciones_reservacion');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}
	
	public function getLoadCliente($item, $cedula = true){
		$db = JFactory::getDbo();
		if($cedula){
			$db->setQuery("SELECT id, CONCAT(nombres,apellidos)  AS `nombre` FROM #__reservaciones_cliente where cedula = '" . $item. "'");
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
	
	
	public function save($data)
	{
		
		
		$dispatcher = JEventDispatcher::getInstance();
		$table      = $this->getTable();
		$context    = $this->option . '.' . $this->name;
	
		if ((!empty($data['tags']) && $data['tags'][0] != ''))
		{
			$table->newTags = $data['tags'];
		}
	
		$key = $table->getKeyName();
		$pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;
	
		// Include the plugins for the save events.
		JPluginHelper::importPlugin($this->events_map['save']);
	
		// Allow an exception to be thrown.
		try
		{
			// Load the row if saving an existing record.
			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
			}

			$datos  = explode("_",$data["turno_fecha"]);
			$data['turno_id'] = $datos[0];
			$data['fecha_reservacion'] = $datos[1];
			$data['fecha_registro'] = date('Y-m-d');
			$data['estado_id'] = 1;
			$user =& JFactory::getUser();
			$data['id_usuario_registro'] = $user->get('id');			

			// Bind the data.
			if (!$table->bind($data))
			{
				$this->setError($table->getError());
	
				return false;
			}
	
			// Prepare the row for saving
			$this->prepareTable($table);
	
			// Check the data.
			if (!$table->check())
			{
				$this->setError($table->getError());
	
				return false;
			}
	
			// Trigger the before save event.
			$result = $dispatcher->trigger($this->event_before_save, array($context, $table, $isNew));
	
			if (in_array(false, $result, true))
			{
				$this->setError($table->getError());
	
				return false;
			}
	
			// Store the data.
			if (!$table->store())
			{
				$this->setError($table->getError());
	
				return false;
			}
	
			// Clean the cache.
			$this->cleanCache();
	
			// Trigger the after save event.
			$dispatcher->trigger($this->event_after_save, array($context, $table, $isNew));
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
	
			return false;
		}
	
		if (isset($table->$key))
		{
			$this->setState($this->getName() . '.id', $table->$key);
		}
	
		$this->setState($this->getName() . '.new', $isNew);
	
		if ($this->associationsContext && JLanguageAssociations::isEnabled() && !empty($data['associations']))
		{
			$associations = $data['associations'];
	
			// Unset any invalid associations
			$associations = Joomla\Utilities\ArrayHelper::toInteger($associations);
	
			// Unset any invalid associations
			foreach ($associations as $tag => $id)
			{
				if (!$id)
				{
					unset($associations[$tag]);
				}
			}
	
			// Show a notice if the item isn't assigned to a language but we have associations.
			if ($associations && ($table->language == '*'))
			{
				JFactory::getApplication()->enqueueMessage(
						JText::_(strtoupper($this->option) . '_ERROR_ALL_LANGUAGE_ASSOCIATED'),
						'notice'
						);
			}
	
			// Adding self to the association
			$associations[$table->language] = (int) $table->$key;
	
			// Deleting old association for these items
			$db    = $this->getDbo();
			$query = $db->getQuery(true)
			->delete($db->qn('#__associations'))
			->where($db->qn('context') . ' = ' . $db->quote($this->associationsContext))
			->where($db->qn('id') . ' IN (' . implode(',', $associations) . ')');
			$db->setQuery($query);
			$db->execute();
	
			if ((count($associations) > 1) && ($table->language != '*'))
			{
				// Adding new association for these items
				$key   = md5(json_encode($associations));
				$query = $db->getQuery(true)
				->insert('#__associations');
	
				foreach ($associations as $id)
				{
					$query->values(((int) $id) . ',' . $db->quote($this->associationsContext) . ',' . $db->quote($key));
				}
	
				$db->setQuery($query);
				$db->execute();
			}
		}
	
		return true;
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
