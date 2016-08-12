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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$doc = JFactory::getDocument();
$doc->addStyleSheet($this->baseurl.'/media/jui/css/icomoon.css');
$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_reservaciones');
$canEdit    = $user->authorise('core.edit', 'com_reservaciones');
$canCheckin = $user->authorise('core.manage', 'com_reservaciones');
$canChange  = $user->authorise('core.edit.state', 'com_reservaciones');
$canDelete  = $user->authorise('core.delete', 'com_reservaciones');

?>
<style>
<!--
.table {
	border-collapse: inherit;
}
-->
</style>
<form action="<?php echo JRoute::_('index.php?option=com_reservaciones&view=turnos'); ?>" method="post"
      name="adminForm" id="adminForm">
<div style="border: 1px solid rgb(220, 220, 220); padding: 15px; border-radius: 5px;">
	<?php echo $this->loadTemplate('filter'); ?>
	</div>
	<br>
	<table class="table table-bordered" id="clienteList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%" class='title-table'>
	<?php echo JHtml::_('grid.sort', 'Estado', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							
				<th class='left title-table'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_TURNOS_ESPECIALIDAD', 'especialidad', $listDirn, $listOrder); ?>
				</th>
				<th class='left title-table'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_TURNOS_NOMBRE', 'doctor', $listDirn, $listOrder); ?>
				</th>
				<th class='left title-table'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_TURNOS_DIA', 'dia', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JText::_('COM_RESERVACIONES_TURNOS_HORA_INICIO'); ?>
				</th>
				<th class='left'>
				<?php echo JText::_('COM_RESERVACIONES_TURNOS_HORA_FIN'); ?>
				</th>
				<th class='left'>
				<?php echo JText::_( 'COM_RESERVACIONES_TURNOS_NUMERO_PERSONAS'); ?>
				</th>			

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 7; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_reservaciones'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_reservaciones')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
						<a class="btn btn-micro <?php echo $class; ?> hasTooltip" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_reservaciones&task=turno.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>"
						data-toggle="tooltip" title="<?php echo ($item->state == 1)? "Inhabilitar":"Habilitar";?>"
						>
						<?php if ($item->state == 1): ?>
							<i class="icon-publish"></i>
						<?php else: ?>
							<i class="icon-unpublish"></i>
						<?php endif; ?>
						</a>
					</td>
				<?php endif; ?>

								
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'turno.', $canCheckin); ?>
				<?php endif; ?>
				<?php echo $item->especialidad; ?>
				
				</td>				
								<td>

					<?php echo $this->escape($item->doctor); ?>
				</td>	<td>

					<?php echo $item->dia; ?>
				</td>			<td>

					<?php echo $item->hora_inicio; ?>:<?php echo ($item->minuto_inicio>0)?$item->minuto_inicio:'00'; ?>
				</td>				<td>

					<?php echo $item->hora_fin; ?>:<?php echo ($item->minuto_fin>0)?$item->minuto_fin:'00'; ?>
				</td>				<td>

					<?php echo $item->numero_personas; ?>
				</td>	
				<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=turnoform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini hasTooltip" type="button"
								 data-toggle="tooltip" 
								
								 title="Editar"
							><i class="icon-pencil" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=turnoform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button hasTooltip" type="button"
							data-toggle="tooltip" 
								 
								 title="Borrar"
							><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=turnoform.edit&id=0', false, 2); ?>"
		   class="btn btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_RESERVACIONES_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_RESERVACIONES_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
