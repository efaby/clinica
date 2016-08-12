<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
$id = uniqid();
?>
<div id="at-categories-<?php echo $id;?>" class="at-categories-list accordion at-accordion-s1 <?php echo $this->pageclass_sfx;?>">
	<?php
		echo JLayoutHelper::render('joomla.content.categories_default', $this);
		echo $this->loadTemplate('items');
	?>
</div>
