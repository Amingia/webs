# Dashboard de Cristina Pareja (Versión PHP Scraping)

Este es el panel de control de monitorización artística para la cantante Cristina Pareja. En esta versión avanzada, el sistema extrae automáticamente y en tiempo real el crecimiento de su base de fans directamente de las páginas públicas de Instagram y Spotify.

## ¿Cómo configurar las URLs?

El sistema está preparado para no requerir bases de datos ni instalación compleja. Simplemente debes decirle a qué perfiles quieres que se conecte:

1. Ve a la carpeta del proyecto y abre el archivo `config.php`.
2. Ábrelo con el **Bloc de notas** o cualquier editor de código.
3. Sustituye las URLs que vienen de ejemplo por las URLs reales de los perfiles de la artista.
4. **Guarda el archivo**. ¡Eso es todo!

## Guía de subida a OVH (Hosting Básico)

El código utiliza PHP nativo, por lo que es 100% compatible con cualquier plan de hosting compartido de OVH sin necesidad de configurar Node.js, bases de datos o comandos por terminal.

Sigue estos pasos para publicarlo:

1. Inicia sesión en el panel de control de tu cuenta de OVH.
2. Ve a la sección **Web Cloud** y luego a **Alojamientos**.
3. Selecciona tu dominio en la barra lateral.
4. Haz clic en la pestaña **FTP - SSH**.
5. Abre el **Explorador FTP** (WebFTP) o usa un programa como FileZilla.
6. Entra en la carpeta pública principal (normalmente `www` o `public_html`).
7. **Sube todos los archivos** de esta carpeta (`index.php`, `config.php`, `scraper.php`, `app.js`, `style.css`) directamente en la carpeta raíz.
   *Nota: Borra cualquier archivo `index.html` viejo que pueda haber en tu servidor para que lea el nuevo `index.php`.*
8. Carga tu página web. El sistema buscará las URLs indicadas y mostrará los KPIs actualizados.

### Sobre el sistema Anti-Bot
Ten en cuenta que Instagram y Spotify tienen medidas de seguridad que a veces bloquean peticiones automáticas. Si esto ocurre, el Dashboard no se romperá; simplemente mostrará que el dato no está disponible temporalmente o usará un último valor simulado para no dejar los gráficos vacíos.