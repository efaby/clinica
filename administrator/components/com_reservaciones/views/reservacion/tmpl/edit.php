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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_reservaciones/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery("#jform_cedula").keyup(function(){
		    var ci = jQuery("#jform_cedula").val();
		    if(ci.length == 10){
		    	jQuery.ajax({
			        type: "GET",
			        dataType: "json",
			        url: "index.php?option=com_reservaciones&task=reservacion.loadCliente&tmpl=raw",
			        data: {
			        	"clienteId": ci
			        },
			        success:function(data) {
				        
				        if(data){
				        	jQuery("#jform_nombres").val(data.nombre);
				        	jQuery("#jform_cliente_id").val(data.id);
				        } else {
							alert("El cliente no exite por favor registrelo en la sección Clientes");
							jQuery('#jform_cedula').parent().append("&nbsp; <a href='index.php?option=com_reservaciones&view=cliente&layout=edit'>Nuevo Cliente</a>");
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
		        url: "index.php?option=com_reservaciones&task=reservacion.loadTurno&tmpl=raw",
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

	Joomla.submitbutton = function (task) {
		if (task == 'reservacion.cancel') {
			Joomla.submitform(task, document.getElementById('reservacion-form'));
		}
		else {
			
			if (task != 'reservacion.cancel' && document.formvalidator.isValid(document.id('reservacion-form'))) {
				
				Joomla.submitform(task, document.getElementById('reservacion-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_reservaciones&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="reservacion-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_RESERVACIONES_TITLE_RESERVACION', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" id="jform_cliente_id" name="jform[cliente_id]" value="<?php echo $this->item->cliente_id; ?>" />
					
							
					<?php echo $this->form->renderField('doctor_id'); ?>	
					<?php echo $this->form->renderField('cedula'); ?>
					<?php echo $this->form->renderField('nombres'); ?>				
					<?php echo $this->form->renderField('observaciones'); ?>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
