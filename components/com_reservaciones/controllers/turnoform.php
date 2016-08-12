<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Controlador Turno Formulario
 *
 */
class ReservacionesControllerTurnoForm extends JControllerForm
{
	public function edit($key = NULL, $urlVar = NULL)
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_reservaciones.edit.turno.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_reservaciones.edit.turno.id', $editId);

		// Get the model.
		$model = $this->getModel('TurnoForm', 'ReservacionesModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=turnoform&layout=edit', false));
	}

	public function save($key = NULL, $urlVar = NULL)
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('TurnoForm', 'ReservacionesModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}		
		
		$result = $this->validarHorario($data);	
		if($result){
			// Validate the posted data.
			$data = $model->validate($form, $data);
		} else {
			$data = $result;
			$model->setError(JText::_('COM_RESERVACIONES_TURNO_MESSAGE_WARNING'));
		}
		

		// Check for errors.
		if ($data === false)
		{
			
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$input = $app->input;
			$jform = $input->get('jform', array(), 'ARRAY');

			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.turno.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.turno.id');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=turnoform&layout=edit&id=' . $id, false));
			return false;
		}

		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.turno.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.turno.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=turnoform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_reservaciones.edit.turno.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_SAVED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=turnos' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_reservaciones.edit.turno.data', null);
	}

	public function cancel($key = NULL)
	{
		$app = JFactory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_reservaciones.edit.turno.id');

		// Get the model.
		$model = $this->getModel('TurnoForm', 'ReservacionesModel');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$app->setUserState('com_reservaciones.edit.turno.data', array());
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=turnos' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
	}

	public function remove()
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('TurnoForm', 'ReservacionesModel');

		// Get the user data.
		$data       = array();
		$data['id'] = $app->input->getInt('id');

		// Check for errors.
		if (empty($data['id']))
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.turno.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.turno.id');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=turno&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.turno.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.turno.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=turno&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_reservaciones.edit.turno.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=turnos' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_reservaciones.edit.turno.data', null);
	}
	
	// Metodos propios
	public function loadDoctor()
	{
		$jinput = JFactory::getApplication()->input;
		$especialidad = $jinput->get('especialidadId');
		$model = $this->getModel();
		echo json_encode($model->getLoadDoctor($especialidad));
		exit();
	}
	
	private function validarHorario($data){
		$model = $this->getModel();
	
		$inicio = ($data["hora_inicio"] * 60) + $data["minuto_inicio"];
		$fin = ($data["hora_fin"] * 60) + $data["minuto_fin"];
		$id = ($data["id"]>0)?$data["id"]:0;
		$results = $model->loadHorarioDoctor($id,$data["doctor_id"],$inicio, $fin, $data["dia_id"]);
		if(count($results)>0){
			return false;
		}
		return true;
	}
	
}
