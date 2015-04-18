# SQL Manager 2011 for MySQL 5.1.0.2
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : siit


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  PRIMARY KEY (`id_cliente`)
)ENGINE=InnoDB
AUTO_INCREMENT=3 AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
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
  PRIMARY KEY (`id_paquete`)
)ENGINE=InnoDB
AUTO_INCREMENT=5 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
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
AUTO_INCREMENT=7 AVG_ROW_LENGTH=5461 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Structure for the `reserva` table : 
#

CREATE TABLE `reserva` (
  `Id_reserva` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `Fk_paquete` INTEGER(11) NOT NULL,
  `fk_cliente` INTEGER(11) NOT NULL,
  `valor` DOUBLE(15,3) DEFAULT NULL,
  `Fecha_pedido` DATE NOT NULL COMMENT 'El dia que tomo el servicio',
  `Fecha_reserva` DATE NOT NULL COMMENT 'para cuando estaria tomando el paquete',
  `Estado` ENUM('Cotizacion','Confirmado','No confirmado') NOT NULL COMMENT 'Aqui miramos si el cliente solo queria cotizar, si cotizo pero aun no confirma su compra y si confirma su compra del paquete',
  `Pago` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'N' COMMENT 'S= si ha pagado\r\nN= no ha pagado',
  PRIMARY KEY (`Id_reserva`),
  KEY `Fk_paquete` (`Fk_paquete`),
  KEY `fk_cliente` (`fk_cliente`),
  CONSTRAINT `reserva_fk1` FOREIGN KEY (`fk_cliente`) REFERENCES cliente (`id_cliente`),
  CONSTRAINT `reserva_fk11` FOREIGN KEY (`Fk_paquete`) REFERENCES paquete (`id_paquete`)
)ENGINE=InnoDB
AUTO_INCREMENT=19 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
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
  `Valor` DOUBLE(15,3) NOT NULL,
  `Estado` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'S' COMMENT 'S= si esta vigente\r\nN= no esta vigente',
  `Disponibilidad` CHAR(20) COLLATE latin1_swedish_ci DEFAULT 'N' COMMENT 'S= si esta disponible el servicio\r\nN= No esta disponible el servicio',
  `fk_sitio` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicios`),
  KEY `fk_Proveedor` (`fk_Proveedor`),
  KEY `fk_sitio` (`fk_sitio`),
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
  `porcentaje_admin` DOUBLE(15,3) NOT NULL COMMENT 'es el porcentaje de ganancia del administrador',
  `Disponible` CHAR(1) COLLATE utf8_general_ci DEFAULT 'S' COMMENT 'S=Si esta disponible\r\nN=No esta disponible',
  PRIMARY KEY (`id_servicios_paquete`),
  KEY `fk_paquete` (`fk_paquete`),
  KEY `fk_servicio` (`fk_servicio`),
  CONSTRAINT `servicios_paquete_fk1` FOREIGN KEY (`fk_paquete`) REFERENCES paquete (`id_paquete`),
  CONSTRAINT `servicios_paquete_fk2` FOREIGN KEY (`fk_servicio`) REFERENCES servicios (`id_servicios`)
)ENGINE=InnoDB
AUTO_INCREMENT=31 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `cliente` table  (LIMIT -497,500)
#

INSERT INTO `cliente` (`id_cliente`, `Nombres`, `Apellidos`, `TipoID`, `Numero_Id`, `Email`) VALUES 
  (1,'daniel','ante','','1061714365','dantethepersa@hotmail.com'),
  (2,'hector','montero','','1061737123','hector.javier@gmail.com');
COMMIT;

#
# Data for the `paquete` table  (LIMIT -496,500)
#

INSERT INTO `paquete` (`id_paquete`, `Nombre`, `Valor`, `Fecha_inicio`, `Fecha_fin`, `Disponible`, `Estado`, `Descripcion`, `urlFoto`) VALUES 
  (1,'paquete semana santa',200000,'2015-03-29','2015-04-04','S','S','La Semana Santa de Popayán es una celebración religiosa en la ciudad de Popayán, Colombia, de la pasión, muerte y resurrección de Jesucristo. La conmemoración incluye solemnes y multitudinarias procesiones que se vienen realizando ininterrumpidadamente desde el siglo XVI,1 desde la noche del Viernes de Dolores hasta la del sábado santo.\r\n\r\nEn estas procesiones están presentes imágenes de madera talladas por las escuelas artísticas de Sevilla, Granada, Andalucía, Quito, Italia, Francia y Popayán. Las efigies sobre andas o muebles con aditamentos especiales, como plataformas de madera con barrotes cargables, permiten representar los diferentes episodios narrados en los Evangelios, relativos a la pasión, Crucifixión, Muerte y Resurrección de Jesucristo.\r\n\r\nCada representación es llamada \"paso\" y es llevado sobre los hombros de los denominados cargueros por las calles, en un recorrido trazado en forma de cruz latina desde tiempo de la conquista, de alrededor 2 Km que incluye las principales iglesias y templos del centro de la ciudad. Estos desfiles se realizan entre las 20.00 y las 21:00 horas de martes a sábado santo.\r\n\r\nLas procesiones de Semana Santa de Popayán fueron inscritas en la lista representativa del Patrimonio Cultural Inmaterial de la Humanidad por la unesco en septiembre de 2009 y declaradas patrimonio cultural de la nación mediante la Ley 891 de 2004.','images/other/paquete-1.jpg'),
  (3,'paquete vacaciones de navidad',1250150,'2015-12-01','2016-01-01','N','S','El plato navideño “Noche Buena” se remonta a los viejos tiempos de la Popayán de antaño, de la colonia, cuando todavía no despuntaba la república. Los europeos utilizaron las frutas que encontraron aquí, para sustituir las que tenían allá en sus tierras rojas musulmanas; otras, las sembraron y se dieron tan abundantes que no hubo necesidad de importarlas. Este plato utilizamos mucha costumbre gastronomica indigena, afro, y europea, que dieron  el sabor de esta gran plato, personalmente  el mejor plato de navidad del mundo.','images/other/paquete-2.jpg'),
  (4,'nuevo paquete de mas',100000,'2014-02-01','2016-11-11','S','S','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tincidunt id massa eget scelerisque. Integer sollicitudin condimentum tincidunt. Duis suscipit, libero at posuere vehicula, lacus sem volutpat nisl, at molestie nunc tellus in ex. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vel tellus vitae felis aliquam eleifend. Nam eget egestas tellus. Integer posuere risus eget turpis laoreet, ac eleifend odio iaculis. Quisque ac mauris vitae augue pulvinar viverra. Nam est ante, rhoncus vitae accumsan nec, sollicitudin nec dui. Duis fermentum dapibus dui nec cursus. Cras massa massa, cursus ut turpis ac, ornare aliquet velit.\r\n\r\nMorbi consequat auctor justo vitae interdum. Nullam sed libero tellus. Aenean ut volutpat risus. Donec sed eleifend dui, at tempus mauris. Phasellus egestas at urna eu ultrices. Proin faucibus ultrices ligula, at congue purus convallis at. Fusce a ex facilisis mi imperdiet fermentum. Praesent vel nulla sed lectus molestie dictum. Phasellus leo arcu, ornare ut consectetur nec, mollis non est. Donec consequat bibendum risus vitae mollis.\r\n\r\nUt consectetur sit amet lacus ut volutpat. Sed dignissim placerat ante, id posuere turpis vestibulum facilisis. Vestibulum dignissim nulla nisi. Aenean malesuada nunc id ex iaculis consequat. Vivamus ornare sed nunc ac aliquet. Nunc pretium lectus vel felis mattis, nec pretium nunc eleifend. Aenean commodo feugiat diam ut blandit. Vestibulum posuere, mauris vel viverra ullamcorper, turpis neque dignissim dolor, ac dictum neque augue eu nisi. Pellentesque porttitor lacus in finibus feugiat.\r\n\r\nAenean posuere laoreet ullamcorper. In ex purus, malesuada nec suscipit ac, sagittis ut risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas quis augue a turpis gravida bibendum. Sed ac hendrerit massa. Suspendisse accumsan urna diam, a malesuada ex auctor sit amet. Sed magna justo, ullamcorper et venenatis ac, gravida sed ante. Aliquam lacinia dictum arcu, commodo placerat odio dictum eget. Nam lectus tellus, lobortis quis vehicula non, vulputate sit amet risus. Nullam eget mollis risus.\r\n\r\nUt nec ipsum at magna bibendum facilisis at vitae dolor. Pellentesque at dignissim neque. Aenean mattis viverra ultrices. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur feugiat dolor ut mi vulputate, ac finibus ligula ullamcorper. Nullam at nibh nisl. Vivamus condimentum quis erat id sagittis. In a sollicitudin sem. Nulla varius elementum commodo. Aliquam rhoncus felis quis condimentum pretium. Cras viverra tortor non ipsum molestie congue. Suspendisse rutrum sem sit amet nisi rutrum porttitor. Etiam sollicitudin consequat erat, varius commodo lorem condimentum porta. Nunc aliquet rutrum turpis, a ultricies sapien mollis ac.','images/other/popayan.jpg');
COMMIT;

#
# Data for the `proveedor` table  (LIMIT -494,500)
#

INSERT INTO `proveedor` (`id_proveedor`, `Nombre`, `Direccion`, `Telefono`, `Email`, `Nit`, `Descripcion`, `Estado`, `Codigo`) VALUES 
  (1,'restaurante','abc','8333333','restaurante@hotmail.com','123456','Descripcion de prueba 12312345678901234567890','A','PSIIT0001'),
  (2,'hotel1','acb','82222222','hotel@hotmail.com','1234567','','A','PSIIT0002'),
  (3,'finca1','cba','82111111','finca@hotmail.com','123456789','','A','PSIIT0003'),
  (4,'milo','milo','9292','milo@hotmmail','n22','','A','PSIIT0005'),
  (5,'milo','milo','9292','milo@hotmmail','n23','','A','PSIIT0006');
COMMIT;

#
# Data for the `reserva` table  (LIMIT -481,500)
#

INSERT INTO `reserva` (`Id_reserva`, `Fk_paquete`, `fk_cliente`, `valor`, `Fecha_pedido`, `Fecha_reserva`, `Estado`, `Pago`) VALUES 
  (1,1,2,0.000,'2015-03-01','2015-03-10','Cotizacion','S'),
  (2,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (3,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (4,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (5,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (6,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (7,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (8,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (9,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (10,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (11,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (12,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (13,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (14,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (15,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (16,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (17,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1'),
  (18,1,1,1.000,'0000-00-00','0000-00-00','Cotizacion','1');
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

INSERT INTO `servicios` (`id_servicios`, `Nombre`, `fk_Proveedor`, `Valor`, `Estado`, `Disponibilidad`, `fk_sitio`) VALUES 
  (1,'Empanadas de pipiam',1,200.000,'S','S',1),
  (2,'Suite por noche',2,50000.000,'S','S',1),
  (3,'sda',1,22.000,'S','N',1),
  (4,'sda',1,22.000,'S','N',1),
  (5,'prueba de servicio',1,2012.000,'S','N',1),
  (6,'prueba orden',1,29.000,'S','N',1),
  (7,'prueba orden2',1,29.000,'S','N',1),
  (8,'prueba orden24',1,29.000,'S','N',1),
  (9,'29mil',1,29000.000,'S','N',1);
COMMIT;

#
# Data for the `servicios_paquete` table  (LIMIT -475,500)
#

INSERT INTO `servicios_paquete` (`id_servicios_paquete`, `fk_paquete`, `fk_servicio`, `cantidad_servicios`, `valor_unitario_servicio`, `porcentaje_admin`, `Disponible`) VALUES 
  (1,1,2,1000,145.000,10.000,'S'),
  (2,1,1,1,150.000,10.000,'N'),
  (6,3,1,70,145.000,10.000,'S'),
  (7,3,2,31,40000.000,10.000,'S'),
  (11,1,1,1,1.000,1.000,'S'),
  (12,1,1,1,1.000,1.000,'N'),
  (13,1,1,1,12.000,1.000,'N'),
  (14,1,1,1,124.000,1.000,'N'),
  (15,1,2,1,124434.000,1.000,'N'),
  (16,1,2,1,124434.000,1.000,'N'),
  (17,1,2,1,124434.000,1.000,'N'),
  (18,1,2,1,124434.000,1.000,'N'),
  (19,1,1,5,150.000,8.900,'N'),
  (20,1,1,5,150.000,8.900,'N'),
  (21,1,1,5,150.000,8.900,'N'),
  (22,3,2,1,213.000,2.800,'N'),
  (23,1,1,2,24.000,32.300,'N'),
  (24,1,1,2,2.000,2.000,'N'),
  (25,1,1,2,22.000,2.000,'N'),
  (26,1,1,2,22.000,2.000,'N'),
  (27,1,1,2,22.000,2.000,'N'),
  (28,1,1,2,22.000,2.000,'N'),
  (29,1,1,2,22.000,2.000,'N'),
  (30,1,1,2,22.000,2.000,'N');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;