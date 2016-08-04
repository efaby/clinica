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
 * Controlador Reservacion
 *
 */
class ReservacionesControllerReservacion extends JControllerLegacy
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
		$model = $this->getModel('Reservacion', 'ReservacionesModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId && $previousId !== $editId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservacionform&layout=edit', false));
	}

	public function publish()
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Checking if the user can remove object
		$user = JFactory::getUser();

		if ($user->authorise('core.edit', 'com_reservaciones') || $user->authorise('core.edit.state', 'com_reservaciones'))
		{
			$model = $this->getModel('Reservacion', 'ReservacionesModel');

			// Get the user data.
			$id    = $app->input->getInt('id');
			$state = $app->input->getInt('state');

			// Attempt to save the data.
			$return = $model->publish($id, $state);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Save failed: %s', $model->getError()), 'warning');
			}

			// Clear the profile id from the session.
			$app->setUserState('com_reservaciones.edit.reservacion.id', null);

			// Flush the data from the session.
			$app->setUserState('com_reservaciones.edit.reservacion.data', null);

			// Redirect to the list screen.
			$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_SAVED_SUCCESSFULLY'));
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();

			if (!$item)
			{
				// If there isn't any menu item active, redirect to list view
				$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservaciones', false));
			}
			else
			{
				$this->setRedirect(JRoute::_($item->link . $menuitemid, false));
			}
		}
		else
		{
			throw new Exception(500);
		}
	}

	public function remove()
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Checking if the user can remove object
		$user = JFactory::getUser();

		if ($user->authorise('core.delete', 'com_reservaciones'))
		{
			$model = $this->getModel('Reservacion', 'ReservacionesModel');

			// Get the user data.
			$id = $app->input->getInt('id', 0);

			// Attempt to save the data.
			$return = $model->delete($id);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			}
			else
			{
				// Check in the profile.
				if ($return)
				{
					$model->checkin($return);
				}

				// Clear the profile id from the session.
				$app->setUserState('com_reservaciones.edit.reservacion.id', null);

				// Flush the data from the session.
				$app->setUserState('com_reservaciones.edit.reservacion.data', null);

				$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_DELETED_SUCCESSFULLY'));
			}

			// Redirect to the list screen.
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();
			$this->setRedirect(JRoute::_($item->link, false));
		}
		else
		{
			throw new Exception(500);
		}
	}
	
	public function save(){		

		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		$grupos = $user->get('groups');
		$parameters = JFactory::getApplication()->getParams();
		if(in_array((int)$parameters->get('grupo_id'),$grupos)){
		
			$model = $this->getModel('Reservacion', 'ReservacionesModel');		
			$data = $app->input->get('jform', array(), 'array');		
		
			$return = $model->saveReservacion($data, $user->id);
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Save failed: %s', $model->getError()), 'warning');
			} else {
				$this->setMessage(JText::_('COM_RESERVACIONES_ITEM_SAVED_SUCCESSFULLY'));
			}			
			
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();
		
			if (!$item)
			{
				// If there isn't any menu item active, redirect to list view
				$this->setRedirect(JRoute::_('index.php?option=com_reservaciones&view=reservaciones', false));
			}
			else
			{
				$this->setRedirect(JRoute::_($item->link . $menuitemid, false));
			}
		}
		else
		{
			throw new Exception(500);
		}	
		
		
	}
}
