<p>DeVorbă - aplicație web educativă</p>

# ed-app

Pentru ca aplicația să poată rula este nevoie ca versiunea PHP 8.1+ să fie instalată și configurată.
De asemenea, trebuie instalat și XAMPP.

## Pași pentru a instala și rula aplicația

1. **Clonați repository-ul local folosind comanda:**
   ```bash
   git clone https://github.com/MariaMurarescu/ed-app.git

2. **Navigați în directorul aplicației:**
`cd ed_app`

3. **Instalați dependințele PHP folosind Composer:**
`composer install`

4. **Creează baza de date MySQL**
- Accesați interfața de administrare a MySQL (phpMyAdmin sau linia de comandă)
- Creați o nou bază de date: CREATE DATABASE ed_app;

5. **Copiați env.example în .env și ajustați configurațiile:**
`cp .env.example .env`
Deschideți fișierul .env în editorul preferat și setați detaliile bazei de date.

DB_DATABASE=ed_app
DB_USERNAME=numele_de_utilizator_propriu_mysql
DB_PASSWORD=parola_proprie_mysql

6. **Generați cheia de aplicație Laravel:**
`php artisan migrate`

7. **Rulați migrațiile pentru a crea tabelele necesare în baza de date:**
`php artisan migrate`

8. **Lansați serverul Laravel:**
`php artisan serve`

Aplicația va fi disponibilă la http://localhost:8000.

9. **Navigați în folderul Vue**
`cd vue`

10. **10. Instalați dependințele JavaScript prin rularea în linia de comandă:**
`npm install`

11. **Copiați vue/.env.example în vue/.env și specificați URL-ul API:**
`cp .env.example .env`

Deschideți fișierul vue/.env și setați URL-ul API:
VUE_APP_API_URL=http://localhost:8000

12. **Porniți aplicația pe frontend prin executarea comenzii:**
`npm run dev`

<p>Aplicația frontend va fi disponibilă la http://localhost:5173 sau un alt port definit. </p>




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

**For Vue, please see Readme from inside the vue folder.**
