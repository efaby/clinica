<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	Templates.bluestork
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *	Input variable $list is an array with offsets:
 *		$list[prefix]		: string
 *		$list[limit]		: int
 *		$list[limitstart]	: int
 *		$list[total]		: int
 *		$list[limitfield]	: string
 *		$list[pagescounter]	: string
 *		$list[pageslinks]	: string
 *
 * pagination_list_render
 *	Input variable $list is an array with offsets:
 *		$list[all]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[start]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[previous]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[next]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[end]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[pages]
 *			[{PAGE}][data]		: string
 *			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 *	Input variable $item is an object with fields:
 *		$item->base	: integer
 *		$item->prefix	: string
 *		$item->link	: string
 *		$item->text	: string
 *
 * pagination_item_inactive
 *	Input variable $item is an object with fields:
 *		$item->base	: integer
 *		$item->prefix	: string
 *		$item->link	: string
 *		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
	// Initialise variables.
	$lang = JFactory::getLanguage();
	$html = "<div class=\"container\"><div class=\"pagination\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('JGLOBAL_DISPLAY_NUM').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"limit\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"" . $list['prefix'] . "limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div></div>";

	return '';
}

function pagination_list_render($list)
{
	// Initialise variables.
	$lang = JFactory::getLanguage();
	$html = null;

	$html .= '<div class="pagination_nav"><div class="left">';
	
	if ($list['start']['active']) {
		$html .= "<div class=\"start\">".$list['start']['data']."</div>";
	} else {
		$html .= "<div class=\"start off\">".$list['start']['data']."</div>";
	}
	if ($list['previous']['active']) {
		$html .= "<div class=\"prev\">".$list['previous']['data']."</div>";
	} else {
		$html .= "<div class=\"prev off\">".$list['previous']['data']."</div>";
	}
	
	$html .= '</div>';
	$html .= "<div class=\"center pages\">";
	foreach($list['pages'] as $page) {
		$html .= "<div class=\"page\">";
		$html .= $page['data'];
		$html .= "</div>";
	}
	
	$html .= "</div>";
	
	$html .= '<div class="right">';
	
	if ($list['next']['active']) {
		$html .= "<div class=\"next\">".$list['next']['data']."</div>";
	} else {
		$html .= "<div class=\"next off\">".$list['next']['data']."</div>";
	}
	if ($list['end']['active']) {
		$html .= "<div class=\"end\">".$list['end']['data']."</div>";
	} else {
		$html .= "<div class=\"end off\">".$list['end']['data']."</div>";
	}

	$html .= '</div></div>';
	
	return $html;
}

function pagination_item_active(&$item)
{
	if ($item->base>0)
		return "<a class=\"link-button button\" href=\"".$item->link."\" title=\"".$item->text."\" >".$item->text."</a>";
	else
		return "<a class=\"link-button button\" href=\"".$item->link."\" title=\"".$item->text."\" >".$item->text."</a>";
}

function pagination_item_inactive(&$item)
{
	return "<span class=\"link-button button\">".$item->text."</span>";
}
?>
