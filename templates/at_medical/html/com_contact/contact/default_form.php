<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="at-contact-form at-form-module">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<fieldset>
			<div class="row">
				<div class="control-group col-md-6">
					<label class="control-label at-icon-assignment-ind" for="inputName"></label>
					<div class="controls"><?php echo $this->form->getInput('contact_name',NULL,JText::_('COM_CONTACT_CONTACT_EMAIL_NAME_DESC')); ?></div>
				</div>
				<div class="control-group col-md-6">
					<label class="control-label at-icon-email" for="inputEmail"></label>
					<div class="controls"><?php echo $this->form->getInput('contact_email',NULL,JText::_('COM_CONTACT_CONTACT_ENTER_VALID_EMAIL')); ?></div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label at-icon-calendar" for="selectSubject"></label>
				<div class="controls"><?php echo $this->form->getInput('contact_subject',NULL,JText::_('COM_CONTACT_CONTACT_MESSAGE_SUBJECT_DESC')); ?></div>
			</div>
			<div class="control-group">
				<label class="control-label at-icon-pen" for="inputMessage"></label>
				<div class="controls"><?php echo $this->form->getInput('contact_message',NULL,JText::_('COM_CONTACT_CONTACT_ENTER_MESSAGE_DESC')); ?></div>
			</div>
		</fieldset>
			<script>
			jQuery(function($){
				$("#jform_contact_name").attr("placeholder", "<?php echo JText::_('COM_CONTACT_CONTACT_EMAIL_NAME_DESC');?>");
				$("#jform_contact_email").attr("placeholder", "<?php echo JText::_('COM_CONTACT_CONTACT_ENTER_VALID_EMAIL');?>");
				$("#jform_contact_emailmsg").attr("placeholder", "<?php echo JText::_('COM_CONTACT_CONTACT_MESSAGE_SUBJECT_DESC');?>");
				$("#jform_contact_message").attr("placeholder", "<?php echo JText::_('COM_CONTACT_CONTACT_ENTER_MESSAGE_DESC');?>");
				$("#jform_contact_name").focus(function() {
				    if (this.value == "<?php echo JText::_('COM_CONTACT_CONTACT_EMAIL_NAME_DESC');?>") {
				        this.value = '';
				    }
				});
				$("#jform_contact_email").focus(function() {
				    if (this.value == "<?php echo JText::_('COM_CONTACT_CONTACT_ENTER_VALID_EMAIL');?>") {
				        this.value = '';
				    }
				});
				$("#jform_contact_emailmsg").focus(function() {
				    if (this.value == "<?php echo JText::_('COM_CONTACT_CONTACT_MESSAGE_SUBJECT_DESC');?>") {
				        this.value = '';
				    }
				});
				$("#jform_contact_message").focus(function() {
				    if (this.value == "<?php echo JText::_('COM_CONTACT_CONTACT_ENTER_MESSAGE_DESC');?>") {
				        this.value = '';
				    }
				});
				
			});
			</script>
			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="at-sent-email">
					<div class=""><?php echo $this->form->getLabel('contact_email_copy'); ?><span class="at-send-email-check"><?php echo $this->form->getInput('contact_email_copy'); ?></span></div>
				</div>
			<?php } ?>
			<?php //Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php if ($fieldset->name != 'contact'):?>
					<?php $fields = $this->form->getFieldset($fieldset->name);?>
					<?php foreach ($fields as $field) : ?>
						<div class="">
							<?php if ($field->hidden) : ?>
								<div class="controls">
									<?php echo $field->input;?>
								</div>
							<?php else:?>
								<div class="control-label">
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type != "Spacer") : ?>
										<span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
									<?php endif; ?>
								</div>
								<div class="controls"><?php echo $field->input;?></div>
							<?php endif;?>
						</div>
					<?php endforeach;?>
				<?php endif ?>
			<?php endforeach;?>
			<div class="form-actions"><button class="at-icon-arrow-right validate" type="submit">&nbsp;</button>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
	</form>
</div>
