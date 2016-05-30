<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */
defined('_JEXEC') or die;
$tmpheight = (int)$height + 14;
$tmpwidth = (int)$width + 14;
?>
<div class="at-social-<?php echo $effect;?>">
<ul class="at-social-list">
<?php
	foreach ($list as $social) : ?>
	<li class="at-social-item" style="height: <?php echo $tmpheight;?>px;width: <?php echo $tmpwidth;?>px;">
		<a href="<?php echo $social->link;?>" target="_blank"><div style="height: <?php echo $height;?>;width: <?php echo $width;?>;background-image: url('<?php echo htmlspecialchars($social->icon); ?>')"></div></a>
	</li>	
<?php endforeach;
?>
<li class="clearbreak"></li>
</ul>
</div>