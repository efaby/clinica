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
		document.formvalidator.setHandler('nombre', function(value) {
		      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('cedula', function(value) {
		      regex=/^(?:\+)?\d{10}$/;
		      return regex.test(value);
		   });

		document.formvalidator.setHandler('apellido', function(value) {
		      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('direccion', function(value) {
		      regex=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\.\_\-\(\)\:\;\,\.]+$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('telefono', function(value) {
		      regex=/^(?:\+)?\d{9}$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('celular', function(value) {
		      regex=/^(?:\+)?\d{10}$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('edad', function(value) {
		      regex=/^(?:\+)?\d{1,2}$/;
		      return regex.test(value);
		   });
		document.formvalidator.setHandler('ficha', function(value) {
		      regex=/^[a-zA-Z0-9\s\.\_\-\(\)]+$/;
		      return regex.test(value);
		   });
	});

	Joomla.submitbutton = function (task) {
		if (task == 'cliente.cancel') {
			Joomla.submitform(task, document.getElementById('cliente-form'));
		}
		else {
			
			if (task != 'cliente.cancel' && document.formvalidator.isValid(document.id('cliente-form'))) {
				
				Joomla.submitform(task, document.getElementById('cliente-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_reservaciones&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="cliente-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_RESERVACIONES_TITLE_CLIENTE', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<?php echo $this->form->renderField('cedula'); ?>
				<?php echo $this->form->renderField('nombres'); ?>
				<?php echo $this->form->renderField('apellidos'); ?>
				<?php echo $this->form->renderField('direccion'); ?>
				<?php echo $this->form->renderField('email'); ?>
				<?php echo $this->form->renderField('telefono'); ?>
				<?php echo $this->form->renderField('celular'); ?>
				<?php echo $this->form->renderField('edad'); ?>
				<?php echo $this->form->renderField('numero_ficha'); ?>
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
