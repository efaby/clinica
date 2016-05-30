<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');

jimport('joomla.html.html.bootstrap');
?>
<div class="at-contact contact<?php echo $this->pageclass_sfx?>" itemscope itemtype="http://schema.org/Person">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>
	<?php if ($this->contact->name && $this->params->get('show_name')) : ?>
		<div class="page-header">
			<h2>
				<?php if ($this->item->published == 0) : ?>
					<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
				<?php endif; ?>
				<span class="contact-name" itemprop="name"><?php echo $this->contact->name; ?></span>
			</h2>
			<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
				<div class="contact-position">
					<div itemprop="jobTitle">
						<?php echo $this->contact->con_position; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif;  ?>
	<?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
		<h3>
			<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
		</h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
		<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid); ?>
		<h3>
			<span class="contact-category"><a href="<?php echo $contactLink; ?>">
				<?php echo $this->escape($this->contact->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
		<form action="#" method="get" name="selectForm" id="selectForm">
			<?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
			<?php echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);?>
		</form>
	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
		<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
	<?php endif; ?>
	<div class="at-contact-detail-contain">
		<div class="row">
			<div class="contact-address-col col-md-6">
				<div class="at-contact-detail-plain">
					
					<?php  //echo '<h2>'. JText::_('COM_CONTACT_DETAILS').'</h2>';  ?>
					<div class="at-contact-content">	
						<?php echo $this->loadTemplate('address'); ?>
			
						<?php if ($this->params->get('allow_vcard')) :	?>
							<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
							<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
							<?php echo JText::_('COM_CONTACT_VCARD');?></a>
						<?php endif; ?>
					</div>
				</div>
				
				<?php if ($this->params->get('show_links')) : ?>
					<?php echo $this->loadTemplate('links'); ?>
				<?php endif; ?>
				
				<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
			
					<div class="at-contact-form-plain">
					<?php echo '<h2 class="at-contact-form-title">'. JText::_('COM_CONTACT_EMAIL_FORM').'</h2>';  ?>
					
					<?php  echo $this->loadTemplate('form');  ?>
			
					</div>
			
				<?php endif; ?>
			</div>
			<div class="contact-image-col">
				<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
						<div class="contact-image" style="background-image:url('<?php echo JURI::base().htmlspecialchars($this->contact->image);?>')">
						</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
		<div class="at-contact-misc">
				<?php echo $this->contact->misc; ?>
		</div>
	<?php endif;?>

	<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>

		<?php echo '<h2>'. JText::_('JGLOBAL_ARTICLES').'</h2>';  ?>

		<?php echo $this->loadTemplate('articles'); ?>

	<?php endif; ?>

	<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>

		<?php echo '<h2>'. JText::_('COM_CONTACT_PROFILE').'</h2>';  ?>

		<?php echo $this->loadTemplate('profile'); ?>

	<?php endif; ?>

</div>
