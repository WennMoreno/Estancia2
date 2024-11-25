DROP DATABASE IF EXISTS gestion_justificantes;
CREATE DATABASE gestion_justificantes;
USE gestion_justificantes;

/* CREACIÓN DE LAS TABLAS */
CREATE TABLE `administrador` (
  `idAdmin` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreAdmin` varchar(25) NOT NULL,
  `apellidoAdmin` varchar(30) NOT NULL,
  `passAd` varchar(25) NOT NULL,
  `CorreoEle` varchar(50) NOT NULL
)AUTO_INCREMENT = 1000;

CREATE TABLE `alumno` (
  `idAlumno` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreAlu` varchar(25) NOT NULL,
  `apellidoAlu` varchar(30) NOT NULL,
  `feNac` date NOT NULL,
  `matricula` varchar(25) NOT NULL, 
  `correoE` varchar(70) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `confirmacionContra` varchar(15) NOT NULL
)AUTO_INCREMENT = 1;  

CREATE TABLE `profesor` (
  `idProf` int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreProf` varchar(25) NOT NULL,
  `apellidoProf` varchar(30) NOT NULL,
  `puesto` varchar(10) NOT NULL,
  `passwordProf` varchar(25) NOT NULL,
  `correoElectronico` varchar(50) NOT NULL
)AUTO_INCREMENT = 1050;

CREATE TABLE `evidencia` (
  `idEvi` INT PRIMARY KEY AUTO_INCREMENT,
  `nomenclatura` VARCHAR(255) NOT NULL,
  `ruta` VARCHAR(255) NOT NULL
);

CREATE TABLE `motivo` (
  `idMotivo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `docSolicitado` varchar(200) NOT NULL
);

CREATE TABLE `justificante` (
  `idJusti` INT PRIMARY KEY AUTO_INCREMENT,
  `cuatrimestre` INT NOT NULL,
  `grupo` VARCHAR(5) NOT NULL,
  `carrera` VARCHAR(10) NOT NULL,
  `periodoEscolar` VARCHAR(25) NOT NULL,
  `motivo` VARCHAR(30) NOT NULL,
  `fecha` DATE NOT NULL,
  `horaInicio` TIME NULL,
  `horaFin` TIME NULL,
  `ausenteTodoDia` BOOLEAN NOT NULL,
  `motivoExtra` VARCHAR(200) NULL,
  `estado` VARCHAR(30) DEFAULT 'Pendiente',
  `idEvi` INT,
  `idAlumno` INT,
  FOREIGN KEY (`idEvi`) REFERENCES `evidencia`(`idEvi`),
  FOREIGN KEY (`idAlumno`) REFERENCES `alumno`(`idAlumno`)
);

CREATE TABLE `justificante_profesor` (
  `idDetalle` INT PRIMARY KEY AUTO_INCREMENT,
  `idJusti` INT,
  `idProf` INT,
  FOREIGN KEY (`idJusti`) REFERENCES `justificante`(`idJusti`),
  FOREIGN KEY (`idProf`) REFERENCES `profesor`(`idProf`)
); 

-- Crear la tabla pdf_generado
CREATE TABLE pdf_generado (
    idPdf INT AUTO_INCREMENT PRIMARY KEY,          -- ID del archivo PDF generado
    idJusti INT NOT NULL,                          -- Referencia al justificante
    nombrePdf VARCHAR(200) NOT NULL,               -- Nombre del archivo PDF generado
    rutaPdf VARCHAR(200) NOT NULL,                 -- Ruta de almacenamiento del archivo
    fechaGeneracion DATETIME NOT NULL,             -- Fecha y hora de generación del PDF
    FOREIGN KEY (idJusti) REFERENCES justificante(idJusti) -- Llave foránea hacia la tabla justificante
); 

CREATE TABLE justificante_evento (
    idJustiEvento INT AUTO_INCREMENT PRIMARY KEY,
    nombreEvento VARCHAR(100) NOT NULL,
    fechaInicio DATE NOT NULL,
    fechaFin DATE
);

CREATE TABLE justificante_evento_alumno (
    idJustiEveAlumno INT AUTO_INCREMENT PRIMARY KEY,
    nombreAlumno VARCHAR(50) NOT NULL,
    matricula VARCHAR(20) NOT NULL,
    grado INT,
    grupo VARCHAR(10),
    carrera VARCHAR(10),
    idJustiEvento INT NOT NULL,
    FOREIGN KEY (idJustiEvento) REFERENCES justificante_evento(idJustiEvento)
);


/** INSERCIONES DE LAS TABLAS */

/*INSERT INTO `alumno` (`nombreAlu`, `apellidoAlu`, `feNac`, `matricula`, `correoE`, `contrasena`, `confirmacionContra`) 
VALUES 
('Dulce Yessenia', 'Villega Martinez', '2004-05-27', 'VMDO220377', 'VMDO220377@Upemor.edu.mx', '456', '456');*/

