<?php
/**
 * og-image.php — Imagen OG (1200x630) para preview en redes sociales.
 * Tema BANPRO: verde corporativo. Sin dependencias externas (GD nativo).
 */

header('Content-Type: image/png');
header('Cache-Control: public, max-age=86400, immutable');
header('X-Content-Type-Options: nosniff');

$W = 1200;
$H = 630;

$im = imagecreatetruecolor($W, $H);
imageantialias($im, true);

// --- Fondo: gradiente vertical verde oscuro → verde medio ---
$c1 = [15, 60, 25];    // verde muy oscuro arriba
$c2 = [30, 100, 50];   // verde medio abajo
for ($y = 0; $y < $H; $y++) {
    $t = $y / $H;
    $r = (int)($c1[0] + ($c2[0] - $c1[0]) * $t);
    $g = (int)($c1[1] + ($c2[1] - $c1[1]) * $t);
    $b = (int)($c1[2] + ($c2[2] - $c1[2]) * $t);
    $line = imagecolorallocate($im, $r, $g, $b);
    imageline($im, 0, $y, $W, $y, $line);
}

// Halo dorado abajo-derecha
$gold = [255, 200, 60];
for ($i = 0; $i < 55; $i++) {
    $alpha = (int)(110 - $i * 2);
    if ($alpha < 0) break;
    $col = imagecolorallocatealpha($im, $gold[0], $gold[1], $gold[2], $alpha);
    $rad  = 300 - $i * 4;
    imagefilledellipse($im, $W - 120, $H - 90, $rad, $rad, $col);
}

// Halo blanco suave arriba-izquierda
for ($i = 0; $i < 45; $i++) {
    $alpha = (int)(120 - $i * 2.5);
    if ($alpha < 0) break;
    $col = imagecolorallocatealpha($im, 255, 255, 255, $alpha);
    $rad  = 240 - $i * 4;
    imagefilledellipse($im, 100, 90, $rad, $rad, $col);
}

// --- Tarjeta central translúcida ---
$cx1 = 80; $cy1 = 100; $cx2 = $W - 80; $cy2 = $H - 100;
$cardCol = imagecolorallocatealpha($im, 255, 255, 255, 108);
imagefilledrectangle($im, $cx1, $cy1, $cx2, $cy2, $cardCol);
$borderCol = imagecolorallocatealpha($im, 255, 215, 80, 75);
imagerectangle($im, $cx1, $cy1, $cx2, $cy2, $borderCol);

// Acento verde izquierdo
$accentCol = imagecolorallocate($im, 45, 122, 58);
imagefilledrectangle($im, $cx1, $cy1, $cx1 + 8, $cy2, $accentCol);

// --- Helper: texto grande escalado ---
function bigText($im, $text, $x, $y, $size, $color, $bold = false) {
    $font = 5;
    $fw = imagefontwidth($font);
    $fh = imagefontheight($font);
    $tw = $fw * strlen($text);
    $th = $fh;

    $tmp = imagecreatetruecolor($tw, $th);
    $bg  = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
    imagealphablending($tmp, false);
    imagesavealpha($tmp, true);
    imagefill($tmp, 0, 0, $bg);
    imagealphablending($tmp, true);
    $cc  = imagecolorallocate($tmp, 255, 255, 255);
    imagestring($tmp, $font, 0, 0, $text, $cc);
    if ($bold) imagestring($tmp, $font, 1, 0, $text, $cc);

    $rgb = imagecolorsforindex($im, $color);
    for ($yy = 0; $yy < $th; $yy++) {
        for ($xx = 0; $xx < $tw; $xx++) {
            $rgba = imagecolorat($tmp, $xx, $yy);
            $a = ($rgba >> 24) & 0x7F;
            if ($a < 127) {
                imagesetpixel($tmp, $xx, $yy,
                    imagecolorallocatealpha($tmp, $rgb['red'], $rgb['green'], $rgb['blue'], $a));
            }
        }
    }

    $nW = (int)($tw * $size);
    $nH = (int)($th * $size);
    imagecopyresampled($im, $tmp, $x, $y, 0, 0, $nW, $nH, $tw, $th);
    imagedestroy($tmp);
    return [$nW, $nH];
}

$white  = imagecolorallocate($im, 255, 255, 255);
$gold_c = imagecolorallocate($im, 255, 215, 80);
$dark   = imagecolorallocate($im, 15, 40, 20);
$green  = imagecolorallocate($im, 45, 122, 58);

// Badge
$badge_y = $cy1 + 52;
$badgeBg = imagecolorallocatealpha($im, 255, 215, 80, 72);
imagefilledrectangle($im, $cx1 + 60, $badge_y - 18, $cx1 + 310, $badge_y + 18, $badgeBg);
bigText($im, 'BANPRO  BENEFICIOS', $cx1 + 78, $badge_y - 11, 1.5, $dark, true);

// Título
bigText($im, 'Consulta tus beneficios', $cx1 + 60, $cy1 + 130, 5.5, $white, true);
bigText($im, 'y servicios en linea', $cx1 + 60, $cy1 + 210, 5.5, $white, true);

// Línea decorativa
imagefilledrectangle($im, $cx1 + 60, $cy1 + 300, $cx1 + 180, $cy1 + 305, $gold_c);

// Subtítulo
bigText($im, 'Accede de forma rapida y segura a tu', $cx1 + 60, $cy1 + 325, 2.8, $white, false);
bigText($im, 'perfil financiero Banpro Nicaragua.', $cx1 + 60, $cy1 + 368, 2.8, $white, false);

// CTA pill
$py1 = $cy2 - 78; $py2 = $cy2 - 28;
$pillBg = imagecolorallocate($im, 255, 210, 60);
imagefilledrectangle($im, $cx1 + 60, $py1, $cx1 + 340, $py2, $pillBg);
bigText($im, 'INGRESAR AHORA  >', $cx1 + 82, $py1 + 12, 1.9, $dark, true);

imagepng($im, null, 6);
imagedestroy($im);
