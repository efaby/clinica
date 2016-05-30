<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die;
?>
<div class="at-showcase-caroucel at-showcase-<?php echo $id;?>" style="visibility: hidden;">
	<?php
	if( $contenSource == 'default') :
		foreach ($list as $key => &$item) :
			$articleImage = json_decode($item->images);
			$articleLinks = json_decode($item->urls);
			$link = NULL;
			switch ($linkTo) {
				case 'urltao':
					$link = JURI::base().'index.php?option=com_content&view=article&id='.$item->id;
					break;
				case 'urltal':
					$link = $item->link;
					break;
				case 'urla':
					$link = $articleLinks->urla;
					break;	
				case 'urlb':
					$link = $articleLinks->urlb;
					break;
				case 'urlc':
					$link = $articleLinks->urlc;
					break;
				case 'unurl':
					$link = null;
					break;
			}
		?>
		<div class="at-caroucel-item at-showcase-item">
			<div class="at-item-image-wrap">
				<img class="at-item-image" src="<?php echo htmlspecialchars($articleImage->image_intro); ?>" alt="<?php echo $item->title;?>">
			</div>
			<?php if($articleTitle == 'true'):?>   
				<<?php echo $item_heading; ?> class="at-item-title">
			   	<?php if ($link != null) : ?>
				<a href="<?php echo $link;?>" <?php echo $newTabText;?>>
						<?php echo $item->title;?></a>
		        <?php else :?>
		        <?php echo $item->title; ?>
		        <?php endif; ?>
		        </<?php echo $item_heading; ?>>
	        <?php endif;?>
	        <?php if($articleIntro == 'true') :?>
			<div class="at-item-info">
				<?php echo str_replace('...', '', JHtml::_('string.truncate', ($item->introtext), $introlength)); ?>
			</div>
			<?php endif; ?>
			<?php if ($link != null && $readmoreBtn == 'true') :?>
				<div>
				<?php 
					echo '<a class="at_readmore" href="'.$link.'"';
					if($newTab=='true') echo " target='_blank'";
					echo ">";
					echo '<div class="at_readmore_text">'.$readmoreText.'</div></a>';
				?>
				</div>
			<?php endif; ?>
		</div>
		<?php endforeach;?>
	<?php endif;?>
</div>
<script type="text/javascript">
jQuery.noConflict();
(function($) { 	
	$(document).ready(function(){
		$(".at-showcase-<?php echo $id;?>").slick({
		  lazyLoad: 'ondemand',
		  slidesToShow: <?php echo $params->get('caroucelItemsShow');?>,
		  slidesToScroll: <?php echo $params->get('caroucelItemsScroll');?>,
		  dots: <?php echo $params->get('caroucelDots');?>,
		  swipeToSlide: true,
		  infinite: true,
		  adaptiveHeight: true,
		  responsive: [
		    {
		      breakpoint: 1280,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 1
		      }
		    },
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 1
		      }
		    },
		    {
		      breakpoint: 768,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});
	});
})(jQuery);
</script>