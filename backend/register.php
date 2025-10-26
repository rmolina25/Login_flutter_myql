<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    $nombre = trim($input['nombre'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';
    
    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit();
    }
    
    // Validar email
    if (!validateEmail($email)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email no válido']);
        exit();
    }
    
    // Validar longitud de contraseña
    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
        exit();
    }
    
    $conn = connectDB();
    
    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();
    
    // Hash de la contraseña
    $hashedPassword = hashPassword($password);
    
    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        echo json_encode([
            'success' => true, 
            'message' => 'Usuario registrado exitosamente',
            'user' => [
                'id' => $user_id,
                'nombre' => $nombre,
                'email' => $email
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $stmt->error]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>