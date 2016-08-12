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
 * Modelo Turno
 *
 */
class ReservacionesModelTurno extends JModelAdmin
{
protected $text_prefix = 'COM_RESERVACIONES';
	public $typeAlias = 'com_reservaciones.turno';
	protected $item = null;

	public function getTable($type = 'Turno', $prefix = 'ReservacionesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm(
			'com_reservaciones.turno', 'turno',
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
		$data = JFactory::getApplication()->getUserState('com_reservaciones.edit.turno.data', array());

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
			$especilidad = 0;
			if($item->doctor_id > 0){
				$db = JFactory::getDbo();
				$db->setQuery('SELECT especialidad_id FROM #__reservaciones_doctor where id = '.$item->doctor_id);
				$especilidad            = $db->loadResult();
			}
			$item->especialidad_id =  $especilidad;

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
				$db->setQuery('SELECT MAX(ordering) FROM #__reservaciones_turno');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}
	
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
