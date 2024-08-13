<?php
// Incluir archivo de conexión a la base de datos
require_once '../db/conexion.php';

// Configurar cabecera para permitir solicitudes desde JavaScript
header("Content-Type: application/json");

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar que los datos requeridos estén presentes
    if (isset($data['usuario_id']) && isset($data['libro_id']) && isset($data['fecha_prestamo'])) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];

        // Inserción en la base de datos
        $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Préstamo registrado exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al registrar préstamo: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recuperar los préstamos de la base de datos
    $sql = "SELECT prestamos.id, usuarios.nombre AS usuario, libros.titulo AS libro, prestamos.fecha_prestamo
            FROM prestamos
            JOIN usuarios ON prestamos.usuario_id = usuarios.id
            JOIN libros ON prestamos.libro_id = libros.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $prestamos = [];
        while($row = $result->fetch_assoc()) {
            $prestamos[] = $row;
        }
        echo json_encode(["success" => true, "prestamos" => $prestamos]);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontraron préstamos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
