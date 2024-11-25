<?php

require_once __DIR__ . '/../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Alumno {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    //inicio de sesión
    public function validarAlumno($usuario,$clave) {
        $sql = "
            SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu
            FROM alumno 
            WHERE matricula = ? AND contrasena = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario,$clave);
        $stmt->execute();
        return $stmt->get_result();
    } 
    
    //registros nuevos
    public function validarAlumnoRe($usuario) {
        $sql = "
            SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu
            FROM alumno 
            WHERE matricula = ?
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        return $stmt->get_result();
    }
    

    public function insertarAlumno($nombre, $apellido, $fechaNacimiento, $matricula, $correoEle, $contrasena, $confirmacionContrasena) {
        $sql = "INSERT INTO alumno (nombreAlu, apellidoAlu, feNac, matricula, correoE, contrasena, confirmacionContra) 
                VALUES (UPPER(?), UPPER(?), ?, UPPER(?), UPPER(?), ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la declaración: " . $this->conexion->error);
        } 

        if ($stmt) {
            // Vincula los parámetros
            $stmt->bind_param("sssssss", $nombre, $apellido, $fechaNacimiento, $matricula, $correoEle, $contrasena, $confirmacionContrasena);
            // Encriptar la contraseña
            $confirmacionContrasena = md5($contrasena);

            // Envía el correo si la inserción es exitosa
            $this->enviarCorreo($correoEle, $matricula, $contrasena);

            // Ejecuta la consulta
            return $stmt->execute();
        }else{
            echo "Error al crear la cuenta: " . $this->conexion->error;
        }
        
    }
    
    private function enviarCorreo($correoE, $usuario, $contra) {
        // Configuración del correo 
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            $mail->setFrom('no-reply@tu-dominio.com', 'Dirección Académica ITI-IET');
            $mail->addAddress($correoE);
    
            $mail->isHTML(true);
            $mail->Subject = "Confirmación de creación de cuenta";
            
            $usuarioMayus = strtoupper($usuario); // Convierte a mayúsculas el nombre de usuario.

            $mail->Body = "
                <h1>¡Hola, $usuarioMayus!</h1>
                <p>Tu cuenta ha sido creada exitosamente. Aquí tienes tus credenciales de inicio de sesión:</p>
                <p><strong>Nombre de usuario:</strong> $usuarioMayus</p>
                <p><strong>Contraseña:</strong> $contra</p>
                <p>Por favor, guarda esta información de manera segura.</p>
            ";

            $mail->AltBody = "Hola $usuarioMayus, tu cuenta ha sido creada exitosamente. Aquí tienes tus credenciales de inicio de sesión:\nNombre de usuario: $usuarioMayus\nContraseña: $contra\nPor favor, guarda esta información de manera segura.";

    
            $mail->send();
            echo "<p class='parrafo'>Registro exitoso, se te ha enviado un correo electrónico con las credenciales ingresadas.</p>";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    function obtenerIdAlumnoPorMatricula($conexion) {
        // Verifica si la matrícula está definida en la sesión
        if (isset($_SESSION['identificador'])) {
            $matricula = $_SESSION['identificador'];
    
            // Prepara la consulta para obtener el idAlumno usando la matrícula
            $sql = "SELECT idAlumno FROM alumno WHERE matricula = ?";
            $stmt = $conexion->prepare($sql);
    
            if ($stmt === false) {
                die("Error en la preparación de la declaración: " . $conexion->error);
            }
    
            // Vincula el parámetro
            $stmt->bind_param("s", $matricula);
    
            // Ejecuta la consulta
            $stmt->execute();
    
            // Obtiene el resultado
            $result = $stmt->get_result();
    
            // Verifica si se encontró el alumno
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['idAlumno']; // Retorna el idAlumno
            } else {
                return null; // Matrícula no encontrada
            }
    
            // Cierra la declaración
            $stmt->close();
        } else {
            return null; // No hay matrícula en la sesión
        }
    }
    
    //para la busqueda de "otros justificantes".
    public function buscarAlumnos($busqueda) {
        // Modificar la consulta para buscar por matrícula
        $query = "SELECT * FROM alumno WHERE matricula LIKE ?";
        $stmt = $this->conexion->prepare($query);
        
        // Usar LIKE con la matrícula
        $like = "%$busqueda%"; 
        $stmt->bind_param("s", $like);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
} 

include_once __DIR__ . '/../Model/Conexion.php'; // Ajusta la ruta según la ubicación del archivo de conexión
class AlumnoModel {
    private $conexion;

    public function __construct() {
        global $conexion; // Utiliza la conexión global
        $this->conexion = $conexion;
    }

    // Obtener todos los alumnos
    public function obtenerAlumnos() {
        $consulta = "SELECT * FROM alumno ORDER BY idAlumno ASC";
        $resultado = $this->conexion->query($consulta);
        
        $alumnos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $alumnos[] = $fila;
        }
        
        return $alumnos;
    }

    // Agregar un nuevo alumno
    public function agregarAlumno($nombreAlu, $apellidoAlu, $feNac, $matricula,$correo, $contrasena) {
        // Hash de la contraseña
        $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO alumno (nombreAlu, apellidoAlu, feNac, matricula,correoE, contrasena) VALUES (UPPER(?), UPPER(?), ?, UPPER(?), UPPER(?), ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssss', $nombreAlu, $apellidoAlu, $feNac, $matricula,$correo, $contrasena);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Obtener un alumno por ID
    public function obtenerAlumnoPorId($idAlumno) {
        $query = "SELECT * FROM alumno WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('i', $idAlumno);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $alumno = $resultado->fetch_assoc();
            $stmt->close();
            return $alumno; // Retorna el alumno o null si no existe
        }
        
        return null;
    }

    // Modificar un alumno
    public function modificarAlumno($idAlumno, $nombreAlu, $apellidoAlu, $feNac, $matricula,$correo, $contrasena) {
       // $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $query = "UPDATE alumno SET nombreAlu = UPPER(?), apellidoAlu = UPPER(?), feNac = ?, matricula = UPPER(?),correoE= UPPER(?), contrasena = ? WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssssi', $nombreAlu, $apellidoAlu, $feNac, $matricula,$correo, $contrasena, $idAlumno);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }

    // Eliminar un alumno
    public function eliminarAlumno($idAlumno) {
        $query = "DELETE FROM alumno WHERE idAlumno = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $idAlumno);
            $stmt->execute();
            $resultado = $stmt->affected_rows > 0;
            $stmt->close();
            return $resultado;
        }
        
        return false;
    }
}

?>
