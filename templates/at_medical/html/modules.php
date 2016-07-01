<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

// No direct access
defined('_JEXEC') or die;

function modChrome_ATmodule($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule1($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-1 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><span><?php echo $module->title; ?><span></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule2($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-2 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule3($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-3 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule4($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-4 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule5($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-5 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule6($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-6 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><div><?php echo $module->title; ?></div></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule7($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-7 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><?php echo $module->title; ?></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}
function modChrome_ATmodule8($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="at-module at-module-8 <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> at-mod-<?php echo $module->id; ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="at-module-heading <?php echo htmlspecialchars($params->get('header_class')); ?>"><div><?php echo $module->title; ?></div></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="at-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}