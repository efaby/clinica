<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('JPATH_BASE') or die;


// Load search tools
JHtml::_('searchtools.form');

?>

<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<label for="filter_search" 
				aria-invalid="false" class="element-invisible"><?php echo JText::_('COM_RESERVACIONES_CLIENTES_CEDULA'); ?></label>

			<div class="btn-wrapper input-append">
				<input type="text" name="filter_search" id="filter_search" class="validate-cedula"
						   placeholder="<?php echo JText::_('COM_RESERVACIONES_CLIENTES_CEDULA'); ?>"
						   value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
						   title="<?php echo JText::_('COM_RESERVACIONES_CLIENTES_CEDULA'); ?>" style="width: 150px;""/>
				<button type="submit" class="btn hasTooltip validate" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i>
				</button>
			</div>
			<div class="btn-wrapper">
				<button type="button" class="btn hasTooltip js-stools-btn-clear" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_CLEAR'); ?>"
					onclick="jQuery(this).closest('form').find('input').val(''); jQuery(this).closest('form').submit();">
					<i class="icon-remove"></i>
				</button>
			</div>
		</div>
	</div>
	
</div>