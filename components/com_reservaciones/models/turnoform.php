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
 * Modelo Turno Formulario
 *
 */
class ReservacionesModelTurnoForm extends JModelForm
{
	private $item = null;

	protected function populateState()
	{
		$app = JFactory::getApplication('com_reservaciones');

		// Load state from the request userState on edit or from the passed variable on default
		if (JFactory::getApplication()->input->get('layout') == 'edit')
		{
			$id = JFactory::getApplication()->getUserState('com_reservaciones.edit.turno.id');
		}
		else
		{
			$id = JFactory::getApplication()->input->get('id');
			JFactory::getApplication()->setUserState('com_reservaciones.edit.turno.id', $id);
		}

		$this->setState('turno.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('turno.id', $params_array['item_id']);
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
				$id = $this->getState('turno.id');
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
		
		$especilidad = 0;
		if($this->item->doctor_id > 0){
			$db = JFactory::getDbo();
			$db->setQuery('SELECT especialidad_id FROM #__reservaciones_doctor where id = '.$this->item->doctor_id);
			$especilidad            = $db->loadResult();
		}
		$this->item->especialidad_id =  $especilidad;

		
		return $this->item;
	}

	public function getTable($type = 'Turno', $prefix = 'ReservacionesTable', $config = array())
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
		$id = (!empty($id)) ? $id : (int) $this->getState('turno.id');

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
		$id = (!empty($id)) ? $id : (int) $this->getState('turno.id');

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
		$form = $this->loadForm('com_reservaciones.turno', 'turnoform', array(
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
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.turno.data', array());

		if (empty($data))
		{
			$data = $this->getData();
		}

		

		return $data;
	}

	public function save($data)
	{
		$id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('turno.id');
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
		$id = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('turno.id');

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
	
	public function getLoadDoctor($item){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT 0 AS `id`, 'Seleccione un Doctor' AS `nombre` UNION SELECT a.id, b.name FROM #__reservaciones_doctor as a inner join #__users as b on a.id_user =  b.id where a.state = 1 and a.especialidad_id = " . $item);
		$list = $db->loadObjectList();
		foreach ($list as $option) {
			$options[$option->id] = $option->nombre;
		}
		return $options;
	
	}
	
	public function loadHorarioDoctor($id,$id_doctor, $inicio, $fin, $dia){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT a.id FROM #__reservaciones_turno as a where a.doctor_id = ".$id_doctor." and dia_id = ".$dia." and ((((hora_inicio*60)+minuto_inicio) < ".$fin." )and (((hora_fin*60)+minuto_fin)> ".$inicio.")) and id <> ".$id);
		return $db->loadObjectList();
	}
	
	
	
}
