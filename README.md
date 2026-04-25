# Dashboard de Cristina Pareja

Este es el panel de control de monitorización artística para la cantante Cristina Pareja. Permite visualizar el crecimiento de su base de fans en Instagram y Spotify.

## ¿Cómo actualizar los datos?

No hace falta tener conocimientos de programación para actualizar las cifras. Todo se hace modificando un único archivo. Sigue estos pasos:

1. Ve a la carpeta del proyecto y busca un archivo llamado `datos.js`.
2. Ábrelo con el **Bloc de notas** (en Windows), **TextEdit** (en Mac) o cualquier otro editor de texto simple.
3. Dentro verás diferentes secciones claramente marcadas en español:
   - Para cambiar las estadísticas principales (KPIs), busca las líneas que dicen `seguidoresInstagram`, `seguidoresSpotify`, etc., y cambia los números o textos que están entre las comillas (por ejemplo, cambia `"18.2K"` por `"20.5K"`).
   - Para actualizar los gráficos, baja hasta la sección `graficoCrecimiento` y cambia los números dentro de los corchetes `[]`.
   - Para cambiar el Top 5 de Canciones o Ciudades, modifica los números al lado de `reproducciones` u `oyentes`.
4. Una vez hechos los cambios, **guarda el archivo** (Archivo > Guardar o `Ctrl + G` / `Cmd + S`).
5. Vuelve a cargar la página web en tu navegador y verás los nuevos datos al instante.

## Guía de subida a OVH (Hosting Básico)

El código ha sido diseñado para funcionar de manera completamente estática ("subir y listo"), por lo que **no hay que instalar nada ni ejecutar comandos de terminal en el servidor**.

Para que la web esté visible en internet a través de tu hosting compartido de OVH, sigue estos pasos:

1. Inicia sesión en el panel de control de tu cuenta de OVH.
2. Ve a la sección **Web Cloud** y luego a **Alojamientos**.
3. Selecciona tu dominio.
4. En el menú superior, haz clic en la pestaña **FTP - SSH**.
5. Usa el botón **Explorador FTP** (WebFTP) para abrir tus carpetas. También puedes usar un programa como FileZilla usando las credenciales que aparecen en esa misma pantalla.
6. Entra en la carpeta raíz pública de tu hosting. Normalmente se llama `www` o `public_html`.
7. **Sube todos los archivos** de esta carpeta (`index.html`, `datos.js`, `app.js`, `style.css`) directamente dentro de la carpeta `www` o `public_html`.
   *Nota: Asegúrate de subir los archivos sueltos y no la carpeta entera contenedora, para que `index.html` quede directamente en la ruta principal.*
8. ¡Ya está! Entra en tu página web y deberías ver el Dashboard funcionando.