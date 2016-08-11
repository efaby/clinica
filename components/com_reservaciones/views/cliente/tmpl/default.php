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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_reservaciones');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_reservaciones')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_NOMBRES'); ?></th>
			<td><?php echo $this->item->nombres; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_APELLIDOS'); ?></th>
			<td><?php echo $this->item->apellidos; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_DIRECCION'); ?></th>
			<td><?php echo $this->item->direccion; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_EMAIL'); ?></th>
			<td><?php echo $this->item->email; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_TELEFONO'); ?></th>
			<td><?php echo $this->item->telefono; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_CELULAR'); ?></th>
			<td><?php echo $this->item->celular; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_EDAD'); ?></th>
			<td><?php echo $this->item->edad; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_CLIENTE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=cliente.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_RESERVACIONES_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_reservaciones')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=cliente.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_RESERVACIONES_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_RESERVACIONES_ITEM_NOT_LOADED');
endif;
