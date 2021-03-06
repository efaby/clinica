<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
	<?php echo '<h3 class="at-contact-form-title">'. JText::_('COM_CONTACT_LINKS').'</h3>';  ?>

<div class="contact-links">
	<ul class="nav nav-tabs nav-stacked">
		<?php
		foreach (range('a', 'e') as $char) :// letters 'a' to 'e'
			$link = $this->contact->params->get('link'.$char);
			$label = $this->contact->params->get('link'.$char.'_name');

			if (!$link) :
				continue;
			endif;

			// Add 'http://' if not present
			$link = (0 === strpos($link, 'http')) ? $link : 'http://'.$link;

			// If no label is present, take the link
			$label = ($label) ? $label : $link;
			?>
			<li>
				<a href="<?php echo $link; ?>" itemprop="url">
					<?php echo $label; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>