-- -----------------------------------------------------
-- Table `#__reservaciones_cliente`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `#__reservaciones_cliente` (
`id` INT NOT NULL AUTO_INCREMENT,
`id_user` INT NOT NULL,
`cedula` VARCHAR(13)  NOT NULL ,
`nombres` VARCHAR(128)  NOT NULL ,
`apellidos` VARCHAR(128)  NOT NULL ,
`direccion` TEXT NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`celular` VARCHAR(255)  NOT NULL ,
`numero_ficha` VARCHAR(45)  NOT NULL ,
`edad` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
PRIMARY KEY (`id`)
-- ) DEFAULT COLLATE=utf8mb4_unicode_ci;
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `#__reservaciones_dia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_dia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(64) NULL,
  `state` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `#__reservaciones_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_estado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(64) NOT NULL,
  `descripcion` VARCHAR(512) NOT NULL,
  `state` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `#__reservaciones_especialidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_especialidad` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(128) NOT NULL,
  `descripcion` VARCHAR(512) NOT NULL,
  `state` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `#__reservaciones_doctor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_doctor` (
  `id` INT NOT NULL AUTO_INCREMENT,  
  `id_user` INT NOT NULL,
  `especialidad_id` INT NOT NULL,
  `cedula` VARCHAR(13)  NOT NULL ,
  `direccion` VARCHAR(512) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `celular` VARCHAR(45) NOT NULL,
  `state` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`),
  INDEX `fk_doctor_especialidad_idx` (`especialidad_id` ASC),
  CONSTRAINT `fk_doctor_especialidad`
    FOREIGN KEY (`especialidad_id`)
    REFERENCES `#__reservaciones_especialidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `#__reservaciones_turno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_turno` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `doctor_id` INT NOT NULL,
  `dia_id` INT NOT NULL,
  `hora_inicio` INT NOT NULL,
  `minuto_inicio` INT NOT NULL,
  `hora_fin` INT NOT NULL,
  `minuto_fin` INT NOT NULL,
  `numero_personas` INT NOT NULL,
  `state` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`),
  INDEX `fk_turno_doctor1_idx` (`doctor_id` ASC),
  INDEX `fk_turno_dias_dia1_idx` (`dia_id` ASC),
  CONSTRAINT `fk_turno_doctor1`
    FOREIGN KEY (`doctor_id`)
    REFERENCES `#__reservaciones_doctor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_turno_dias_dia1`
    FOREIGN KEY (`dia_id`)
    REFERENCES `#__reservaciones_dia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `#__reservaciones_reservacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__reservaciones_reservacion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `estado_id` INT NOT NULL,
  `turno_id` INT NOT NULL,
  `fecha_reservacion` DATE NOT NULL,
  `fecha_registro` DATE NOT NULL,
  `fecha_atencion` DATE NULL,
  `observaciones` VARCHAR(1024) NULL,
  `id_usuario_registro` INT NOT NULL,
  `id_usuario_atencion` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_reservacion_cliente1_idx` (`cliente_id` ASC),
  INDEX `fk_reservacion_estado1_idx` (`estado_id` ASC),
  INDEX `fk_reservacion_turno1_idx` (`turno_id` ASC),
  CONSTRAINT `fk_reservacion_cliente1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `#__reservaciones_cliente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservacion_estado1`
    FOREIGN KEY (`estado_id`)
    REFERENCES `#__reservaciones_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservacion_turno1`
    FOREIGN KEY (`turno_id`)
    REFERENCES `#__reservaciones_turno` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Cliente','com_reservaciones.cliente','{"special":{"dbtable":"#__reservaciones_cliente","key":"id","type":"Cliente","prefix":"ReservacionesTable"}}', '{"formFile":"administrator\/components\/com_reservaciones\/models\/forms\/cliente.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"direccion"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_reservaciones.cliente')
) LIMIT 1;

Insert into `#__reservaciones_dia` (`nombre`, `state`) values 
('Lunes',1),
('Martes',1),
('Miercoles',1),
('Jueves',1),
('Viernes',1),
('Sabado',1),
('Domingo',1);

INSERT INTO `#__reservaciones_estado` (`nombre`, `descripcion`, `state`) VALUES 
('Reservado', 'Turno Reservado', '1'),
('Cancelado', 'Turno cancelado', '1'),
('Atendido', 'Turno Atendido', '1');







