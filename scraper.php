<?php
// ==========================================
// MOTOR DE SCRAPING (VERSIÓN 4 - REALIDAD BRUTA)
// ==========================================
// Este archivo lee la URL de Spotify de config.php, se conecta a ella
// mediante cURL y extrae exclusivamente de la etiqueta <meta property="og:description">
// Sin inventar históricos ni simular nada extra.

require_once 'config.php';

function obtenerHTML($url) {
    // Configuración de cURL haciéndose pasar por un navegador real
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300 && $html) {
        return $html;
    }

    return null; // Fallo en la descarga o bloqueo
}

function rasparSpotifyReal($url) {
    $html = obtenerHTML($url);
    if (!$html) {
        return [
            'seguidores' => "Dato no disponible",
            'oyentes' => "Dato no disponible"
        ];
    }

    $seguidores = "Dato no disponible";
    $oyentes = "Dato no disponible";

    // Buscar exclusivamente en la meta description
    if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $matches)) {
        $desc = $matches[1];

        // Buscar oyentes mensuales ("monthly listeners" o "oyentes mensuales")
        if (preg_match('/([\d\.,]+[KMB]?)\s*(monthly listeners|oyentes mensuales)/i', $desc, $m)) {
             $oyentes = strtoupper(str_replace(',', '.', $m[1]));
        }

        // Buscar seguidores ("followers" o "seguidores") de forma limpia
        if (preg_match('/([\d\.,]+[KMB]?)\s*(followers|seguidores)/i', $desc, $m)) {
            $seguidores = strtoupper(str_replace(',', '.', $m[1]));
        }
    }

    return [
        'seguidores' => $seguidores,
        'oyentes' => $oyentes
    ];
}

// Ejecutar el raspado de forma segura y real
$datosSpotify = rasparSpotifyReal($config['url_spotify_perfil']);
?>