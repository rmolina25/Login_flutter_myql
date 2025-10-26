<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';
    
    // Validar campos obligatorios
    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email y contraseña son obligatorios']);
        exit();
    }
    
    // Validar email
    if (!validateEmail($email)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email no válido']);
        exit();
    }
    
    $conn = connectDB();
    
    // Buscar usuario por email
    $stmt = $conn->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        $stmt->close();
        $conn->close();
        exit();
    }
    
    $stmt->bind_result($id, $nombre, $db_email, $hashedPassword);
    $stmt->fetch();
    $stmt->close();
    
    // Verificar contraseña
    if (verifyPassword($password, $hashedPassword)) {
        echo json_encode([
            'success' => true, 
            'message' => 'Login exitoso',
            'user' => [
                'id' => $id,
                'nombre' => $nombre,
                'email' => $db_email
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
    }
    
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>