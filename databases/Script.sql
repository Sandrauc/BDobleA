-- MySQL Workbench Synchronization
-- Generated: 2020-12-03 15:17
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: GUTIERREZ

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `dbdoblea` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`usuario` (
  `id` INT(10) UNSIGNED NOT NULL,
  `nombres` VARCHAR(50) NOT NULL,
  `apellidos` VARCHAR(50) NOT NULL,
  `documento` BIGINT(19) NOT NULL,
  `telefono` BIGINT(19) UNSIGNED NOT NULL,
  `email` VARCHAR(70) NOT NULL,
  `user` VARCHAR(30) NOT NULL,
  `password` VARCHAR(30) NOT NULL,
  `rol` ENUM('Administrador', 'Contador') NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `ciudad_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_ciudad1_idx` (`ciudad_id` ASC) ,
  CONSTRAINT `fk_usuario_ciudad1`
    FOREIGN KEY (`ciudad_id`)
    REFERENCES `dbdoblea`.`ciudad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`ciudad` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departamento` VARCHAR(45) NOT NULL,
  `nombre_ciudad` VARCHAR(45) NOT NULL,
  `cod_dane` INT(10) UNSIGNED NOT NULL,
  `estado` ENUM('Activa', 'Inactiva') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`venta` (
  `id_ventas` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `valor_ total` DOUBLE NOT NULL,
  `metodo_pago` ENUM('Efectivo', 'Cuenta') NOT NULL,
  `estado` ENUM('En proceso', 'Finalizada', 'Cancelada') NOT NULL,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ventas`),
  INDEX `fk_venta_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_venta_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `dbdoblea`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`compra` (
  `id_compra` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio` DECIMAL NOT NULL,
  `proveedor` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_compra`),
  INDEX `fk_compra_persona1_idx` (`proveedor` ASC) ,
  CONSTRAINT `fk_compra_persona1`
    FOREIGN KEY (`proveedor`)
    REFERENCES `dbdoblea`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`detalle_compra` (
  `id_detalle_compra` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cantidad` INT(11) NOT NULL,
  `precio_unitario` DOUBLE NOT NULL,
  `compra_id` INT(10) UNSIGNED NOT NULL,
  `insumo_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_detalle_compra`),
  INDEX `fk_detalle_compra_compra1_idx` (`compra_id` ASC) ,
  INDEX `fk_detalle_compra_insumo1_idx` (`insumo_id` ASC) ,
  CONSTRAINT `fk_detalle_compra_compra1`
    FOREIGN KEY (`compra_id`)
    REFERENCES `dbdoblea`.`compra` (`id_compra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_compra_insumo1`
    FOREIGN KEY (`insumo_id`)
    REFERENCES `dbdoblea`.`insumo` (`id_insumo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`insumo` (
  `id_insumo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `stock` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_insumo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`produccion` (
  `id_produccion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `cantidad` MEDIUMINT(8) UNSIGNED NOT NULL,
  `producto_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_produccion`),
  INDEX `fk_inventario_producto1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_inventario_producto1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `dbdoblea`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`producto` (
  `id_producto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `tamano` MEDIUMINT(8) UNSIGNED NOT NULL,
  `precio` DOUBLE NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estado` ENUM('En stock', 'Agotado') NOT NULL,
  `stock` MEDIUMINT(9) NOT NULL,
  `precio_base` DOUBLE NOT NULL,
  `categoria` ENUM('Futbol', 'Microfutbol', 'FutbolDeSalon', 'Numero5', 'Futbol8', 'FutbolSala') NOT NULL,
  PRIMARY KEY (`id_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`detalle_insumo` (
  `id_insumo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `insumo_id` INT(10) UNSIGNED NOT NULL,
  `produccion_id` INT(10) UNSIGNED NOT NULL,
  `cantidad` MEDIUMINT(8) UNSIGNED NOT NULL,
  INDEX `fk_insumo_has_inventario_inventario1_idx` (`produccion_id` ASC) ,
  INDEX `fk_insumo_has_inventario_insumo_idx` (`insumo_id` ASC) ,
  PRIMARY KEY (`id_insumo`),
  CONSTRAINT `fk_insumo_has_inventario_insumo`
    FOREIGN KEY (`insumo_id`)
    REFERENCES `dbdoblea`.`insumo` (`id_insumo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_insumo_has_inventario_inventario1`
    FOREIGN KEY (`produccion_id`)
    REFERENCES `dbdoblea`.`produccion` (`id_produccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dbdoblea`.`detalle_venta` (
  `id_detalle_venta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cantidad` MEDIUMINT(8) UNSIGNED NOT NULL,
  `producto_id` INT(10) UNSIGNED NOT NULL,
  `venta_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  INDEX `fk_detalle_venta_producto1_idx` (`producto_id` ASC) ,
  INDEX `fk_detalle_venta_venta1_idx` (`venta_id` ASC) ,
  CONSTRAINT `fk_detalle_venta_producto1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `dbdoblea`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_venta_venta1`
    FOREIGN KEY (`venta_id`)
    REFERENCES `dbdoblea`.`venta` (`id_ventas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
