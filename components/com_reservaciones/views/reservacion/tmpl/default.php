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
JHtml::_('behavior.formvalidation');
$user = JFactory::getUser();
$grupos = $user->get('groups');
$parameters = JFactory::getApplication()->getParams();
if(in_array((int)$parameters->get('grupo_id'),$grupos)){
	$canEdit = true;
}



?>

<script type="text/javascript">
jQuery(document).ready(function () {
	
	document.formvalidator.setHandler('observaciones', function(value) {
	      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\.\_\-\(\)\:\;\,\.]+$/;
	      return regex.test(value);
	   });
});
</script>
<?php if ($this->item) : ?>
<?php if($this->item->fecha_reservacion != date('Y-m-d')):?>
<div id="avatar-pos-message">
	
	<div class="alert alert-warning">										
	<h4 class="alert-heading">Atención</h4>
	
	<div class="alert-warning">Usted no puede atender este turno porque la fecha de reservación no es hoy.</div>
	</div>
	</div>
	<?php endif;?>
	<div class="item_fields">
		<table class="table table-bordered" style="border: 1px solid #ddd">
<tr><th colspan="2"><?php echo JText::_("COM_RESERVACIONES_MODAL_DETALLE")?></th></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_FECHA1")?></td><td><?php echo $this->item->dia ." ". $this->item->fecha_reservacion;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_ESPECIALIDAD")?></td><td><?php echo $this->item->especialidad;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_DOCTOR")?></td><td><?php echo $this->item->name;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_PACIENTE")?></td><td><?php echo $this->item->nombres." ".$this->item->apellidos;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_FICHA")?></td><td><?php echo $this->item->numero_ficha;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_OBSERVACIONES")?></td><td><?php echo $this->item->observaciones;?></td></tr>
<?php if($canEdit):?>
<tr>
	<td colspan="2">
	<?php if($this->item->fecha_reservacion == date('Y-m-d')):?>
	<form id="form-reservacion"
		  action="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacion.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
		<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
		<div class="control-group">
			<div class="control-label"><label class="required" for="jform_estado" id="jform_estado-lbl">
				<?php echo JText::_("COM_RESERVACIONES_FORM_LBL_RESERVACION_ATENCION"); ?><span class="star">&nbsp;*</span></label>
			</div>
			<div class="controls">
			<input type="checkbox" aria-required="true" required="required"  class="required" value="3" id="jform_estado" name="jform[estado]"></div>
		</div>
		<div class="control-group">
			<div class="control-label"><label class="required" for="jform_observaciones" id="jform_observaciones-lbl">
				<?php echo JText::_("COM_RESERVACIONES_FORM_LBL_RESERVACION_OBSERVACION"); ?><span class="star">&nbsp;*</span></label>
			</div>
			<div class="controls"><textarea aria-required="true" placeholder="<?php echo JText::_("COM_RESERVACIONES_FORM_LBL_RESERVACION_OBSERVACION"); ?>" 
			class="validate-observaciones" id="jform_observaciones" name="jform[observaciones]"></textarea></div>
		</div>
		<br>
		<div class="control-group">
			<div class="controls">
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT1'); ?>
					</button>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacionform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_reservaciones"/>
		<input type="hidden" name="task"
			   value="reservacion.save"/>
		
	</form>
	<?php else:?>
	
	<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacionform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
	<?php endif;?>
	</td>
</tr>
<?php endif;?>
</table>
	</div>
	
	<?php
else:
	echo JText::_('COM_RESERVACIONES_ITEM_NOT_LOADED');
endif;
