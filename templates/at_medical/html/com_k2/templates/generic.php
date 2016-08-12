<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Generic (search/date) Layout -->
<div id="k2Container" class="at-blog genericView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title') || JRequest::getCmd('task')=='search' || JRequest::getCmd('task')=='date'): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if(JRequest::getCmd('task')=='search' && $this->params->get('googleSearch')): ?>
	<!-- Google Search container -->
	<div id="<?php echo $this->params->get('googleSearchContainer'); ?>"></div>
	<?php endif; ?>

	<?php if(count($this->items) && $this->params->get('genericFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>

	<div class="genericItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="at-blog-item">

		  <div class="genericItemBody">
			  <?php if($this->params->get('genericItemImage') && !empty($item->imageLarge)): ?>
			  <!-- Item Image -->
			  	<a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
			    	<div class="at-item-image-wrap"> <div class="at-item-image lazy" data-original="<?php echo htmlspecialchars($item->imageLarge); ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"/> </div></div>
			    </a>
			  <?php endif; ?>
			  
			<?php if($this->params->get('genericItemTitle')): ?>
			<!-- Item title -->
			<div class="at-page-header">
			  <h2>
			
			  	<?php if ($this->params->get('genericItemTitleLinked')): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h2>
			</div>
			<?php endif; ?>
			
			<?php if(
			    $this->params->get('genericItemDateCreated') ||
				$this->params->get('genericItemCategory')
				 ): ?>
				<dl class="article-info">
			  		<?php if($this->params->get('genericItemDateCreated')): ?>
					<!-- Date created -->
					<dd class="create">
						<span class="icon-calendar"></span>
						<time datetime="<?php echo JHTML::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
							<?php echo JHTML::_('date', $item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
						</time>
					</dd>
					<?php endif; ?>
				
					<?php if($this->params->get('genericItemCategory')): ?>
					<!-- Item category name -->
					<dd class="category-name">
						<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
						<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
					</dd>
					<?php endif; ?>
					<div class="clr"></div>
				</dl>
				<div class="clearbreak"></div>
				<?php endif; ?>

			  <?php if($this->params->get('genericItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="genericItemIntroText">
			  	<?php echo $item->introtext; ?>
			  </div>
			  <?php endif; ?>

			  <div class="clr"></div>
		  </div>

		  <div class="clr"></div>

		  <?php if($this->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->
		  <div class="genericItemExtraFields">
		  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<?php if($extraField->type == 'header'): ?>
					<h4 class="genericItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
					<?php else: ?>
					<span class="genericItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
					<span class="genericItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
		    <div class="clr"></div>
		  </div>
		  <?php endif; ?>
		  
		  <?php if ($this->params->get('genericItemReadMore')): ?>
		<!-- Item "read more..." link -->
		<p class="at-readmore">
			<a href="<?php echo $item->link; ?>" itemprop="url">
				<?php echo JText::_('K2_READ_MORE'); ?>
			</a>
		</p>
		<?php endif; ?>

			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->

		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php else: ?>

	<?php if(!$this->params->get('googleSearch')): ?>
	<!-- No results found -->
	<div id="genericItemListNothingFound">
		<p><?php echo JText::_('K2_NO_RESULTS_FOUND'); ?></p>
	</div>
	<?php endif; ?>

	<?php endif; ?>

</div>
<!-- End K2 Generic (search/date) Layout -->
