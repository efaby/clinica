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
 * Controlador Reservacion Formulario
 *
 */
class ReservacionesControllerReservacionForm extends JControllerForm
{
	public function edit()
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_reservaciones.edit.reservacion.id', $editId);

		// Get the model.
		$model = $this->getModel('ReservacionForm', 'ReservacionesModel');

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
		$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacionform&layout=edit', false));
	}

	public function save()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('ReservacionForm', 'ReservacionesModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}
		
		

		// Validate the posted data.
		$data = $model->validate($form, $data);

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
			$app->setUserState('com_reservaciones.edit.reservacion.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacionform&layout=edit&id=' . $id, false));
		}

		$datos  = explode("_",$data["turno_fecha"]);
		$data['turno_id'] = $datos[0];
		$data['fecha_reservacion'] = $datos[1];
		$data['fecha_registro'] = date('Y-m-d');
		$data['estado_id'] = 1;
		$user =& JFactory::getUser();
		$data['id_usuario_registro'] = $user->get('id');
		
		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.reservacion.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacionform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_reservaciones.edit.reservacion.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_SAVED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=reservaciones' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_reservaciones.edit.reservacion.data', null);
	}

	public function cancel()
	{
		$app = JFactory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');

		// Get the model.
		$model = $this->getModel('ReservacionForm', 'ReservacionesModel');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$app->setUserState('com_reservaciones.edit.reservacion.data', array());
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=reservaciones' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
	}

	public function remove()
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('ReservacionForm', 'ReservacionesModel');

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
			$app->setUserState('com_reservaciones.edit.reservacion.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacion&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_reservaciones.edit.reservacion.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_reservaciones.edit.reservacion.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacion&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_reservaciones.edit.reservacion.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=reservaciones' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_reservaciones.edit.reservacion.data', null);
	}
	
	// metodos propios
	public function loadTurno()
	{
		$jinput = JFactory::getApplication()->input;
		$doctor = $jinput->get('doctorId');
		$model = $this->getModel();
		echo json_encode($model->getLoadDoctor($doctor));
		exit();
	}
	
	public function loadCliente()
	{
		$jinput = JFactory::getApplication()->input;
		$cliente = $jinput->get('clienteId');
		$model = $this->getModel();
		echo json_encode($model->getLoadCliente($cliente));
		exit();
	}
	
	
	
	public function cambioEstado()
	{
	
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
	
		if (empty($cid))
		{
			JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
		}
		else
		{
			$model = $this->getModel();
			JArrayHelper::toInteger($cid);
			try
			{
				$model->cambioEstado($cid, 2);
				$errors = $model->getErrors();
				if ($errors)
				{
					$app = JFactory::getApplication();
					$app->enqueueMessage(JText::plural($this->text_prefix . '_N_ITEMS_FAILED_PUBLISHING', count($cid)), 'error');
				}
					
				$ntext = 'COM_RESERVACIONES_N_ITEMS_CANCELED';
	
				$this->setMessage(JText::plural($ntext, count($cid)));
			}
			catch (Exception $e)
			{
				$this->setMessage($e->getMessage(), 'error');
			}
		}
	
		// Clear the profile id from the session.
		
		
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_reservaciones&view=reservaciones' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
		
		
	}
	
	
}
