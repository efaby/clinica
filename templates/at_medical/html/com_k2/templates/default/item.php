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

<?php if(JRequest::getInt('print')==1): ?>
<!-- Print button at the top of the print page only -->
<a class="itemPrintThisPage" rel="nofollow" href="#" onclick="window.print();return false;">
	<span><?php echo JText::_('K2_PRINT_THIS_PAGE'); ?></span>
</a>
<?php endif; ?>

<!-- Start K2 Item Layout -->
<span id="startOfPageId<?php echo JRequest::getInt('id'); ?>"></span>

<div id="k2Container" class="at-item-page itemView <?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

	<?php if(
		$this->item->params->get('itemFontResizer') ||
		$this->item->params->get('itemPrintButton') ||
		$this->item->params->get('itemEmailButton') ||
		$this->item->params->get('itemSocialButton') ||
		$this->item->params->get('itemVideoAnchor') ||
		$this->item->params->get('itemImageGalleryAnchor') ||
		$this->item->params->get('itemCommentsAnchor')
	): ?>
  <div class="itemToolbar">
		<ul>
			<?php if($this->item->params->get('itemFontResizer')): ?>
			<!-- Font Resizer -->
			<li>
				<span class="itemTextResizerTitle"><?php echo JText::_('K2_FONT_SIZE'); ?></span>
				<a href="#" id="fontDecrease">
					<span><?php echo JText::_('K2_DECREASE_FONT_SIZE'); ?></span>
					<img src="<?php echo JURI::root(true); ?>/components/com_k2/images/system/blank.gif" alt="<?php echo JText::_('K2_DECREASE_FONT_SIZE'); ?>" />
				</a>
				<a href="#" id="fontIncrease">
					<span><?php echo JText::_('K2_INCREASE_FONT_SIZE'); ?></span>
					<img src="<?php echo JURI::root(true); ?>/components/com_k2/images/system/blank.gif" alt="<?php echo JText::_('K2_INCREASE_FONT_SIZE'); ?>" />
				</a>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemPrintButton') && !JRequest::getInt('print')): ?>
			<!-- Print Button -->
			<li>
				<a class="itemPrintLink" rel="nofollow" href="<?php echo $this->item->printLink; ?>" onclick="window.open(this.href,'printWindow','width=900,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes'); return false;">
					<span><?php echo JText::_('K2_PRINT'); ?></span>
				</a>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemEmailButton') && !JRequest::getInt('print')): ?>
			<!-- Email Button -->
			<li>
				<a class="itemEmailLink" rel="nofollow" href="<?php echo $this->item->emailLink; ?>" onclick="window.open(this.href,'emailWindow','width=400,height=350,location=no,menubar=no,resizable=no,scrollbars=no'); return false;">
					<span><?php echo JText::_('K2_EMAIL'); ?></span>
				</a>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemSocialButton') && !is_null($this->item->params->get('socialButtonCode', NULL))): ?>
			<!-- Item Social Button -->
			<li>
				<?php echo $this->item->params->get('socialButtonCode'); ?>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemVideoAnchor') && !empty($this->item->video)): ?>
			<!-- Anchor link to item video below - if it exists -->
			<li>
				<a class="itemVideoLink k2Anchor" href="<?php echo $this->item->link; ?>#itemVideoAnchor"><?php echo JText::_('K2_MEDIA'); ?></a>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemImageGalleryAnchor') && !empty($this->item->gallery)): ?>
			<!-- Anchor link to item image gallery below - if it exists -->
			<li>
				<a class="itemImageGalleryLink k2Anchor" href="<?php echo $this->item->link; ?>#itemImageGalleryAnchor"><?php echo JText::_('K2_IMAGE_GALLERY'); ?></a>
			</li>
			<?php endif; ?>

			<?php if($this->item->params->get('itemCommentsAnchor') && $this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
			<!-- Anchor link to comments below - if enabled -->
			<li>
				<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
					<!-- K2 Plugins: K2CommentsCounter -->
					<?php echo $this->item->event->K2CommentsCounter; ?>
				<?php else: ?>
					<?php if($this->item->numOfComments > 0): ?>
					<a class="itemCommentsLink k2Anchor" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<span><?php echo $this->item->numOfComments; ?></span> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
					</a>
					<?php else: ?>
					<a class="itemCommentsLink k2Anchor" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
					</a>
					<?php endif; ?>
				<?php endif; ?>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clr"></div>
  </div>
	<?php endif; ?>

  <div class="itemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('itemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="at-item-image-wrap item-image">
	  	<div class="at-item-image lazy" data-original="<?php echo $this->item->image; ?>" alt="<?php echo htmlspecialchars($this->item->image_caption); ?>"/> </div>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>
	  
	  <?php echo $this->item->event->AfterDisplayTitle; ?>
	
		<!-- K2 Plugins: K2AfterDisplayTitle -->
		<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	  	
		<?php if($this->item->params->get('catItemTitle')): ?>
		<!-- Item title -->
		<div class="at-page-header">
		  <h2>
				<?php if(isset($this->item->editLink)): ?>
				<!-- Item edit link -->
					<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
						<?php echo JText::_('K2_EDIT_ITEM'); ?>
					</a>
				<?php endif; ?>
		
		  	<?php if ($this->item->params->get('catItemTitleLinked')): ?>
				<a href="<?php echo $this->item->link; ?>">
		  		<?php echo $this->item->title; ?>
		  	</a>
		  	<?php else: ?>
		  	<?php echo $this->item->title; ?>
		  	<?php endif; ?>
		
		  	<?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
		  	<!-- Featured flag -->
		  	<span>
			  	<sup>
			  		<?php echo JText::_('K2_FEATURED'); ?>
			  	</sup>
		  	</span>
		  	<?php endif; ?>
		  </h2>
		</div>
		<?php endif; ?>
		
		<?php if($this->item->params->get('itemRating')): ?>
		<!-- Item Rating -->
		<div class="itemRatingBlock">
			<div class="itemRatingContainer">
			<span><?php echo JText::_('K2_RATE_THIS_ITEM'); ?></span>
			<div class="itemRatingForm">
				<ul class="itemRatingList">
					<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
					<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star"></a></li>
					<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars"></a></li>
					<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars"></a></li>
					<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars"></a></li>
					<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars"></a></li>
				</ul>
				<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
			</div>
		</div>
		<?php endif; ?>
	
	  <!-- Plugins: AfterDisplayTitle -->
	  <?php echo $this->item->event->AfterDisplayTitle; ?>
	
	  <!-- K2 Plugins: K2AfterDisplayTitle -->
	  <?php echo $this->item->event->K2AfterDisplayTitle; ?>
	  
	  
  <?php if(
    $this->item->params->get('catItemDateCreated') ||
    $this->item->params->get('catItemAuthor') ||
	$this->item->params->get('catItemHits') ||
	$this->item->params->get('catItemCategory') ||
	$this->item->params->get('itemTags')): ?>
	<div class="at-article-info">
		<dl class="article-info">
	  		<?php if($this->item->params->get('catItemDateCreated')): ?>
			<!-- Date created -->
			<dd class="create">
				<span class="icon-calendar"></span>
				<time datetime="<?php echo JHTML::_('date', $this->item->created, 'c'); ?>" itemprop="dateCreated">
					<?php echo JHTML::_('date', $this->item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
				</time>
			</dd>
			<?php endif; ?>
			<?php if($this->item->params->get('catItemAuthor')): ?>
				<!-- Item Author -->
			<span class="catItemAuthor">
			<dd class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span class="icon-user"></span>
				<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?> 
				<span itemprop="name">
					<?php if(isset($this->item->author->link) && $this->item->author->link): ?>
					<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
					<?php else: ?>
					<?php echo $this->item->author->name; ?>
					<?php endif; ?>
				</span>
			</dd>
			<?php endif; ?>
		
			<?php if($this->item->params->get('catItemHits')): ?>
			<!-- Item Hits -->
			<dd class="hits">
				<span class="icon-eye-open"></span>
				<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $this->item->hits; ?>" />
				<?php echo JText::_('K2_READ'); ?> <b><?php echo $this->item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
			</dd>
			<?php endif; ?>
		
			<?php if($this->item->params->get('catItemCategory')): ?>
			<!-- Item category name -->
			<dd class="category-name">
				<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
				<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
			</dd>
			<?php endif; ?>
			<div class="clr"></div>
		</dl>
		

	  <?php if(!empty($this->item->fulltext)): ?>
	  <?php if($this->item->params->get('itemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="itemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>
	  <?php if($this->item->params->get('itemFullText')): ?>
	  <!-- Item fulltext -->
	  <div class="itemFullText">
	  	<?php echo $this->item->fulltext; ?>
	  </div>
	  <?php endif; ?>
	  <?php else: ?>
	  <!-- Item text -->
	  <div class="itemFullText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>
	  
	  <?php if($this->item->params->get('itemTags') && count($this->item->tags)): ?>
			<!-- Item tags -->
				<div class="at-tags">
					<span class="icon-tags"> </span>
					<span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
					<?php foreach ($this->item->tags as $tag): ?>
					<span itemprop="keywords">
						<a class="label label-info" href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
					</span>
					<?php endforeach; ?>
					<div class="clr"></div>
				</div>
			<?php endif; ?>
			<div class="clearbreak"></div>
		</div>
		<?php endif; ?>

		<div class="clr"></div>

	  <?php if($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)): ?>
	  <!-- Item extra fields -->
	  <div class="itemExtraFields">
	  	<h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
	  	<ul>
			<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
			<?php if($extraField->value != ''): ?>
			<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
				<?php if($extraField->type == 'header'): ?>
				<h4 class="itemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
				<?php else: ?>
				<span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
				<span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span>
				<?php endif; ?>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
	    <div class="clr"></div>
	  </div>
	  <?php endif; ?>
	  
	  <?php if( $this->item->params->get('itemAttachments')): ?>
	  <div class="itemLinks">
		  <?php if($this->item->params->get('itemAttachments') && count($this->item->attachments)): ?>
		  <!-- Item attachments -->
		  <div class="itemAttachmentsBlock">
			  <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
			  <ul class="itemAttachments">
			    <?php foreach ($this->item->attachments as $attachment): ?>
			    <li>
				    <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
				    <?php if($this->item->params->get('itemAttachmentsCounter')): ?>
				    <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
				    <?php endif; ?>
			    </li>
			    <?php endforeach; ?>
			  </ul>
		  </div>
		  <?php endif; ?>
	
			<div class="clr"></div>
	  </div>
	  <?php endif; ?>
	
	  <?php if($this->item->params->get('itemVideo') && !empty($this->item->video)): ?>
	  <!-- Item video -->
	  <a name="itemVideoAnchor" id="itemVideoAnchor"></a>
	
	  <div class="itemVideoBlock">
	  	<h3 class="itemVideoBlockTitle"><?php echo JText::_('K2_MEDIA'); ?></h3>
	
			<?php if($this->item->videoType=='embedded'): ?>
			<div class="itemVideoEmbedded">
				<?php echo $this->item->video; ?>
			</div>
			<?php else: ?>
			<span class="itemVideo"><?php echo $this->item->video; ?></span>
			<?php endif; ?>
	
		  <?php if($this->item->params->get('itemVideoCaption') && !empty($this->item->video_caption)): ?>
		  <span class="itemVideoCaption"><?php echo $this->item->video_caption; ?></span>
		  <?php endif; ?>
	
		  <?php if($this->item->params->get('itemVideoCredits') && !empty($this->item->video_credits)): ?>
		  <span class="itemVideoCredits"><?php echo $this->item->video_credits; ?></span>
		  <?php endif; ?>
	
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>
	
	  <?php if($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)): ?>
	  <!-- Item image gallery -->
	  <a name="itemImageGalleryAnchor" id="itemImageGalleryAnchor"></a>
	  <div class="itemImageGallery">
		  <h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
		  <?php echo $this->item->gallery; ?>
	  </div>
	  <?php endif; ?>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php echo $this->item->event->K2AfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

	<?php if($this->item->params->get('itemTwitterButton',1) || $this->item->params->get('itemFacebookButton',1) || $this->item->params->get('itemGooglePlusOneButton',1)): ?>
	<!-- Social sharing -->
	<div class="itemSocialSharing">

		<?php if($this->item->params->get('itemTwitterButton',1)): ?>
		<!-- Twitter Button -->
		<div class="itemTwitterButton">
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"<?php if($this->item->params->get('twitterUsername')): ?> data-via="<?php echo $this->item->params->get('twitterUsername'); ?>"<?php endif; ?>>
				<?php echo JText::_('K2_TWEET'); ?>
			</a>
			<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('itemFacebookButton',1)): ?>
		<!-- Facebook Button -->
		<div class="itemFacebookButton">
			<div id="fb-root"></div>
			<script type="text/javascript">
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('itemGooglePlusOneButton',1)): ?>
		<!-- Google +1 Button -->
		<div class="itemGooglePlusOneButton">
			<g:plusone annotation="inline" width="120"></g:plusone>
			<script type="text/javascript">
			  (function() {
			  	window.___gcfg = {lang: 'en'}; // Define button default language here
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>
		<?php endif; ?>

		<div class="clr"></div>
	</div>
	<?php endif; ?>
  
  <?php if($this->item->params->get('itemNavigation') && !JRequest::getCmd('print') && (isset($this->item->nextLink) || isset($this->item->previousLink))): ?>
  <!-- Item navigation -->
  <ul class="pager pagenav">

		<?php if(isset($this->item->previousLink)): ?>
		<li class="previous">
			<a class="itemPrevious" href="<?php echo $this->item->previousLink; ?>">
				&lt;&nbsp;<?php echo 'Previous';//$this->item->previousTitle; ?>
			</a>
		</li>
		<?php endif; ?>

		<?php if(isset($this->item->nextLink)): ?>
		<li class="next">
			<a class="itemNext" href="<?php echo $this->item->nextLink; ?>">
				<?php echo 'Next'//$this->item->nextTitle; ?>&nbsp;&gt; 
			</a>
		</li>
		<?php endif; ?>

  </ul>
  <?php endif; ?>
  
<?php
/*
Note regarding 'Related Items'!
If you add:
- the CSS rule 'overflow-x:scroll;' in the element div.itemRelated {…} in the k2.css
- the class 'k2Scroller' to the ul element below
- the classes 'k2ScrollerElement' and 'k2EqualHeights' to the li element inside the foreach loop below
- the style attribute 'style="width:<?php echo $item->imageWidth; ?>px;"' to the li element inside the foreach loop below
...then your Related Items will be transformed into a vertical-scrolling block, inside which, all items have the same height (equal column heights). This can be very useful if you want to show your related articles or products with title/author/category/image etc., which would take a significant amount of space in the classic list-style display.
*/
?>
  
  <?php if($this->item->params->get('itemRelated') && isset($this->relatedItems)): ?>
 <!-- Related items by tag -->
	<div class="itemRelated">
		<h3 class="itemRelatedBlock"><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h3>
		<div class="at-related-items at-medical-effect-2 row">
		<?php
		$itemcount = 0;
		$counter = 0;
		foreach($this->relatedItems as $key=>$item): ?>	
			<div class="at-related-item col-md-<?php echo round((12 / count($this->relatedItems)));?>">
				<?php if($this->item->params->get('itemRelatedImageSize')): ?>
					<div class="at-image-intro-item">
							<div class="at-item-image lazy" data-original="<?php echo htmlspecialchars($item->image); ?>" alt="<?php K2HelperUtilities::cleanHtml($item->title); ?>">		
							</div>
					</div>
				<?php endif; ?>
				<?php if($this->item->params->get('itemRelatedTitle', 1)): ?>
					<h3 class="at-item-title" >
						<a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
					</h3>
				<?php endif; ?>
				<?php if($this->item->params->get('itemRelatedIntrotext')): ?>
					<div class="at-item-info"><?php echo str_replace('...', '', JHtml::_('string.truncate', ($item->introtext), 100));?>
					</div>
				<?php endif; ?>
	        </div>
		<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

<div class="clr"></div>

  <?php if($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias)): ?>
  <!-- Author Block -->
  <div class="itemAuthorBlock">
  	
  	<h3 class="itemAuthorName">
      	<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
      </h3>

    <div class="itemAuthorDetails">
	    <?php if($this->item->params->get('itemAuthorImage') && !empty($this->item->author->avatar)): ?>
	  	<img class="itemAuthorAvatar" src="<?php echo $this->item->author->avatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->item->author->name); ?>" />
	  	<?php endif; ?>

      <?php if($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)): ?>
      <span class="itemAuthorUrl"><?php echo JText::_('K2_WEBSITE'); ?> <a rel="me" href="<?php echo $this->item->author->profile->url; ?>" target="_blank"><?php echo str_replace('http://','',$this->item->author->profile->url); ?></a></span>
      <?php endif; ?>

      <?php if($this->item->params->get('itemAuthorEmail')): ?>
      <span class="itemAuthorEmail"><?php echo JText::_('K2_EMAIL'); ?> <?php echo JHTML::_('Email.cloak', $this->item->author->email); ?></span>
      <?php endif; ?>
      
      <?php if($this->item->params->get('itemAuthorDescription') && !empty($this->item->author->profile->description)): ?>
      	<?php echo $this->item->author->profile->description; ?>
      <?php endif; ?>

			<div class="clr"></div>

			<!-- K2 Plugins: K2UserDisplay -->
			<?php echo $this->item->event->K2UserDisplay; ?>

    </div>
    <div class="clr"></div>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)): ?>
  <!-- Latest items from author -->
	<div class="itemAuthorLatest">
		<h3><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo $this->item->author->name; ?></h3>
		<ul class="at-blog-link">
			<?php foreach($this->authorLatestItems as $key=>$item): ?>
			<li>
				<a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clr"></div>
	</div>
	<?php endif; ?>


  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php echo $this->item->event->K2AfterDisplay; ?>

  <?php if($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
  <!-- K2 Plugins: K2CommentsBlock -->
  <?php echo $this->item->event->K2CommentsBlock; ?>
  <?php endif; ?>

 <?php if($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)): ?>
  <!-- Item comments -->
  <a name="itemCommentsAnchor" id="itemCommentsAnchor"></a>

  <div class="at-itemComments">

	  <?php if($this->item->params->get('commentsFormPosition')=='above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
	  <!-- Item comments form -->
	  <div class="itemCommentsForm">
	  	<?php echo $this->loadTemplate('comments_form'); ?>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->numOfComments>0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))): ?>
	  <!-- Item user comments -->
	  <h3 class="itemCommentsCounter">
	  	<?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
	  </h3>

	  <ul class="itemCommentsList">
	    <?php foreach ($this->item->comments as $key=>$comment): ?>
	    <li style="padding-left: <?php echo ((int)$this->item->params->get('commenterImgWidth')+10); ?>px;" class="<?php echo (!$this->item->created_by_alias && $comment->userID==$this->item->created_by) ? " authorResponse" : ""; echo($comment->published) ? '':' unpublishedComment'; ?>">

				<?php if($comment->userImage): ?>
				<img class="at-k2-avatar" src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $this->item->params->get('commenterImgWidth'); ?>" />
				<?php endif; ?>

			<div class="commentAuthorName">
			    <?php if(!empty($comment->userLink)): ?>
			    <a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
			    	<?php echo $comment->userName; ?>
			    </a>
			    <?php else: ?>
			    <?php echo $comment->userName; ?>
			    <?php endif; ?>
		    </div>
		    
			<div class="commentDate">
		    	<?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?>
		    </div>
		    
			<div class="commentContent">
		    <p><?php echo $comment->commentText; ?></p>
		    </div>

				<?php if($this->inlineCommentsModeration || ($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest)))): ?>
				<span class="commentToolbar">
					<?php if($this->inlineCommentsModeration): ?>
					<?php if(!$comment->published): ?>
					<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_APPROVE')?></a>
					<?php endif; ?>

					<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_REMOVE')?></a>
					<?php endif; ?>

					<?php if($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest))): ?>
					<a class="modal" rel="{handler:'iframe',size:{x:560,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id)?>"><?php echo JText::_('K2_REPORT')?></a>
					<?php endif; ?>

					<?php if($comment->reportUserLink): ?>
					<a class="k2ReportUserButton" href="<?php echo $comment->reportUserLink; ?>"><?php echo JText::_('K2_FLAG_AS_SPAMMER'); ?></a>
					<?php endif; ?>

				</span>
				<?php endif; ?>

				<div class="clr"></div>
	    </li>
	    <?php endforeach; ?>
	  </ul>

	  <div class="itemCommentsPagination">
	  	<?php echo $this->pagination->getPagesLinks(); ?>
	  	<div class="clr"></div>
	  </div>
		<?php endif; ?>

		<?php if($this->item->params->get('commentsFormPosition')=='below' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
	  <!-- Item comments form -->
	  <div class="itemCommentsForm">
	  	<?php echo $this->loadTemplate('comments_form'); ?>
	  </div>
	  <?php endif; ?>

	  <?php $user = JFactory::getUser(); if ($this->item->params->get('comments') == '2' && $user->guest): ?>
	  		<div><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS'); ?></div>
	  <?php endif; ?>

  </div>
  <?php endif; ?>

	<?php if(!JRequest::getCmd('print')): ?>
	<div class="itemBackToTop">
		<a class="k2Anchor" href="<?php echo $this->item->link; ?>#startOfPageId<?php echo JRequest::getInt('id'); ?>">
			<?php echo JText::_('K2_BACK_TO_TOP'); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="clr"></div>
</div>
<!-- End K2 Item Layout -->