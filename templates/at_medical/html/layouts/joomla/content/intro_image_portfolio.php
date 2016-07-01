<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$params  = $displayData->params;
$id = uniqid();
?>
<?php $images = json_decode($displayData->images); ?>
<div class="at-item-image-wrap">
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
		<div class="at-item-image lazy" data-original="<?php echo JURI::base().htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/> </div>
<?php endif; ?>
	<div class="at-item-more">
		<div>
			<div class="at-item-more-content">
				<?php
					echo '<a class="at-icon-more" href="#at-image-'.$id.'" data-toggle="modal"><div class="icon-search"></div></a>';
				?>
				<?php
				if ($params->get('show_readmore') && $displayData->readmore) :
				if ($params->get('access-view')) :
					$link = JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid));
				else :
					$menu = JFactory::getApplication()->getMenu();
					$active = $menu->getActive();
					$itemId = $active->id;
					$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
					$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid));
					$link = new JUri($link1);
					$link->setVar('return', base64_encode($returnURL));
				endif; ?>
			
				<?php echo JLayoutHelper::render('joomla.content.readmore_2', array('item' => $displayData, 'params' => $params, 'link' => $link)); ?>
			
				<?php endif; ?>
			</div>
		</div>
	</div>

</div>
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
<div id="at-image-<?php echo $id;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
    <img class="at-modal-image" src="<?php echo JURI::base().htmlspecialchars($images->image_intro);?>">
  </div>
  <div class="modal-footer">
    <button data-dismiss="modal" aria-hidden="true"><span class="icon-remove icon-white"></span></button>
  </div>
</div>
<?php endif;?>