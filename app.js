// ==========================================
// LÓGICA PRINCIPAL DEL DASHBOARD
// ==========================================
// Este archivo lee la información dinámica de DATOS_SCRAPING (inyectada por PHP)
// y la inyecta en el HTML y en los gráficos simulando un histórico si es necesario.

document.addEventListener('DOMContentLoaded', () => {
  // Función auxiliar para convertir "18.2K" a número (18200)
  function parsearKpi(str) {
    if (!str || str.includes("no disponible") || str.includes("Simulado")) return 0;
    let num = parseFloat(str.replace(/[^0-9.]/g, ''));
    if (str.includes('K')) num *= 1000;
    if (str.includes('M')) num *= 1000000;
    return num;
  }

  // 1. Rellenar KPIs
  const igText = DATOS_SCRAPING.seguidoresInstagram;
  const spSegText = DATOS_SCRAPING.seguidoresSpotify;
  const spOyText = DATOS_SCRAPING.oyentesMensuales;

  document.getElementById('kpi-ig-seguidores').textContent = igText;
  document.getElementById('kpi-sp-seguidores').textContent = spSegText;
  document.getElementById('kpi-sp-oyentes').textContent = spOyText;

  // Modificar el estilo del texto si hay error ("Dato no disponible...")
  if (igText.length > 10) document.getElementById('kpi-ig-seguidores').classList.replace('text-2xl', 'text-xs');
  if (spSegText.length > 10) document.getElementById('kpi-sp-seguidores').classList.replace('text-2xl', 'text-xs');
  if (spOyText.length > 10) document.getElementById('kpi-sp-oyentes').classList.replace('text-2xl', 'text-xs');

  // Simular histórico basado en el dato actual (para los gráficos)
  const baseIg = parsearKpi(igText) || 18200; // Si falla, usamos fallback visual
  const baseSpSeg = parsearKpi(spSegText) || 11200;
  const baseSpOy = parsearKpi(spOyText) || 45000;

  const graficoCrecimiento = {
    fechas: ["1 Oct", "5 Oct", "10 Oct", "15 Oct", "20 Oct", "25 Oct", "Hoy"],
    instagram: [baseIg*0.65, baseIg*0.70, baseIg*0.75, baseIg*0.80, baseIg*0.88, baseIg*0.95, baseIg],
    spotifySeguidores: [baseSpSeg*0.7, baseSpSeg*0.75, baseSpSeg*0.8, baseSpSeg*0.85, baseSpSeg*0.9, baseSpSeg*0.95, baseSpSeg],
    spotifyOyentes: [baseSpOy*0.6, baseSpOy*0.65, baseSpOy*0.7, baseSpOy*0.78, baseSpOy*0.85, baseSpOy*0.9, baseSpOy]
  };

  // 2. Renderizar Top 5 Canciones
  const listaCanciones = document.getElementById('lista-canciones');
  const maxReproducciones = Math.max(...DATOS_SCRAPING.canciones.map(c => c.reproducciones));

  DATOS_SCRAPING.canciones.forEach((cancion, index) => {
    const porcentaje = (cancion.reproducciones / maxReproducciones) * 100;

    // Formatear el número con separadores de miles
    const reproduccionesFormateadas = cancion.reproducciones.toLocaleString("es-ES");

    const html = `
      <div class="group">
        <div class="flex justify-between items-end mb-2">
          <div class="flex items-center gap-3">
            <span class="text-neutral-500 font-mono text-sm">${index + 1}</span>
            <span class="font-medium group-hover:text-neutral-300 transition-colors">${cancion.titulo}</span>
          </div>
          <span class="text-sm text-neutral-400 font-mono">${reproduccionesFormateadas}</span>
        </div>
        <div class="h-2 w-full bg-neutral-800 rounded-full overflow-hidden">
          <div
            class="h-full bg-spotify rounded-full transition-all duration-1000 ease-out"
            style="width: ${porcentaje}%"
          ></div>
        </div>
      </div>
    `;
    listaCanciones.innerHTML += html;
  });

  // ----------------------------------------
  // Configuración Global de Chart.js
  // ----------------------------------------
  Chart.defaults.color = '#737373';
  Chart.defaults.font.family = 'sans-serif';
  Chart.defaults.scale.grid.color = '#262626';

  // 3. Gráfico de Instagram
  const ctxIg = document.getElementById('chartInstagram').getContext('2d');

  // Crear un gradiente naranja a magenta para Instagram
  const gradientIg = ctxIg.createLinearGradient(0, 0, 0, 300);
  gradientIg.addColorStop(0, 'rgba(219, 39, 119, 0.5)'); // Magenta
  gradientIg.addColorStop(1, 'rgba(245, 158, 11, 0.1)'); // Naranja

  new Chart(ctxIg, {
    type: 'line',
    data: {
      labels: graficoCrecimiento.fechas,
      datasets: [{
        label: 'Seguidores',
        data: graficoCrecimiento.instagram,
        borderColor: '#db2777', // Magenta Tailwind
        backgroundColor: gradientIg,
        borderWidth: 3,
        pointBackgroundColor: '#db2777',
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#171717',
          titleColor: '#e5e5e5',
          bodyColor: '#e5e5e5',
          borderColor: '#262626',
          borderWidth: 1,
          padding: 10,
          displayColors: false,
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          border: { display: false },
          ticks: { callback: (value) => value / 1000 + 'k' }
        },
        x: {
          grid: { display: false },
          border: { display: false }
        }
      }
    }
  });

  // 4. Gráfico de Spotify
  const ctxSp = document.getElementById('chartSpotify').getContext('2d');
  new Chart(ctxSp, {
    type: 'line',
    data: {
      labels: graficoCrecimiento.fechas,
      datasets: [
        {
          label: 'Oyentes Mensuales',
          data: graficoCrecimiento.spotifyOyentes,
          borderColor: '#1DB954',
          borderWidth: 3,
          pointBackgroundColor: '#1DB954',
          tension: 0.4
        },
        {
          label: 'Seguidores',
          data: graficoCrecimiento.spotifySeguidores,
          borderColor: '#1ed760',
          borderWidth: 2,
          borderDash: [5, 5],
          pointBackgroundColor: '#1ed760',
          tension: 0.4
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: '#a3a3a3', boxWidth: 12, usePointStyle: true }
        },
        tooltip: {
          backgroundColor: '#171717',
          titleColor: '#e5e5e5',
          bodyColor: '#e5e5e5',
          borderColor: '#262626',
          borderWidth: 1,
          padding: 10
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          border: { display: false },
          ticks: { callback: (value) => value / 1000 + 'k' }
        },
        x: {
          grid: { display: false },
          border: { display: false }
        }
      }
    }
  });

  // 5. Gráfico de Demografía (Barras Horizontales)
  const ctxDemografia = document.getElementById('chartDemografia').getContext('2d');
  new Chart(ctxDemografia, {
    type: 'bar',
    data: {
      labels: DATOS_SCRAPING.ciudades.map(c => c.nombre),
      datasets: [{
        label: 'Oyentes',
        data: DATOS_SCRAPING.ciudades.map(c => c.oyentes),
        backgroundColor: '#1DB954',
        borderRadius: 4,
        barPercentage: 0.6
      }]
    },
    options: {
      indexAxis: 'y', // Hace que las barras sean horizontales
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#171717',
          titleColor: '#e5e5e5',
          bodyColor: '#e5e5e5',
          borderColor: '#262626',
          borderWidth: 1,
          padding: 10,
          displayColors: false
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          border: { display: false },
          grid: { color: '#262626' }
        },
        y: {
          grid: { display: false },
          border: { display: false },
          ticks: { color: '#a3a3a3' }
        }
      }
    }
  });
});