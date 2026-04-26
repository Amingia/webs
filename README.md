# Dashboard Analítico de Spotify (Versión 5 - Profesional)

Este es un panel de control corporativo, oscuro y minimalista diseñado para mostrar estadísticas en tiempo real extraídas directamente desde Spotify, 100% nativo y sin depender de bases de datos o configuraciones engorrosas de API.

## Funcionalidades Principales

*   **Puro PHP:** Compatible "out-of-the-box" con cualquier alojamiento básico compartido (como OVH).
*   **Scraping Avanzado:** No solo lee la metaetiqueta pública para obtener Seguidores y Oyentes mensuales, sino que decodifica internamente el "Hydration Data" (`initialState`) de Spotify para obtener **las reproducciones exactas y reales** de tus 5 canciones más escuchadas en ese preciso segundo.
*   **Protección Anti-Caídas:** En caso de que Spotify cambie su estructura interna, el código está blindado mediante `try/catch`. En lugar de romper la página, mostrará elegantemente un mensaje de "Datos no disponibles temporalmente".

## Instrucciones: Instalar y Listo

El cliente no necesita saber programar ni lidiar con códigos de inserción Iframe.

1. Abre el archivo `config.php`.
2. Verás una única línea con la variable `$url_spotify_perfil`. Sustituye la URL por la tuya.
3. **Guarda el archivo**.
4. Sube por FTP los 3 archivos (`index.php`, `config.php`, `scraper.php`) a la carpeta `www` o `public_html` de tu servidor.
5. Listo. El dashboard profesional ya está funcionando.

## ¿Cómo configurar el Histórico Automático (Cron Job en OVH)?

Para que la gráfica de "Evolución de Audiencia" crezca cada día con nuevos datos sin que tengas que hacer nada, debes configurar una "tarea planificada" (Cron Job) en tu panel de control.

1. Entra a tu panel de control de OVH.
2. Ve a la sección **Web Cloud** y selecciona tu alojamiento (Hosting).
3. Busca la pestaña **Cron** o **Tareas planificadas**.
4. Haz clic en **Añadir una planificación** (o "Añadir un Cron").
5. En el formulario:
    * **Comando a ejecutar:** Escribe la ruta hacia tu archivo `scraper.php` (por ejemplo: `www/scraper.php`).
    * **Lenguaje:** Selecciona PHP (la versión más reciente que tengas).
    * **Frecuencia:** Configúralo para que se ejecute "Todos los días a las 00:00" (o una vez al día).
6. Guarda la configuración.

¡Eso es todo! Cada medianoche, el sistema leerá los datos de Spotify y los guardará en un archivo llamado `historial.json` para dibujar tu gráfica al día siguiente.