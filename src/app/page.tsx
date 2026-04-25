"use client";

import React from "react";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  BarChart,
  Bar,
  Legend,
} from "recharts";
import {
  Music,
  Camera,
  Users,
  Headphones,
  MapPin,
  ExternalLink,
} from "lucide-react";

// --- Datos Falsos (Mock Data) ---

// Evolución de los últimos 30 días (resumido en puntos de datos clave)
const crecimientoData = [
  { fecha: "1 Oct", instagram: 12000, spotifySeguidores: 8000, spotifyOyentes: 25000 },
  { fecha: "5 Oct", instagram: 12500, spotifySeguidores: 8200, spotifyOyentes: 26000 },
  { fecha: "10 Oct", instagram: 13200, spotifySeguidores: 8600, spotifyOyentes: 28500 },
  { fecha: "15 Oct", instagram: 14000, spotifySeguidores: 9100, spotifyOyentes: 31000 },
  { fecha: "20 Oct", instagram: 15100, spotifySeguidores: 9800, spotifyOyentes: 35000 },
  { fecha: "25 Oct", instagram: 16500, spotifySeguidores: 10500, spotifyOyentes: 40000 },
  { fecha: "30 Oct", instagram: 18200, spotifySeguidores: 11200, spotifyOyentes: 45000 },
];

const topCanciones = [
  { id: 1, titulo: "Ecos de Medianoche", reproducciones: 1250000, max: 1250000 },
  { id: 2, titulo: "Luces de Neón", reproducciones: 850000, max: 1250000 },
  { id: 3, titulo: "Sombra y Luz", reproducciones: 620000, max: 1250000 },
  { id: 4, titulo: "Vuelo sin Retorno", reproducciones: 450000, max: 1250000 },
  { id: 5, titulo: "Amanecer en Madrid", reproducciones: 310000, max: 1250000 },
];

const demografiaData = [
  { ciudad: "Madrid", oyentes: 12000 },
  { ciudad: "Barcelona", oyentes: 9500 },
  { ciudad: "Ciudad de México", oyentes: 8200 },
  { ciudad: "Valencia", oyentes: 4500 },
  { ciudad: "Sevilla", oyentes: 3800 },
];

