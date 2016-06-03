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
 * Modelo Estado
 *
 */
class ReservacionesModelEstado extends JModelAdmin
{
	
	protected $text_prefix = 'COM_RESERVACIONES';	
	public $typeAlias = 'com_reservaciones.estado';
	protected $item = null;	

	public function getTable($type = 'Estado', $prefix = 'ReservacionesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm(
			'com_reservaciones.estado', 'estado',
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
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.estado.data', array());
	
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
				$db->setQuery('SELECT MAX(ordering) FROM #__reservaciones_estado');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}
	
	public function duplicate(&$pks)
	{
		$user = JFactory::getUser();
	
		// Access checks.
		if (!$user->authorise('core.create', 'com_reservaciones'))
		{
			throw new Exception(JText::_('JERROR_CORE_CREATE_NOT_PERMITTED'));
		}
	
		$dispatcher = JEventDispatcher::getInstance();
		$context    = $this->option . '.' . $this->name;
	
		// Include the plugins for the save events.
		JPluginHelper::importPlugin($this->events_map['save']);
	
		$table = $this->getTable();
	
		foreach ($pks as $pk)
		{
			if ($table->load($pk, true))
			{
				// Reset the id to create a new record.
				$table->id = 0;
	
				if (!$table->check())
				{
					throw new Exception($table->getError());
				}
	
	
				// Trigger the before save event.
				$result = $dispatcher->trigger($this->event_before_save, array($context, &$table, true));
	
				if (in_array(false, $result, true) || !$table->store())
				{
					throw new Exception($table->getError());
				}
	
				// Trigger the after save event.
				$dispatcher->trigger($this->event_after_save, array($context, &$table, true));
			}
			else
			{
				throw new Exception($table->getError());
			}
		}
	
		// Clean cache
		$this->cleanCache();
	
		return true;
	}
	
	
}
