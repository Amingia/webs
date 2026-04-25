// ==========================================
// DATOS DEL DASHBOARD DE CRISTINA PAREJA
// ==========================================
// Instrucciones:
// 1. Abre este archivo con un Bloc de notas o editor de texto.
// 2. Cambia los números entre comillas o sin comillas.
// 3. Guarda el archivo y recarga la página web para ver los cambios.

const DATOS = {
  // ----------------------------------------
  // 1. ESTADÍSTICAS GENERALES (KPIs)
  // ----------------------------------------
  seguidoresInstagram: "18.2K",
  seguidoresSpotify: "11.2K",
  oyentesMensuales: "45.0K",

  // ----------------------------------------
  // 2. CRECIMIENTO EN LOS ÚLTIMOS 30 DÍAS
  // ----------------------------------------
  // Cambia estos números si quieres actualizar la gráfica
  graficoCrecimiento: {
    fechas: ["1 Oct", "5 Oct", "10 Oct", "15 Oct", "20 Oct", "25 Oct", "30 Oct"],
    instagram: [12000, 12500, 13200, 14000, 15100, 16500, 18200],
    spotifySeguidores: [8000, 8200, 8600, 9100, 9800, 10500, 11200],
    spotifyOyentes: [25000, 26000, 28500, 31000, 35000, 40000, 45000]
  },

  // ----------------------------------------
  // 3. TOP 5 CANCIONES (Spotify)
  // ----------------------------------------
  canciones: [
    { titulo: "Ecos de Medianoche", reproducciones: 1250000 },
    { titulo: "Luces de Neón", reproducciones: 850000 },
    { titulo: "Sombra y Luz", reproducciones: 620000 },
    { titulo: "Vuelo sin Retorno", reproducciones: 450000 },
    { titulo: "Amanecer en Madrid", reproducciones: 310000 }
  ],

  // ----------------------------------------
  // 4. TOP 5 CIUDADES DE ESCUCHA
  // ----------------------------------------
  ciudades: [
    { nombre: "Madrid", oyentes: 12000 },
    { nombre: "Barcelona", oyentes: 9500 },
    { nombre: "Ciudad de México", oyentes: 8200 },
    { nombre: "Valencia", oyentes: 4500 },
    { nombre: "Sevilla", oyentes: 3800 }
  ]
};
