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
<script src="<?php echo JUri::root() . 'administrator/components/com_reservaciones/assets/js/jquery-ui.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JUri::root() . 'administrator/components/com_reservaciones/assets/css/jquery-ui.min.css'; ?>" media="screen" />
<script type="text/javascript">

jQuery(document).ready(function () {
	jQuery('#clear-search-button').on('click', function () {
		jQuery('#filter_search').val('');
		jQuery('#filter_inicio').val('');
		jQuery('#filter_fin').val('');
		jQuery("#filter_doctor option[value='']").attr("selected", "selected");
		jQuery('#adminForm').submit();
	});

	document.formvalidator.setHandler('nombre', function(value) {
	      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
	      return regex.test(value);
	   });

	document.formvalidator.setHandler('fecha', function(value) {
	      regex=/\d{4}\-\d{2}\-\d{2}/;
	      return regex.test(value);
	   });
	
});

jQuery(function() {
	jQuery( "#filter_inicio" ).datepicker({	   
		showOn: "button",
		dateFormat: "yy-mm-dd",
		buttonText: "<span class='icon-calendar'></span>",
      onClose: function( selectedDate ) {
    	  jQuery( "#filter_fin" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	jQuery( "#filter_fin" ).datepicker({	
		showOn: "button",
		dateFormat: "yy-mm-dd",
		buttonText: "<span class='icon-calendar'></span>",    
      onClose: function( selectedDate ) {
    	  jQuery( "#filter_inicio" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_reservaciones&view=reservaciones'); ?>" method="post"
      name="adminForm" id="adminForm" class="form-validate">

	<?php echo $this->loadTemplate('filter'); ?>
	<br>
	<table class="table table-bordered" id="clienteList">
		<thead>
		<tr>						
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_CLIENTE', 'cliente`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_DOCTOR', 'doctor', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_FECHA', 'dia', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_ESTADO_TURNO', 'estado', $listDirn, $listOrder); ?>
				</th>
				<th class='center'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_NUMERO_TURNO'); ?>
				</th>
				<th class='center'>
				<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_ESTADO_ACCION'); ?>
				</th>
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
				<td class='center'>
					<?php if($item->turno_id != $turno || $item->fecha_reservacion != $fecha):?>
						<?php $turno = $item->turno_id; $fecha = $item->fecha_reservacion; $j = 1;?>
					<?php endif; ?>
					<?php if ($item->estado_id==2) : ?>
						<?php $j = 0; ?>
					<?php endif;?>
						<?php echo $j;  $j++;?>
				</td>		
				<td class='center'>
					<?php if ($canEdit) : ?>
						<?php if ($item->estado_id==1) : ?>
						
						<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacionform.cambioEstado&cid=' . $item->id, false, 2); ?>" 
								class="btn btn-mini active hasTooltip cancel-button" 
								title="Cancelar Turno"											
								data-toggle="tooltip" 
								data-placement="right"								>
							<span class="icon-trash"></span>
							</a>							
						<?php else : ?>
							<?php if ($item->estado_id==2) : ?>
								<a href="javascript:void(0);" 
								class="btn btn-micro active hasTooltip" 
								data-toggle="tooltip" 
								data-placement="right" 
								title="Turno Cancelado" >
							<span class="icon-cancel-circle"></span></a>
							<?php else : ?>
								<a rel="{handler: 'iframe', size: {x: 500, y: 300}}" 
								  href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservaciones.modal&tmpl=component&turnoId='.(int) $item->id); ?>"
								 class="btn btn-micro active hasTooltip modal" 
								 data-toggle="tooltip" 
								 data-placement="right" 
								 title="Turno Atendido">
							<span class="icon-publish"></span></a>
							<?php endif; ?>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($item->estado_id==1) : ?>
							<?php if($this->doctor):?>
								<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&view=reservacion&id='.(int) $item->id); ?>" 
								class="btn btn-micro active hasTooltip" 
									data-toggle="tooltip" 
									data-placement="right" 
									title="Atender Turno">
								<span class="icon-pencil"></span></a>
							<?php else:?>
								<a href="javascript:void(0);" 
									class="btn btn-micro active hasTooltip" 
									data-toggle="tooltip" 
									data-placement="right" 
									title="Turno Reservado">
								<span class="icon-trash"></span></a>
							<?php endif;?>
						<?php else : ?>
							<?php if ($item->estado_id==2) : ?>
								<a href="javascript:void(0);" 
								class="btn btn-micro active hasTooltip" 								
								data-toggle="tooltip" 
								data-placement="right" 
								title="Turno Cancelado"
								>
							<span class="icon-cancel-circle"></span></a>
							<?php else : ?>
								<?php if($this->doctor):?>
									<a rel="{handler: 'iframe', size: {x: 500, y: 300}}" 
										  href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservaciones.modal&tmpl=component&turnoId='.(int) $item->id); ?>"
										 class="btn btn-micro active hasTooltip modal" 
										 data-toggle="tooltip" 
										 data-placement="right" 
										 title="Turno Atendido">
									<span class="icon-publish"></span></a>
								<?php else:?>
									<a href="javascript:void(0);" 
									class="btn btn-micro active hasTooltip" 
									data-toggle="tooltip" 
									data-placement="right" 
									title="Turno Atendido">
									<span class="icon-publish"></span></a>
								<?php endif;?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
						
				</td>							

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacionform.edit&id=0', false, 2); ?>"
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
		jQuery('.cancel-button').click(cancelItem);
	});

	function cancelItem() {

		if (!confirm("<?php echo JText::_('COM_RESERVACIONES_CANCEL_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>


