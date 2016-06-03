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

jimport('joomla.application.component.controllerform');

/**
 * Controlador de Cliente
 *
 */
class ReservacionesControllerCliente extends JControllerForm
{

	public function __construct()
	{
		$this->view_list = 'clientes';
		parent::__construct();
	}
	
	public function save($key = null, $urlVar = null){
	
		$app   = JFactory::getApplication();
		$context = "$this->option.edit.$this->context";
		$data  = $this->input->post->get('jform', array(), 'array');
		$validData = $this->validarCedula($data);
	
		if ($validData === false)
		{
			// Save the data in the session.
			$app->setUserState($context . '.data', $data);
			$id = ($data["id"]>0)?$data["id"]:0;
			$this->setMessage(JText::_('COM_RESERVACIONES_CLIENTE_MESSAGE_WARNING'), 'warning');
			$this->setRedirect(
					JRoute::_(
							'index.php?option=' . $this->option . '&view=' . $this->view_item
							. $this->getRedirectToItemAppend($recordId, $urlVar).'&id='.$id, false
							)
					);
	
			return false;
		}
		parent::save($key,$urlVar);
	}
	
	private function validarCedula($data){
		$model = $this->getModel();

		$id = ($data["id"]>0)?$data["id"]:0;
		$results = $model->loadClienteByCedula($id,$data["cedula"]);
		if(count($results)>0){
			return false;
		}
		return true;
	}
	
	
}
