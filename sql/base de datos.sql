# SQL Manager 2011 for MySQL 5.1.0.2
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : siit


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `siit`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `siit`;

#
# Structure for the `cliente` table : 
#

CREATE TABLE `cliente` (
  `id_cliente` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Nombres` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `Apellidos` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `TipoID` ENUM('Tarjeta de indentidad','Cedula de ciudadania','Cedula de extranjeria','Pasaporte') NOT NULL,
  `Numero_Id` VARCHAR(100) COLLATE latin1_swedish_ci NOT NULL,
  `Email` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `Telefono` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
)ENGINE=InnoDB
AUTO_INCREMENT=10 AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `cotizacion` table : 
#

CREATE TABLE `cotizacion` (
  `id_cotizacion` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` INTEGER(11) DEFAULT NULL,
  `Fecha_cotizacion` DATE DEFAULT NULL,
  `Fecha_inicio` DATE DEFAULT NULL,
  `Descripcion` TEXT COLLATE utf8_general_ci,
  `precio` DOUBLE(15,3) DEFAULT NULL,
  `Estado` VARCHAR(20) COLLATE utf8_general_ci DEFAULT 'P' COMMENT 'P=Pendiente\r\nA=Aprobado',
  PRIMARY KEY (`id_cotizacion`),
  KEY `id_usuario` (`id_cliente`),
  CONSTRAINT `cotizacion_fk1` FOREIGN KEY (`id_cliente`) REFERENCES cliente (`id_cliente`)
)ENGINE=InnoDB
AUTO_INCREMENT=18 AVG_ROW_LENGTH=1820 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `cotizacion_servicio` table : 
#

CREATE TABLE `cotizacion_servicio` (
  `id_cotizacion_servicio` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` INTEGER(11) DEFAULT NULL,
  `cantidad` INTEGER(11) DEFAULT NULL,
  `id_cotizacion` INTEGER(11) DEFAULT NULL,
  `Precio` DOUBLE(15,3) DEFAULT NULL,
  PRIMARY KEY (`id_cotizacion_servicio`)
)ENGINE=InnoDB
AUTO_INCREMENT=29 AVG_ROW_LENGTH=1260 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `departamento` table : 
#

CREATE TABLE `departamento` (
  `iddepartamento` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`iddepartamento`)
)ENGINE=InnoDB
AUTO_INCREMENT=33 AVG_ROW_LENGTH=512 CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci'
COMMENT=''
;

#
# Structure for the `municipio` table : 
#

CREATE TABLE `municipio` (
  `idmunicipio` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `departamento_iddepartamento` INTEGER(11) NOT NULL,
  `nombreMunicipio` VARCHAR(200) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idmunicipio`),
  KEY `departamento_iddepartamento` (`departamento_iddepartamento`),
  CONSTRAINT `municipio_fk1` FOREIGN KEY (`departamento_iddepartamento`) REFERENCES departamento (`iddepartamento`)
)ENGINE=InnoDB
AUTO_INCREMENT=43 AVG_ROW_LENGTH=381 CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci'
COMMENT=''
;

#
# Structure for the `paquete` table : 
#

