# 🚀 Servi-Go (Huila • Yaguará & Pueblos)

> Vitrina comercial, directorio georreferenciado, catálogo de productos y sistema de cotizaciones/chat en tiempo real para comercios y prestadores de servicios en Yaguará, Huila.

---

## 🌟 Características Principales

- **🎨 Interfaz Servi-Go Dark Mode:** Diseño oscuro elegante (`#111315`, `#1c1f24`, `#ff5c00`, `#00b37e`) 100% responsivo con Bootstrap 5 y CSS personalizado.
- **🔍 Buscador en Tiempo Real (AJAX):** Búsqueda instantánea de productos y comercios por texto, categorías y filtro de *Solo Verificados*.
- **🗺️ Mapa Interactivo (Leaflet / OpenStreetMap):** Exploración visual de negocios georreferenciados por barrios (Centro, Malecón Betania, Las Ferias, Barrio Upar, El Triunfo).
- **💬 Chat Nativo con Protección Servi-Go:** Mensajería bidireccional entre clientes y proveedores.
- **🤝 Cierre de Tratos (Deals) & Cotizaciones:** Propuestas formales de servicio dentro del chat con cálculo automático de comisión de plataforma (5%).
- **📊 Dashboard del Proveedor con Métricas GMV:**
  - Control de Tratos Cerrados y Ventas Totales (GMV).
  - Comisiones deducidas.
  - Tasa de Respuesta y tiempo promedio (~4 min).
  - Generador de Códigos QR para mostradores físicos.
  - Gestor CRUD de Catálogo / Menú.
- **🛡️ Panel de Moderación y Auditoría Admin:** Aprobación y rechazo de solicitudes de registro de comercios y asignación del sello de verificación verde.

---

## 🛠️ Stack Tecnológico

- **Backend:** PHP 8+ (Arquitectura MVC sin dependencias pesadas, PDO seguro con prepared statements).
- **Base de Datos:** MySQL / MariaDB (InnoDB con claves foráneas e integridad referencial).
- **Frontend:** HTML5 semántico, JavaScript Vanilla (AJAX Fetch API), Bootstrap 5.3, Leaflet.js, FontAwesome 6.
- **Servidor:** Laragon / Apache.

---

## 📂 Estructura del Proyecto

```plaintext
directorio_digital_Yaguara/
├── config/
│   ├── config.php            # Configuración general y constantes
│   └── database.php          # Conexión PDO a MySQL
├── controllers/
│   ├── HomeController.php    # Catálogo público y mapa
│   ├── AutenticacionController.php # Login, Registro y Logout
│   ├── NegocioController.php # Fichas de negocio y búsqueda AJAX
│   ├── ProductoController.php# CRUD de productos y catálogo
│   ├── ChatController.php    # Chat bidireccional y tratos
│   ├── UsuarioController.php # Perfil, favoritos y panel de negocios
│   └── AdminController.php   # Aprobaciones, rechazos y métricas
├── models/
│   ├── Usuario.php
│   ├── Negocio.php
│   ├── Producto.php
│   ├── MensajeChat.php
│   ├── Trato.php
│   ├── Categoria.php
│   └── Sector.php
├── views/
│   ├── auth/                 # Vistas de Login y Registro (Split 2-column)
│   ├── home/                 # Página principal con catálogo y mapa
│   ├── negocios/             # Fichas de detalle y catálogo
│   ├── chat/                 # Conversación segura e Inbox
│   ├── usuario/              # Dashboard de cliente y proveedor
│   ├── admin/                # Dashboard de administración
│   ├── components/           # Navbar, Footer y Tarjetas
│   └── layouts/              # Header y Footer globales
├── public/
│   └── assets/
│       ├── css/directorio.css# Sistema de diseño Servi-Go
│       └── js/               # scripts de búsqueda y mapas
└── scripts/                  # Migraciones y seeders de base de datos
```

---

## 🔑 Credenciales de Acceso por Defecto

- **Administrador:**
  - **Correo:** `admin@directorio.com`
  - **Contraseña:** `12345678`
  - **URL:** `http://localhost/directorio_digital_Yaguara/index.php?url=autenticacion/login`

---

## 🚀 Instalación y Puesta en Marcha

1. Clonar el repositorio en la carpeta `www` o `htdocs` de tu servidor local (ej. `C:/laragon/www/directorio_digital_Yaguara`).
2. Importar o ejecutar los scripts de migración de base de datos:
   ```bash
   php scripts/migrate_fase1.php
   php scripts/migrate_chat_tratos.php
   php scripts/seed_mockup_data.php
   php scripts/set_single_admin.php
   ```
3. Acceder desde el navegador a `http://localhost/directorio_digital_Yaguara/`.

---

## 📄 Licencia

Desarrollado para la comunidad de Yaguará, Huila • Servi-Go © 2026. Todos los derechos reservados.
