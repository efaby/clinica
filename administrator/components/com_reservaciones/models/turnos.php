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
 * Modelo de Listado de Turnos.
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
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_reservaciones');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'asc');
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*, b.name, c.nombre, d.nombre as dia '
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
}
