import 'dart:convert';
import 'package:http/http.dart' as http;

class AuthService {
  static const String baseUrl =
      'http://10.0.2.2/Login_flutter_myql/backend'; // Para XAMPP local en Android emulator
  // static const String baseUrl = 'https://musica.fitchile.cloud/flutter_login/backend'; // Para base de datos remota

  static Future<Map<String, dynamic>> register(
    String nombre,
    String email,
    String password,
  ) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/register.php'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'nombre': nombre,
          'email': email,
          'password': password,
        }),
      );

      // Verificar si la respuesta es JSON válido
      if (response.body.trim().startsWith('{') ||
          response.body.trim().startsWith('[')) {
        final data = jsonDecode(response.body);
        return data;
      } else {
        // Si no es JSON, es probable que sea un error del servidor
        return {
          'success': false,
          'message':
              'Error del servidor: ${response.body.length > 100 ? response.body.substring(0, 100) + '...' : response.body}',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Error de conexión: $e'};
    }
  }

  static Future<Map<String, dynamic>> login(
    String email,
    String password,
  ) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login.php'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email, 'password': password}),
      );

      // Verificar si la respuesta es JSON válido
      if (response.body.trim().startsWith('{') ||
          response.body.trim().startsWith('[')) {
        final data = jsonDecode(response.body);
        return data;
      } else {
        // Si no es JSON, es probable que sea un error del servidor
        return {
          'success': false,
          'message':
              'Error del servidor: ${response.body.length > 100 ? response.body.substring(0, 100) + '...' : response.body}',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Error de conexión: $e'};
    }
  }
}
