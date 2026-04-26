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

  <!-- Chart.js vía CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <!-- 2. HISTÓRICO (Gráfica de Evolución de Audiencia) -->
    <section class="bg-neutral-900/60 p-6 md:p-8 rounded-3xl border border-neutral-800 shadow-2xl backdrop-blur-sm mb-8">
      <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
        <i data-lucide="trending-up" class="w-6 h-6 text-spotify"></i>
        Evolución de Audiencia
      </h2>
      <div class="relative w-full h-64 md:h-80">
        <canvas id="audienciaChart"></canvas>
      </div>
    </section>

    <!-- 3. CUERPO (Rendimiento de Pistas) -->
    <section class="bg-neutral-900/60 p-6 md:p-8 rounded-3xl border border-neutral-800 shadow-2xl backdrop-blur-sm">
      <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
        <i data-lucide="bar-chart-2" class="w-6 h-6 text-spotify"></i>
        Rendimiento de Pistas
      </h2>

      <div class="space-y-4">
        <?php if (!empty($datosSpotify['canciones']) && is_array($datosSpotify['canciones'])): ?>
            <?php foreach ($datosSpotify['canciones'] as $index => $cancion): ?>
                <div class="flex items-center justify-between p-4 bg-neutral-800/50 rounded-2xl border border-neutral-700/50 hover:bg-neutral-800 transition-colors group">

                  <div class="flex items-center gap-4">
                    <span class="text-neutral-500 font-mono text-lg font-bold w-6 text-center"><?php echo $index + 1; ?></span>

                    <div class="w-12 h-12 rounded-lg overflow-hidden border border-neutral-700 flex-shrink-0 bg-neutral-900">
                      <?php if (!empty($cancion['miniatura'])): ?>
                        <img src="<?php echo htmlspecialchars($cancion['miniatura']); ?>" alt="Portada" class="w-full h-full object-cover">
                      <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                          <i data-lucide="music" class="w-5 h-5 text-neutral-600"></i>
                        </div>
                      <?php endif; ?>
                    </div>

                    <span class="font-medium text-neutral-200 group-hover:text-white transition-colors line-clamp-1">
                      <?php echo htmlspecialchars($cancion['titulo']); ?>
                    </span>
                  </div>

                  <div class="text-right ml-4">
                    <span class="text-lg font-mono font-bold text-spotify tracking-tight">
                      <?php echo number_format((int)$cancion['reproducciones'], 0, ',', '.'); ?>
                    </span>
                  </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 text-center bg-neutral-800/30 rounded-2xl border border-neutral-700/30 border-dashed">
              <i data-lucide="alert-circle" class="w-8 h-8 text-neutral-500 mx-auto mb-3"></i>
              <p class="text-neutral-400 font-medium">Datos de pistas no disponibles temporalmente.</p>
            </div>
        <?php endif; ?>
      </div>
    </section>

  </div>

  <!-- Inicializa los iconos de Lucide -->
  <script>
    lucide.createIcons();
  </script>

  <?php
    // Leer el historial para pasarlo a Chart.js
    $fechas = [];
    $oyentes_historico = [];
    $seguidores_historico = [];

    $archivoHistorial = 'historial.json';
    if (file_exists($archivoHistorial)) {
        $contenido = file_get_contents($archivoHistorial);
        $historial = json_decode($contenido, true);

        if (is_array($historial)) {
            foreach ($historial as $entrada) {
                // Formatear la fecha a dd/mm para que ocupe menos
                $dateObj = DateTime::createFromFormat('Y-m-d', $entrada['fecha']);
                $fechas[] = $dateObj ? $dateObj->format('d/m') : $entrada['fecha'];
                $oyentes_historico[] = $entrada['oyentes'];
                $seguidores_historico[] = $entrada['seguidores'];
            }
        }
    }
  ?>

  <!-- Configuración de Chart.js -->
  <script>
    const ctx = document.getElementById('audienciaChart').getContext('2d');

    // Inyección segura de datos PHP a JS
    const etiquetasFechas = <?php echo json_encode($fechas); ?>;
    const datosOyentes = <?php echo json_encode($oyentes_historico); ?>;
    const datosSeguidores = <?php echo json_encode($seguidores_historico); ?>;

    // Configuración del tema oscuro para la gráfica
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.font.family = 'ui-sans-serif, system-ui, sans-serif';

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: etiquetasFechas.length > 0 ? etiquetasFechas : ['Hoy'],
        datasets: [
          {
            label: 'Oyentes Mensuales',
            data: datosOyentes.length > 0 ? datosOyentes : [<?php echo (isset($datosSpotify['oyentes']) && $datosSpotify['oyentes'] !== "No disponible") ? ((float)str_replace(['K', 'M', ','], ['', '', '.'], $datosSpotify['oyentes']) * (strpos($datosSpotify['oyentes'], 'M') !== false ? 1000000 : (strpos($datosSpotify['oyentes'], 'K') !== false ? 1000 : 1))) : 'null'; ?>],
            borderColor: '#1DB954',
            backgroundColor: 'rgba(29, 185, 84, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#1DB954',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
          },
          {
            label: 'Seguidores',
            data: datosSeguidores.length > 0 ? datosSeguidores : [<?php echo (isset($datosSpotify['seguidores']) && $datosSpotify['seguidores'] !== "No disponible") ? ((float)str_replace(['K', 'M', ','], ['', '', '.'], $datosSpotify['seguidores']) * (strpos($datosSpotify['seguidores'], 'M') !== false ? 1000000 : (strpos($datosSpotify['seguidores'], 'K') !== false ? 1000 : 1))) : 'null'; ?>],
            borderColor: '#3b82f6',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            align: 'end',
            labels: {
              usePointStyle: true,
              boxWidth: 8,
              font: {
                weight: 'bold'
              }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(23, 23, 23, 0.9)',
            titleColor: '#fff',
            bodyColor: '#e5e5e5',
            borderColor: '#404040',
            borderWidth: 1,
            padding: 12,
            cornerRadius: 8,
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  // Formato de miles
                  label += new Intl.NumberFormat('es-ES').format(context.parsed.y);
                }
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: 'rgba(64, 64, 64, 0.4)',
              drawBorder: false,
            },
            ticks: {
              callback: function(value, index, values) {
                if (value >= 1000000) {
                  return (value / 1000000).toFixed(1) + 'M';
                } else if (value >= 1000) {
                  return (value / 1000).toFixed(1) + 'K';
                }
                return value;
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false,
            }
          }
        },
        interaction: {
          mode: 'index',
          intersect: false,
        },
      }
    });
  </script>
</body>
</html>