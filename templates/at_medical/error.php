<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$templateparams =  JFactory::getApplication()->getTemplate(true)->params;

if (($this->error->getCode()) == '404' && $templateparams->get('404_article') != '') {
	header('Location: '.$this->baseurl.'/index.php?option=com_content&view=article&id='.$templateparams->get('404_article'));
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/at_medical/css/template.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/at_medical/css/typography.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/at_medical/css/error.css" type="text/css" />
</head>
<body>
		<div class="error">
				<div id="error-code"><?php echo $this->error->getCode(); ?></div>
				<div id="error-message-wrap"><div class="error-message"><?php echo $this->error->getMessage(); ?></div></div>
				<div id="error-body">
				<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</p>
				<div id="techinfo">
				<p class="text-error"><?php echo $this->error->getMessage(); ?></p>
				<p class="text-error">
					<?php if ($this->debug) :
						echo $this->renderBacktrace();
					endif; ?>
				</p>
				</div>
				<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></p>
				<div class="back-home"><a class="button btn" href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></div>
				</div>
			</div>
			</div>
		</div>
</body>
</html>