INSERT INTO `profesor` (`nombreProf`, `apellidoProf`, `puesto`, `passwordProf`, `correoElectronico`) VALUES
(UPPER('Gil'), UPPER('Velasco Irma Yazmín'), UPPER('PTC'), 'password123', UPPER('ihernandez@upemor.edu.mx')),
(UPPER('Deny Lizbeth'), UPPER('Hernández Rabadán'), UPPER('PTC'), '789', UPPER('dhernandezr@upemor.edu.mx')),
(UPPER('Sandra Elizabeth'), UPPER('León Sosa'), UPPER('PTC'), '963', UPPER('lsandra@upemor.edu.mx')),
(UPPER('Roberto Enrique'), UPPER('López Díaz'), UPPER('PTC'), 'password123', UPPER('rlopezd@upemor.edu.mx')),
(UPPER('Daniel'), UPPER('Rojas Sandoval'), UPPER('PTC'), 'password123', UPPER('drojas@upemor.edu.mx')),
(UPPER('Miguel Ángel'), UPPER('Ruiz Jaimes'), UPPER('PTC'), 'password123', UPPER('mruiz@upemor.edu.mx')),
(UPPER('Juan Paulo'), UPPER('Sánchez Hernández'), UPPER('PTC'), 'password123', UPPER('juan.paulosh@upemor.edu.mx')),
(UPPER('Miguel Ángel'), UPPER('Velasco Castillo'), UPPER('PTC'), 'password123', UPPER('mvelasco@upemor.edu.mx'));


/*INSERT INTO `profesor` (`nombreProf`, `apellidoProf`, `puesto`, `passwordProf`, `correoElectronico`) VALUES
('Cardoso', 'Contreras Lorenzo Antonio', 'PA', 'password123', 'lcardosoc@upemor.edu.mx'),
('Carrera', 'Avendaño Edgardo de Jesus', 'PA', 'password123', 'ecarrera@upemor.edu.mx'),
('Castro', 'Martínez María Isabel', 'PA', 'password123', 'mcastro@upemor.edu.mx'),
('Chavarría', 'Carranza José René', 'PA', 'password123', 'jchavarria@upemor.edu.mx'),
('Delgado', 'Gonzaga Javier', 'PA', 'password123', 'jdelgadog@upemor.edu.mx'),
('Eloisa', 'Huerta Luz María', 'PA', 'password123', 'leloisa@upemor.edu.mx'),
('Eloisa', 'Huerta Rosario', 'PA', 'password123', 'rhuerta@upemor.edu.mx'),
('Garcia', 'Arroyo Joel', 'PA', 'password123', 'jgarciaa@upemor.edu.mx'),
('Gil', 'Palafox Ambar María', 'PA', 'password123', 'agilp@upemor.edu.mx'),
('Gómez', 'Núñez Eduardo', 'PA', 'password123', 'egomez@upemor.edu.mx'),
('Gómez', 'Tellez Daniel', 'PA', 'password123', 'dgomez@upemor.edu.mx'),
('Hernández', 'Soria Ángel Horacio', 'PA', 'password123', 'ahernandez@upemor.edu.mx'),
('Jiménez', 'Valle Oscar', 'PA', 'password123', 'ojimenez@upemor.edu.mx'),
('Juan', 'Zacarías José', 'PA', 'password123', 'jzacarias@upemor.edu.mx'),
('Minauro', 'Cervera Cesar Ricardo', 'PA', 'password123', 'cminauro@upemor.edu.mx'),
('Ramos', 'Palencia Celia', 'PA', 'password123', 'cramos@upemor.edu.mx'),
('Salgado', 'Arillo Erika', 'PA', 'password123', 'esalgadoa@upemor.edu.mx'),
('Sánchez', 'Godínez Antonia', 'PA', 'password123', 'asanchezg@upemor.edu.mx'),
('Silva', 'Brito Alfredo', 'PA', 'password123', 'asilvab@upemor.edu.mx'),
('Solano', 'García Enrique', 'PA', 'password123', 'esolano@upemor.edu.mx'),
('Zagal', 'Solano José Enrique', 'PA', 'password123', 'jzagal@upemor.edu.mx');*/


INSERT INTO `administrador` (`nombreAdmin`, `apellidoAdmin`, `passAd`, `CorreoEle`) VALUES
('María Guadalupe', 'Ruiz Soto', '7845', 'proyectos.iet.iif@upemor.edu.mx');

INSERT INTO `motivo` (`idMotivo`, `tipo`, `descripcion`, `docSolicitado`) VALUES
(1, 'Causa de fuerza mayor', 'Situaciones fuera del control del alumno como eventos imprevistos.', 'Fotografías tomadas al momento en un archivo PDF o documento que avale la falta (Todo en formato PDF).'),
(2, 'Enfermedad', 'Cuando un alumno se ve afectado por una enfermedad que le impide realizar sus actividades académicas', 'Recetas médicas, constancia, carnet o registro de cita (Todo en formato PDF).'),
(3, 'Problemas de Salud', 'El alumno tiene citas médicas o cita para análisis.', 'Recetas médicas, constancia, carnet, registro de cita y/o resultados de análisis (Todo en formato PDF).'),
(4, 'Accidente', 'Aplica para lesiones o daños que limitan temporalmente la capacidad del alumno de cumplir con las actividades o responsabilidades académicas.', 'Fotografías tomadas al momento, receta, constancia del IMSS o ISSTE en (Todo en archivo PDF).'),
(5, 'Trámite de carácter urgente', 'Trámite legal, gubernamental o personal, que el alumno no puede posponer', 'Documento proporcionado por la institución, fotografía de que asistió en el momento o documento de la cita (Todo en formato PDF).');

select * from alumno; 
select * from profesor; 
select * from motivo; 
select * from evidencia; 


select * from administrador; 
select * from justificante;
select * from justificante_profesor;