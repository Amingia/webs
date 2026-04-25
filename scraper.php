<?php
// ==========================================
// MOTOR DE SCRAPING
// ==========================================
// Este archivo lee las URLs de config.php, se conecta a ellas
// y extrae los datos de las etiquetas meta públicas.

require_once 'config.php';

function obtenerHTML($url) {
    // Configuración de cURL haciéndose pasar por un navegador real
    // para evitar bloqueos anti-bot básicos.
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

function rasparInstagram($url) {
    $html = obtenerHTML($url);
    if (!$html) return "Dato no disponible temporalmente";

    // En Instagram, la meta description tiene este formato:
    // <meta property="og:description" content="18K Followers, 500 Following, 100 Posts..." />
    if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $matches)) {
        $desc = $matches[1];
        // Extraer los seguidores (antes de la palabra "Followers" o "seguidores")
        if (preg_match('/([\d\.,]+[KMB]?)\s*(Followers|seguidores)/i', $desc, $m)) {
            return strtoupper(str_replace(',', '.', $m[1]));
        }
    }

    return "Dato no disponible temporalmente";
}

function rasparSpotify($url) {
    $html = obtenerHTML($url);
    if (!$html) {
        return [
            'seguidores' => "Dato no disponible temporalmente",
            'oyentes' => "Dato no disponible temporalmente"
        ];
    }

    // En Spotify, el og:description suele ser:
    // <meta property="og:description" content="Artist · 45K monthly listeners." />
    // O variaciones dependiendo del idioma. Vamos a buscar cifras cerca de "listeners", "oyentes", "followers", "seguidores"

    $seguidores = "Dato no disponible temporalmente";
    $oyentes = "Dato no disponible temporalmente";

    // Expresión regular mejorada para og:description en Spotify
    if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $matches)) {
        $desc = $matches[1];

        // Buscar oyentes mensuales
        if (preg_match('/([\d\.,]+[KMB]?)\s*(monthly listeners|oyentes mensuales)/i', $desc, $m)) {
             $oyentes = strtoupper(str_replace(',', '.', $m[1]));
        }

        // A veces Spotify no pone los seguidores en la meta description,
        // pero podemos intentar extraer un dato general si está disponible.
        // Si no está en el HTML plano extraíble fácilmente, devolveremos un placeholder o un valor estimado/fallback.
        // Para este ejercicio y dadas las limitaciones de scraping puro sin API:
        // Si no encontramos seguidores explícitos, dejamos el fallback.
        if (preg_match('/([\d\.,]+[KMB]?)\s*(followers|seguidores)/i', $desc, $m)) {
            $seguidores = strtoupper(str_replace(',', '.', $m[1]));
        } else {
             // Mock fallback ya que las páginas SPA de Spotify cargan seguidores vía JS
             $seguidores = "11.2K (Simulado)";
        }
    }

    // Si ambos fallaron porque la estructura cambió, proveer fallback gracefully.
    if ($oyentes === "Dato no disponible temporalmente") $oyentes = "45.0K (Simulado)";

    return [
        'seguidores' => $seguidores,
        'oyentes' => $oyentes
    ];
}

// Ejecutar el raspado de forma segura
$igSeguidores = rasparInstagram($config['url_instagram']);
$spotifyDatos = rasparSpotify($config['url_spotify']);

// Preparar los datos finales para ser inyectados en el Frontend
$datosScraping = [
    'seguidoresInstagram' => $igSeguidores,
    'seguidoresSpotify' => $spotifyDatos['seguidores'],
    'oyentesMensuales' => $spotifyDatos['oyentes'],

    // Canciones y Ciudades se mantienen estáticas en este ejemplo
    // ya que extraer tablas profundas de Spotify requiere API real,
    // pero mantenemos la estructura para que app.js no se rompa.
    'canciones' => [
        [ 'titulo' => "Ecos de Medianoche", 'reproducciones' => 1250000 ],
        [ 'titulo' => "Luces de Neón", 'reproducciones' => 850000 ],
        [ 'titulo' => "Sombra y Luz", 'reproducciones' => 620000 ],
        [ 'titulo' => "Vuelo sin Retorno", 'reproducciones' => 450000 ],
        [ 'titulo' => "Amanecer en Madrid", 'reproducciones' => 310000 ]
    ],
    'ciudades' => [
        [ 'nombre' => "Madrid", 'oyentes' => 12000 ],
        [ 'nombre' => "Barcelona", 'oyentes' => 9500 ],
        [ 'nombre' => "Ciudad de México", 'oyentes' => 8200 ],
        [ 'nombre' => "Valencia", 'oyentes' => 4500 ],
        [ 'nombre' => "Sevilla", 'oyentes' => 3800 ]
    ]
];
?>