<h1 align="center">FlyVans</h1>

<p align="center">
  Plataforma de gestión de anuncios y reservas de furgonetas
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red">
  <img src="https://img.shields.io/badge/PHP-8.x-blue">
  <img src="https://img.shields.io/badge/status-en%20desarrollo-yellow">
  <img src="https://img.shields.io/badge/license-educational-lightgrey">
</p>

## Descripción

FlyVans es una aplicación web desarrollada con Laravel que permite a los usuarios publicar anuncios de furgonetas y gestionar reservas de forma sencilla.

Incluye sistema de autenticación, gestión de anuncios y reservas, así como tareas automáticas para mantener el sistema actualizado.

---

## Tecnologías utilizadas

- Laravel (PHP)
- MySQL
- HTML, CSS, JavaScript
- Blade
- Composer
- Node.js y npm

---

## Requisitos

Para ejecutar el proyecto en local necesitas:

- XAMPP
- PHP >= 8.x
- Composer
- Node.js y npm
- Git

---

## Instalación y ejecución en local

### 1. Clonar el repositorio

```bash
git clone https://github.com/antoniocubero/FlyVans.git
cd .\flyvans\
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Crear archivo de entorno

```bash
cp .env.example .env
```

### 5. Configurar la base de datos

1. Crear una base de datos en phpMyAdmin (por ejemplo: flyvans)
2. Editar el archivo .env:

```bash
DB_DATABASE=flyvans
DB_USERNAME=root
DB_PASSWORD=
```

_(La contraseña depende de tu configuración de XAMPP)_

### 6. Generar clave de la aplicación

```bash
php artisan key:generate
```

### 7. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creara las tablas en la base de datos e introducira datos de ejemplo para poder trabajar, si quieres el modelo limpio sin ningun dato tienes que hacer:

```bash
php artisan migrate
```

### 8. Ejecutar node en modo desarrollo

```bash
npm run dev
```

### 9. Iniciar el servidor

```bash
php artisan serve
```

### 10. Acceder a la aplicación en local

Abrir en el navegador

```bash
http://127.0.0.1:8000
```

Y veremos nuestra aplicacion ejecutandose
