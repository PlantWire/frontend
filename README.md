# pWire Frontend
[![pipeline status](https://gitlab.dev.ifs.hsr.ch/epj/2020/pwire/pwire-frontend/badges/master/pipeline.svg)](https://gitlab.dev.ifs.hsr.ch/epj/2020/pwire/pwire-frontend/-/commits/master)
[![coverage report](https://gitlab.dev.ifs.hsr.ch/epj/2020/pwire/pwire-frontend/badges/master/coverage.svg)](https://gitlab.dev.ifs.hsr.ch/epj/2020/pwire/pwire-frontend/-/commits/master)

## Installation
Requires a working valet or homestead environment

```bash
  npm install -g laravel-echo-server
  composer install
  npm install
  cp .env.example .env
  vi .env 
  # Edit .env to your liking
  php artisan key:generate
  php artisan migrate
  npm run watch
```

## After each pull
```bash
  composer install
  npm install
  php artisan migrate
  laravel-echo-server start
  npm run watch
```

## After modifying the Dockerfile
Requires a valid docker login session with the gitlab registry

```bash
docker build -t gitlab.dev.ifs.hsr.ch:45023/epj/2020/pwire/pwire-frontend .
docker push gitlab.dev.ifs.hsr.ch:45023/epj/2020/pwire/pwire-frontend
```

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

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
The pWire Frontend is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
