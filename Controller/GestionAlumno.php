<?php
    include '../../Model/Conexion.php';
    include '../../Model/Alumno.php';

    class gestionAlumno {
        private $conexion;

        public function __construct($conexion) {
            $this->conexion = $conexion;
        } 

        public function altaAlumno(){
            if(isset($_POST['nombre']) && isset($_POST['ape']) && isset($_POST['feNac']) && isset($_POST['matricula']) && isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['Rclave'])){
                
                function validar($data){
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
        
                // Obtener los datos del formulario
                $nombre = validar($_POST['nombre']);
                $ape = validar($_POST['ape']);
                $nac = validar($_POST['feNac']);
                $usuario = validar($_POST['matricula']);
                $correoE = $_POST['correo']; // Obtener el correo electrónico
                $clave = validar($_POST['clave']);
                $Rclave = validar($_POST['Rclave']);
        
                // Verificar si los campos están vacíos
                $datosUsuario = 'nombre=' . $nombre . "&ape=" . $ape . '&feNac=' . $nac . '&matricula=' . $usuario;
        
                if (empty($nombre)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=El Nombre es requerido&$datosUsuario");
                    exit();
                } elseif (empty($ape)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=El Apellido es requerido&$datosUsuario");
                    exit();
                } elseif (empty($nac)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=La fecha de Nacimiento es requerida&$datosUsuario");
                    exit();
                } elseif (empty($usuario)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=La Matricula es requerida&$datosUsuario");
                    exit();
                } elseif (empty($correoE)) { // Verificar correo
                    header("location: ../Views/StudentView/Registrarse.php?error=El correo es requerido&$datosUsuario");
                    exit();
                } elseif (empty($clave)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=La Contraseña es requerida&$datosUsuario");
                    exit();
                } elseif (empty($Rclave)) {
                    header("location: ../Views/StudentView/Registrarse.php?error=Repetir la Contraseña es requerida&$datosUsuario");
                    exit();
                } elseif ($clave !== $Rclave) {
                    header("location: ../Views/StudentView/Registrarse.php?error=No Coinciden las Contraseñas&$datosUsuario");
                    exit();
                } else {
                    // Instanciar el modelo y llamar la función
                    $modeloAlumno = new Alumno($this->conexion);
                    $query = $modeloAlumno->validarAlumnoRe($usuario);
        
                    if (mysqli_num_rows($query) > 0) {
                        header("location: ../../Views/StudentView/Registrarse.php?error=El Usuario ya existe");
                        exit();
                    } else {
                        if ($modeloAlumno->insertarAlumno($nombre, $ape, $nac, $usuario, $correoE, $clave, $Rclave)) {
                            header("location: ../../Views/StudentView/Registrarse.php?success=Usuario Creado Exitosamente");
                            exit();
                        } else {
                            header("location: ../Views/StudentView/Registrarse.php?error=Ocurrio un Error");
                            exit();
                        }
                    }
                }
            } else {
                header("location: ../Views/StudentView/Registrarse.php");
                exit();
            }
        }
        

        public function barraDeBusqueda($conexion) {
            // Capturar el término de búsqueda si se proporciona
            $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
        
            // Crear una nueva instancia del modelo
            $alumnoModel = new Alumno($conexion);
        
            // Consultar alumnos según el término de búsqueda
            $result = $alumnoModel->buscarAlumnos($busqueda);
        
            // Retornar el resultado
            return $result;
        }

    } 

    include_once __DIR__ . '/../Model/Alumno.php'; // Incluye el modelo del alumno

class AlumnoController {
    private $alumnoModel;

    public function __construct() {
        $this->alumnoModel = new AlumnoModel(); // Instancia del modelo de alumno
    }

    public function obtenerAlumnos() {
        return $this->alumnoModel->obtenerAlumnos(); // Llama al método del modelo para obtener todos los alumnos
    }

    public function agregarAlumno($nombre, $apellido, $fechaNac, $matricula, $contrasena, $confirmacionContra) {
        // Verificar si la contraseña y su confirmación coinciden
        if ($contrasena !== $confirmacionContra) {
            return false; // O manejar el error de otra manera
        }
        return $this->alumnoModel->agregarAlumno($nombre, $apellido, $fechaNac, $matricula, $contrasena);
    }

    public function obtenerAlumnoPorId($idAlumno) {
        return $this->alumnoModel->obtenerAlumnoPorId($idAlumno); // Llama al método del modelo para obtener un alumno por ID
    }

    public function modificarAlumno($idAlumno, $nombre, $apellido, $feNac, $matricula, $contrasena, $confirmacionContra) {
        // Verificar si la contraseña y su confirmación coinciden
        if ($contrasena !== $confirmacionContra) {
            return false; // O manejar el error de otra manera
        }
        return $this->alumnoModel->modificarAlumno($idAlumno, $nombre, $apellido, $feNac, $matricula, $contrasena); // Llama al método del modelo para modificar un alumno
    }

    public function eliminarAlumno($idAlumno) {
        return $this->alumnoModel->eliminarAlumno($idAlumno); // Llama al método del modelo para eliminar un alumno
    }
}

?>