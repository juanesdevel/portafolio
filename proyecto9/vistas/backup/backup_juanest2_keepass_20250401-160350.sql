-- Backup de la base de datos: juanest2_keepass
-- Fecha de creación: 2025-04-01 16:03:50

-- Estructura de la tabla mensualidades
CREATE TABLE `mensualidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dia_obligacion` int(2) NOT NULL,
  `fecha_del_pago` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor_fijo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `valor_pagado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ref_contrato` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `link_pago` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `nota` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Datos de la tabla mensualidades
INSERT INTO mensualidades VALUES ('1', 'Tigo', '3', '2025-02-03 12:34:00', '56090', '56090', '19831430', 'N/A', '0');
INSERT INTO mensualidades VALUES ('2', 'Tigo', '3', '2025-03-03 12:40:00', '56090', '56090', '19831430', 'N/A', '0');
INSERT INTO mensualidades VALUES ('4', 'Tigo', '3', '2025-03-29 13:11:00', '56090', '56090', '19831430', 'N/A', '0');
INSERT INTO mensualidades VALUES ('5', 'Funeraria', '15', '2025-01-15 13:17:00', '30100', '30100', 'N/A', 'N/A', '0');
INSERT INTO mensualidades VALUES ('6', 'Funeraria', '15', '2025-02-15 13:17:00', '30100', '30100', 'N/A', 'N/A', '0');
INSERT INTO mensualidades VALUES ('7', 'Funeraria', '15', '2025-03-15 14:27:00', '30100', '30100', 'N/A', 'N/A', 'ZULMA IVONE MONSALVE - Ahorros bancolombia - 10242720946');
INSERT INTO mensualidades VALUES ('8', 'Transporte Hija', '5', '2025-01-30 14:33:00', '140000', '30100', 'N/A', 'N/A', 'Se paga proporcional los días de enero');
INSERT INTO mensualidades VALUES ('9', 'Transporte Hija', '5', '2025-02-05 14:36:00', '140000', '140000', 'N/A', 'N/A', 'Mes de febrero');
INSERT INTO mensualidades VALUES ('10', 'Transporte Hija', '5', '2025-03-05 14:36:00', '140000', '140000', 'N/A', 'N/A', 'Mes de Marzo');
INSERT INTO mensualidades VALUES ('11', 'Comfama', '10', '2025-03-03 14:38:00', '491600', '491600', '5200035083', 'https://g-ma.co/KFi2HQ', 'Técnica de Confama - Resta: $2.379.301,00');
INSERT INTO mensualidades VALUES ('12', 'Comfama', '10', '2025-04-01 14:40:00', '491600', '491600', '5200035083', 'https://g-ma.co/KFi2HQ', 'Técnica de Confama - Resta: 1.887.701');
INSERT INTO mensualidades VALUES ('13', 'Coasist', '29', '2025-01-30 14:45:00', '----', '126324', '1389146', 'N/A', 'Factura EPM del vergel');
INSERT INTO mensualidades VALUES ('14', 'Coasist', '29', '2025-02-28 14:46:00', '----', '125796', '1389146', 'N/A', 'Factura EPM del vergel');
INSERT INTO mensualidades VALUES ('15', 'Coasist', '29', '2025-03-30 14:47:00', '----', '84280', '1389146', 'N/A', 'Factura EPM del vergel');
INSERT INTO mensualidades VALUES ('16', 'EPM', '30', '2024-12-30 14:49:00', '----', '102268', '12318092', 'N/A', 'Factura EPM La Palomera');
INSERT INTO mensualidades VALUES ('17', 'EPM', '30', '2025-01-30 14:50:00', '----', '124460', '12318092', 'N/A', 'Factura EPM La Palomera');
INSERT INTO mensualidades VALUES ('18', 'EPM', '30', '2025-02-28 14:51:00', '----', '118782', '12318092', 'N/A', 'Factura EPM La Palomera');
INSERT INTO mensualidades VALUES ('19', 'EPM', '30', '2025-03-30 14:51:00', '----', '126937', '12318092', 'N/A', 'Factura EPM La Palomera');

