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

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Controlador de Listado de Reservaciones
 *
 */
class ReservacionesControllerReservaciones extends JControllerAdmin
{
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_RESERVACIONES_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_RESERVACIONES_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_reservaciones&view=reservaciones');
	}

	public function getModel($name = 'reservacion', $prefix = 'ReservacionesModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks   = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
	
	public function cambioEstado()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
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
	
		$extension = $this->input->get('extension');
		$extensionURL = ($extension) ? '&extension=' . $extension : '';
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL, false));
	}
	
	public function modal(){
		
		$turnoId = JFactory::getApplication()->input->get('turnoId', 0);		

		$model = $this->getModel('reservaciones');		
		$view = $this->getView( 'reservaciones', 'html' );
		$view->setLayout('modal');
		$datos = $model->getDatosTurno($turnoId);
		$view->datosTurno = (count($datos)>0)?$datos[0]:null;
		$view->display();
	}
}
