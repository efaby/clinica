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
		        url: "index.php?option=com_reservaciones&task=turno.loadDoctor&tmpl=raw",
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

	Joomla.submitbutton = function (task) {
		if (task == 'turno.cancel') {
			Joomla.submitform(task, document.getElementById('turno-form'));
		}
		else {
			
			if (task != 'turno.cancel' && document.formvalidator.isValid(document.id('turno-form'))) {
				
				Joomla.submitform(task, document.getElementById('turno-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_reservaciones&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="turno-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_RESERVACIONES_TITLE_TURNO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

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