-- Estructura de la tabla servicios
CREATE TABLE `servicios` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `entidad` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `propietario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contrasena` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `nota` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Datos de la tabla servicios
INSERT INTO servicios VALUES ('112', 'juandeveloper.42web.io', 'juanesnet2016@gmail.com', 'if0_37356103', 'Developer.2025', 'https://dash.infinityfree.com/accounts');
INSERT INTO servicios VALUES ('113', 'juangallego.42web.io/htdocs', 'juanesnet2016@gmail.com', 'if0_37358701', 'EJuaROS4rY', 'https://dash.infinityfree.com/accounts');
INSERT INTO servicios VALUES ('114', 'Github', 'juanesnet2016@gmail.com', 'juanesnet2016@gmail.com', 'Developer.2025', 'https://juanesdevel.github.io/net/');
INSERT INTO servicios VALUES ('115', 'Infinityfree', 'juanesnet2016@gmail.com', 'juanesnet2016@gmail.com', 'Developer.2026', 'https://dash.infinityfree.com/register');
INSERT INTO servicios VALUES ('116', 'Infinityfree', 'juanesnet2016@gmail.com', 'juanesnet2016@gmail.com', 'Developer2027', 'usuarios.kesug.com');
INSERT INTO servicios VALUES ('117', 'Infinityfree', 'juanesnet2016@gmail.com', 'juanesnet2016@gmail.com', '074sbSkxl1qMI', 'electrofact.kesug.com');
INSERT INTO servicios VALUES ('118', 'HostGator', 'juanesnet2016@gmail.com', 'juanest2_', 'Developer.2026', 'juanesnet.com');
INSERT INTO servicios VALUES ('119', 'HostGator Base de datos', 'juanesnet2016@gmail.com', 'juanest2_2025', 'Developer.2026', 'DB juanest2_facturacion');
INSERT INTO servicios VALUES ('120', 'HostGator Base de datos', 'juanesnet2016@gmail.com', 'juanest2_keepass', 'Developer.2026', 'DB juanest2_keepass');
INSERT INTO servicios VALUES ('121', 'Gmail', 'Juan Esteban', 'juanesnet2016@gmail.com', 'Juanes.2023', 'Códigos recuperación: 7843 4694, 2474 6282, 3474 8025, 6473 9123, 3785 2410, 470');
INSERT INTO servicios VALUES ('122', 'Sena', 'Patricia Osorio', '1128462346', 'Patricia3233548872', '');
INSERT INTO servicios VALUES ('123', 'Tarjeta Civica', 'Patricia Osorio', '1128462346', '6060', '');
INSERT INTO servicios VALUES ('124', 'Gana', 'Patricia Osorio', '1128462346', 'Pato#1', '');
INSERT INTO servicios VALUES ('125', 'Sura', 'Patricia Osorio', '1128462346', '0525', '');
INSERT INTO servicios VALUES ('126', 'Protección', 'Patricia Osorio', 'patriciaosorio', '0525', '');
INSERT INTO servicios VALUES ('127', 'Humanitas', 'Patricia Osorio', '1128462346', '462346', '');
INSERT INTO servicios VALUES ('128', 'Ecar D.A', 'Juan Esteban', 'jegallego', 'Ecar.1987', '');
INSERT INTO servicios VALUES ('129', 'Nueva EPS', 'Alfredo', '71598112', '71598112Alfredo', '');
INSERT INTO servicios VALUES ('130', 'Keypago', 'Juan', '1036611055', '300814', '');
INSERT INTO servicios VALUES ('131', 'Metrosalud', 'Patricia Cano', '42765950', 'Patri.2023', 'https://resultadoslab.metrosalud.gov.co/');
INSERT INTO servicios VALUES ('132', 'Alcaldía de Medellín', 'Patricia Cano', '42765950', 'Patricia.2023', '');
INSERT INTO servicios VALUES ('133', 'Sofia plus', 'Juan', '1036611055', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('134', 'WIFI - Molina', 'Patricia Cano', 'Molina', '112845828825', '');
INSERT INTO servicios VALUES ('135', 'Hernán ocasiones', 'Juan', '1036611055', 'QnUbhun:=RNc', '');
INSERT INTO servicios VALUES ('136', 'Mi Xiaomi', 'Juan', '573008144841', 'Juan.2023', '');
INSERT INTO servicios VALUES ('137', 'Platzi', 'Juan', 'juanesnet2010@yahoo.com', 'Juan3145840329', '');
INSERT INTO servicios VALUES ('138', 'Airdroid', 'Juan', 'evelingallego2023@hotmail.com', 'evelin.2023', '');
INSERT INTO servicios VALUES ('139', 'Funeraria prever', 'Juan', '1036611055', '8383', '');
INSERT INTO servicios VALUES ('140', 'Segunda clave Bancolombia', 'Juan', 'N/A', '2020', '');
INSERT INTO servicios VALUES ('141', 'Bancolombia', 'Patricia Cano', '', 'Expofaro23', '');
INSERT INTO servicios VALUES ('142', 'Cifin', 'Juan', 'Juanesnet2010@yahoo.com', 'Bodeguero1', '');
INSERT INTO servicios VALUES ('143', 'Bancolombia', 'Juan', '', 'Bodeguero1', '');
INSERT INTO servicios VALUES ('144', 'Fondo Nacional del Ahorro', 'Juan', '1036611055', '8383', '');
INSERT INTO servicios VALUES ('145', 'UNE', 'Juan', 'juanesnet2010@yahoo.com', '3234677123', '');
INSERT INTO servicios VALUES ('146', 'Airdroid', 'Juan', 'Juanesnet2016@hotmail.com', 'Juan3145840329', '');
INSERT INTO servicios VALUES ('147', 'Instagram', 'Juan', '3145840329', '3145840329', '');
INSERT INTO servicios VALUES ('148', 'Mega', 'Juan', 'juanesnet20162@gmail.com', 'EvelinGallego', '');
INSERT INTO servicios VALUES ('149', 'Paypal', 'Juan', 'juanesnet2016@gmail.com', 'juan$3145840329', '');
INSERT INTO servicios VALUES ('150', 'PSE', 'Juan', 'juanesnet2010@yahoo.com', '?', '');
INSERT INTO servicios VALUES ('151', 'Comfama', 'Juan', 'juanesnet2016@gmail.com', 'juanes.2023', '');
INSERT INTO servicios VALUES ('152', 'Instagram', 'Juan', 'juanesnet2016@gmail.com', '3145840319', '');
INSERT INTO servicios VALUES ('153', 'Lola music', 'Juan', '3145840329', 'V423pf', '');
INSERT INTO servicios VALUES ('154', 'Midasoft', 'Juan', '1036611055', 'J1036611055', 'http://empleados.ecar.com.co/NGMidasoft/menu/0?onBoarding=false');
INSERT INTO servicios VALUES ('155', 'Github', 'Juan', 'juanesnet2016@gmail.com', 'Developer.2025', '');
INSERT INTO servicios VALUES ('156', 'freesqldatabase', 'Juan', 'juanesnet2016@gmail.com', 'Developer.2025', 'https://www.freesqldatabase.com/resetpass/');
INSERT INTO servicios VALUES ('157', 'infinityfree', 'Juan', 'juanesnet2016@gmail.com', 'Developer.2026', 'https://dash.infinityfree.com/register');
INSERT INTO servicios VALUES ('158', 'Microsoft', 'Juan', 'auxvalidaciones03@Laborstoriosecarsa.onmicrosoft.com', 'Lab.123*', '');
INSERT INTO servicios VALUES ('159', 'Tigoune', 'Juan', 'Juanesnet2016@gmail.com', 'Juan3145840329', '');
INSERT INTO servicios VALUES ('160', 'Medicamentos Colsubsidio', 'Juan', '?', 'Juan611055', '');
INSERT INTO servicios VALUES ('161', 'Tarjeta cívica 2', 'Juan', '1036611055', '6060', '');
INSERT INTO servicios VALUES ('162', 'Gana', 'Juan', 'CC', 'Juan#20', '');
INSERT INTO servicios VALUES ('163', 'Tarjeta Civica', 'Patricia Osorio', '', 'Patricia2020', '3233548872');
INSERT INTO servicios VALUES ('164', 'Gana', 'Patricia Osorio', 'CC', 'Pato#1', '');
INSERT INTO servicios VALUES ('165', 'Cifrado USB', 'Juan', '?', 'Juan31458403291036611055', '');
INSERT INTO servicios VALUES ('166', 'Protección', 'Juan', 'Juangallegocano', '103661', '');
INSERT INTO servicios VALUES ('167', 'Alkomprar', 'Juan', '1036611055', '', '');
INSERT INTO servicios VALUES ('168', 'Servidesk plus', 'Juan', '', 'Developer.2025', '');
INSERT INTO servicios VALUES ('169', 'softexpert', 'Juan', 'T1965', 'J3008144841', 'https://ecar.softexpert.com/softexpert/workspace?page=home');
INSERT INTO servicios VALUES ('170', 'Sofia plus', 'Patricia Osorio', '1128462346', '3195468662', '');
INSERT INTO servicios VALUES ('171', 'Jira', 'Juan', 'auxvalidaciones03@ecar.com.co', 'Developer.2025', '');
INSERT INTO servicios VALUES ('172', 'Linkedin', 'Juan', '', 'Developer.$2025', '');
INSERT INTO servicios VALUES ('173', 'bolt AI', 'Juan', 'juanesnet2016@gmail.com', 'Developer.2025', 'https://bolt.new/');
INSERT INTO servicios VALUES ('174', 'Pagina de empleo', 'Patricia', 'patriciaosorio0525@gmail.com', 'Patricia.2025', 'http://career8.successfactors.com');
INSERT INTO servicios VALUES ('175', 'Gmail', 'Patricia', 'posoriorestrepo@gmail.com', '1128462346.1996', '');
INSERT INTO servicios VALUES ('176', 'Datacredito', 'Patricia', 'patriciaosorio0525@gmail.com', 'Patri.1996', '');
INSERT INTO servicios VALUES ('177', 'Computrabajo', 'Patricia', 'patriciaosorio1996@gmail.com', '1128462346.1996', '');
INSERT INTO servicios VALUES ('178', 'Datacredito', 'Patricia', 'patriciaosorio0525@gmail.com', '1128462346.1996', '');
INSERT INTO servicios VALUES ('179', 'Nequi', 'Patricia', '3194584782', '', '');
INSERT INTO servicios VALUES ('181', 'V380 Camara', 'Juan', '3008144841', 'Camara.2024', 'Camara ( ubicada en Apto Santy)');
INSERT INTO servicios VALUES ('182', 'LG soporte tecnico', 'Juan', 'juanesnet2010@yahoo.com', 'Soporte.2024', '');
INSERT INTO servicios VALUES ('183', 'O-KAM-Pro', 'Juan', 'juanesnet2016@gmail.com', 'Camara.2024', 'Camara ( ubicada en Apto 113)');
INSERT INTO servicios VALUES ('184', 'Computrabajo 2', 'Juan', 'juanesnet2016@gmail.com', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('185', 'Datacredito', 'Juan', '1036611055', '08101987Jg$', '');
INSERT INTO servicios VALUES ('186', 'Notas Evelin', 'Juan', '1195214684', '3145840329h', '');
INSERT INTO servicios VALUES ('187', 'Facebook', 'Juan', '3008144841', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('188', 'Sura 2', 'Juan', '1036611055', '1987', '');
INSERT INTO servicios VALUES ('189', 'Alkomprar', 'Juan', '1036611055', '3145840329', '');
INSERT INTO servicios VALUES ('190', 'EPM', 'Juan', '1036611055', 'Juan$2021', '');
INSERT INTO servicios VALUES ('191', 'Cotrafa', 'Juan', 'JUANES2021', '8383', 'Frase de seguridad: Mirada fija hacia el fituro2021.');
INSERT INTO servicios VALUES ('192', 'Tigo', 'Juan', 'juanesnet2010@yahoo.com', 'Juan$3145840329', '');
INSERT INTO servicios VALUES ('193', 'Amazon', 'Juan', 'juanesnet2010@yahoo.com', '611055', '');
INSERT INTO servicios VALUES ('194', 'Binance', 'Juan', 'juanesnet2010@yahoo.com', 'Juan&3145840329', '');
INSERT INTO servicios VALUES ('195', 'Puntos Colombia', 'Juan', '1036611055', '6060', '');
INSERT INTO servicios VALUES ('196', 'Colsubsidio Emilce', 'Juan', '21516132', 'Emilce#1973', 'juanesnet2010@yahoo.com');
INSERT INTO servicios VALUES ('197', 'Midasoft 2', 'Juan', '1036611055', 'Juan$3145840329', 'http://empleados.ecar.com.co/NGMidasoft/menu/0?onBoarding=false');
INSERT INTO servicios VALUES ('198', 'Nequi 2', 'Juan', 'Tarjeta 424/Expira 01/28', '4093550018469100', '');
INSERT INTO servicios VALUES ('199', 'Gmail', 'Cecilia', 'socialmedellin.2025@gmail.com', 'Cecilia.2025', '');
INSERT INTO servicios VALUES ('200', 'Gmail', 'Cecilia', 'ceciliamariamejiamerino@gmail.com', 'Cecilia.2024', '');
INSERT INTO servicios VALUES ('201', 'Gmail', 'Cecilia', 'social1.cpt460@gmail.com', 'Cecilia.2024', '');
INSERT INTO servicios VALUES ('202', 'Gmail', 'Juan Esteban', 'juanesnet2016@gmail.com', 'Juanes.2023', 'Códigos recuperación: 7843 4694, 2474 6282, 3474 8025, 6473 9123, 3785 2');
INSERT INTO servicios VALUES ('203', 'Hotmail', 'Juan Esteban', 'Juanesnet2016@hotmail.com', 'Juanes.2023', '');
INSERT INTO servicios VALUES ('204', 'Yahoo', 'Juan Esteban', 'juanesnet2010@yahoo.com', '?', '');
INSERT INTO servicios VALUES ('205', 'Gmail', 'Patricia Cano', 'Patriciacano708@gmail.com', '337141200m', '');
INSERT INTO servicios VALUES ('206', 'Gmail', 'Patricia Cano', 'Patriciacano2018palomera@gmail.com', '3145840329', '');
INSERT INTO servicios VALUES ('207', 'Gmail', 'Juan Esteban', 'juanesnet20162@gmail.com', 'Evelin.123', '');
INSERT INTO servicios VALUES ('208', 'Hotmail', 'Evelin', 'evelingallego2023@hotmail.com', 'evelin.2023', '');
INSERT INTO servicios VALUES ('209', 'Misena', 'Juan Esteban', 'jegallego550@misena.edu.co', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('210', 'Soy.Sena', 'Juan Esteban', 'juan_egallegoc@soy.sena.edu.co', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('211', 'Ecar', 'Juan Esteban', 'auxvalidaciones03@ecar.com.co', 'Juan.2025', '');
INSERT INTO servicios VALUES ('212', 'Gmail', 'Patricia Osorio', 'patriciaosorio1996@gmail.com', '1128462346.1996', '');
INSERT INTO servicios VALUES ('213', 'Gmail', 'Patricia Osorio', 'patriciaosorio0525@gmail.com', '1128462346.1996', '');
INSERT INTO servicios VALUES ('214', 'Gmail', 'Juan Esteban', 'aipopular2025@gmail.com', 'Juan.3008144841', '');
INSERT INTO servicios VALUES ('215', 'Grupo-exito', 'Patricia Osorio', 'posorio644@grupo-exito.com', 'Asesoracesde.2025', '');
INSERT INTO servicios VALUES ('216', 'Convenio Confama', 'Patricia Osorio', 'Convenio Cesde', '48210', '');
INSERT INTO servicios VALUES ('217', 'Cuenta davivienda', 'Patricia Osorio', '1128462346', '000525', '0550036200866873');
INSERT INTO servicios VALUES ('218', 'Prisma (Icfes)', 'Juan Esteban', '1036611055', 'Juan.2025', '');
INSERT INTO servicios VALUES ('219', 'Comfama credito', '', '', '', 'Numero de Referencia 5200035083 Link de pago https://g-ma.co/KFi2HQ');
INSERT INTO servicios VALUES ('220', 'portafolio@juanesnet.com', '', '', 'Developer.2026', '');

-- Estructura de la tabla usuarios
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `rol_usuario` varchar(10) NOT NULL,
  `codigo_usuario` varchar(4) NOT NULL,
  `nombre_usuario` varchar(40) NOT NULL,
  `contrasena_usuario` varchar(70) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Datos de la tabla usuarios
INSERT INTO usuarios VALUES ('1', 'admin', '0001', 'juan', '$2y$10$B7dDk2qtum2EITN7UDeAWOVQxgOeGmwWbTv6RMPb7KqSQntTlicma');
INSERT INTO usuarios VALUES ('4', 'admin', '0002', 'admin', '$2y$10$wAY6dPDjdY.hcgFsHqTst.IFWYwz/AVgCGrrW5VutmvVZofIr7I62');
INSERT INTO usuarios VALUES ('5', 'admin', '0004', 'admin', '$2y$10$cKnvgWHZpI6cSVCAiVDji.RNUiTfoCM5A/Ssek3xfgXK.8w8jywyK');

