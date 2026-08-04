# Sweet Dreams
### Sistema Web de Gestión de Pedidos para Pastelería

Sistema web dinámico desarrollado con **PHP**, **MySQL** y patrón **MVC** que permite gestionar productos, pedidos y usuarios de una pastelería con roles diferenciados.

---

## Descripción

**Sweet Dreams** es una pastelería local que recibía sus pedidos por WhatsApp y redes sociales, lo que generaba confusiones, pedidos perdidos y demoras. Para solucionar esto, se desarrolló un sistema web donde los clientes pueden ver el catálogo, hacer sus pedidos y dar seguimiento al estado de los mismos, mientras que el personal gestiona la producción y el administrador supervisa todo el negocio.

---

## Tecnologías utilizadas

- **PHP 8.2** — Lógica del servidor
- **MySQL** — Base de datos
- **HTML5 / CSS3 / JavaScript** — Frontend
- **Bootstrap 5** — Framework CSS
- **Bootstrap Icons** — Iconografía
- **Google Fonts** — Tipografía (Playfair Display + Poppins)
- **Patrón MVC** — Organización del código

---

## Roles del sistema

| Rol | Descripción |
|-----|-------------|
| **Admin** | Gestión completa: usuarios, productos y todos los pedidos |
| **Empleado** | Gestión de pedidos asignados y actualización de estados |
| **Cliente** | Ver catálogo, hacer pedidos y seguimiento de los mismos |

---

## Estructura del proyecto

```
sweet-dreams/
├── public/
│   ├── index.php          # Punto de entrada (enrutador)
│   ├── css/
│   └── js/
│       └── validaciones.js
├── app/
│   ├── controllers/
│   │   ├── UsuarioController.php
│   │   ├── ProductoController.php
│   │   └── PedidoController.php
│   ├── models/
│   │   ├── Usuario.php
│   │   ├── Producto.php
│   │   ├── Pedido.php
│   │   └── DetallePedido.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── auth/
│       ├── dashboard/
│       ├── productos/
│       ├── pedidos/
│       └── usuarios/
├── config/
│   ├── database.php           # Credenciales reales (no se sube)
│   └── database.example.php   # Plantilla de credenciales
├── database/
│   └── database.sql           # Estructura de la base de datos
├── .gitignore
└── README.md
```

---

## Requisitos

- PHP 8.0 o superior
- MySQL 5.7 o superior
- XAMPP (para desarrollo local)
- Servidor web Apache

---

## Instalación local

1. **Clona el repositorio**
```bash
git clone https://github.com/tu-usuario/sweet-dreams.git
```

2. **Coloca el proyecto en htdocs**
```
C:\xampp\htdocs\sweet-dreams\
```

3. **Configura la base de datos**
   - Copia `config/database.example.php` y renómbralo a `config/database.php`
   - Rellena tus credenciales de conexión:
```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'sweet_dreams');
define('DB_USER', 'root');
define('DB_PASS', '');
```

4. **Importa la base de datos**
   - Abre MySQL Workbench o phpMyAdmin
   - Ejecuta el archivo `database/database.sql`

5. **Inserta datos de prueba** (opcional)
```sql
INSERT INTO usuarios (nombre, email, password, rol, telefono, direccion, pregunta_seguridad, respuesta_seguridad, estado) VALUES
('Administrador', 'admin@sweetdreams.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '0999999999', 'Oficina Principal', '¿Cual es el nombre de tu primera mascota?', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'activo');
```

6. **Abre en el navegador**
```
http://localhost/sweet-dreams/public/
```

---

## Credenciales de prueba

| Rol | Email | Contraseña |
|-----|-------|-----------|
| Admin | admin@sweetdreams.com | password |
| Empleado | empleado@sweetdreams.com | password |
| Cliente | cliente@sweetdreams.com | password |

---

## Despliegue

El sistema está desplegado en Render:

🔗 **[Link del sistema](#)** ← *(actualizar cuando esté desplegado)*

---

## Funcionalidades

- [x] Registro e inicio de sesión con roles
- [x] Recuperación de cuenta con pregunta de seguridad
- [x] CRUD completo de productos
- [x] CRUD completo de pedidos con detalle
- [x] CRUD completo de usuarios
- [x] Control de acceso por roles (Admin / Empleado / Cliente)
- [x] Cálculo automático de totales
- [x] Control de stock
- [x] Cambio de estado de pedidos
- [x] Asignación de empleados a pedidos
- [x] Validaciones frontend (JS) y backend (PHP)
- [x] Diseño responsive con Bootstrap 5

---

## Desarrollado por

**Edwin** — Proyecto Segundo Parcial  
Desarrollo de Aplicaciones Web — 2026