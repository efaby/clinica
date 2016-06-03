<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('JPATH_BASE') or die;


JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of categories
 *
 */
class JFormFieldDoctor extends JFormFieldList
{

	protected $type = 'doctor';

	public function getOptions() {
		$app = JFactory::getApplication();
		
		$turno = ($app->input->get('id')>0)?$app->input->get('id'):0; 
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);		
		$db->setQuery('SELECT d.especialidad_id FROM #__reservaciones_doctor as d inner join #__reservaciones_turno as t on t.doctor_id = d.id where t.id = '.$turno);
		$especialidad            = $db->loadResult();
		$especialidad = ($especialidad>0)?$especialidad:0;
		
		if($especialidad==0){
			$data = $app->getUserState('com_reservaciones.edit.turno.data');
			$especialidad =  ($data["especialidad_id"]>0)?$data["especialidad_id"]:0;
		}
		
		$query->select('a.id, b.name')->from('`#__reservaciones_doctor` AS a')
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_user') . ' = ' . $db->quoteName('b.id') . ')')
		
		->where('a.especialidad_id = '.$especialidad.' and a.state = 1 ');
		$rows = $db->setQuery($query)->loadObjectlist();
		$options =  array();
		foreach($rows as $row){
			$options[] = (object) array('value' =>$row->id,'text' =>$row->name);
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
