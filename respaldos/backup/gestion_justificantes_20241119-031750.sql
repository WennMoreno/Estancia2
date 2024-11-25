

CREATE TABLE `administrador` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `nombreAdmin` varchar(25) NOT NULL,
  `apellidoAdmin` varchar(30) NOT NULL,
  `passAd` varchar(25) NOT NULL,
  `CorreoEle` varchar(50) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=MyISAM AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `administrador` VALUES ('1000', 'María Guadalupe', 'Ruiz Soto', '7845', 'proyectos.iet.iif@upemor.edu.mx');
INSERT INTO `administrador` VALUES ('1001', 'dulce', 'villega', '741', 'vmdo220377@upemor.edu.mx');
INSERT INTO `administrador` VALUES ('1002', 'yessi', 'villega', '123', 'vmdo220277@upemor.edu.mx');


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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `evidencia` VALUES ('1', 'ingles.PNG', 'C:/wamp64/www/pruebasOfAllVerDul/proyEstancia2/ingles.PNG');
INSERT INTO `evidencia` VALUES ('2', 'ingles.PNG', 'C:/wamp64/www/pruebasOfAllVerDul/proyEstancia2/ingles.PNG');
INSERT INTO `evidencia` VALUES ('3', 'ingles.PNG', 'C:/wamp64/www/pruebasOfAllVerDul/proyEstancia2/ingles.PNG');


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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante` VALUES ('1', '7', 'a', 'ITI', 'Otoño 2025', 'No aplica', '2024-11-15', '08:04:00', '14:04:00', '0', 'por que se le olvido la  credencial', 'Pendiente', '1', '2');
INSERT INTO `justificante` VALUES ('2', '7', 'd', 'IET', 'Otoño 2025', 'No aplica', '2024-11-06', '00:00:00', '00:00:00', '1', 'se le olvido la credencial en su casa', 'Rechazada', '2', '1');
INSERT INTO `justificante` VALUES ('3', '7', 'a', 'ITI', 'Otoño 2025', 'No aplica', '2024-11-14', '11:00:00', '16:00:00', '0', 'falto por credencial', 'Pendiente', '3', '3');


CREATE TABLE `justificante_evento` (
  `idJustiEvento` int NOT NULL AUTO_INCREMENT,
  `nombreEvento` varchar(100) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date DEFAULT NULL,
  PRIMARY KEY (`idJustiEvento`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_evento` VALUES ('1', 'rally', '2024-11-06', '2024-11-08');
INSERT INTO `justificante_evento` VALUES ('2', 'jardines de mexico', '2024-11-11', '0000-00-00');


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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_evento_alumno` VALUES ('1', 'dulce', 'VMDO220377', '7', 'a', 'iti', '1');
INSERT INTO `justificante_evento_alumno` VALUES ('2', 'wendy', 'MBWO220238', '7', 'A', 'IET', '1');
INSERT INTO `justificante_evento_alumno` VALUES ('3', 'dulce', 'VMDO220377', '7', 'a', 'iti', '2');


CREATE TABLE `justificante_profesor` (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `idJusti` int DEFAULT NULL,
  `idProf` int DEFAULT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `idJusti` (`idJusti`),
  KEY `idProf` (`idProf`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `justificante_profesor` VALUES ('1', '2', '1050');
INSERT INTO `justificante_profesor` VALUES ('2', '2', '1051');
INSERT INTO `justificante_profesor` VALUES ('3', '2', '1054');


CREATE TABLE `motivo` (
  `idMotivo` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `docSolicitado` varchar(200) NOT NULL,
  PRIMARY KEY (`idMotivo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `motivo` VALUES ('1', 'Causas de fuerza mayor', 'Situaciones fuera del control del alumno como eventos imprevistos.', 'Fotografías tomadas');
INSERT INTO `motivo` VALUES ('6', 'Accidentes', 'son', 'imagen');
INSERT INTO `motivo` VALUES ('2', 'Enfermedad', 'Cuando un alumno se ve afectado por una enfermedad que le impide realizar sus actividades académicas', 'Recetas médicas, constancia, carnet o registro de cita (Todo en formato PDF).');
INSERT INTO `motivo` VALUES ('3', 'Problemas de Salu', 'El alumno tiene citas médicas o cita para análisis.', 'Recetas médicas, constancia, carnet, registro de cita y/o resultados de análisis');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



CREATE TABLE `profesor` (
  `idProf` int NOT NULL AUTO_INCREMENT,
  `nombreProf` varchar(25) NOT NULL,
  `apellidoProf` varchar(30) NOT NULL,
  `puesto` varchar(10) NOT NULL,
  `passwordProf` varchar(25) NOT NULL,
  `correoElectronico` varchar(50) NOT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=MyISAM AUTO_INCREMENT=1055 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `profesor` VALUES ('1050', 'Sandra Elizabeth', 'León Sosa', 'PTC', '1245', 'lsandra@upemor.edu.mx');
INSERT INTO `profesor` VALUES ('1051', 'Deny Lizbeth', 'Hernández Rabadán', 'PA', '7845', 'dhernandezr@upemor.edu.mx');
INSERT INTO `profesor` VALUES ('1053', 'dulce yessenia', 'villega martinez', 'PA', '741', 'vmdo220377@upemor.edu.mx');
INSERT INTO `profesor` VALUES ('1054', 'Sandra yessenia', 'villega martinez', 'PA', '789', 'vmdo220371@upemor.edu.mx');
