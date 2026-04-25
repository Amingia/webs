<?php
// Modo depuración activado para evitar pantallas en blanco (Error 500) en OVH
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el scraper para obtener los datos al cargar la página
require_once 'scraper.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Monitorización de Spotify</title>

  <!-- Tailwind CSS vía CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Configuración personalizada de Tailwind -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            spotify: '#1DB954',
            'spotify-hover': '#1ed760',
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons vía CDN -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100 p-4 md:p-8 font-sans overflow-x-hidden">

  <div class="max-w-4xl mx-auto space-y-8">

    <!-- 1. CABECERA (Header Híbrido Perfecto) -->
    <header class="flex flex-col md:flex-row items-center justify-between gap-6 bg-neutral-900/50 p-6 md:p-8 rounded-3xl border border-neutral-800 shadow-2xl backdrop-blur-md">

      <!-- Información Genérica y Título -->
      <div class="flex items-center gap-6 w-full md:w-auto text-center md:text-left flex-col md:flex-row">
        <!-- Foto de perfil genérica -->
        <div class="w-28 h-28 rounded-full bg-neutral-800 p-1 flex-shrink-0 shadow-lg border border-neutral-700">
          <div class="w-full h-full rounded-full bg-neutral-900 flex items-center justify-center overflow-hidden">
            <i data-lucide="user" class="w-12 h-12 text-neutral-500"></i>
          </div>
        </div>

        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2 text-white">Monitorización de Spotify</h1>
          <a href="<?php echo htmlspecialchars($config['url_spotify_perfil']); ?>" target="_blank" class="inline-flex items-center justify-center md:justify-start gap-2 text-sm font-semibold text-spotify hover:text-spotify-hover transition-colors">
            <i data-lucide="music" class="w-5 h-5"></i>
            Perfil Oficial <i data-lucide="external-link" class="w-4 h-4"></i>
          </a>
        </div>
      </div>

      <!-- Tarjetas de KPIs (Datos Reales Scrapeados) -->
      <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto mt-6 md:mt-0">
        <!-- Seguidores -->
        <div class="flex-1 bg-neutral-800/80 p-5 rounded-2xl border border-neutral-700 flex flex-col items-center justify-center text-center shadow-inner min-w-[160px]">
          <div class="flex items-center justify-center gap-2 text-neutral-400 mb-2">
            <i data-lucide="users" class="w-5 h-5 text-spotify"></i>
            <span class="text-xs font-bold uppercase tracking-widest text-neutral-300">Seguidores</span>
          </div>
          <span class="<?php echo (strlen($datosSpotify['seguidores']) > 10) ? 'text-sm' : 'text-3xl'; ?> font-black text-white">
             <?php echo htmlspecialchars($datosSpotify['seguidores']); ?>
          </span>
        </div>

        <!-- Oyentes Mensuales -->
        <div class="flex-1 bg-neutral-800/80 p-5 rounded-2xl border border-neutral-700 flex flex-col items-center justify-center text-center shadow-inner min-w-[160px]">
          <div class="flex items-center justify-center gap-2 text-neutral-400 mb-2">
            <i data-lucide="headphones" class="w-5 h-5 text-spotify"></i>
            <span class="text-xs font-bold uppercase tracking-widest text-neutral-300">Oyentes Mens.</span>
          </div>
          <span class="<?php echo (strlen($datosSpotify['oyentes']) > 10) ? 'text-sm' : 'text-3xl'; ?> font-black text-white">
             <?php echo htmlspecialchars($datosSpotify['oyentes']); ?>
          </span>
        </div>
      </div>
    </header>

    <!-- 2. CUERPO (Solución Oficial Iframe) -->
    <section class="bg-neutral-900/40 p-2 rounded-3xl border border-neutral-800/50 shadow-2xl">
      <!-- Se inyecta directamente el Iframe oficial de configuración -->
      <?php echo $config['url_spotify_iframe']; ?>
    </section>

  </div>

  <!-- Inicializa los iconos de Lucide -->
  <script>
    lucide.createIcons();
  </script>
</body>
</html>