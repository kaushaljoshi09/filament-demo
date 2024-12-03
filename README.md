<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>





## About Filament Demo Documentation

1. Run `composer install`.
2. Run `php artisan migrate` and `php artisan db:seed` to migrate and seed your database.
3. Run `php artisan serve` to run the project.
4. To use the activiy in other project then just copy this trait : `app/Trait/ActivityLogger.php` and model : `app/Models/Activity.php`
5. Update the particular model to use the trait as provided into this model `app/Models/Post.php` in this function `logActivity`.
6. To create new activity please refer this example `app/Filament/Resources/PostResource/Pages/CreatePost.php` this function `afterCreate`
7. Admin Credentials : `email` : `admin@example.com` and `password` : `password`.
8. User Credentials : `email` :     `john@example.com` and `password` : `password`.
