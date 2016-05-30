<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_related_items
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="at-related-items at-medical-effect-2 <?php echo $moduleclass_sfx; ?> row">
<?php foreach ($list as $item) :?>
<?php
$article = JTable::getInstance("content"); 
$article->load(($item->id)); // Get Article ID
$article_images = $article->get("images"); // Get image parameters
$item_image = json_decode($article_images); // Split the parameters apart
// Print the image
?>
<div class="at-related-item col-md-<?php echo round((12 / count($list))); ?> ">
	<div class="at-showcase-item-wrap">
		<div class="at-showcase-content">
		    <div class="at-image-intro-item">
				<?php if($item_image->image_intro): ?>
					<div class="at-item-image-wrap">
						<div class="at-item-image" style="background-image: url('<?php echo JURI::base().htmlspecialchars($item_image->image_intro); ?>')">
						</div>
					</div>
				<?php endif;?>
			</div>  
			<h3 class="at-item-title">
			<a href="<?php echo $item->route; ?>" target="_blank"><?php echo $item->title;?></a>
	        </h3>
	        <?php if ($showDate) :?>
				<div><?php echo JHtml::_('date', $item->created, JText::_('d M Y'))?></div>
			<?php endif; ?>
			<div class="at-item-info">
				<?php echo str_replace('...', '', JHtml::_('string.truncate', ($article->introtext), 100)); ?>
			</div>			
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>
