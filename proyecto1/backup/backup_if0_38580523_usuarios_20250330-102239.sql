-- Backup de la base de datos: if0_38580523_usuarios
-- Fecha de creación: 2025-03-30 10:22:39

-- Estructura de la tabla clientes
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nom_cliente` varchar(40) NOT NULL,
  `doc_cliente` varchar(10) NOT NULL,
  `cel1_cliente` varchar(13) NOT NULL DEFAULT '+57',
  `cel2_cliente` varchar(13) NOT NULL DEFAULT '+57',
  `direccion_cliente` varchar(50) NOT NULL,
  `correo_cliente` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla clientes
INSERT INTO clientes VALUES ('69', 'JUAN PABLO GOMEZ', '1145678901', '3023334455', '3023334455', 'Calle 60 Carrera 25 35', 'juanpablo@gmail.com');
INSERT INTO clientes VALUES ('70', 'LAURA SOFIA RODRIGUEZ', '1156789012', '3034445566', '3034445566', 'Calle 50 Calle  8-22', 'laura@gmail.com');
INSERT INTO clientes VALUES ('71', 'DIEGO ALEJANDRO PEREZ', '1167890123', '3045556677', '3045556677', 'Carrera 15 Calle 23-56', 'diego@gmail.com');
INSERT INTO clientes VALUES ('72', 'ANA CAMILA RAMIREZ', '1178901234', '3056667788', '3056667788', 'Diagonal 3 Calle 9-40', 'ana@gmail.com');
INSERT INTO clientes VALUES ('73', 'MIGUEL ANGEL TORRES', '1189012345', '3067778899', '3067778899', 'Calle 80 Calle 100-12', 'miguel258@gmail.com');
INSERT INTO clientes VALUES ('74', 'SANTIAGO JOSE HERNANDEZ', '1190123456', '3078889900', '3078889900', 'Transversal 45 Calle 67-89', 'santiago@gmail.com');

-- Estructura de la tabla devoluciones
CREATE TABLE `devoluciones` (
  `id_devolucion` int(10) NOT NULL AUTO_INCREMENT,
  `fecha_devo` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_devo` varchar(30) NOT NULL,
  `doc_cliente_devo` varchar(10) NOT NULL,
  `id_venta` varchar(10) NOT NULL,
  `ref_producto` varchar(4) NOT NULL,
  `unidades_pro` varchar(2) NOT NULL,
  `factura_devo` varchar(10) NOT NULL,
  `valor_devo` varchar(10) NOT NULL,
  `tipo_devo` varchar(15) NOT NULL,
  `descripcion_devo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_devolucion`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla devoluciones
INSERT INTO devoluciones VALUES ('55', '2025-03-26 20:43:00', 'admin', '', '223', 'UG21', '1', '1', '34990', 'Garantía', 'Prueba');
INSERT INTO devoluciones VALUES ('56', '2025-03-27 09:01:00', 'admin', '', '226', 'UG21', '1', '3', '34990', 'Garantía', 'Prueba');

-- Estructura de la tabla facturas
CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `no_factura` int(150) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Cerrada',
  `fecha_factura` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_anulacion` datetime NOT NULL,
  `descripcion_anulacion` varchar(200) NOT NULL DEFAULT 'N/A',
  `doc_cliente` varchar(10) NOT NULL,
  `nom_cliente` varchar(50) NOT NULL,
  `asesor` varchar(14) NOT NULL,
  `caja` varchar(2) NOT NULL,
  `forma_de_pago` varchar(15) NOT NULL,
  `total_venta_con_iva` varchar(10) NOT NULL,
  `doc_factura` varchar(200) NOT NULL DEFAULT 'C:\\Users\\GalleOso\\Documents\\Facturas',
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla facturas
INSERT INTO facturas VALUES ('130', '1', 'Abierta', '2025-03-28 06:20:29', '0000-00-00 00:00:00', 'N/A', '1167890123', 'DIEGO ALEJANDRO PEREZ', 'admin', '', '', '', 'C:\\Users\\GalleOso\\Documents\\Facturas');
INSERT INTO facturas VALUES ('131', '2', 'Cerrada', '2025-03-28 08:19:47', '0000-00-00 00:00:00', 'N/A', '1167890123', 'DIEGO ALEJANDRO PEREZ', 'admin', '', 'Tarjeta DÃ©bito', '32990.00', 'C:\\Users\\GalleOso\\Documents\\Facturas');

-- Estructura de la tabla productos
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `ref_producto` varchar(15) NOT NULL,
  `descripcion_producto` varchar(50) NOT NULL,
  `cat_producto` varchar(20) NOT NULL DEFAULT 'TECNOLOGIA',
  `valor_producto` varchar(10) NOT NULL,
  `unidades_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla productos
INSERT INTO productos VALUES ('28', 'SE19', 'Antena amplificadora', 'TECNOLOGIA', '49990', '20');
INSERT INTO productos VALUES ('29', 'TF20', 'Estuche para auriculares Profesionales', 'TECNOLOGIA', '14990', '75');
INSERT INTO productos VALUES ('30', 'UG21', 'Cable de carga USB', 'TECNOLOGIA', '34990', '47');
INSERT INTO productos VALUES ('31', 'VH22', 'Teclado inalámbrico', 'TECNOLOGIA', '74900', '40');
INSERT INTO productos VALUES ('32', 'WI23', 'Adaptador Bluetooth', 'TECNOLOGIA', '24990', '50');
INSERT INTO productos VALUES ('33', 'XJ24', 'Disco SSD 500GB', 'TECNOLOGIA', '124990', '18');
INSERT INTO productos VALUES ('34', 'YK25', 'Mousepad Gaming', 'TECNOLOGIA', '32990', '38');
INSERT INTO productos VALUES ('35', 'ZL26', 'Hub USB 3.0', 'TECNOLOGIA', '39900', '15');

-- Estructura de la tabla usuarios
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `rol_usuario` varchar(10) NOT NULL,
  `codigo_usuario` varchar(4) NOT NULL,
  `nombre_usuario` varchar(40) NOT NULL,
  `contrasena_usuario` varchar(60) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla usuarios
INSERT INTO usuarios VALUES ('70', 'asesor', '1965', 'juang', '$2y$10$LlVm7n4Cy.vX.ftSDWqROewtAl7O1nbm3Bh1k832vpa4MgAdhyqA.');
INSERT INTO usuarios VALUES ('71', 'asesor', '0001', 'carlosp', '$2y$10$hSA');
INSERT INTO usuarios VALUES ('98', 'admin', '0002', 'admin', '$2y$10$RRmjttH5.D4pmPFBYaOwFOcw1rGWGfRc6KN.Wod4s0A2HIvVSfrim');

-- Estructura de la tabla ventas
CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `factura_venta` int(150) NOT NULL,
  `fecha_hora_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `valor_total_venta` decimal(10,0) NOT NULL,
  `asesor_venta` varchar(30) NOT NULL,
  `unidades_venta` int(3) NOT NULL,
  `ref_prod_venta` varchar(10) NOT NULL,
  `producto_venta` varchar(50) NOT NULL,
  `valor_producto` varchar(10) NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'Realizada',
  PRIMARY KEY (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Datos de la tabla ventas
INSERT INTO ventas VALUES ('237', '1', '2025-03-28 06:21:01', '34990', 'admin', '1', 'UG21', 'Cable de carga USB', '34990', 'Realizada');
INSERT INTO ventas VALUES ('238', '2', '2025-03-28 08:20:17', '32990', 'admin', '1', 'YK25', 'Mousepad Gaming', '32990', 'Realizada');

