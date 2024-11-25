

CREATE TABLE `administrador` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `nombreAdmin` varchar(25) NOT NULL,
  `apellidoAdmin` varchar(30) NOT NULL,
  `passAd` varchar(25) NOT NULL,
  `CorreoEle` varchar(50) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `administrador` VALUES ('1000', 'María Guadalupe', 'Ruiz Soto', '7845', 'proyectos.iet.iif@upemor.edu.mx');


CREATE TABLE `alumno` (
  `idAlumno` int NOT NULL AUTO_INCREMENT,
  `nombreAlu` varchar(25) NOT NULL,
  `apellidoAlu` varchar(30) NOT NULL,
  `feNac` date NOT NULL,
  `matricula` varchar(25) NOT NULL,
  `correoE` varchar(70) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `confirmacionContra` varchar(15) NOT NULL,
  PRIMARY KEY (`idAlumno`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `alumno` VALUES ('1', 'Wendy', 'Moreno', '2004-08-05', 'MBWO220238', '', '123', '');
INSERT INTO `alumno` VALUES ('2', 'Dulce Yessenia', 'Villega Martinez', '2004-05-27', 'VMDO220377', '', '456', '');
INSERT INTO `alumno` VALUES ('3', 'Yatziry Amairani', 'Serrano Hernández', '2004-01-24', 'SHYO221058', '', '569', '');
INSERT INTO `alumno` VALUES ('4', 'Kevin', 'Trinidad Medina', '2004-02-10', 'TMK0220477', '', '785', '');


CREATE TABLE `evidencia` (
  `idEvi` int NOT NULL AUTO_INCREMENT,
  `nomenclatura` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  PRIMARY KEY (`idEvi`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `evidencia` VALUES ('1', 'OIG4.JPEG', 'C:/WAMP64/WWW/PRUEBASOFALLVERDUL/PROYESTANCIA2/OIG4.JPEG');
INSERT INTO `evidencia` VALUES ('2', 'HORARIOS ITI-IET.XLSX.PDF', 'C:/WAMP64/WWW/PRUEBASOFALLVERDUL/PROYESTANCIA2/HORARIOS ITI-IET.XLSX.PDF');
INSERT INTO `evidencia` VALUES ('3', 'EP1.MBWO220238.PDF', 'C:/WAMP64/WWW/PRUEBASOFALLVERDUL/PROYESTANCIA2/EP1.MBWO220238.PDF');
INSERT INTO `evidencia` VALUES ('4', 'EC2_PATRICKPÉREZ (1) (1).PDF', 'C:/WAMP64/WWW/PRUEBASOFALLVERDUL/PROYESTANCIA2/EC2_PATRICKPÉREZ (1) (1).PDF');
INSERT INTO `evidencia` VALUES ('5', 'EP1.MBWO220238.PDF', 'C:/WAMP64/WWW/PRUEBASOFALLVERDUL/PROYESTANCIA2/EP1.MBWO220238.PDF');


CREATE TABLE `justificante` (
  `idJusti` int NOT NULL AUTO_INCREMENT,
  `cuatrimestre` int NOT NULL,
  `grupo` varchar(5) NOT NULL,
  `carrera` varchar(10) NOT NULL,
  `periodoEscolar` varchar(25) NOT NULL,
  `motivo` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  `ausenteTodoDia` tinyint(1) NOT NULL,
  `motivoExtra` varchar(200) DEFAULT NULL,
  `estado` varchar(30) DEFAULT 'Pendiente',
  `idEvi` int DEFAULT NULL,
  `idAlumno` int DEFAULT NULL,
  PRIMARY KEY (`idJusti`),
  KEY `idEvi` (`idEvi`),
  KEY `idAlumno` (`idAlumno`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante` VALUES ('1', '7', 'A', 'IET', 'INVIERNO 2025', 'NO APLICA', '2024-11-19', '00:00:00', '00:00:00', '1', 'SE LE DESCOMPUSO EL CARRO Y NO LE SABE A LA RUTA ', 'Aceptada', '1', '4');
INSERT INTO `justificante` VALUES ('3', '10', 'A', 'ITI', 'OTOÑO 2025', 'ENFERMEDAD', '2024-11-18', '00:00:00', '00:00:00', '1', 'NO APLICA', 'PENDIENTE', '3', '2');
INSERT INTO `justificante` VALUES ('4', '7', 'E', 'ITI', 'OTOÑO 2025', 'CAUSA DE FUERZA MAYOR', '2024-11-18', '09:50:00', '12:50:00', '0', 'NO APLICA', 'PENDIENTE', '4', '2');


CREATE TABLE `justificante_evento` (
  `idJustiEvento` int NOT NULL AUTO_INCREMENT,
  `nombreEvento` varchar(100) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date DEFAULT NULL,
  PRIMARY KEY (`idJustiEvento`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_evento` VALUES ('1', 'RALLY LATAM', '2024-11-18', '0000-00-00');


CREATE TABLE `justificante_evento_alumno` (
  `idJustiEveAlumno` int NOT NULL AUTO_INCREMENT,
  `nombreAlumno` varchar(50) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `grado` int DEFAULT NULL,
  `grupo` varchar(10) DEFAULT NULL,
  `carrera` varchar(10) DEFAULT NULL,
  `idJustiEvento` int NOT NULL,
  PRIMARY KEY (`idJustiEveAlumno`),
  KEY `idJustiEvento` (`idJustiEvento`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_evento_alumno` VALUES ('1', 'WENDY MORENO BENÍTEZ', 'MBWO220238', '7', 'A', 'ITI', '1');


CREATE TABLE `justificante_profesor` (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `idJusti` int DEFAULT NULL,
  `idProf` int DEFAULT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `idJusti` (`idJusti`),
  KEY `idProf` (`idProf`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_profesor` VALUES ('1', '1', '1050');
INSERT INTO `justificante_profesor` VALUES ('2', '1', '1051');
INSERT INTO `justificante_profesor` VALUES ('3', '3', '1051');
INSERT INTO `justificante_profesor` VALUES ('4', '5', '1051');


CREATE TABLE `motivo` (
  `idMotivo` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `docSolicitado` varchar(200) NOT NULL,
  PRIMARY KEY (`idMotivo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `motivo` VALUES ('1', 'Causa de fuerza mayor', 'Situaciones fuera del control del alumno como eventos imprevistos.', 'Fotografías tomadas al momento en un archivo PDF o documento que avale la falta (Todo en formato PDF).');
INSERT INTO `motivo` VALUES ('2', 'Enfermedad', 'Cuando un alumno se ve afectado por una enfermedad que le impide realizar sus actividades académicas', 'Recetas médicas, constancia, carnet o registro de cita (Todo en formato PDF).');
INSERT INTO `motivo` VALUES ('3', 'Problemas de Salud', 'El alumno tiene citas médicas o cita para análisis.', 'Recetas médicas, constancia, carnet, registro de cita y/o resultados de análisis (Todo en formato PDF).');
INSERT INTO `motivo` VALUES ('4', 'Accidente', 'Aplica para lesiones o daños que limitan temporalmente la capacidad del alumno de cumplir con las actividades o responsabilidades académicas.', 'Fotografías tomadas al momento, receta, constancia del IMSS o ISSTE en (Todo en archivo PDF).');
INSERT INTO `motivo` VALUES ('5', 'Trámite de carácter urgente', 'Trámite legal, gubernamental o personal, que el alumno no puede posponer', 'Documento proporcionado por la institución, fotografía de que asistió en el momento o documento de la cita (Todo en formato PDF).');


CREATE TABLE `pdf_generado` (
  `idPdf` int NOT NULL AUTO_INCREMENT,
  `idJusti` int NOT NULL,
  `nombrePdf` varchar(200) NOT NULL,
  `rutaPdf` varchar(200) NOT NULL,
  `fechaGeneracion` datetime NOT NULL,
  PRIMARY KEY (`idPdf`),
  KEY `idJusti` (`idJusti`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pdf_generado` VALUES ('1', '1', 'UPEMOR_IIF-ITI_1_TMK0220477.pdf', 'C:UsersEnriqueDesktopJustificantes2025/UPEMOR_IIF-ITI_1_TMK0220477.pdf', '2024-11-20 03:58:37');


CREATE TABLE `profesor` (
  `idProf` int NOT NULL AUTO_INCREMENT,
  `nombreProf` varchar(25) NOT NULL,
  `apellidoProf` varchar(30) NOT NULL,
  `puesto` varchar(10) NOT NULL,
  `passwordProf` varchar(25) NOT NULL,
  `correoElectronico` varchar(50) NOT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=MyISAM AUTO_INCREMENT=1052 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `profesor` VALUES ('1050', 'SANDRA ELIZABETH', 'LEÓN SOSA', 'PA', '1245', 'LSANDRA@UPEMOR.EDU.MX');
INSERT INTO `profesor` VALUES ('1051', 'DENY LIZBETH', 'HERNÁNDEZ RABADÁN', 'PTC', '7845', 'DHERNANDEZR@UPEMOR.EDU.MX');
