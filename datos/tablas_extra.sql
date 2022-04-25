/*
  TENEMOS QUE CREAR
  PROVEEDORES
  LABORATORIOS
  CONDICIONES DE LABORATORIOS.
  PRODUCTOS.
  TABLAS TEMPORALES DE STOCK.
  TABLAS DE PEDIDOS.
*/

CREATE TABLE `proveedores` (
  `proveedor_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `proveedor_order` smallint(5) NOT NULL default 0,
  `proveedor_cif` varchar(15) NOT NULL DEFAULT '0' DEFAULT '',
  `proveedor_nombre` varchar(255) NOT NULL DEFAULT '',
  `proveedor_email` varchar(255) NOT NULL DEFAULT '',
  `proveedor_nombrecomercial` varchar(255) NOT NULL DEFAULT '',
  `proveedor_direccion` varchar(100) NOT NULL DEFAULT '',
  `proveedor_poblacion` varchar(100) NOT NULL DEFAULT '',
  `proveedor_municipio` VARCHAR(100) NOT NULL DEFAULT '',
  `proveedor_idpais` TINYINT(4) NOT NULL DEFAULT '73',
  `proveedor_cp` varchar(10) NOT NULL,
  `proveedor_telefono` varchar(30) NOT NULL,
  `proveedor_pwd` varchar(255) NOT NULL,
  `proveedor_activo` tinyint(1) NOT NULL DEFAULT '1',
  `proveedor_pwd_token` varchar(255) NOT NULL,
  `proveedor_selectorvalidator` varchar(255) DEFAULT NULL,
  `proveedor_hashedvalidator` varchar(255) DEFAULT NULL,
  `proveedor_create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `proveedor_pwd_seed` varchar(255) DEFAULT NULL,
  `proveedor_pwd_seed_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `laboratorios` (
  `laboratorio_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `laboratorio_cif` varchar(15) NOT NULL DEFAULT '0' DEFAULT '',
  `laboratorio_nombre` varchar(255) NOT NULL DEFAULT '',
  `laboratorio_email` varchar(100) NOT NULL DEFAULT '',
  `laboratorio_nombrecomercial` varchar(100) NOT NULL DEFAULT '',
  `laboratorio_direccion` varchar(100) NOT NULL DEFAULT '',
  `laboratorio_poblacion` varchar(100) NOT NULL DEFAULT '',
  `laboratorio_municipio` VARCHAR(100) NOT NULL DEFAULT '',
  `laboratorio_idpais` TINYINT(4) NOT NULL DEFAULT '73',
  `laboratorio_cp` varchar(10) NOT NULL,
  `laboratorio_telefono` varchar(30) NOT NULL,
  `laboratorio_pwd` varchar(255) NOT NULL,
  `laboratorio_activo` tinyint(1) NOT NULL DEFAULT '1',
  `laboratorio_pwd_token` varchar(255) NOT NULL,
  `laboratorio_selectorvalidator` varchar(255) DEFAULT NULL,
  `laboratorio_hashedvalidator` varchar(255) DEFAULT NULL,
  `laboratorio_create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `laboratorio_pwd_seed` varchar(255) DEFAULT NULL,
  `laboratorio_pwd_seed_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`laboratorio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `productos` (
  `cod_nacional` varchar(255) NOT NULL default '',
  `producto_nombre` varchar(100) NOT NULL DEFAULT '',
  `producto_descripcion` varchar(255) NOT NULL DEFAULT '',
  `producto_pvp` decimal(7,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `condiciones` (
  `condicion_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `laboratorio_id` smallint(5) NOT NULL,
  `condicion_nombre` varchar(255) NOT NULL DEFAULT '',
  `condicion_cantidad_minima` smallint(5) NOT NULL DEFAULT -1,
  `condicion_cantidad_maxima` smallint(5) NOT NULL DEFAULT -1,
  `condicion_cantidad_minima_eur` smallint(5) NOT NULL DEFAULT -1,
  `condicion_cantidad_maxima_eur` smallint(5) NOT NULL DEFAULT -1,
  `condicion_tipo_descuento` tinyint(1) NOT NULL DEFAULT '0', /* 0 --> %   1 --> € directo  -->*/
  `condicion_cantidad_descuento` smallint(5) NOT NULL DEFAULT 0,
  `condicion_activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`condicion_id`)
  ,KEY (`laboratorio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `condiciones_productos` (
  `condicion_id` smallint(5) NOT NULL,
  `cod_nacional` varchar(255) NOT NULL default '',
  PRIMARY KEY (`condicion_id`,`cod_nacional`)
  ,KEY (`cod_nacional`,`condicion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `excel_incrementales` (
  `nombre_excel` varchar(255) NOT NULL default '',
  `num_registros` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`nombre_excel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `stock_necesario_incremental` (
  `nombre_excel` varchar(255) NOT NULL default '',
  `cod_nacional` varchar(255) NOT NULL DEFAULT '',
  `num_unidades` int(5) NOT NULL DEFAULT 0, /* L/2 + S*/
  PRIMARY KEY (`nombre_excel`,`cod_nacional`)
  ,KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `stock_necesario_externo`(
  `cod_nacional` varchar(255) NOT NULL DEFAULT '',
  `num_unidades` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `stock_extra`(
  `cod_nacional` varchar(255) NOT NULL DEFAULT '',
  `num_unidades` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `pedidos` (
  `pedido_id` int(5) NOT NULL AUTO_INCREMENT,
  `proveedor_id` smallint(5) NOT NULL,
  `pedido_realizado` tinyint(1) NOT NULL DEFAULT '0', /* 0 --> NO ATENDIDO   1 --> REALIZADO    -->*/
  `pedido_create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `pedido_realizado_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pedido_id`)
  ,KEY (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pedidos_productos`(
  `pedido_id` int(5) NOT NULL,
  `cod_nacional` varchar(255) NOT NULL DEFAULT '',
  `num_unidades` int(5) NOT NULL DEFAULT 0,
  `num_obtener` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pedido_id`,`cod_nacional`)
  ,KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pedidos_promociones`(
  `pedidopromo_id` int(5) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(5) NOT NULL,
  `nombre_promo` varchar(255) NOT NULL DEFAULT '',
  `beneficios` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`pedidopromo_id`)
  ,KEY (`pedido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `pedidostmp_productos`(
  `proveedor_id` smallint(5) NOT NULL,
  `cod_nacional` varchar(255) NOT NULL DEFAULT '',
  `num_unidades` int(5) NOT NULL DEFAULT 0,
  `num_obtener` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`proveedor_id`,`cod_nacional`)
  ,KEY (`cod_nacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pedidostmp_promociones`(
  `pedidopromotmp_id` int(5) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(5) NOT NULL,
  `nombre_promo` varchar(255) NOT NULL DEFAULT '',
  `beneficios` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`pedidopromotmp_id`)
  ,KEY (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
