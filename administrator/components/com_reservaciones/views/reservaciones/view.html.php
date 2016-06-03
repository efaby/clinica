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

jimport('joomla.application.component.view');

/**
 * Vista de listado de Reservaciones.
 *
 * @since  1.6
 */
class ReservacionesViewReservaciones extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;
	
	public $datosTurno;
	

	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		ReservacionesHelpersReservaciones::addSubmenu('reservaciones');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = ReservacionesHelpersReservaciones::getActions();

		JToolBarHelper::title(JText::_('COM_RESERVACIONES_TITLE_RESERVACIONES'), 'reservaciones.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/reservacion';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('reservacion.add', 'JTOOLBAR_NEW');
				
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('reservacion.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('reservaciones.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('reservaciones.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'reservaciones.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('reservaciones.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('reservaciones.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'reservaciones.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('reservaciones.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_reservaciones');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_reservaciones&view=reservaciones');

		$this->extra_sidebar = '';
	}

	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'c.`nombres`' => JText::_('COM_RESERVACIONES_RESERVACIONES_NOMBRES'),
			'c.`apellidos`' => JText::_('COM_RESERVACIONES_RESERVACIONES_APELLIDOS'),
			'b.`name`' => JText::_('COM_RESERVACIONES_RESERVACIONES_DOCTOR'),
			'd.`dia`' => JText::_('COM_RESERVACIONES_RESERVACIONES_DIA'),
			'e.`estado`' => JText::_('COM_RESERVACIONES_RESERVACIONES_ESTADO'),			
			'a.`fecha_reservacion`' => JText::_('COM_RESERVACIONES_RESERVACIONES_FECHA'),
			'a.`state`' => JText::_('JSTATUS'),
		);
	}
}
