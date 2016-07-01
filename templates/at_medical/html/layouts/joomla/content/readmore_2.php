<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

$params = $displayData['params'];
$item = $displayData['item'];
?>

<a class="at-icon-more" href="<?php echo $displayData['link']; ?>" itemprop="url">
	<?php if (!$params->get('access-view')) :
		echo '<div class="icon-folder-open"></div>';
	elseif ($readmore = $item->alternative_readmore) :
		echo $readmore;
		if ($params->get('show_readmore_title', 0) != 0) :
			//echo JHtml::_('string.abridge', ($item->title), $params->get('readmore_limit'));
		endif;
	elseif ($params->get('show_readmore_title', 0) == 0) :
		echo '<div class="icon-folder-open"></div>';
	else :
		echo '<div class="icon-folder-open"></div>';
		//echo JHtml::_('string.abridge', ($item->title), $params->get('readmore_limit'));
	endif; ?>
</a>
