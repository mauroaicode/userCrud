<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre mi prueba

Desarrollé una API CRUD básica con Laravel, siguiendo buenas prácticas de programación y aplicando los principios SOLID (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion). Utilicé el patrón de repositorio para separar la lógica de acceso a datos de la lógica de negocio, y empleé inyección e inversión de dependencias para facilitar la modularidad y la reutilización del código.

Implementé scopes para definir consultas predefinidas en los modelos, lo que mejoró la legibilidad del código y la eficiencia de las consultas. Además, utilicé interfaces para desacoplar componentes y hacer que el código sea más flexible y mantenible.

Para la autenticación de usuarios, utilicé Laravel Passport, una biblioteca que proporciona una solución completa de autenticación API OAuth2. Esto aseguró la seguridad de la API y permitió la implementación de autenticación basada en tokens.

La API está documentada con Swagger, proporcionando una referencia clara de los endpoints disponibles, los parámetros aceptados y las respuestas esperadas. Esto facilita su consumo por parte de otros desarrolladores.

Para garantizar la calidad del código, escribí pruebas automatizadas utilizando PHPUnit, cubriendo tanto pruebas unitarias como de integración. Utilicé la herramienta de cobertura de código para medir la eficacia de las pruebas y asegurarme de que todo el código estuviera correctamente probado.

Puede ver el [frontend hecho Vue con Nuxt](https://github.com/mauroaicode/userCrudFrontNuxtVuetify))

Puede ver la API en swagger [http://127.0.0.1:8000/api/V1/documentation](http://127.0.0.1:8000/api/V1/documentation)

## Iniciar

```bash
# Instalar dependencias
$ composer install

# Llave única de la aplicación
$ php artisan key:generate

# Generar Client ID y Client Secret
$ php artisan passport:install (yes a todo)

# generar datos semilla
$ php artisan migrate:fresh --seed

# Puedes probar la api usando Postman
$ php artisan serve

```
