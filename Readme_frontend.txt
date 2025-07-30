
# 📘 Frontend - React (resources/frontend)

Este es el frontend del sistema de solicitud de certificados, construido con React.js e integrado dentro del proyecto Laravel en la carpeta `resources/frontend`.

---

## 🚀 Tecnologías

- React.js + Vite
- JWT Authentication
- Tailwind CSS (si aplica)
- Axios para peticiones HTTP

---

## 📦 Instalación

1. Accede a la carpeta:
   ```bash
   cd resources/frontend
   ```

2. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

3. Instala las dependencias:
   ```bash
   npm install
   ```

4. Inicia el servidor de desarrollo:
   ```bash
   npm run dev
   ```

---

## ⚙️ Variables de entorno (`.env`)

Para desarrollo local:
```env
VITE_API_URL=http://localhost:8000/api
VITE_STORAGE_URL=http://localhost:8000/storage
```

Para producción (Render u otro hosting):
```env
# VITE_API_URL=https://docutrank-api-1.onrender.com/api
# VITE_STORAGE_URL=https://docutrank-api-1.onrender.com/storage
```

---

## 📋 Funcionalidades principales

- Registro de usuarios con rol (usuario o administrador)
- Login con JWT
- Dashboard dinámico según rol
- Solicitud de certificados
- Descarga de certificados PDF (cuando están emitidos)

---
