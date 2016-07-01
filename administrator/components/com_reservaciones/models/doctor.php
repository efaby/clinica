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
 * Modelo Doctor
 *
 */
class ReservacionesModelDoctor extends JModelAdmin
{
	protected $text_prefix = 'COM_RESERVACIONES';
	public $typeAlias = 'com_reservaciones.doctor';
	protected $item = null;

	public function getTable($type = 'Doctor', $prefix = 'ReservacionesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm(
			'com_reservaciones.doctor', 'doctor',
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
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.doctor.data', array());

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
			// cargar datos de usuario
			$user = JUser::getInstance($item->id_user);
			$item->name = $user->name;
			$item->username = $user->username;
			$item->email = $user->email;
			$item->id_user = $user->id;			
		}

		return $item;
	}

	// almacenar datos
	
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
			$user = new JUser;
			// Load the row if saving an existing record.
			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
				$user = JUser::getInstance($data["id_user"]);
			}			
		
			$parameters = JComponentHelper::getParams('com_reservaciones');	
					
			// gestion de usuario
			$userData = array(
				"id" => $data["id_user"],
		        "name"=>$data["name"],
		        "username"=>$data["username"],
		        "password"=>$data["password"],
		        "password2"=>$data["password"],
		        "email"=>$data["email"],
		        "block"=>0,
		        "groups"=>array("2",$parameters->get('grupo_id')) 
		    );
	
			if(!$user->bind($userData)) {
			
				$this->setError($user->getError());
				return false;
			}
			if (!$user->save()) {
				$this->setError($user->getError());
				return false;
			}
			
			$data["id_user"] = $user->id;

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

	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__reservaciones_doctor');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}
	
	public function loadDoctorByCedula($id,$cedula){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT a.id FROM #__reservaciones_doctor as a where a.cedula = ".$cedula." and id <> ".$id);
		return $db->loadObjectList();
	}
	
	
}
