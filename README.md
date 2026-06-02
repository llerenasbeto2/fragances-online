#  Fragances Online

Tienda en línea especializada en perfumes y fragancias, desarrollada como proyecto de periodo de prueba para **Turing - Inteligencia Artificial**.

🔗 **Demo en vivo:** [fragances-online-production.up.railway.app](https://fragances-online-production.up.railway.app/)  
📁 **Repositorio:** [github.com/llerenasbeto2/fragances-online](https://github.com/llerenasbeto2/fragances-online)  
📖 **Documentación técnica (DeepWiki):** disponible en el repositorio

---

## 📋 Descripción

Fragances Online permite a los visitantes explorar un catálogo de perfumes con filtrado por marcas y colecciones. Cuenta con un sistema de autenticación basado en JWT y un control de roles diferenciado:

- **Administrador:** acceso completo al panel de gestión (CRUD de fragancias, marcas y colecciones).
- **Usuario:** vista del catálogo y panel personal.

---

## 🛠️ Stack Tecnológico

| Tecnología | Descripción |
|---|---|
| **Laravel 13** | Framework PHP — rutas, controladores, modelos, migraciones y API REST |
| **Vue.js 3** | Framework JavaScript reactivo para la interfaz (SPA) |
| **Inertia.js** | Puente entre Laravel y Vue; navegación SPA sin API REST separada para vistas |
| **MySQL** | Motor de base de datos relacional, gestionado en contenedor Docker |
| **Laravel Sail** | Wrapper de Docker CLI para levantar el entorno con un solo comando |
| **JWT (tymon/jwt-auth)** | Autenticación stateless con JSON Web Tokens |
| **Tailwind CSS** | Framework CSS utility-first |
| **Vite** | Bundler moderno para compilar assets de frontend |

---

## ⚙️ Requisitos Previos

> Todos los comandos deben ejecutarse dentro del entorno de **Ubuntu en WSL 2**.

| Herramienta | Versión Mínima | Propósito |
|---|---|---|
| WSL 2 + Ubuntu | 24.04 LTS | Entorno Linux en Windows |
| Docker Desktop | 4+ | Gestión de contenedores (MySQL, Redis, etc.) |
| Node.js / npm | 18+ | Compilación de assets Vue/Tailwind con Vite |
| PHP | 8.5 | Runtime de Laravel (gestionado por Sail/Docker) |

---

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio

```bash
git clone https://github.com/llerenasbeto2/fragances-online.git
cd fragances-online
```

### 2. Instalar dependencias de Composer

```bash
curl -s https://laravel.build/fragances-online | bash
```

### 3. Levantar los contenedores Docker

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
sail up -d
```

Sail levanta los siguientes servicios: `laravel.test`, `MySQL`, `Redis`, `Mailpit`, `Meilisearch` y `Selenium`.

### 4. Configurar variables de entorno

```bash
cp .env.example .env
```

Ajusta los valores de conexión a la base de datos en `.env` si es necesario.

### 5. Generar la clave de la aplicación y el secret de JWT

```bash
sail artisan key:generate
sail artisan jwt:secret
```

### 6. Ejecutar migraciones

```bash
sail artisan migrate:fresh
```

### 7. Crear usuarios de prueba

```bash
sail tinker
```

Dentro de Tinker:

```php
App\Models\User::factory()->create(['email' => 'admin@prueba.com', 'role' => 'admin']);
App\Models\User::factory()->create(['email' => 'user@prueba.com', 'role' => 'user']);
```

### 8. Instalar dependencias de frontend y compilar

```bash
npm install && npm run dev
```


## 🗂️ Estructura de Base de Datos

El proyecto cuenta con las siguientes tablas principales:

- **users** — Usuarios con campo `role` (enum: `admin` / `user`)
- **brands** — Marcas de perfumes (`name`, `country`, `logo_url`)
- **collections** — Colecciones de fragancias (`nombre`, `descripcion`)
- **fragrances** — Catálogo de productos, relacionado con `brands` y `collections` (`name`, `description`, `price`, `image_url`, `stock`, `concentration`)

---

## 🔐 Autenticación con JWT

La autenticación utiliza la librería `tymon/jwt-auth`. El flujo es:

1. El cliente envía `email` y `password` al endpoint `POST /api/auth/login`.
2. El servidor valida las credenciales y devuelve un **token JWT** junto con los datos del usuario (id, nombre, email, rol).
3. El token se almacena en `localStorage` y se envía en el header `Authorization: Bearer <token>` en cada petición protegida.
4. Para cerrar sesión, se llama a `POST /api/auth/logout` con el token, que lo invalida en el servidor.

---

## 🛣️ Endpoints de la API

### Autenticación

| Método | Endpoint | Descripción | Auth |
|---|---|---|---|
| POST | `/api/auth/login` | Iniciar sesión | No |
| POST | `/api/auth/logout` | Cerrar sesión | Bearer Token |

### Fragancias

| Método | Endpoint | Descripción | Auth |
|---|---|---|---|
| GET | `/api/fragrances` | Listar todas | No |
| GET | `/api/fragrances/{id}` | Ver una | No |
| POST | `/api/fragrances` | Crear | Admin |
| PUT | `/api/fragrances/{id}` | Actualizar | Admin |
| DELETE | `/api/fragrances/{id}` | Eliminar | Admin |

### Marcas y Colecciones

Misma estructura CRUD que Fragancias, bajo `/api/brands` y `/api/collections`.

---

## 🧭 Cómo Navegar el Proyecto

### Página Principal (`/`)
Pública, sin autenticación requerida. Muestra el catálogo de fragancias, colecciones y marcas cargados desde la API. Incluye switch de **modo oscuro / claro** cuya preferencia se persiste en el navegador.

### Login (`/login`)
Solicita correo y contraseña. Tras autenticarse, redirige automáticamente según el rol:
- `admin` → `/admin/dashboard`
- `user` → `/user/dashboard`

### Panel de Administración (`/admin/dashboard`)
Gestión completa (CRUD) de fragancias, marcas y colecciones. Acceso restringido; sin token de administrador válido el acceso es denegado.

### Panel de Usuario (`/user/dashboard`)
Muestra nombre y correo del usuario autenticado. Acceso restringido al rol `user`.

---

## 🌗 Dark Mode

Implementado con Tailwind CSS en modo `class`. La preferencia del usuario se guarda en `localStorage` y se respeta la configuración del sistema operativo si no hay preferencia guardada. Se activa mediante un toggle en la barra de navegación.

---

## 📁 Estructura de Vistas (Frontend)

```
resources/js/
├── Components/
│   ├── Navbar.vue
│   ├── HeroSection.vue
│   ├── FeaturesSection.vue
│   ├── FragrancesSection.vue
│   ├── CollectionsSection.vue
│   ├── BrandsSection.vue
│   ├── FooterSection.vue
│   └── Darkmode.vue
└── Pages/
    ├── Home.vue
    ├── Auth/
    │   ├── Login.vue
    │   └── Admin/
    │       ├── Dashboard.vue
    │       └── Fragrances/
    │           ├── Index.vue
    │           └── Create.vue
    └── User/
        └── Dashboard.vue
```

---

## 🎨 Paleta de Colores

| Modo | Rol | Hex | Tailwind |
|---|---|---|---|
| Claro | Background | `#FAF3E1` | `bg-amber-50` |
| Claro | Primary | `#222222` | `bg-neutral-800` |
| Claro | Accent | `#ffaf00` | `bg-amber-500` |
| Oscuro | Background | `#222222` | `bg-neutral-800` |
| Oscuro | Primary | `#FAF3E1` | `bg-amber-50` |
| Oscuro | Accent | `#ffaf00` | `bg-amber-500` |

---

## 📚 Referencias y Recursos

- [Laravel Sail — Documentación oficial](https://laravel.com/docs/13.x/sail)
- [JWT Auth para Laravel — tymon/jwt-auth](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)
- [Laravel Controllers — API Resource Routes](https://laravel.com/docs/13.x/controllers#api-resource-routes)
- [Vue.js — Composition API Lifecycle](https://vuejs.org/api/composition-api-lifecycle)
- [Despliegue en Railway](https://www.youtube.com/watch?v=uU7tWbyqKXc)

---

## ✍️ Autor

**Jesus Alberto Llerenas Ramirez**  
Periodo de prueba — Desarrollo de Software  
Turing - Inteligencia Artificial
