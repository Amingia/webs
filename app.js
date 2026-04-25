// ==========================================
// LÓGICA PRINCIPAL DEL DASHBOARD
// ==========================================
// Este archivo lee la información de datos.js
// y la inyecta en el HTML y en los gráficos.

document.addEventListener('DOMContentLoaded', () => {
  // 1. Rellenar KPIs
  document.getElementById('kpi-ig-seguidores').textContent = DATOS.seguidoresInstagram;
  document.getElementById('kpi-sp-seguidores').textContent = DATOS.seguidoresSpotify;
  document.getElementById('kpi-sp-oyentes').textContent = DATOS.oyentesMensuales;

  // 2. Renderizar Top 5 Canciones
  const listaCanciones = document.getElementById('lista-canciones');
  const maxReproducciones = Math.max(...DATOS.canciones.map(c => c.reproducciones));

  DATOS.canciones.forEach((cancion, index) => {
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
      labels: DATOS.graficoCrecimiento.fechas,
      datasets: [{
        label: 'Seguidores',
        data: DATOS.graficoCrecimiento.instagram,
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
      labels: DATOS.graficoCrecimiento.fechas,
      datasets: [
        {
          label: 'Oyentes Mensuales',
          data: DATOS.graficoCrecimiento.spotifyOyentes,
          borderColor: '#1DB954',
          borderWidth: 3,
          pointBackgroundColor: '#1DB954',
          tension: 0.4
        },
        {
          label: 'Seguidores',
          data: DATOS.graficoCrecimiento.spotifySeguidores,
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
      labels: DATOS.ciudades.map(c => c.nombre),
      datasets: [{
        label: 'Oyentes',
        data: DATOS.ciudades.map(c => c.oyentes),
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