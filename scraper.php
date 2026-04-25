<?php
// ==========================================
// MOTOR DE SCRAPING (ANTIBALAS Y SEGURO)
// ==========================================
// Este archivo lee la URL de Spotify de config.php mediante cURL,
// envuelto en bloques Try-Catch para evitar cualquier Error 500.

// 1. Verificación crítica de existencia del archivo de configuración
if (!file_exists('config.php')) {
    die("Error Crítico: Falta el archivo config.php. Por favor, crea este archivo antes de continuar.");
}
require_once 'config.php';

function rasparSpotifyReal($url) {
    // Valores por defecto seguros ante cualquier catástrofe
    $seguidores = "No disponible";
    $oyentes = "No disponible";

    try {
        if (empty($url)) {
            throw new Exception("La URL proporcionada está vacía.");
        }

        // Configuración de cURL extremando precauciones (Anti-Error 500 en compartidos)
        $ch = curl_init();
        if ($ch === false) {
             throw new Exception("No se pudo inicializar cURL.");
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

        // Reglas estrictas Anti-Error 500 para OVH
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evita fallos de certificados locales
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout corto para no colgar el servidor

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($html === false || $httpCode >= 400) {
            throw new Exception("Error cURL HTTP $httpCode: $curlError");
        }

        // Buscar exclusivamente en la meta description mediante regex segura
        if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $matches)) {
            $desc = $matches[1];

            // Extraer oyentes mensuales ("monthly listeners" o "oyentes mensuales")
            if (preg_match('/([\d\.,]+[KMB]?)\s*(monthly listeners|oyentes mensuales)/i', $desc, $m)) {
                 $oyentes = strtoupper(str_replace(',', '.', $m[1]));
            }

            // Extraer seguidores ("followers" o "seguidores")
            if (preg_match('/([\d\.,]+[KMB]?)\s*(followers|seguidores)/i', $desc, $m)) {
                $seguidores = strtoupper(str_replace(',', '.', $m[1]));
            }
        }
    } catch (Exception $e) {
        // En producción el catch absorbe el error silenciosamente.
        // Opcional: Se podría escribir en un log local ($e->getMessage())
        // Pero devolvemos los strings "No disponible" para que la web cargue siempre.
    }

    return [
        'seguidores' => $seguidores,
        'oyentes' => $oyentes
    ];
}

// Comprobar que la URL existe en config para evitar avisos PHP
$urlSpotify = isset($config['url_spotify_perfil']) ? $config['url_spotify_perfil'] : '';

// Ejecutar el raspado de forma segura
$datosSpotify = rasparSpotifyReal($urlSpotify);
?>