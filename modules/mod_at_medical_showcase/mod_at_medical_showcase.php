<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
$language = JFactory::getLanguage();
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'at.helper.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'at.showcase.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'at.articles.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'defined.php' );
$contenSource = mod_at_arrowzex_showcaseHelper::getcontentSource($params);
if( $contenSource == 'default'){
	$list = at_articles::getList($params);
	$catid = at_articles::getcati($params);
}
else if( $contenSource == 'k2' ){
	require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'at.k2content.php' );
	$list = at_k2content::getItems($params);
	$catid = at_k2content::getcati($params);
}
if (count($list)<1)return;
$linkTo = at_articles::getarticleLink($params);
$newTab = at_articles::getnewTab($params);
$articleTitle = at_articles::getarticleTitle($params);
$articleIntro = at_articles::getarticleIntro($params);

$showcaseWidth = AMSize::getWidth($params);
$showcaseheight = AMSize::getheight($params);
$cr = AMSize::getCopyRight($params);
$jquery = AMJquery::getJqueryVer($params);

$showcase= ASLayout::getshowcase($params);
$primaryCount = ASLayout::getprimaryCount($params);
$primaryColumns = ASLayout::getprimaryColumns($params);
$secondaryColumns = ASLayout::getsecondaryColumns($params);
$readmoreIcon = ASLayout::getreadmoreIcon($params);
$readmoreBtn = ASLayout::getreadmoreBtn($params);
$imgLightboxIcon = ASLayout::getimgLightboxIcon($params);
$item_heading = ASLayout::getitem_heading($params);
$readmoreText = ASLayout::getreadmoreText($params);
$introlength = at_articles::getintroLength($params);
$newTabText = '';
if($newTab == 'true'){
	$newTabText = "target='_blank'";
}
$id=uniqid();
$document = JFactory::getDocument();
?>
<div class="at-medical-showcase" style="width:<?php echo $showcaseWidth?>;">
<?php
require( JModuleHelper::getLayoutPath( AT_NAME , $showcase) );
?>
</div>
<script type="text/javascript">
jQuery.noConflict();
(function($) {
	function carousel_resize(showcase_element,negativePercent) {
		var showcaseHeight = showcase_element.parent().height();
		var negative = '-' + ( showcaseHeight *  negativePercent) + 'px';
		showcase_element.parent().parent().css('margin-top',negative);
	}
	var negativePercent = <?php echo $params->get('negativePosition');?>;
	$(window).load(function(){
		$(".at-showcase-<?php echo $id;?>").css('visibility','visible');
		carousel_resize($(".at-showcase-<?php echo $id;?>"),negativePercent);
	});
	$(window).resize(function() {
	 	carousel_resize($(".at-showcase-<?php echo $id;?>"),negativePercent);
	});
	
})(jQuery);
</script>