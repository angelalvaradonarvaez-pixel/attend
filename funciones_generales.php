<?php
function isAlphanumeric(string $text): bool
{
    // Returns true if the string consists solely of letters (a-z, A-Z) and digits (0-9)
    return (bool) preg_match('/^[a-zA-Z0-9]+$/', $text);
}

function valida_campo(string $text, string $tipo, string $nombre_campo, string $pronombre): string
{
    $message_error = '';
    switch ($tipo) {
        case 'alfanumerico':
            if (empty($text)) {
                $message_error = '<br> Especifique ' . strtolower($pronombre) . ' ' . $nombre_campo . '.';
            } else {
                if (!isAlphanumeric($text)) {
                    $message_error = '<br> ' . $pronombre . ' ' . strtolower($nombre_campo) . ' debe ser alfanumérico,(a-z, A-Z) and digits (0-9)';
                }
            }
            break;
        case 'texto':
            if (empty($text)) {
                $message_error = '<br> Especifique ' . strtolower($pronombre) . ' ' . $nombre_campo . '.';
            }
            break;
        case 'password':
            if (empty($text)) {
                $message_error = '<br> Especifique ' . strtolower($pronombre) . ' ' . $nombre_campo . '.';
            } else {
                if (str_contains($text, ' ')) {
                    $message_error = '<br> El campo ' . strtolower($nombre_campo) . ' no debe contener espacios.';
                }
            }
            break;
    }
    return ($message_error);
}

?>