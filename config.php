<?php
// ==========================================
// CONFIGURACIÓN DEL DASHBOARD (VERSIÓN 4 - DEFINITIVA)
// ==========================================
// Instrucciones:
// 1. Añade la URL del perfil oficial de Spotify.
// 2. Añade el código "iframe" que da Spotify para incrustar el perfil.
// No hay datos inventados, todo será extraído en tiempo real.

$config = [
    // URL del perfil público de Spotify (Artist Page)
    'url_spotify_perfil' => 'https://open.spotify.com/artist/0TnOYISbd1XYRBk9myaseg',

    // Código iFrame de incrustación de Spotify (Cópialo de Spotify -> Compartir -> Insertar artista)
    'url_spotify_iframe' => '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/artist/0TnOYISbd1XYRBk9myaseg?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>'
];
