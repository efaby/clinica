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
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		document.formvalidator.setHandler('cedula', function(value) {
		      regex=/^[0-9]*$/;
		      return regex.test(value);
		   });

	});
	</script>
	
<form action="<?php echo JRoute::_('index.php?option=com_reservaciones&view=clientes'); ?>" method="post"
      name="adminForm" id="adminForm" class="form-validate">
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

				<th class='title-table'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_CLIENTES_CEDULA', 'a.cedula', $listDirn, $listOrder); ?>
				</th>
				<th class="title-table">
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_CLIENTES_NOMBRES', 'a.nombres', $listDirn, $listOrder); ?>
				</th>
				<th class='title-table'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_CLIENTES_APELLIDOS', 'a.apellidos', $listDirn, $listOrder); ?>
				</th>
				<th class='title-table'>
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_DIRECCION'); ?>
				</th>
				<th class=''>
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_EMAIL'); ?>
				</th>
				<th class=''>
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_TELEFONO'); ?>
				</th>
				<th class=''>
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_CELULAR'); ?>
				</th>
				<th class=''>
				<?php echo JText::_('COM_RESERVACIONES_CLIENTES_EDAD'); ?>
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
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
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
	<a class="btn btn-micro <?php echo $class; ?> hasTooltip" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_reservaciones&task=cliente.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>"
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

					<?php echo $item->cedula; ?>
				</td>
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'clientes.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&view=cliente&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->nombres); ?></a>
				</td>
				<td>

					<?php echo $item->apellidos; ?>
				</td>
				<td>

					<?php echo $item->direccion; ?>
				</td>
				<td>

					<?php echo $item->email; ?>
				</td>
				<td>

					<?php echo $item->telefono; ?>
				</td>
				<td>

					<?php echo $item->celular; ?>
				</td>
				<td>

					<?php echo $item->edad; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=clienteform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini hasTooltip" type="button"
								data-toggle="tooltip" 
								
								title="Editar"
							><i class="icon-pencil" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=clienteform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button hasTooltip" type="button"
							data-toggle="tooltip" 
								title="Eliminar"
							><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=clienteform.edit&id=0', false, 2); ?>"
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
