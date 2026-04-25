# Dashboard - Monitorización de Spotify (Versión 4 - Definitiva)

Este es el panel de control de monitorización artística, diseñado específicamente como una **versión final y real** libre de datos inventados y falsos. Su objetivo es brindar un cuadro de mandos minimalista y elegante enfocado 100% en los datos reales extraídos en vivo desde Spotify.

## Características Técnicas

*   **Puro PHP:** Desarrollado sin frameworks complejos como Node.js o React. Funciona nativamente en cualquier servidor o hosting compartido básico como **OVH**.
*   **Cero Datos Falsos:** Se ha eliminado toda gráfica inventada o historial simulado por falta de base de datos. Lo que ves es exactamente lo que extrae en el momento.
*   **Integración Oficial:** El listado de canciones es el iframe del reproductor oficial de "Spotify for Artists".

## Instrucciones de Configuración

Para que el panel funcione con el artista que desees, solo necesitas cambiar dos líneas:

1. Abre la carpeta del proyecto y busca el archivo `config.php`.
2. Edítalo usando el Bloc de notas u otro editor básico.
3. Actualiza las dos únicas variables disponibles:
   *   `$url_spotify_perfil`: Pega aquí el enlace web público del perfil del artista en Spotify (ej. *https://open.spotify.com/artist/...*). De este enlace extraerá los números automáticos.
   *   `$url_spotify_iframe`: Pega el código HTML completo que te da Spotify. Para conseguirlo, ve al perfil del artista en Spotify, haz clic en los tres puntos (Opciones) > Compartir > **Insertar artista** > Copiar.
4. **Guarda el archivo**.

## Instrucciones de Subida a tu Hosting (OVH)

Desplegar este panel es extremadamente rápido ("subir y listo"):

1. Accede al panel de control de tu cuenta de OVH.
2. Entra en **Web Cloud** > **Alojamientos** y selecciona tu dominio.
3. Abre la pestaña **FTP - SSH** y usa el **Explorador FTP** (o FileZilla si lo prefieres).
4. Entra en la carpeta pública raíz de tu servidor (normalmente llamada `www` o `public_html`).
5. **Copia y sube** directamente a esa carpeta estos 3 archivos:
   *   `index.php`
   *   `config.php`
   *   `scraper.php`
6. Listo. Accede a tu página web desde el navegador.

*Nota: Asegúrate de que no haya ningún archivo llamado `index.html` viejo estorbando en esa carpeta para que tu servidor lea correctamente este nuevo `index.php`.*