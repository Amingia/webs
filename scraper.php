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
    $canciones = [];

    try {
        if (empty($url)) {
            throw new Exception("La URL proporcionada está vacía.");
        }

        // Para que Spotify nos devuelva el HTML completo (con el initialState en Base64),
        // a veces es necesario solicitarlo de forma plana si el cURL del servidor compartido
        // viene con cabeceras que provocan respuestas reducidas.
        // Intentaremos primero con file_get_contents si está disponible, y usaremos cURL como fallback genérico.
        $html = false;

        // Intentar primero con file_get_contents (que suele traer el HTML sucio y completo de Spotify)
        $context = stream_context_create([
            "ssl" => ["verify_peer" => false, "verify_peer_name" => false],
            "http" => ["header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n", "timeout" => 5]
        ]);
        $html = @file_get_contents($url, false, $context);

        // Si falló, intentar con cURL estándar
        if ($html === false || strlen($html) < 10000) {
            $ch = curl_init();
            if ($ch === false) throw new Exception("No se pudo inicializar cURL.");
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);

            $html = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($html === false || $httpCode >= 400) {
                throw new Exception("Error cURL HTTP $httpCode: $curlError");
            }
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

        // Extracción Avanzada de Reproducciones Reales (Hydration Data)
        if (preg_match('/<script id="initialState" type="text\/plain">([^<]+)<\/script>/i', $html, $matches)) {
            $jsonBase64 = $matches[1];
            $json = base64_decode($jsonBase64);
            $data = json_decode($json, true);

            if (is_array($data)) {
                $tracks = [];

                // Función recursiva para encontrar objetos de canciones
                $findTracks = function($array) use (&$findTracks, &$tracks) {
                    if (!is_array($array)) return;

                    if (isset($array['playcount']) && isset($array['name']) && isset($array['uri']) && strpos($array['uri'], 'spotify:track:') === 0) {
                        $coverUrl = '';
                        // Buscar la portada en diferentes lugares del objeto
                        if (isset($array['coverArt']) && isset($array['coverArt']['sources']) && count($array['coverArt']['sources']) > 0) {
                            $coverUrl = $array['coverArt']['sources'][0]['url'];
                        } else if (isset($array['albumOfTrack']) && isset($array['albumOfTrack']['coverArt']) && isset($array['albumOfTrack']['coverArt']['sources']) && count($array['albumOfTrack']['coverArt']['sources']) > 0) {
                            $coverUrl = $array['albumOfTrack']['coverArt']['sources'][0]['url'];
                        }

                        $tracks[] = [
                            'titulo' => $array['name'],
                            'reproducciones' => (int)$array['playcount'],
                            'miniatura' => $coverUrl
                        ];
                    }

                    foreach ($array as $value) {
                        if (is_array($value)) {
                            $findTracks($value);
                        }
                    }
                };

                $findTracks($data);

                // Eliminar duplicados y ordenar por reproducciones
                $uniqueTracks = [];
                foreach ($tracks as $track) {
                    // Mantener la versión con portada si hay duplicados donde uno no tiene
                    if (!isset($uniqueTracks[$track['titulo']]) || (empty($uniqueTracks[$track['titulo']]['miniatura']) && !empty($track['miniatura']))) {
                        $uniqueTracks[$track['titulo']] = $track;
                    }
                }

                $tracks = array_values($uniqueTracks);
                usort($tracks, function($a, $b) {
                    return $b['reproducciones'] <=> $a['reproducciones'];
                });

                // Quedarnos solo con el Top 5
                $canciones = array_slice($tracks, 0, 5);
            }
        }

    } catch (Exception $e) {
        // En producción el catch absorbe el error silenciosamente.
        // Opcional: Se podría escribir en un log local ($e->getMessage())
        // Pero devolvemos los strings "No disponible" para que la web cargue siempre.
    }

    return [
        'seguidores' => $seguidores,
        'oyentes' => $oyentes,
        'canciones' => $canciones
    ];
}

// Comprobar que la URL existe en config para evitar avisos PHP
$urlSpotify = isset($url_spotify_perfil) ? $url_spotify_perfil : '';

// Ejecutar el raspado de forma segura
$datosSpotify = rasparSpotifyReal($urlSpotify);
?>