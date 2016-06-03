<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Modelo listado de Turnos.
 *
 */
class ReservacionesModelTurnos extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.`id`',
					'doctor_id', 'a.`doctor_id`',
					'name', 'b.`name`',
					'hora_inicio', 'a.`hora_inicio`',
					'minuto_inicio', 'a.`minuto_inicio`',
					'hora_fin', 'a.`hora_fin`',
					'minuto_fin', 'a.`minuto_fin`',
					'numero_personas', 'a.`numero_personas`',
					'state', 'a.`state`',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0);
		$this->setState('list.start', $limitstart);
		
		$especialidad = $app->getUserStateFromRequest($this->context . '.filter.especialidad', 'filter_especialidad');
		$this->setState('filter.especialidad', $especialidad);
		
		$dia = $app->getUserStateFromRequest($this->context . '.filter.dia', 'filter_dia');
		$this->setState('filter.dia', $dia);
		

		$filters = JRequest::getVar('jform');
		$filters = $filters['filters'];
		
		if (empty($filters)) {
			$data = $app->getUserState($this->context.'.data');
			$filters = $data['filters'];
		}
		else {
			$app->setUserState($this->context.'.data', array('filters'=>$filters));
		}
		
		
		
		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');

		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');

		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		

		if (isset($list['ordering']))
		{
			$this->setState('list.ordering', $list['ordering']);
		}

		if (isset($list['direction']))
		{
			$this->setState('list.direction', $list['direction']);
		}
	}

	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*, b.name as doctor, c.nombre as especialidad, d.nombre as dia '
			)
		);
		$query->from('`#__reservaciones_turno` AS a')
		->join('INNER', $db->quoteName('#__reservaciones_doctor', 'dr') . ' ON (' . $db->quoteName('a.doctor_id') . ' = ' . $db->quoteName('dr.id') . ')')
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('dr.id_user') . ' = ' . $db->quoteName('b.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_dia', 'd') . ' ON (' . $db->quoteName('d.id') . ' = ' . $db->quoteName('a.dia_id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_especialidad', 'c') . ' ON (' . $db->quoteName('dr.especialidad_id') . ' = ' . $db->quoteName('c.id') . ')');
		
		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('b.name like ' .$search);
				
			}
		}
		$especialidad  = $this->state->get('filter.especialidad');
		if ($especialidad != '') {
			$query->where('especialidad_id=' . intval($especialidad));
		}
		
		$dia  = $this->state->get('filter.dia');
		if ($dia != '') {
			$query->where('dia_id=' . intval($dia));
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}
		
		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();		
		return $items;
	}

	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_RESERVACIONES_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? JFactory::getDate($date)->format("Y-m-d") : null;
	}
	
	
	
	
	public function getEspecialidades(){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT a.id, a.nombre FROM #__reservaciones_especialidad as a where a.state = 1 ");
		$list = $db->loadObjectList();
		$options =  array();
		foreach ($list as $option) {
			$options[] = array('id' =>$option->id, 'nombre' =>$option->nombre);
		}
		return $options;
	}
	
	public function getDias(){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT a.id, a.nombre FROM #__reservaciones_dia as a where a.state = 1 ");
		$list = $db->loadObjectList();
		$options =  array();
		foreach ($list as $option) {
			$options[] = array('id' =>$option->id, 'nombre' =>$option->nombre);
		}
		return $options;
	}
	
}
