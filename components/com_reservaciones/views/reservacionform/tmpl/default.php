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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_reservaciones', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_reservaciones/js/form.js');

/*
if($this->item->state == 1){
	$state_string = 'Publish';
	$state_value = 1;
} else {
	$state_string = 'Unpublish';
	$state_value = 0;
}
$canState = JFactory::getUser()->authorise('core.edit.state','com_reservaciones');*/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-reservacion').submit(function (event) {
				
			});

			

			
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-reservacion').submit(function (event) {
				
			});


			jQuery("#jform_cedula").keyup(function(){
			    var ci = jQuery("#jform_cedula").val();
			    if(ci.length == 10){
			    	jQuery.ajax({
				        type: "GET",
				        dataType: "json",
				        url: "index.php?option=com_reservaciones&task=reservacionform.loadCliente&tmpl=raw",
				        data: {
				        	"clienteId": ci
				        },
				        success:function(data) {
					        
					        if(data){
					        	jQuery("#jform_nombres").val(data.nombre);
					        	jQuery("#jform_cliente_id").val(data.id);
					        } else {
								alert("El cliente no exite por favor registrelo en la sección Clientes");
								jQuery('#jform_cedula').parent().append("&nbsp; <a href='index.php?option=com_reservaciones&view=clienteform&layout=edit'>Nuevo Cliente</a>");
					        }
				        	
				        }
				    });
			    }
			});

			jQuery("#jform_doctor_id").chosen().change( function() {
			    var doctorId = jQuery("#jform_doctor_id").val();
			    jQuery.ajax({
			        type: "GET",
			        dataType: "json",
			        url: "index.php?option=com_reservaciones&task=reservacionform.loadTurno&tmpl=raw",
			        data: {
			        	"doctorId": doctorId
			        },
			        success:function(data) {
			        	if (jQuery('#turnos').length){
			        		jQuery("#turnos").empty();		        		
			        	} else {
			        		jQuery("select#jform_doctor_id").parent().append( '<div id="turnos"></div>' );
			        	}	 
			        	jQuery("#jform_turno-lbl").remove();  
			        	jQuery("#br").remove();  
			        	     	
			        	jQuery("label#jform_doctor_id-lbl").parent().append('<br id="br"><label class="required " for="jform_turno" id="jform_turno-lbl">Seleccione un Turno<input type="hidden" name="jform[turno]" required value="" id="jform_turno"><span class="star">&nbsp;*</span></label>');
			        	if(data != null){
			            jQuery.each(data, function(i, item) {
			                jQuery("#turnos").append( '<br><input type="radio" name="jform[turno_fecha]" value="'+ i +'" class="required" aria-required="true" required="required" >&nbsp;' + item );
			            });
			            jQuery("select").trigger("liszt:updated");
			        	} else {
			        		jQuery("#turnos").append("<br>El doctor seleccionado no tiene turnos establecidos. ");
			        		
			        	}
			        	jQuery("#turnos").append('<script type="text/javascript"> jQuery(document).ready(function() { jQuery("input:radio[name=\'jform[turno_fecha]\']").change(function() { jQuery("#jform_turno").val(this.value) });});</' + 'script>'); 
			        }
			    });
			});

			document.formvalidator.setHandler('observacion', function(value) {
			      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\.\_\-\(\)\:\;\,\.]+$/;
			      return regex.test(value);
			   });
			   
			
		});
	}
</script>

<div class="reservacion-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Editar ID <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Nuevo</h1>
	<?php endif; ?>

	<form id="form-reservacion"
		  action="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacion.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" id="jform_cliente_id" name="jform[cliente_id]" value="<?php echo $this->item->cliente_id; ?>" />
					
							
					<?php echo $this->form->renderField('doctor_id'); ?>	
					<?php echo $this->form->renderField('cedula'); ?>
					<?php echo $this->form->renderField('nombres'); ?>				
					<?php echo $this->form->renderField('observaciones'); ?>
		<br>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary" id="boton">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=reservacionform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_reservaciones"/>
		<input type="hidden" name="task"
			   value="reservacionform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