// --- Componente Principal del Dashboard ---
export default function Dashboard() {
  return (
    <div className="min-h-screen bg-neutral-950 text-neutral-100 p-4 md:p-8 font-sans">
      <div className="max-w-7xl mx-auto space-y-8">

        {/* 1. CABECERA (Header) */}
        <header className="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 bg-neutral-900/50 p-6 rounded-2xl border border-neutral-800 backdrop-blur-sm">
          <div className="flex items-center gap-6">
            {/* Foto de perfil (Placeholder si no hay imagen) */}
            <div className="w-24 h-24 rounded-full bg-gradient-to-tr from-purple-600 to-orange-500 p-1 flex-shrink-0">
              <div className="w-full h-full rounded-full bg-neutral-800 flex items-center justify-center overflow-hidden">
                <span className="text-2xl font-bold text-neutral-400">CP</span>
                {/* <img src="/ruta-a-imagen.jpg" alt="Cristina Pareja" className="w-full h-full object-cover" /> */}
              </div>
            </div>

            <div>
              <h1 className="text-3xl font-bold tracking-tight mb-2">Cristina Pareja</h1>
              <div className="flex gap-4">
                <a href="#" className="flex items-center gap-2 text-sm font-medium text-[#1DB954] hover:text-[#1ed760] transition-colors">
                  <Music size={16} />
                  Spotify <ExternalLink size={12} />
                </a>
                <a href="#" className="flex items-center gap-2 text-sm font-medium text-pink-500 hover:text-pink-400 transition-colors">
                  <Camera size={16} />
                  Instagram <ExternalLink size={12} />
                </a>
              </div>
            </div>
          </div>

          {/* Tarjetas de KPIs (Key Performance Indicators) */}
          <div className="flex flex-wrap md:flex-nowrap gap-4 w-full md:w-auto">
            <div className="flex-1 min-w-[140px] bg-neutral-900 p-4 rounded-xl border border-neutral-800 flex flex-col items-center justify-center">
              <div className="flex items-center gap-2 text-neutral-400 mb-1">
                <Camera size={16} className="text-pink-500" />
                <span className="text-xs font-semibold uppercase tracking-wider">Seguidores</span>
              </div>
              <span className="text-2xl font-bold">18.2K</span>
            </div>
            <div className="flex-1 min-w-[140px] bg-neutral-900 p-4 rounded-xl border border-neutral-800 flex flex-col items-center justify-center">
              <div className="flex items-center gap-2 text-neutral-400 mb-1">
                <Users size={16} className="text-[#1DB954]" />
                <span className="text-xs font-semibold uppercase tracking-wider">Seguidores (Sp)</span>
              </div>
              <span className="text-2xl font-bold">11.2K</span>
            </div>
            <div className="flex-1 min-w-[140px] bg-neutral-900 p-4 rounded-xl border border-neutral-800 flex flex-col items-center justify-center">
              <div className="flex items-center gap-2 text-neutral-400 mb-1">
                <Headphones size={16} className="text-[#1DB954]" />
                <span className="text-xs font-semibold uppercase tracking-wider">Oyentes Mens.</span>
              </div>
              <span className="text-2xl font-bold">45.0K</span>
            </div>
          </div>
        </header>

        {/* 2. SECCIÓN DE CRECIMIENTO (Gráficos de Líneas) */}
        <section className="grid grid-cols-1 lg:grid-cols-2 gap-6">

          {/* Crecimiento de Instagram */}
          <div className="bg-neutral-900 p-6 rounded-2xl border border-neutral-800">
            <h2 className="text-lg font-semibold mb-6 flex items-center gap-2">
              <Camera size={20} className="text-pink-500" />
              Crecimiento en Instagram (Últimos 30 días)
            </h2>
            <div className="h-[300px] w-full">
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={crecimientoData}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#262626" vertical={false} />
                  <XAxis dataKey="fecha" stroke="#737373" fontSize={12} tickLine={false} axisLine={false} />
                  <YAxis stroke="#737373" fontSize={12} tickLine={false} axisLine={false} tickFormatter={(value) => `${value / 1000}k`} />
                  <Tooltip
                    contentStyle={{ backgroundColor: '#171717', borderColor: '#262626', borderRadius: '8px' }}
                    itemStyle={{ color: '#e5e5e5' }}
                  />
                  <Line
                    type="monotone"
                    dataKey="instagram"
                    name="Seguidores"
                    stroke="url(#colorIg)"
                    strokeWidth={3}
                    dot={{ r: 4, fill: '#db2777' }}
                    activeDot={{ r: 6 }}
                  />
                  <defs>
                    <linearGradient id="colorIg" x1="0%" y1="0%" x2="100%" y2="0%">
                      <stop offset="0%" stopColor="#f59e0b" /> {/* Naranja */}
                      <stop offset="100%" stopColor="#db2777" /> {/* Magenta */}
                    </linearGradient>
                  </defs>
                </LineChart>
              </ResponsiveContainer>
            </div>
          </div>

          {/* Crecimiento de Spotify */}
          <div className="bg-neutral-900 p-6 rounded-2xl border border-neutral-800">
            <h2 className="text-lg font-semibold mb-6 flex items-center gap-2">
              <Music size={20} className="text-[#1DB954]" />
              Crecimiento en Spotify (Últimos 30 días)
            </h2>
            <div className="h-[300px] w-full">
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={crecimientoData}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#262626" vertical={false} />
                  <XAxis dataKey="fecha" stroke="#737373" fontSize={12} tickLine={false} axisLine={false} />
                  <YAxis stroke="#737373" fontSize={12} tickLine={false} axisLine={false} tickFormatter={(value) => `${value / 1000}k`} />
                  <Tooltip
                    contentStyle={{ backgroundColor: '#171717', borderColor: '#262626', borderRadius: '8px' }}
                  />
                  <Legend wrapperStyle={{ fontSize: '12px', paddingTop: '10px' }} />
                  <Line
                    type="monotone"
                    dataKey="spotifyOyentes"
                    name="Oyentes Mensuales"
                    stroke="#1DB954"
                    strokeWidth={3}
                    dot={{ r: 4, fill: '#1DB954' }}
                    activeDot={{ r: 6 }}
                  />
                  <Line
                    type="monotone"
                    dataKey="spotifySeguidores"
                    name="Seguidores"
                    stroke="#1ed760"
                    strokeWidth={2}
                    strokeDasharray="5 5"
                    dot={{ r: 3, fill: '#1ed760' }}
                  />
                </LineChart>
              </ResponsiveContainer>
            </div>
          </div>

        </section>

        {/* 3 y 4. RENDIMIENTO MUSICAL Y DEMOGRAFÍA */}
        <section className="grid grid-cols-1 lg:grid-cols-2 gap-6">

          {/* Top 5 Canciones */}
          <div className="bg-neutral-900 p-6 rounded-2xl border border-neutral-800">
            <h2 className="text-lg font-semibold mb-6 flex items-center gap-2">
              <Headphones size={20} className="text-neutral-400" />
              Top 5 Canciones Populares
            </h2>
            <div className="space-y-5">
              {topCanciones.map((cancion, index) => {
                const porcentaje = (cancion.reproducciones / cancion.max) * 100;
                return (
                  <div key={cancion.id} className="group">
                    <div className="flex justify-between items-end mb-2">
                      <div className="flex items-center gap-3">
                        <span className="text-neutral-500 font-mono text-sm">{index + 1}</span>
                        <span className="font-medium group-hover:text-neutral-300 transition-colors">{cancion.titulo}</span>
                      </div>
                      <span className="text-sm text-neutral-400 font-mono">
                        {cancion.reproducciones.toLocaleString("es-ES")}
                      </span>
                    </div>
                    {/* Barra de progreso visual */}
                    <div className="h-2 w-full bg-neutral-800 rounded-full overflow-hidden">
                      <div
                        className="h-full bg-[#1DB954] rounded-full transition-all duration-1000 ease-out"
                        style={{ width: `${porcentaje}%` }}
                      ></div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>

          {/* Demografía (Top 5 Ciudades) */}
          <div className="bg-neutral-900 p-6 rounded-2xl border border-neutral-800">
            <h2 className="text-lg font-semibold mb-6 flex items-center gap-2">
              <MapPin size={20} className="text-neutral-400" />
              Top 5 Ciudades de Escucha
            </h2>
            <div className="h-[280px] w-full">
              <ResponsiveContainer width="100%" height="100%">
                <BarChart
                  data={demografiaData}
                  layout="vertical"
                  margin={{ top: 0, right: 30, left: 40, bottom: 0 }}
                >
                  <CartesianGrid strokeDasharray="3 3" stroke="#262626" horizontal={true} vertical={false} />
                  <XAxis type="number" stroke="#737373" fontSize={12} tickLine={false} axisLine={false} />
                  <YAxis dataKey="ciudad" type="category" stroke="#a3a3a3" fontSize={12} tickLine={false} axisLine={false} width={80} />
                  <Tooltip
                    cursor={{ fill: '#262626' }}
                    contentStyle={{ backgroundColor: '#171717', borderColor: '#262626', borderRadius: '8px' }}
                  />
                  <Bar dataKey="oyentes" name="Oyentes" fill="#1DB954" radius={[0, 4, 4, 0]} barSize={20} />
                </BarChart>
              </ResponsiveContainer>
            </div>
          </div>

        </section>

      </div>
    </div>
  );
}
