
# 📗 Backend - Laravel API

Este es el backend del sistema de solicitud de certificados, desarrollado con Laravel. Se encarga de la autenticación, manejo de usuarios, flujo de certificados y generación de PDFs.

---

## 🚀 Tecnologías

- Laravel 10+
- PostgreSQL
- DOMPDF
- JWT Auth (via tymon/jwt-auth)

---

## 📦 Instalación

1. Clona el repositorio y accede al proyecto:
   ```bash
   git clone https://github.com/yarke19841/docutrank-api.git
   cd docutrank-api
   ```

2. Copia el archivo `.env`:
   ```bash
   cp .env.example .env
   ```

3. Instala dependencias:
   ```bash
   composer install
   ```

4. Genera la clave de la app:
   ```bash
   php artisan key:generate
   ```

5. Ejecuta las migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Corre el servidor:
   ```bash
   php artisan serve
   ```

---

## ⚙️ Variables de entorno (`.env`)

Para desarrollo local:
```env
APP_URL=http://localhost:8000
```

Para producción (Render u otro entorno):
```env
# APP_URL=https://docutrank-api-1.onrender.com
```

---

## 📋 Funcionalidades principales

- Registro y autenticación JWT
- Roles: Usuario y Administrador
- Subida y almacenamiento de documentos
- Control de estados y etapas
- Generación automática de PDF cuando el estado es "Emitido"

---
