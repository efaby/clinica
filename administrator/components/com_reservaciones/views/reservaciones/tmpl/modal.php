<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Reservaciones
 * @author     Wilmer <wilmeraguear@hotmail.es>
 * @copyright  Wilmer
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

?>
<table class="table table-striped" style="border: 1px solid #ddd">
<tr><th colspan="2"><?php echo JText::_("COM_RESERVACIONES_MODAL_DETALLE")?></th></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_FECHA1")?></td><td><?php echo $this->datosTurno->dia ." ". $this->datosTurno->fecha_reservacion;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_ESPECIALIDAD")?></td><td><?php echo $this->datosTurno->especialidad;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_DOCTOR")?></td><td><?php echo $this->datosTurno->name;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_PACIENTE")?></td><td><?php echo $this->datosTurno->nombres." ".$this->datosTurno->apellidos;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_FECHA2")?></td><td><?php echo $this->datosTurno->fecha_atencion;?></td></tr>
<tr><td><?php echo JText::_("COM_RESERVACIONES_MODAL_OBSERVACIONES")?></td><td><?php echo $this->datosTurno->observaciones;?></td></tr>
</table>