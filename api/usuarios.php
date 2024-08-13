<?php
// Incluir archivo de conexión a la base de datos
require_once '../db/conexion.php';

// Configurar cabecera para permitir solicitudes desde JavaScript
header("Content-Type: application/json");

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar que los datos requeridos estén presentes
    if (isset($data['nombre']) && isset($data['email'])) {
        $nombre = $data['nombre'];
        $email = $data['email'];

        // Inserción en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Usuario registrado exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al registrar usuario: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
