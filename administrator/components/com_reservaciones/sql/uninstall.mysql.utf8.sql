DROP TABLE IF EXISTS `#__reservaciones_reservacion`;
DROP TABLE IF EXISTS `#__reservaciones_turno`;
DROP TABLE IF EXISTS `#__reservaciones_dia`;
DROP TABLE IF EXISTS `#__reservaciones_estado`;
DROP TABLE IF EXISTS `#__reservaciones_doctor`;
DROP TABLE IF EXISTS `#__reservaciones_especialidad`;
DROP TABLE IF EXISTS `#__reservaciones_cliente`;


DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_reservaciones.%');
