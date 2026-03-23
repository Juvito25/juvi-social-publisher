# Juvi Social Publisher

Plataforma web para publicar contenido en múltiples redes sociales desde un solo lugar.

## Descripción

Herramienta desarrollada para **Juvi Web** que permite:
- Subir archivos (imágenes/videos)
- Redactar copy y hashtags
- Seleccionar redes sociales objetivo
- Publicar en Instagram, TikTok, Facebook y WhatsApp

## Stack Tecnológico

- **Backend**: Laravel 11
- **Frontend**: Vue 3 + Inertia.js
- **Estilos**: TailwindCSS
- **Base de datos**: SQLite (desarrollo)

## Colores de Marca

| Uso | Color | Hex |
|-----|-------|-----|
| Fondo principal | Dark Mode | `#262626` |
| Acento/Botones | Verde Juvi | `#A8D95F` |
| Hover botón | Verde claro | `#D2F2A2` |
| Verde oscuro | Secundario | `#81A64B` |
| Verde grisáceo | Borde | `#7D8C65` |

## Installation

```bash
# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Iniciar servidor
php artisan serve
npm run dev
```

## Licencia

MIT
