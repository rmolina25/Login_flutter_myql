# Sistema de Login Flutter con MySQL - Instrucciones de Implementación

## 📋 Requisitos Previos

1. **XAMPP instalado** y funcionando
2. **MySQL** activo en XAMPP
3. **Flutter SDK** instalado
4. **Dispositivo/Emulador** para probar la app

## 🗄️ Configuración de la Base de Datos

### Paso 1: Crear la Base de Datos
1. Abre phpMyAdmin (http://localhost/phpmyadmin)
2. Ejecuta el script `database_setup.sql` que se encuentra en la raíz del proyecto
3. Verifica que se haya creado la base de datos `flutter_login` con la tabla `usuarios`

### Paso 2: Verificar la Estructura
La tabla `usuarios` debe tener las siguientes columnas:
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `nombre` (VARCHAR 100)
- `email` (VARCHAR 150, UNIQUE)
- `password` (VARCHAR 255)
- `fecha_registro` (TIMESTAMP)

## 🔧 Configuración del Backend PHP

### Paso 1: Colocar los archivos PHP
1. Copia la carpeta `backend/` al directorio `htdocs` de XAMPP
2. La ruta debe quedar: `C:\xampp\htdocs\flutter_login\backend\`

### Paso 2: Verificar Configuración
- Asegúrate de que los archivos `config.php`, `register.php` y `login.php` estén en la carpeta backend
- Verifica que las credenciales de MySQL en `config.php` sean correctas para tu instalación

## 📱 Configuración de la App Flutter

### Paso 1: Instalar Dependencias
```bash
cd mi_app_flutter
flutter pub get
```

### Paso 2: Configurar URLs
En el archivo `lib/services/auth_service.dart`, verifica la URL base:
- Para Android emulator: `http://10.0.2.2/flutter_login/backend`
- Para web: `http://localhost/flutter_login/backend`
- Para dispositivo físico: `http://[TU_IP_LOCAL]/flutter_login/backend`

### Paso 3: Ejecutar la App
```bash
flutter run
```

## 🧪 Pruebas de Funcionalidad

### Prueba 1: Registro de Usuario
1. Abre la app en tu dispositivo/emulador
2. Ve a "Regístrate" 
3. Completa el formulario:
   - Nombre: "Usuario Demo"
   - Email: "demo@example.com" 
   - Contraseña: "123456"
4. Verifica que recibas mensaje de éxito

### Prueba 2: Login de Usuario
1. Ve a "Iniciar Sesión"
2. Usa las credenciales del usuario registrado
3. Verifica que accedas a la pantalla principal

### Prueba 3: Validaciones
- Intenta registrar un email ya existente
- Intenta login con contraseña incorrecta
- Verifica validaciones de campos vacíos

## 🔒 Consideraciones de Seguridad

### Implementadas:
- ✅ Hash de contraseñas con `password_hash()`
- ✅ Validación de email
- ✅ Protección contra inyección SQL con prepared statements
- ✅ Headers CORS para desarrollo

### Para Producción:
- 🔄 Usar HTTPS
- 🔄 Implementar tokens JWT
- 🔄 Validaciones más estrictas
- 🔄 Rate limiting

## 🐛 Solución de Problemas Comunes

### Error: "Error de conexión"
- Verifica que XAMPP esté ejecutándose
- Confirma que MySQL esté activo
- Revisa la URL en `auth_service.dart`

### Error: "Usuario no encontrado"
- Verifica que el usuario exista en la base de datos
- Confirma que el email esté escrito correctamente

### Error: "Contraseña incorrecta"
- Verifica que la contraseña sea la correcta
- Confirma que el hash en la BD sea válido

## 📁 Estructura del Proyecto

```
Login_flutter_myql/
├── database_setup.sql          # Script de creación de BD
├── backend/
│   ├── config.php             # Configuración de BD
│   ├── register.php           # Endpoint de registro
│   └── login.php              # Endpoint de login
└── mi_app_flutter/
    ├── lib/
    │   ├── main.dart          # App principal con rutas
    │   ├── services/
    │   │   └── auth_service.dart  # Servicio de autenticación
    │   └── screens/
    │       ├── login_screen.dart     # Pantalla de login
    │       ├── register_screen.dart  # Pantalla de registro
    │       └── home_screen.dart      # Pantalla principal
    └── pubspec.yaml           # Dependencias
```

## 🚀 Próximos Pasos

1. **Implementar logout** en todas las pantallas
2. **Agregar persistencia** con SharedPreferences
3. **Mejorar UI/UX** con animaciones
4. **Agregar recuperación** de contraseña
5. **Implementar roles** de usuario

## 📞 Soporte

Si encuentras problemas:
1. Revisa los logs de la app Flutter
2. Verifica los logs de Apache en XAMPP
3. Confirma que la BD esté accesible desde phpMyAdmin