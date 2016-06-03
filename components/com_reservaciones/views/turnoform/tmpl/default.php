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
			jQuery('#form-turnos').submit(function (event) {
				
			});

			
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-turnos').submit(function (event) {
				
			});

			document.formvalidator.setHandler('personas', function(value) {
			      regex=/^(?:\+)?\d{1,2}$/;
			      return regex.test(value);
			   });
			 
			document.formvalidator.setHandler('horas', function(value) {
				var hora_inicio = parseInt(($('jform_hora_inicio').value * 60 )) + parseInt($('jform_minuto_inicio').value);
				var hora_fin   = parseInt(($('jform_hora_fin').value * 60 )) + parseInt($('jform_minuto_fin').value);
				return (hora_inicio <= hora_fin); 
			   });
			   
			jQuery("#jform_especialidad_id").chosen().change( function() {
			    var especialidadId = jQuery("#jform_especialidad_id").val();
			    jQuery.ajax({
			        type: "GET",
			        dataType: "json",
			        url: "index.php?option=com_reservaciones&task=turnoform.loadDoctor&tmpl=raw",
			        data: {
			        	"especialidadId": especialidadId
			        },
			        success:function(data) {
			            jQuery("select#jform_doctor_id option").remove();
			            jQuery.each(data, function(i, item) {
			                jQuery("select#jform_doctor_id").append( "<option value="+ i +">" + item + "</option>" );
			            });
			            jQuery("select").trigger("liszt:updated")
			        }
			    });
			});
			
		});
	}
</script>

<div class="turnos-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Editar ID <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Nuevo</h1>
	<?php endif; ?>

	<form id="form-turnos"
		  action="<?php echo JRoute::_('index.php?option=com_reservaciones&task=turno.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
		<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				
				<?php echo $this->form->renderField('especialidad_id'); ?>
				<?php echo $this->form->renderField('doctor_id'); ?>	
				<?php echo $this->form->renderField('dia_id'); ?>			
				<?php echo $this->form->renderField('hora_inicio'); ?>
				<?php echo $this->form->renderField('minuto_inicio'); ?>
				<?php echo $this->form->renderField('hora_fin'); ?>				
				<?php echo $this->form->renderField('minuto_fin'); ?>
				<?php echo $this->form->renderField('numero_personas'); ?>
				<?php echo $this->form->renderField('state'); ?>
		<br>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT1'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=turnoform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_reservaciones"/>
		<input type="hidden" name="task"
			   value="turnoform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
