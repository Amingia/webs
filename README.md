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