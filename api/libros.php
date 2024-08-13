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
    if (isset($data['titulo']) && isset($data['autor']) && isset($data['genero']) && isset($data['fecha_publicacion'])) {
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $genero = $data['genero'];
        $fecha_publicacion = $data['fecha_publicacion'];

        // Inserción en la base de datos
        $sql = "INSERT INTO libros (titulo, autor, genero, fecha_publicacion) VALUES ('$titulo', '$autor', '$genero', '$fecha_publicacion')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Libro registrado exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al registrar libro: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recuperar los libros de la base de datos
    $sql = "SELECT * FROM libros";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $libros = [];
        while($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
        echo json_encode(["success" => true, "libros" => $libros]);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontraron libros."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
