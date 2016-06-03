<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('JPATH_BASE') or die;

JHtml::_('searchtools.form');

?>
<style>
<!--
#jform_filters_especialidad_id-lbl,
#jform_filters_dia_id-lbl,
#jform_filters_especialidad_id_chzn,
#jform_filters_dia_id_chzn{
	 display: inline-block;
}

#jform_filters_especialidad_id-lbl,
#jform_filters_dia_id-lbl{
	padding-right: 5px;
}

#jform_filters_especialidad_id_chzn,
#jform_filters_dia_id_chzn{
	width: 170px !important;
}

-->
</style>
<script type="text/javascript">

function resetearBusqueda(){

	jQuery("#filter_especialidad option[value='']").attr("selected", "selected");
	jQuery("#filter_dia option[value='']").attr("selected", "selected");
	jQuery('#adminForm').submit();
	
	
}

</script>

<div class="js-stools clearfix">
<div class="clearfix">
	<div class="js-stools-container-bar">
	<div class="btn-wrapper">
	<label for="for-filter-especialidad" class="element-invisible"><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_TURNO_ESPECIALIDAD'); ?></label>
	<select name="filter_especialidad" id="filter_especialidad" class="input-medium" >
		<option value=""><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_TURNO_ESPECIALIDAD'); ?></option>
			<?php echo JHtml::_('select.options', $this->especialidades, 'id', 'nombre',$this->escape($this->state->get('filter.especialidad'))); ?>
	</select>
	<label for="for-filter-dia" class="element-invisible"><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_TURNO_DIA'); ?></label>
	<select name="filter_dia" id="filter_dia" class="input-medium" >
		<option value=""><?php echo JText::_('COM_RESERVACIONES_FORM_LBL_TURNO_DIA'); ?></option>
			<?php echo JHtml::_('select.options', $this->dias, 'id', 'nombre',$this->escape($this->state->get('filter.dia'))); ?>
	</select>
	</div>
	
			<div class="btn-wrapper ">
				
				<button type="submit" class="btn hasTooltip" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i>
				</button>
			</div>
			<div class="btn-wrapper">
				<button type="button" class="btn hasTooltip js-stools-btn-clear" title=""
					data-original-title="<?php echo JText::_('COM_RESERVACIONES_SEARCH_FILTER_CLEAR'); ?>"
					onclick="javascript:resetearBusqueda();">
					<i class="icon-remove"></i>
				</button>
			</div>
			</div>
			</div>
			</div>
<div class="clr"></div>