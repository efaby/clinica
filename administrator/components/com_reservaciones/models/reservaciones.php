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
 * Modelo de Listado de Reservaciones.
 *
 */
class ReservacionesModelReservaciones extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.`id`',
					'nombres', 'c.`nombres`',
					'apellidos', 'c.`apellidos`',
					'nombre', 'b.`name`',
					'fecha', 'a.`fecha_reservacion`',
					'estado', 'e.`nombre`',
					'dia', 'd.`nombre`',
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
		
		$fecha_inicio = $app->getUserStateFromRequest($this->context . '.filter.search.inicio', 'filter_inicio'); //, date('Y-m-d'));
		$this->setState('filter.search.inicio', $fecha_inicio);
		
		$fecha_fin = $app->getUserStateFromRequest($this->context . '.filter.search.fin', 'filter_fin'); //, date('Y-m-d'));
		$this->setState('filter.search.fin', $fecha_fin);

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
				'list.select', ' a.*, b.name, c.nombres, c.apellidos, e.nombre as estado, d.nombre as dia '
			)
		);
		
		$query->from('`#__reservaciones_reservacion` AS a')
		->join('INNER', $db->quoteName('#__reservaciones_cliente', 'c') . ' ON (' . $db->quoteName('a.cliente_id') . ' = ' . $db->quoteName('c.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_estado', 'e') . ' ON (' . $db->quoteName('a.estado_id') . ' = ' . $db->quoteName('e.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_turno', 't') . ' ON (' . $db->quoteName('a.turno_id') . ' = ' . $db->quoteName('t.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_dia', 'd') . ' ON (' . $db->quoteName('t.dia_id') . ' = ' . $db->quoteName('d.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_doctor', 'dr') . ' ON (' . $db->quoteName('t.doctor_id') . ' = ' . $db->quoteName('dr.id') . ')')
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('dr.id_user') . ' = ' . $db->quoteName('b.id') . ')')
		->order(array( 'fecha_reservacion','id'));
		

		// Filter by published state
		$published = $this->getState('filter.state');

		/*if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}*/

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
				$query->where('c.nombres like ' .$search);
			}
		}
		$fecha_inicio =  $this->getState('filter.search.inicio');
		if (!empty($fecha_inicio))
		{			
			$query->where("a.fecha_reservacion >= '" .$fecha_inicio."'");
			
		}
		
		$fecha_fin =  $this->getState('filter.search.fin');
		if (!empty($fecha_fin))
		{
			$query->where("a.fecha_reservacion <= '" .$fecha_fin."'");
				
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
	
	public function getDatosTurno($turnoId){
		$db    = $this->getDbo();
		$query = $db->getQuery(true);		
		
		$query->select(
				$this->getState(
						'list.select', ' a.*, b.name, c.nombres, c.apellidos, e.nombre as especialidad, d.nombre as dia '
						)
				);
		
		$query->from('`#__reservaciones_reservacion` AS a')
		->join('INNER', $db->quoteName('#__reservaciones_cliente', 'c') . ' ON (' . $db->quoteName('a.cliente_id') . ' = ' . $db->quoteName('c.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_turno', 't') . ' ON (' . $db->quoteName('a.turno_id') . ' = ' . $db->quoteName('t.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_dia', 'd') . ' ON (' . $db->quoteName('t.dia_id') . ' = ' . $db->quoteName('d.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_doctor', 'dr') . ' ON (' . $db->quoteName('a.id_usuario_atencion') . ' = ' . $db->quoteName('dr.id_user') . ')')
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('dr.id_user') . ' = ' . $db->quoteName('b.id') . ')')
		->join('INNER', $db->quoteName('#__reservaciones_especialidad', 'e') . ' ON (' . $db->quoteName('dr.especialidad_id') . ' = ' . $db->quoteName('e.id') . ')')
		
		->where('a.id = '.$turnoId);
		
		$db->setQuery($query);
		
		return $db->loadObjectList();
		
	}
}
