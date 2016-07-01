<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$class = 'first';
JHtml::_('bootstrap.tooltip');
$lang	= JFactory::getLanguage();

if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) : ?>

	<?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
		<?php
		if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
		if (!isset($this->children[$this->category->id][$id + 1]))
		{
			$class = 'last';
		}
		?>
		<div class="panel at-icon-medical-shield <?php echo $class; ?>">
		<?php $class = ''; ?>
			<h3 class="panel-heading">
				<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id));?>">
				<?php echo $this->escape($child->title); ?>
				<?php if ($this->params->get('show_cat_num_articles_cat') == 1) :?>
					<span class="badge badge-info tip hasTooltip" title="<?php echo JHtml::tooltipText('COM_CONTENT_NUM_ITEMS'); ?>">
						<?php echo $child->numitems; ?>
					</span>
				<?php endif; ?>
				</a>
				<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
					<a id="category-btn-<?php echo $child->id;?>" href="#category-<?php echo $child->id;?>" 
						data-toggle="collapse" data-toggle="button" class="at-categories-btn"><span class="at-icon-plus"></span></a>
				<?php endif;?>
			</h3>
			<?php if ($this->params->get('show_description_image') && $child->getParams()->get('image')) : ?>
				<img src="<?php echo $child->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($child->getParams()->get('image_alt')); ?>" />
			<?php endif; ?>
			<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
				<?php if ($child->description) : ?>
					<div class="category-desc">
						<?php echo JHtml::_('content.prepare', $child->description, '', 'com_content.categories'); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) :?>
				<div class="collapse fade" id="category-<?php echo $child->id;?>">
				<?php
				$this->children[$child->id] = $child->getChildren();
				$this->parent = $child;
				$this->maxLevelcat--;
				echo $this->loadTemplate('items');
				$this->parent = $child->getParent();
				$this->maxLevelcat++;
				?>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
