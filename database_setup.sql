-- Script para crear la base de datos y tabla de usuarios
-- Ejecutar este script en phpMyAdmin o MySQL CLI

CREATE DATABASE IF NOT EXISTS flutter_login CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE flutter_login;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuario de prueba (opcional)
INSERT INTO usuarios (nombre, email, password) VALUES 
('Usuario Demo', 'demo@example.com', '123456');