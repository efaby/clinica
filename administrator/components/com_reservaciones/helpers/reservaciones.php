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
 * Reservaciones helper.
 *
 * @since  1.6
 */
class ReservacionesHelpersReservaciones
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_RESERVACIONES_TITLE_CLIENTES'),
			'index.php?option=com_reservaciones&view=clientes',
			$vName == 'clientes'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_RESERVACIONES_TITLE_TURNOS'),
			'index.php?option=com_reservaciones&view=turnos',
			$vName == 'turnos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_RESERVACIONES_TITLE_ESPECIALIDADES'),
			'index.php?option=com_reservaciones&view=especialidades',
			$vName == 'especialidades'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_RESERVACIONES_TITLE_DOCTORES'),
			'index.php?option=com_reservaciones&view=doctores',
			$vName == 'doctores'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_RESERVACIONES_TITLE_RESERVACIONES'),
			'index.php?option=com_reservaciones&view=reservaciones',
			$vName == 'reservaciones'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_reservaciones';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}


class ReservacionesHelper extends ReservacionesHelpersReservaciones
{

}
