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
<style>
<!--
#filter_search,
#filter_doctor,
#filter_inicio,
#filter_fin{
	 display: inline-block;
	 margin-bottom: 0px;
}
</style>

<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<label for="filter_search" class="element-invisible"
				aria-invalid="false"><?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_CLIENTE'); ?></label>

			<div class="btn-wrapper ">
				<input type="text" name="filter_search" id="filter_search" class="validate-nombre"
						   placeholder="<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_CLIENTE'); ?>"
						   value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
						   title="<?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_CLIENTE'); ?>" style="width:120px;"/>
				
				<?php if(!$this->doctor):?>
				<label for="for-filter-doctor" class="element-invisible"><?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_DOCTOR'); ?></label>
					<select name="filter_doctor" id="filter_doctor" class="input-medium" >
						<option value=""><?php echo JText::_('COM_RESERVACIONES_RESERVACIONES_DOCTOR'); ?></option>
						<?php echo JHtml::_('select.options', $this->doctores, 'id', 'nombre',$this->escape($this->state->get('filter.doctor'))); ?>
					</select>				
				<?php endif;?>
				<input type="text" placeholder="Desde" id="filter_inicio" name="filter_inicio" value="<?php echo $this->escape($this->state->get('filter.search.inicio'));?>" style="width:90px;"  maxlength="8" size="10" class="validate-fecha">				
				<input type="text" placeholder="Hasta" id="filter_fin" name="filter_fin" value="<?php echo $this->escape($this->state->get('filter.search.fin'));?>" style="width:90px;"  maxlength="8" size="10" class="validate-fecha">	   
				<button type="button" class="btn hasTooltip validate" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_SUBMIT'); ?>"
					id="buscar-search-button">
					<i class="icon-search"></i>
				</button>
			</div>
			
			<div class="btn-wrapper">
				<button type="button" class="btn hasTooltip js-stools-btn-clear" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_CLEAR'); ?>"
					id="clear-search-button">
					<i class="icon-remove"></i>
				</button>
				
				<button type="button" class="btn hasTooltip js-stools-btn-export" title=""
					data-original-title="Exportar"
					id="export-search-button">
					<i class="icon-download"></i>
				</button>
				
			</div>
		</div>
	</div>
	
</div>

