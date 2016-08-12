<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.framework');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$id = uniqid();
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_CONTACT_NO_CONTACTS'); ?>	 </p>
<?php else : ?>

	<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
	<fieldset class="filters btn-toolbar 123">
		<?php if ($this->params->get('filter_field') != 'hide') :?>
			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search"><span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span><?php echo JText::_('COM_CONTACT_FILTER_LABEL').'&#160;'; ?></label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTACT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTACT_FILTER_SEARCH_DESC'); ?>" />
			</div>
		<?php endif; ?>

		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="btn-group pull-right">
				<label for="limit" class="element-invisible">
					<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>
	</fieldset>
	<?php endif; ?>

		<div id="at-contact-list-<?php echo $id;?>" class="at-contact-list accordion at-accordion-s1">
			<?php foreach ($this->items as $i => $item) : ?>

				<?php if (in_array($item->access, $this->user->getAuthorisedViewLevels())) : ?>
					<?php if ($this->items[$i]->published == 0) : ?>
						<div class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
					<?php else: ?>
						<div class="panel cat-list-row<?php echo $i % 2; ?>" >
					<?php endif; ?>

						<h3 class="panel-heading">
							<a href="<?php echo JRoute::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>">
								<?php echo $item->name; ?></a>
							<?php if ($this->items[$i]->published == 0) : ?>
								<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
							<?php endif; ?>
							<a id="category-btn-<?php echo $item->id;?>" href="#category-<?php echo $item->id;?>" 
								data-toggle="collapse" data-toggle="button" class="at-categories-btn"><span class="at-icon-plus"></span>
							</a>
						</h3>
						<div class="at-contact-detail collapse fade" id="category-<?php echo $item->id;?>">
							<?php if ($this->params->get('show_position_headings')) : ?>
								<div>
									<span class="at-icon-user-tie"></span>
									<?php echo $item->con_position; ?>
								</div>
							<?php endif; ?>
							<?php if ($this->params->get('show_email_headings')) : ?>
								<div>
									<span class="at-icon-email"></span>
									<?php echo $item->email_to; ?>
								</div>
							<?php endif; ?>
							<div>
								<span class="at-icon-location-on"></span>
							<?php if ($this->params->get('show_suburb_headings') AND !empty($item->suburb)) : ?>
								<?php echo $item->suburb . ', '; ?>
							<?php endif; ?>
	
							<?php if ($this->params->get('show_state_headings') AND !empty($item->state)) : ?>
								<?php echo $item->state . ', '; ?>
							<?php endif; ?>
	
							<?php if ($this->params->get('show_country_headings') AND !empty($item->country)) : ?>
								<?php echo $item->country; ?>
							<?php endif; ?>
							</div>
							<?php if ($this->params->get('show_telephone_headings') AND !empty($item->telephone)) : ?>
								<div>
									<span class="at-icon-phone"></span>
								<?php echo JTEXT::sprintf('COM_CONTACT_TELEPHONE_NUMBER', $item->telephone); ?>
								</div>
							<?php endif; ?>

							<?php if ($this->params->get('show_mobile_headings') AND !empty ($item->mobile)) : ?>
								<div>
									<span class="at-icon-smartphone11"></span>
									<?php echo JTEXT::sprintf('COM_CONTACT_MOBILE_NUMBER', $item->mobile); ?>
								</div>
							<?php endif; ?>

							<?php if ($this->params->get('show_fax_headings') AND !empty($item->fax) ) : ?>
								<div>
									<?php echo JTEXT::sprintf('COM_CONTACT_FAX_NUMBER', $item->fax); ?><br/>
								</div>
							<?php endif; ?>
						</div>
						
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<?php if ($this->params->get('show_pagination')) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
		<?php endif; ?>
		<div>
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		</div>
</form>
<?php endif; ?>