CREATE TABLE `paquete` (
  `id_paquete` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(200) COLLATE latin1_swedish_ci DEFAULT NULL,
  `Valor` INTEGER(11) NOT NULL,
  `Fecha_inicio` DATE NOT NULL COMMENT 'fecha de inicio de la promocion',
  `Fecha_fin` DATE NOT NULL,
  `Disponible` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'N' COMMENT 'S=Si esta disponible\r\nN=No esta disponible',
  `Estado` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'S' COMMENT 'S=Si esta vigente el paquete\r\nN=No esta vigente',
  `Descripcion` TEXT COLLATE utf8_general_ci,
  `urlFoto` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL,
  `id_Muncipio` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id_paquete`),
  KEY `id_Muncipio` (`id_Muncipio`),
  CONSTRAINT `paquete_fk1` FOREIGN KEY (`id_Muncipio`) REFERENCES municipio (`idmunicipio`)
)ENGINE=InnoDB
AUTO_INCREMENT=65 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `proveedor` table : 
#

CREATE TABLE `proveedor` (
  `id_proveedor` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `Direccion` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL,
  `Telefono` VARCHAR(20) COLLATE latin1_swedish_ci NOT NULL,
  `Email` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `Nit` VARCHAR(100) COLLATE latin1_swedish_ci NOT NULL,
  `Descripcion` TEXT COLLATE utf8_general_ci,
  `Estado` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'A' COMMENT 'A=activo\r\nN=No activo',
  `Codigo` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `Nit` (`Nit`),
  UNIQUE KEY `Codigo` (`Codigo`),
  UNIQUE KEY `Codigo_2` (`Codigo`)
)ENGINE=InnoDB
AUTO_INCREMENT=12 AVG_ROW_LENGTH=5461 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `reserva` table : 
#

CREATE TABLE `reserva` (
  `Id_reserva` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Fk_paquete` INTEGER(11) DEFAULT NULL,
  `fk_cab_cotizacion` INTEGER(11) DEFAULT NULL,
  `fk_cliente` INTEGER(11) NOT NULL,
  `valor` DOUBLE(15,3) DEFAULT NULL,
  `Fecha_pedido` DATE NOT NULL COMMENT 'El dia que tomo el servicio',
  `Fecha_reserva` DATE NOT NULL COMMENT 'para cuando estaria tomando el paquete',
  `Estado` ENUM('Cotizacion','Confirmado','No confirmado') NOT NULL COMMENT 'Aqui miramos si el cliente solo queria cotizar, si cotizo pero aun no confirma su compra y si confirma su compra del paquete',
  `Pago` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'N' COMMENT 'S= si ha pagado\r\nN= no ha pagado',
  PRIMARY KEY (`Id_reserva`),
  KEY `Fk_paquete` (`Fk_paquete`),
  KEY `fk_cliente` (`fk_cliente`),
  CONSTRAINT `reserva_fk1` FOREIGN KEY (`fk_cliente`) REFERENCES cliente (`id_cliente`)
)ENGINE=InnoDB
AUTO_INCREMENT=16 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT='Este es el sistema para que los clientes puedan hacer o reservas, cotizaciones y saber sus estados'
;

#
# Structure for the `sitio_tipo` table : 
#

CREATE TABLE `sitio_tipo` (
  `id_sitio_tipo` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_sitio_tipo`)
)ENGINE=InnoDB
AUTO_INCREMENT=4 AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `sitios` table : 
#

CREATE TABLE `sitios` (
  `id_sitios` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL,
  `id_sitio_tipo` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id_sitios`),
  KEY `id_sitio_tipo` (`id_sitio_tipo`),
  CONSTRAINT `sitios_fk1` FOREIGN KEY (`id_sitio_tipo`) REFERENCES sitio_tipo (`id_sitio_tipo`)
)ENGINE=InnoDB
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `servicios` table : 
#

