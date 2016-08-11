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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHTML::_( 'behavior.modal' );
JHtml::_('behavior.formvalidation');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_reservaciones');
$canEdit    = $user->authorise('core.edit', 'com_reservaciones');
$canCheckin = $user->authorise('core.manage', 'com_reservaciones');
$canChange  = $user->authorise('core.edit.state', 'com_reservaciones');
$canDelete  = $user->authorise('core.delete', 'com_reservaciones');

$doc = JFactory::getDocument();
$doc->addStyleSheet($this->baseurl.'/media/jui/css/icomoon.css');

?>

<style>
<!--
.table {
	border-collapse: inherit;
}
-->
</style>
<form action="<?php echo JRoute::_('index.php?option=com_reservaciones&view=reservaciones'); ?>" method="post"
      name="adminForm" id="adminForm" class="form-validate">
	
	<div style="float: left; "><img src="<?php echo JURI::base()."images/clinica/logo1.jpg"; ?>" height="50px"></div>
	 <div style="width: 80%; font-family: Oswald; font-size: 30px;  font-style: italic; font-weight: bold; line-height: 50px; color: #ff8706; margin-left: 90px;">Hospital basico moderno</div>
	<h2>Reporte General</h2>
	<table  id="clienteList" style="width: 100%">
		<thead>
		<tr>						
				<th class='title-table'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_CLIENTE'); ?>
				</th>
				<th class='title-table'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_DOCTOR'); ?>
				</th>
				<th class='title-table'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_FECHA'); ?>
				</th>
				<th class='title-table'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_ESTADO_TURNO'); ?>
				</th>
				
		</tr>
		</thead>		
		<tbody>
		<?php $j=1; $turno = 0; $fecha = ''; foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_reservaciones'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_reservaciones')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">			
						
										<td>
				<?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'reservaciones.', $canCheckin); ?>
				<?php endif; ?>
				
				<?php echo $this->escape($item->cliente); ?>
				

				</td>				<td>

					<?php echo $item->doctor; ?>
				</td>				<td>

					<?php echo $item->dia; ?>
				</td>				<td>

					<?php echo $item->estado; ?>
				</td>		
										

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	
</form>


