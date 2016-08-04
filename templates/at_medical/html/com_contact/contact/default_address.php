<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<div class="contact-address row" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	<?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
		<div class="contact-webpage">
			<a href="<?php echo $this->contact->webpage; ?>" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->contact->webpage); ?></a>
		</div>
	<?php endif; ?>
	<div class="contact-address-col col-md-8">
	<?php if (($this->params->get('address_check') > 0) &&
		($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>
		<div class="at-address-block">
		<?php if ($this->params->get('address_check') > 0) : ?>
				<div class="jicon-text" >
					<?php echo JText::_('COM_CONTACT_ADDRESS'); ?>
				</div>
		<?php endif; ?>

		<?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
				<span class="contact-street" itemprop="streetAddress">
					<?php echo $this->contact->address .', '; ?>
				</span>
		<?php endif; ?>

		<?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
				<span class="contact-suburb" itemprop="addressLocality">
					<?php echo $this->contact->suburb .', '; ?>
				</span>
		<?php endif; ?>
		<?php if ($this->contact->state && $this->params->get('show_state')) : ?>
				<span class="contact-state" itemprop="addressRegion">
					<?php echo $this->contact->state . ', '; ?>
				</span>
		<?php endif; ?>
		<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
				<span class="contact-postcode" itemprop="postalCode">
					<?php echo $this->contact->postcode .', '; ?>
				</span>
		<?php endif; ?>
		<?php if ($this->contact->country && $this->params->get('show_country')) : ?>
			<span class="contact-country" itemprop="addressCountry">
				<?php echo $this->contact->country .', '; ?>
			</span>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
		<div class="at-address-block">
			<div class="jicon-text" itemprop="email">
				<?php echo JText::_('COM_CONTACT_EMAIL_LABEL'); ?>
			</div>
			<span class="contact-emailto">
				<?php echo $this->contact->email_to; ?>
			</span>
		</div>
	<?php endif; ?>
	</div>
	<div class="contact-address-col col-md-4">
	<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
		<div class="at-address-block">
			<div class="jicon-text" >
				<?php echo JText::_('COM_CONTACT_TELEPHONE'); ?>
			</div>
			<span class="contact-telephone" itemprop="telephone">
				<?php echo nl2br($this->contact->telephone); ?>
			</span>
		</div>
	<?php endif; ?>
	<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
		<div class="at-address-block">
			<div class="jicon-text">
				<?php echo JText::_('COM_CONTACT_FAX'); ?>
			</div>
			<span class="contact-fax" itemprop="faxNumber">
			<?php echo nl2br($this->contact->fax); ?>
			</span>
		</div>
	<?php endif; ?>
	<?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
		<div class="at-address-block">
			<div class="jicon-text" >
				<?php echo JText::_('COM_CONTACT_MOBILE'); ?>
			</div>
			<span class="contact-mobile" itemprop="telephone">
				<?php echo nl2br($this->contact->mobile); ?>
			</span>
		</div>
	<?php endif; ?>
	</div>
</div>

