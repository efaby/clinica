<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die;
$id = uniqid();
$document->addStyleSheet("modules/mod_at_medical_showcase/tmpl/banner/css/royal-slider.css");
$document->addStyleSheet("modules/mod_at_medical_showcase/tmpl/banner/css/skins/minimal-white/rs-minimal-white.css");
$document->addScript("modules/mod_at_medical_showcase/tmpl/banner/js/jquery.royalslider.min.js");
?>
<div class="at-royal-banner-showcase">
	<div class="at-showcase-<?php echo $id;?> at-mod-royal-slider royalSlider heroSlider rsMinW">
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
					<div class="rsContent">
						<div class="caption-Container">
							<?php echo $item->introtext;?>
						</div>
						<img class="rsImg" src="<?php echo JURI::base().htmlspecialchars($articleImage->image_intro); ?>" alt="image desc">
					</div>
				<?php endforeach;?>
			<?php endif;?>
	</div>
</div>
<script type="text/javascript">
jQuery.noConflict();
(function($) { 	
	$(document).ready(function(){
		$(".at-showcase-<?php echo $id;?>").royalSlider({
            arrowsNav: <?php echo $params->get('bannerNav');?>,
		    loop: <?php echo $params->get('bannerLoop');?>,
		    keyboardNavEnabled: true,
		    controlsInside: false,
		    arrowsNavAutoHide: false,
		    autoScaleSlider:false,
		    numImagesToPreload: 2,
			imageScaleMode:'fill',
			imageAlignCenter: false,
		    autoHeight: <?php echo $params->get('bannerAdaptiveHeight');?>,
		    controlNavigation: 'bullets',
		    thumbsFitInViewport: true,
		    navigateByClick: <?php echo $params->get('bannerNavClick');?>,
		    startSlideId: 0,
		    autoPlay: <?php echo $params->get('bannerAuto');?>,
		    transitionType:'<?php echo $params->get('bannerEffect');?>',
		    globalCaption: false,
		    fadeinLoadedSlide:	true,
		    deeplinking: {
		      enabled: true,
		      change: false
		    }
        }); 
	});
})(jQuery);
</script>
<div class="clearbreak"></div>