CREATE TABLE `servicios` (
  `id_servicios` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(200) COLLATE latin1_swedish_ci NOT NULL,
  `fk_Proveedor` INTEGER(11) NOT NULL,
  `Valor` DOUBLE(15,0) NOT NULL,
  `Estado` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'S' COMMENT 'S= si esta vigente\r\nN= no esta vigente',
  `Disponibilidad` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'N' COMMENT 'S= si esta disponible el servicio\r\nN= No esta disponible el servicio',
  `fk_sitio` INTEGER(11) DEFAULT NULL,
  `fk_municipio` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicios`),
  KEY `fk_Proveedor` (`fk_Proveedor`),
  KEY `fk_sitio` (`fk_sitio`),
  KEY `fk_municipio` (`fk_municipio`),
  CONSTRAINT `servicios_fk1` FOREIGN KEY (`fk_Proveedor`) REFERENCES proveedor (`id_proveedor`),
  CONSTRAINT `servicios_fk2` FOREIGN KEY (`fk_sitio`) REFERENCES sitios (`id_sitios`)
)ENGINE=InnoDB
AUTO_INCREMENT=10 AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `servicios_paquete` table : 
#

CREATE TABLE `servicios_paquete` (
  `id_servicios_paquete` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `fk_paquete` INTEGER(11) NOT NULL,
  `fk_servicio` INTEGER(11) NOT NULL,
  `cantidad_servicios` INTEGER(11) NOT NULL,
  `valor_unitario_servicio` DOUBLE(15,3) NOT NULL COMMENT 'El valor del servicio dentro del paquete',
  `porcentaje_admin` DOUBLE(15,3) NOT NULL DEFAULT 0.000 COMMENT 'es el porcentaje de ganancia del administrador',
  `Disponible` CHAR(1) COLLATE utf8_general_ci DEFAULT 'S' COMMENT 'S=Si esta disponible\r\nN=No esta disponible',
  PRIMARY KEY (`id_servicios_paquete`),
  KEY `fk_paquete` (`fk_paquete`),
  KEY `fk_servicio` (`fk_servicio`),
  CONSTRAINT `servicios_paquete_fk1` FOREIGN KEY (`fk_paquete`) REFERENCES paquete (`id_paquete`),
  CONSTRAINT `servicios_paquete_fk2` FOREIGN KEY (`fk_servicio`) REFERENCES servicios (`id_servicios`)
)ENGINE=InnoDB
AUTO_INCREMENT=9 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `cliente` table  (LIMIT -494,500)
#

INSERT INTO `cliente` (`id_cliente`, `Nombres`, `Apellidos`, `TipoID`, `Numero_Id`, `Email`, `Telefono`) VALUES 
  (1,'daniel','ante','','1061714365','dantethepersa@hotmail.com','8'),
  (2,'hector','montero','','1061737123','hector.javier@gmail.com','9'),
  (3,'Camilo ernesto','Ruiz vidal','Cedula de ciudadania','1061716139','milo9022@hotmail.com','8365678'),
  (8,'1','1','Tarjeta de indentidad','1','1','1'),
  (9,'daniel','ante','Cedula de ciudadania','32','DAN@HOT','345');
COMMIT;

#
# Data for the `cotizacion` table  (LIMIT -490,500)
#

INSERT INTO `cotizacion` (`id_cotizacion`, `id_cliente`, `Fecha_cotizacion`, `Fecha_inicio`, `Descripcion`, `precio`, `Estado`) VALUES 
  (8,3,'2015-05-04','2015-12-31','3333',NULL,'P'),
  (9,3,'2015-05-04','2015-12-31','3333',NULL,'P'),
  (10,3,'2015-05-04','2015-12-01','eee',NULL,'P'),
  (11,3,'2015-05-04','2015-12-31','33',NULL,'P'),
  (12,3,'2015-05-04','2015-12-31','222',NULL,'P'),
  (13,3,'2015-05-04','2015-12-31','ww',NULL,'P'),
  (14,3,'2015-05-04','2015-12-31','22',NULL,'P'),
  (16,3,'2015-05-07','0000-00-00','',NULL,'P'),
  (17,3,'2015-05-07','0000-00-00','',NULL,'P');
COMMIT;

#
# Data for the `cotizacion_servicio` table  (LIMIT -486,500)
#

INSERT INTO `cotizacion_servicio` (`id_cotizacion_servicio`, `id_servicio`, `cantidad`, `id_cotizacion`, `Precio`) VALUES 
  (2,2,4,1,50000.000),
  (3,2,4,1,50000.000),
  (4,2,4,1,50000.000),
  (5,2,4,1,50000.000),
  (6,2,4,1,50000.000),
  (7,2,4,1,50000.000),
  (8,2,4,1,50000.000),
  (23,2,48000,1,NULL),
  (24,2,2,1,NULL),
  (25,2,1,1,NULL),
  (26,2,2,1,49000.000),
  (27,NULL,0,1,0.000),
  (28,2,2,1,49999.000);
COMMIT;

#
# Data for the `departamento` table  (LIMIT -467,500)
#

INSERT INTO `departamento` (`iddepartamento`, `nombre`) VALUES 
  (1,'AMAZONAS'),
  (2,'ANTIOQUIA'),
  (3,'ARAUCA'),
  (4,'ATLÁNTICO'),
  (5,'BOLÍVAR'),
  (6,'BOYACÁ'),
  (7,'CALDAS'),
  (8,'CAQUETÁ'),
  (9,'CASANARE'),
  (10,'CAUCA'),
  (11,'CESAR'),
  (12,'CHOCÓ'),
  (13,'CÓRDOBA'),
  (14,'CUNDINAMARCA'),
  (15,'GUAINÍA'),
  (16,'GUAVIARE'),
  (17,'HUILA'),
  (18,'LA GUAJIRA'),
  (19,'MAGDALENA'),
  (20,'META'),
  (21,'NARIÑO'),
  (22,'NORTE DE SANTANDER'),
  (23,'PUTUMAYO'),
  (24,'QUINDÍO'),
  (25,'RISARALDA'),
  (26,'SAN ANDRÉS Y ROVIDENCIA'),
  (27,'SANTANDER'),
  (28,'SUCRE'),
  (29,'TOLIMA'),
  (30,'VALLE DEL CAUCA'),
  (31,'VAUPÉS'),
  (32,'VICHADA');
COMMIT;

#
# Data for the `municipio` table  (LIMIT -457,500)
#

INSERT INTO `municipio` (`idmunicipio`, `departamento_iddepartamento`, `nombreMunicipio`) VALUES 
  (1,10,'Almaguer'),
  (2,10,'Argelia'),
  (3,10,'Balboa'),
  (4,10,'Bolívar'),
  (5,10,'Buenos Aires'),
  (6,10,'Cajibío'),
  (7,10,'Caldono'),
  (8,10,'Caloto'),
  (9,10,'Corinto'),
  (10,10,'El Tambo'),
  (11,10,'Florencia'),
  (12,10,'Guapi'),
  (13,10,'Inzá'),
  (14,10,'Jambaló'),
  (15,10,'La Sierra'),
  (16,10,'La Vega'),
  (17,10,'López de Micay'),
  (18,10,'Mercaderes'),
  (19,10,'Miranda'),
  (20,10,'Morales'),
  (21,10,'Padilla'),
  (22,10,'Páez'),
  (23,10,'Patía (El Bordo)'),
  (24,10,'Piamonte'),
  (25,10,'Piendamó'),
  (26,10,'Popayán'),
  (27,10,'Puerto Tejada'),
  (28,10,'Puracé'),
  (29,10,'Rosas'),
  (30,10,'San Sebastián'),
  (31,10,'Santa Rosa'),
  (32,10,'Santander de Quilichao'),
  (33,10,'Silvia'),
  (34,10,'Sotará'),
  (35,10,'Suárez'),
  (36,10,'Sucre'),
  (37,10,'Timbío'),
  (38,10,'Timbiquí'),
  (39,10,'Toribío'),
  (40,10,'Totoró'),
  (41,10,'Villa Rica'),
  (42,10,'Guachené');
COMMIT;

#
# Data for the `paquete` table  (LIMIT -435,500)
#

INSERT INTO `paquete` (`id_paquete`, `Nombre`, `Valor`, `Fecha_inicio`, `Fecha_fin`, `Disponible`, `Estado`, `Descripcion`, `urlFoto`, `id_Muncipio`) VALUES 
  (1,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (2,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (3,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (4,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (5,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (6,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (7,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (8,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (9,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (10,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (11,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (12,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (13,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (14,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (15,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (16,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (17,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (18,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (19,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (20,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (21,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (22,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (23,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (24,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (25,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (26,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (27,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (28,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (29,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (30,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (31,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (32,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (33,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (34,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (35,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (36,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (37,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (38,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (39,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (40,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (41,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (42,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (43,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (44,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (45,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (46,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (47,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (48,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (49,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (50,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (51,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (52,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (53,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (54,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (55,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (56,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (57,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (58,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (59,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (60,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (61,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (62,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26),
  (63,'Prueba de paquete 1',64644,'2015-05-02','2015-05-28','S','S',NULL,'images/other/default.jpg',26),
  (64,'Prueba de paquete 2',1,'2015-05-02','2015-05-28','S','S','Prueba de que se cambio','images/other/default.jpg',26);
COMMIT;

#
# Data for the `proveedor` table  (LIMIT -491,500)
#

INSERT INTO `proveedor` (`id_proveedor`, `Nombre`, `Direccion`, `Telefono`, `Email`, `Nit`, `Descripcion`, `Estado`, `Codigo`) VALUES 
  (1,'restaurante','abc','8333333','restaurante@hotmail.com','123456','Descripcion de prueba 12312345678901234567890','A','PSIIT0001'),
  (2,'hotel1','acb','82222222','hotel@hotmail.com','1234567','descripcion 2','A','PSIIT0002'),
  (3,'finca1','cba','82111111','finca@hotmail.com','123456789','descripcion 3','A','PSIIT0003'),
  (4,'milo','milo','9292','milo@hotmmail','n22','Descripcion 4','A','PSIIT0005'),
  (5,'milo2','milo','9292','milo@hotmmail','n23','123','A','PSIIT0006'),
  (7,'MILO90222','IOSDF','908','980','80','890','A','PSIIT0008'),
  (10,'Juliana  Ruiz','Mi casa','3147703682','andreita1234@hotmail.com','12312','DASASDA','A','PSIIT000011'),
  (11,'nombre','direccion','8393939','proveedor@hotmail.com','938002','Descripcion','A','PSIIT000012');
COMMIT;

#
# Data for the `reserva` table  (LIMIT -484,500)
#

INSERT INTO `reserva` (`Id_reserva`, `Fk_paquete`, `fk_cab_cotizacion`, `fk_cliente`, `valor`, `Fecha_pedido`, `Fecha_reserva`, `Estado`, `Pago`) VALUES 
  (1,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (2,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (3,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (4,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (5,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (6,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (7,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (8,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (9,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (10,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (11,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (12,1,NULL,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (13,NULL,NULL,3,174000.000,'2015-05-04','2015-12-30','Cotizacion','N'),
  (14,NULL,7,3,174000.000,'2015-05-04','2015-12-30','Cotizacion','N'),
  (15,NULL,15,9,14450.000,'2015-05-04','2015-05-07','Cotizacion','N');
COMMIT;

#
# Data for the `sitio_tipo` table  (LIMIT -496,500)
#

INSERT INTO `sitio_tipo` (`id_sitio_tipo`, `descripcion`) VALUES 
  (1,'Municipio'),
  (2,'Vereda'),
  (3,'Corregimiento');
COMMIT;

#
# Data for the `sitios` table  (LIMIT -498,500)
#

INSERT INTO `sitios` (`id_sitios`, `descripcion`, `id_sitio_tipo`) VALUES 
  (1,'Popayán',1);
COMMIT;

#
# Data for the `servicios` table  (LIMIT -490,500)
#

INSERT INTO `servicios` (`id_servicios`, `Nombre`, `fk_Proveedor`, `Valor`, `Estado`, `Disponibilidad`, `fk_sitio`, `fk_municipio`) VALUES 
  (1,'Empanadas de pipiam',1,200,'S','S',1,1),
  (2,'Suite por noche',2,50000,'S','S',1,1),
  (3,'sda',1,22,'S','S',1,1),
  (4,'sda',1,22,'S','S',1,1),
  (5,'prueba de servicio',1,2012,'S','S',1,1),
  (6,'prueba orden',1,29,'N','N',1,1),
  (7,'prueba orden2',1,29,'S','S',1,1),
  (8,'prueba orden24',1,29,'S','S',1,1),
  (9,'29mil',1,29000,'S','S',1,1);
COMMIT;

#
# Data for the `servicios_paquete` table  (LIMIT -497,500)
#

INSERT INTO `servicios_paquete` (`id_servicios_paquete`, `fk_paquete`, `fk_servicio`, `cantidad_servicios`, `valor_unitario_servicio`, `porcentaje_admin`, `Disponible`) VALUES 
  (7,2,2,1,1.000,0.000,'S'),
  (8,1,2,2,32322.000,0.000,'S');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;