<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$nombre   = trim(strip_tags($_POST['nombre']   ?? ''));
$correo   = trim(strip_tags($_POST['correo']   ?? ''));
$telefono = trim(strip_tags($_POST['telefono'] ?? ''));
$mensaje  = trim(strip_tags($_POST['mensaje']  ?? ''));

if (empty($nombre) || empty($correo) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?enviado=error#contact');
    exit;
}

$destinatario = 'marijoua77@gmail.com';
$asunto       = 'Mensaje desde el sitio web - ' . $nombre;
$cuerpo       = "Has recibido un mensaje desde tu sitio web:\n\n"
              . "Nombre:    $nombre\n"
              . "Correo:    $correo\n"
              . "Teléfono:  $telefono\n\n"
              . "Mensaje:\n$mensaje";

$encabezados  = "From: noreply@{$_SERVER['HTTP_HOST']}\r\n";
$encabezados .= "Reply-To: $correo\r\n";
$encabezados .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($destinatario, $asunto, $cuerpo, $encabezados)) {
    header('Location: index.html?enviado=ok#contact');
} else {
    header('Location: index.html?enviado=error#contact');
}
exit;
