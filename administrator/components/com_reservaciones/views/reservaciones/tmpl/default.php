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

$document = JFactory::getDocument();
$document->addScript(JUri::root() . 'administrator/components/com_reservaciones/assets/js/jquery.js');
$document->addScript(JUri::root() . 'administrator/components/com_reservaciones/assets/js/jquery-ui.js');



JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
 JHTML::_('behavior.calendar');
JHtml::_('formbehavior.chosen', 'select');

JHtml::_('behavior.formvalidation');

JHTML::_( 'behavior.modal' );

// Import CSS

$document->addStyleSheet(JUri::root() . 'administrator/components/com_reservaciones/assets/css/reservaciones.css');
$document->addStyleSheet(JUri::root() . 'media/com_reservaciones/css/list.css');
$document->addStyleSheet(JUri::root() . 'administrator/components/com_reservaciones/assets/css/jquery-ui.min.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_reservaciones');


$sortFields = $this->getSortFields();
?>
<script type="text/javascript">

	

	Joomla.orderTable = function () {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	};

	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery('#clear-search-button').on('click', function () {
			jQuery('#filter_search').val('');
			jQuery('#filter_inicio').val('');
			jQuery('#filter_fin').val('');
			jQuery('#adminForm').submit();
		});

		jQuery('#search-button').on('click', function () {
			if (document.formvalidator.isValid(document.id('adminForm'))) {			
				jQuery('#adminForm').submit();
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		});
		
		document.formvalidator.setHandler('fecha', function(value) {
			var startDate = jQuery("#filter_inicio").val();
			return Date.parse(startDate) <= Date.parse(value);
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
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search"
						   class="element-invisible">
						<?php echo JText::_('JSEARCH_FILTER'); ?>
					</label>
					<input type="text" name="filter_search" id="filter_search"
						   placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>"
						   value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
						   title="<?php echo JText::_('JSEARCH_FILTER'); ?>"/>
				</div>				
				<div class="btn-group pull-left">
					<button class="btn hasTooltip" type="button" id="search-button"
							title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="icon-search"></i></button>
					<button class="btn hasTooltip" id="clear-search-button" type="button"
							title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>">
						<i class="icon-remove"></i></button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit"
						   class="element-invisible">
						<?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable"
						   class="element-invisible">
						<?php echo JText::_('JFIELD_ORDERING_DESC'); ?>
					</label>
					<select name="directionTable" id="directionTable" class="input-medium"
							onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
						<option value="asc" <?php echo $listDirn == 'asc' ? 'selected="selected"' : ''; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?>
						</option>
						<option value="desc" <?php echo $listDirn == 'desc' ? 'selected="selected"' : ''; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?>
						</option>
					</select>
				</div>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
					<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
					</select>
				</div>
			</div>
			<div class="filter-search btn-group pull-left">
			<table>
			<tr>
			<td><label for="for-filter-inicio" style="float: left; padding-right: 10px; " >Desde:</label></td>
			<td> 
			<div class="input-append">
				<input type="text" id="filter_inicio" name="filter_inicio" value="<?php echo $this->escape($this->state->get('filter.search.inicio'));?>" style="width:100px;"  maxlength="8" size="10">
			</div>
			</td>
			<td><label for="for-filter-inicio" style="float: left; padding-right: 10px;padding-left: 10px;" >Hasta:</label></td>
			<td> 
			<div class="input-append">
				<input type="text" id="filter_fin" name="filter_fin" value="<?php echo $this->escape($this->state->get('filter.search.fin'));?>" style="width:100px;"  maxlength="8" size="10">
			</div>	
			</td>
			</tr>
			</table>
			
				
				

			</div>
			<div class="clearfix"></div>
			<table class="table table-striped" id="doctorList">
				<thead>
				<tr>
					
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					

									<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_ID', 'a.`id`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_CLIENTE', 'c.`nombres`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_DOCTOR', 'b.`name`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_FECHA', 'a.`fecha_reservacion`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_RESERVACIONES_RESERVACIONES_ESTADO_TURNO', 'e.`estado`', $listDirn, $listOrder); ?>
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
				<?php $j=1; $turno = 0; $fecha = ''; foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_reservaciones');
					$canEdit    = $user->authorise('core.edit', 'com_reservaciones');
					$canCheckin = $user->authorise('core.manage', 'com_reservaciones');
					$canChange  = $user->authorise('core.edit.state', 'com_reservaciones');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						
										<td>

					<?php echo $item->id; ?>
				</td>				<td>
				<?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'reservaciones.', $canCheckin); ?>
				<?php endif; ?>
				
				<?php echo $this->escape($item->nombres) ." ".$this->escape($item->apellidos); ?>
				

				</td>				<td>

					<?php echo $item->name; ?>
				</td>				<td>

					<?php echo $item->dia ." ". $item->fecha_reservacion; ?>
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
							<a title="" onclick="return listItemTask('cb<?php echo $i; ?>','reservaciones.cambioEstado')" 
								href="javascript:void(0);" class="btn btn-micro active hasTooltip" 
								data-original-title="Cancelar Turno">
							<span class="icon-trash"></span>
							</a>
							
						<?php else : ?>
							<?php if ($item->estado_id==2) : ?>
								<a href="javascript:void(0);" class="btn btn-micro active hasTooltip" 
								data-original-title="Turno Cancelado">
							<span class="icon-cancel-circle"></span></a>
							<?php else : ?>
								<a rel="{handler: 'iframe', size: {x: 500, y: 300}}" 
								  href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservaciones.modal&tmpl=component&turnoId='.(int) $item->id); ?>"
								 class="btn btn-micro active hasTooltip modal" 
								data-original-title="Turno Atendido">
							<span class="icon-publish"></span></a>
							<?php endif; ?>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($item->estado_id==1) : ?>
							<a href="javascript:void(0);" class="btn btn-micro active hasTooltip" 
								data-original-title="Turno Reservado">
							<span class="icon-trash"></span></a>
						<?php else : ?>
							<?php if ($item->estado_id==2) : ?>
								<a href="javascript:void(0);" class="btn btn-micro active hasTooltip" 
								data-original-title="Turno Cancelado">
							<span class="icon-cancel-circle"></span></a>
							<?php else : ?>
								<a href="javascript:void(0);" class="btn btn-micro active hasTooltip" 
								data-original-title="Turno Atendido">
							<span class="icon-publish"></span></a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
						
				</td>	
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>        
