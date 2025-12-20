# Laravel + Vue + Inertia + Docker

Proyecto configurado para desarrollo local y despliegue en producción con Docker.

---

## 🐳 Configuración Docker (Copiar Prompt)

**Usa este prompt con una IA para configurar Docker en futuros proyectos Laravel similares:**

```
Necesito dockerizar mi proyecto Laravel con las siguientes características:
- Laravel 10+ con Jetstream e Inertia.js
- Frontend: Vue 3 + Vite
- Base de datos: SQLite (archivo local)
- Despliegue: Render u otro servicio cloud similar

Requisitos específicos:
1. Crear Dockerfile basado en php:8.2-cli con:
   - Extensiones PHP: pdo_sqlite, mbstring, exif, pcntl, bcmath, gd
   - Node.js y npm para el frontend
   - Composer para dependencias PHP

2. Crear docker-compose.yml para desarrollo local con:
   - Servicio único "app"
   - Puertos: 8000 (Laravel) y 5173 (Vite)
   - Volúmenes para desarrollo en caliente

3. Crear script entrypoint.sh que automáticamente:
   - Cree el archivo database.sqlite si no existe
   - Instale dependencias de Composer (con --no-dev --optimize-autoloader en producción)
   - Instale dependencias de npm
   - Ejecute npm run build para compilar assets
   - Ejecute migraciones con --force
   - Optimice caché de Laravel (config, route, view)
   - Inicie el servidor con php artisan serve

4. Configuraciones para producción en HTTPS (Render/similar):
   - Modificar app/Http/Middleware/TrustProxies.php: $proxies = '*'
   - Configurar variables de entorno necesarias

5. Crear .dockerignore adecuado

Proporciona todos los archivos necesarios y las instrucciones de configuración de variables de entorno.
```

---

## 📁 Estructura de Archivos Docker

Este proyecto incluye 4 archivos clave para Docker:

```
├── Dockerfile              # Imagen base con PHP, Node y extensiones
├── docker-compose.yml      # Orquestación para desarrollo local
├── docker/
│   └── entrypoint.sh      # Script de inicialización automática
└── .dockerignore          # Archivos excluidos del build
```

---

## 🚀 Uso Local (Desarrollo)

### 1. Iniciar la aplicación:

```bash
docker-compose up -d
```

### 2. Ver logs:

```bash
docker-compose logs -f
```

### 3. Acceder a la aplicación:

-   **Backend**: http://localhost:8000
-   **Frontend (Vite HMR)**: Ejecuta `docker-compose exec app npm run dev`

### 4. Comandos útiles:

```bash
# Ejecutar comandos Artisan
docker-compose exec app php artisan migrate

# Instalar dependencias adicionales
docker-compose exec app composer require nombre/paquete

# Acceder al contenedor
docker-compose exec app bash

# Detener
docker-compose down
```

---

## ☁️ Despliegue en Producción (Render)

### Variables de Entorno Requeridas:

En el panel de Render → Environment, configura:

```env
# Aplicación
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:TU_CLAVE_GENERADA
APP_DEBUG=false
APP_URL=https://tu-dominio.onrender.com

# Base de datos SQLite
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

# Assets (IMPORTANTE para HTTPS)
ASSET_URL=https://tu-dominio.onrender.com

# Proxy (IMPORTANTE para HTTPS)
FORWARD_PROTO=https

# Logs
LOG_CHANNEL=stderr
LOG_LEVEL=debug

# Otros (mantener valores por defecto de Laravel)
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Pasos para Deploy:

1. **Conecta tu repositorio de GitHub a Render**
2. **Configura las variables de entorno** (arriba)
3. **Render detectará el Dockerfile automáticamente**
4. **Espera a que termine el build** (primera vez toma ~5-10 min)
5. **Accede a tu URL asignada**

---

## ⚠️ Problemas Comunes y Soluciones

### 🔴 Pantalla en blanco / Archivos no se cargan

**Síntoma:** La página carga pero está en blanco, o los botones de Inertia no funcionan.

**Causa:** Laravel genera URLs con `http://` en lugar de `https://`, el navegador bloquea por "Mixed Content".

**Solución:**

1. Verifica que `APP_URL` y `ASSET_URL` usen `https://`
2. Verifica que `TrustProxies.php` tenga `$proxies = '*'`
3. Recarga con Ctrl+F5

### 🔴 Error "APP_KEY missing"

**Causa:** La variable `APP_KEY` no está configurada en Render.

**Solución:**

1. En tu PC: Ejecuta `php artisan key:generate` y copia la clave del archivo `.env`
2. En Render: Pega esa clave en la variable `APP_KEY`

### 🔴 Base de datos se borra al reiniciar

**Causa:** SQLite en Render (plan gratuito) usa almacenamiento efímero.

**Solución:**

-   **Opción A (Recomendada):** Usa PostgreSQL gratis de Render
-   **Opción B:** Contrata un "Persistent Disk" de pago
-   **Opción C:** Solo para pruebas, acepta que los datos se borren

---

## 🛠️ Configuraciones Aplicadas

### 1. **TrustProxies.php**

```php
protected $proxies = '*';
```

Permite que Laravel detecte correctamente HTTPS detrás de proxies.

### 2. **Entrypoint.sh**

-   NO genera `APP_KEY` automáticamente (se configura por variables de entorno)
-   Compila assets con `npm run build`
-   Optimiza caché de Laravel para producción

### 3. **Dockerfile**

-   Usa `php:8.2-cli` (ligero, suficiente para `artisan serve`)
-   Instala extensiones necesarias para Laravel
-   Copia código con `COPY . .` para producción

---

## 📚 Stack Tecnológico

-   **Backend:** Laravel 10 + Jetstream
-   **Frontend:** Vue 3 + Inertia.js + Tailwind CSS
-   **Build:** Vite
-   **Base de datos:** SQLite (desarrollo) / PostgreSQL (producción recomendada)
-   **Containerización:** Docker
-   **Despliegue:** Render (compatible con Heroku, Railway, Fly.io)

---

## 👤 Autor

Desarrollado como proyecto de prueba para Docker + Laravel + Render.

---

## 📄 Licencia

Este proyecto usa Laravel, licenciado bajo [MIT license](https://opensource.org/licenses/MIT).
