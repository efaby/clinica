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

// Get user stuff (do not change)
$user = JFactory::getUser();

?>

<!-- Start K2 User Layout -->

<div id="k2Container" class="at-blog userView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title') && $this->params->get('page_title')!=$this->user->name): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('userFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if ($this->params->get('userImage') || $this->params->get('userName') || $this->params->get('userDescription') || $this->params->get('userURL') || $this->params->get('userEmail')): ?>
	<div class="at-userBlock">
	
		<?php if(isset($this->addLink) && JRequest::getInt('id')==$user->id): ?>
		<!-- Item add link -->
		<span class="userItemAddLink">
			<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->addLink; ?>">
				<?php echo JText::_('K2_POST_A_NEW_ITEM'); ?>
			</a>
		</span>
		<?php endif; ?>
	
		<?php if ($this->params->get('userImage') && !empty($this->user->avatar)): ?>
		<img class="at-k2-blog-user-avatar" src="<?php echo $this->user->avatar; ?>" alt="<?php echo htmlspecialchars($this->user->name, ENT_QUOTES, 'UTF-8'); ?>" style="width:<?php echo $this->params->get('userImageWidth'); ?>px; height:auto;" />
		<?php endif; ?>
		
		<?php if ($this->params->get('userName')): ?>
		<h2 class="at-user-name"><?php echo $this->user->name; ?></h2>
		<?php endif; ?>
		
		<?php if (($this->params->get('userURL') && isset($this->user->profile->url) && $this->user->profile->url) || $this->params->get('userEmail')): ?>
		<div class="userAdditionalInfo">
			<?php if ($this->params->get('userURL') && isset($this->user->profile->url) && $this->user->profile->url): ?>
			<span class="userURL">
				<?php echo JText::_('K2_WEBSITE_URL'); ?>: <a href="<?php echo $this->user->profile->url; ?>" target="_blank" rel="me"><?php echo $this->user->profile->url; ?></a>
			</span>
			<?php endif; ?>

			<?php if ($this->params->get('userEmail')): ?>
			<span class="userEmail">
				<?php echo JText::_('K2_EMAIL'); ?>: <?php echo JHTML::_('Email.cloak', $this->user->email); ?>
			</span>
			<?php endif; ?>	
		</div>
		<?php endif; ?>
		
		<div class="clr"></div>
		
		<?php if ($this->params->get('userDescription') && trim($this->user->profile->description)): ?>
		<div class="userDescription"><?php echo $this->user->profile->description; ?></div>
		<?php endif; ?>

		<div class="clr"></div>
		
		<?php echo $this->user->event->K2UserDisplay; ?>
		
		<div class="clr"></div>
	</div>
	<?php endif; ?>



	<?php if(count($this->items)): ?>
	<!-- Item list -->
	<div class="userItemList">
		<?php foreach ($this->items as $item): ?>
		
		<!-- Start K2 Item Layout -->
		<div class="at-blog-item userItemView<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)) echo ' userItemViewUnpublished'; ?>">
		
		<!-- Plugins: BeforeDisplay -->
		<?php echo $item->event->BeforeDisplay; ?>
			
		<!-- K2 Plugins: K2BeforeDisplay -->
		<?php echo $item->event->K2BeforeDisplay; ?>

		<div class="at-userItemBody">
		
			  <!-- Plugins: BeforeDisplayContent -->
			  <?php echo $item->event->BeforeDisplayContent; ?>
			  
			  <!-- K2 Plugins: K2BeforeDisplayContent -->
			  <?php echo $item->event->K2BeforeDisplayContent; ?>
		
			  <?php if($this->params->get('userItemImage') && !empty($item->imageGeneric)):?>
			  <!-- Item Image -->
			  <a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
			    <div class="at-item-image-wrap"> <div class="at-item-image lazy" data-original="<?php echo htmlspecialchars($item->imageLarge); ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"/> </div></div>
			  </a>
				<div class="clr"></div>
			  <?php endif; ?>
			  
			  <div class="at-page-header">
			  <h2>
					<?php if(isset($item->editLink)): ?>
					<!-- Item edit link -->
					<span class="catItemEditLink">
						<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $item->editLink; ?>">
							<?php echo JText::_('K2_EDIT_ITEM'); ?>
						</a>
					</span>
					<?php endif; ?>
			
			  	<?php if ($this->params->get('catItemTitleLinked')): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			
			  	<?php if($item->params->get('catItemFeaturedNotice') && $item->featured): ?>
			  	<!-- Featured flag -->
			  	<span>
				  	<sup>
				  		<?php echo JText::_('K2_FEATURED'); ?>
				  	</sup>
			  	</span>
			  	<?php endif; ?>
			  </h2>
			</div>
			
			<!-- Plugins: AfterDisplayTitle -->
			<?php echo $item->event->AfterDisplayTitle; ?>
			  
			<!-- K2 Plugins: K2AfterDisplayTitle -->
			<?php echo $item->event->K2AfterDisplayTitle; ?>
			
			<?php if(
		    $item->params->get('catItemDateCreated') ||
			$item->params->get('catItemHits') ||
			$item->params->get('catItemCategory')
			 ): ?>
			<dl class="article-info">
		  		<?php if($item->params->get('catItemDateCreated')): ?>
				<!-- Date created -->
				<dd class="create">
					<span class="icon-calendar"></span>
					<time datetime="<?php echo JHTML::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
						<?php echo JHTML::_('date', $item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
					</time>
				</dd>
				<?php endif; ?>
			
				<?php if($item->params->get('catItemHits')): ?>
				<!-- Item Hits -->
				<dd class="hits">
					<span class="icon-eye-open"></span>
					<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
					<?php echo JText::_('K2_READ'); ?> <b><?php echo $item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
				</dd>
				<?php endif; ?>
			
				<?php if($item->params->get('catItemCategory')): ?>
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
			
			  
			  <?php if($this->params->get('userItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="at-blog-introtext">
			  	<?php echo $item->introtext; ?>
			  </div>
			  <?php endif; ?>
		
				<div class="clr"></div>

			  <!-- Plugins: AfterDisplayContent -->
			  <?php echo $item->event->AfterDisplayContent; ?>
			  
			  <!-- K2 Plugins: K2AfterDisplayContent -->
			  <?php echo $item->event->K2AfterDisplayContent; ?>
		
			  <div class="clr"></div>
		  </div>
		  
		  <?php if($this->params->get('userItemCommentsAnchor') && ( ($this->params->get('comments') == '2' && !$this->user->guest) || ($this->params->get('comments') == '1')) ): ?>
			<!-- Anchor link to comments below -->
			<div class="catItemCommentsLink">
				<span class="icon-comment"></span>
				<?php if(!empty($item->event->K2CommentsCounter)): ?>
					<!-- K2 Plugins: K2CommentsCounter -->
					<?php echo $item->event->K2CommentsCounter; ?>
				<?php else: ?>
					<?php if($item->numOfComments > 0): ?>
					<a href="<?php echo $item->link; ?>#itemCommentsAnchor">
						<?php echo $item->numOfComments; ?> <?php echo ($item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
					</a>
					<?php else: ?>
					<a href="<?php echo $item->link; ?>#itemCommentsAnchor">
						<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
					</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		  
		  <?php if($item->params->get('catItemTags') && count($item->tags)): ?>
			<!-- Item tags -->
			<div class="at-tags">
				<span class="icon-tags"> </span>
				<span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
				<?php foreach ($item->tags as $tag): ?>
				<span itemprop="keywords">
					<a class="label label-info" href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
				</span>
				<?php endforeach; ?>
				<div class="clr"></div>
			</div>
			<?php endif; ?>
		
			<div class="clr"></div>
			
			<?php if ($item->params->get('userItemReadMore')): ?>
			<!-- Item "read more..." link -->
			<p class="at-readmore">
				<a href="<?php echo $item->link; ?>" class="btn" itemprop="url">
					<?php echo JText::_('K2_READ_MORE'); ?>
				</a>
			</p>
			<?php endif; ?>
			
			<div class="clr"></div>

		  <!-- Plugins: AfterDisplay -->
		  <?php echo $item->event->AfterDisplay; ?>
		  
		  <!-- K2 Plugins: K2AfterDisplay -->
		  <?php echo $item->event->K2AfterDisplay; ?>
			
			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if(count($this->pagination->getPagesLinks())): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>
	
	<?php endif; ?>

</div>

<!-- End K2 User Layout -->
