CREATE TABLE `condiciones_proveedor_multiple`(
   `condicion_id` smallint(5) NOT NULL,
  `proveedor_id` smallint(5) NOT NULL,
  PRIMARY KEY (`condicion_id`,`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `condiciones` ADD `unidades_oferta` SMALLINT(5) NOT NULL AFTER `condicion_cantidad_descuento`, ADD `unidades_regalo_oferta` SMALLINT(5) NOT NULL AFTER `unidades_oferta`;