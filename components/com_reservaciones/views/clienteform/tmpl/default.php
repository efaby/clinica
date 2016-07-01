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


?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-cliente').submit(function (event) {
				
			});

			
		});
	} else {
		jQuery(document).ready(function () {
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
			   
			jQuery('#form-cliente').submit(function (event) {
				
			});

			
		});
	}
</script>

<div class="cliente-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Editar ID <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Nuevo</h1>
	<?php endif; ?>

	<form id="form-cliente"
		  action="<?php echo JRoute::_('index.php?option=com_reservaciones&task=cliente.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
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
			
		<br>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT1'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_reservaciones&task=clienteform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_reservaciones"/>
		<input type="hidden" name="task"
			   value="clienteform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
