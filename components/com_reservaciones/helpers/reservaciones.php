<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Helper Reservaciones FrontEnd
 *
 */
class ReservacionesHelpersReservaciones
{
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_reservaciones/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_reservaciones/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'ReservacionesModel');
		}

		return $model;
	}
}
