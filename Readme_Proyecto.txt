
🧾 Sistema de Solicitud de Certificados - Laravel + React

Este proyecto es un sistema web para la gestión de solicitudes de certificados (Nacimiento, Matrimonio, Defunción), con roles diferenciados de usuario ciudadano y administrador.

🔗 Repositorio GitHub: https://github.com/yarke19841/docutrank-api

──────────────────────────────────────────────────────────────

🗂️ PLANIFICACIÓN DEL PROYECTO

1. Análisis de requerimientos: Se definieron los roles, flujos, tipos de certificados y etapas del trámite.
2. Diseño de arquitectura: Laravel para el backend de API REST y React como frontend embebido.
3. Desarrollo modular: Registro, login, dashboards diferenciados, flujo de aprobación y generación de certificados en PDF.
4. Pruebas locales.
5. Documentación (este archivo).
6. Despliegue: No realizado, pero preparado para Render.

──────────────────────────────────────────────────────────────

🚀 TECNOLOGÍAS UTILIZADAS

- Laravel (PHP): Backend robusto y modular.
- React.js: Frontend dinámico y desacoplado.
- PostgreSQL: Base de datos relacional.
- DOMPDF: Generación de certificados PDF.
- JWT Auth: Autenticación moderna y segura.

──────────────────────────────────────────────────────────────

🛠️ INSTALACIÓN DE HERRAMIENTAS NECESARIAS (MacOS, Windows, Linux)

1. PHP >= 8.2 y Composer
   - macOS (Homebrew):
     brew install php@8.2
     brew link --overwrite php@8.2 --force
     brew install composer

   - Windows:
     Descargar PHP desde https://windows.php.net/download
     Instalar Composer desde https://getcomposer.org/Composer-Setup.exe

   - Ubuntu/Debian:
     sudo apt install php8.2 php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl php8.2-pgsql unzip curl
     curl -sS https://getcomposer.org/installer | php
     sudo mv composer.phar /usr/local/bin/composer

2. PostgreSQL
   - macOS: brew install postgresql
   - Windows: https://www.postgresql.org/download/windows/
   - Linux: sudo apt install postgresql postgresql-contrib

3. Node.js y npm
   - macOS: brew install node
   - Windows: https://nodejs.org
   - Linux: sudo apt install nodejs npm

4. Git
   - macOS: brew install git
   - Windows: https://git-scm.com/download/win
   - Linux: sudo apt install git

──────────────────────────────────────────────────────────────

📦 INSTALACIÓN Y EJECUCIÓN

1. Clonar el proyecto:
   git clone https://github.com/yarke19841/docutrank-api.git
   cd docutrank-api

2. Backend Laravel:
   cp .env.example .env
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve

   En .env usar:
   APP_URL=http://localhost:8000

3. Frontend React:
   cd resources/frontend
   cp .env.example .env
   npm install
   npm run dev

   En .env del frontend usar:
   VITE_API_URL=http://localhost:8000/api
   VITE_STORAGE_URL=http://localhost:8000/storage

──────────────────────────────────────────────────────────────

👥 USO DEL SISTEMA

- Registro con selección de rol (Usuario o Administrador).
- Dashboard dinámico según rol.
- Usuario: solicitar certificado, ver estado, descargar si es Emitido.
- Admin: aprobar, rechazar, pedir corrección, emitir certificado (PDF).

──────────────────────────────────────────────────────────────

📁 ARCHIVOS IMPORTANTES

- .env.example (backend y frontend)
- routes/api.php
- resources/views/certificates/pdf.blade.php
- database/seeders (si aplica)

──────────────────────────────────────────────────────────────

📝 NOTAS FINALES

- El sistema corre localmente.
- Despliegue en Render no forma parte de esta entrega, pero está preparado.
- Las variables de entorno de producción están comentadas.

──────────────────────────────────────────────────────────────

🧠 AUTORA

Desarrollado por Yarquelis Paz
Rol: Ingeniería en Sistemas y Computación

──────────────────────────────────────────────────────────────

📚 DOCUMENTACIÓN ADICIONAL

Este proyecto incluye dos archivos de ayuda específicos para cada parte del sistema:

- 📘 resources/frontend/README_FRONTEND.txt  
  Explica cómo instalar, configurar y ejecutar el frontend (React) embebido en el proyecto Laravel.

- 📗 README_BACKEND.txt  
  Contiene las instrucciones detalladas para el backend Laravel, incluyendo migraciones, rutas, configuración de JWT, etc.

Ambos archivos son útiles si deseas trabajar solo con una parte del sistema o entenderla en profundidad.
