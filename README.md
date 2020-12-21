# Envault

[Envault](https://envault.dev) is a repository for your credentials. It lets you manage and sync your entire team’s local .env variables, so you’re all kept up to date. Simply install your Envault server and you're ready to sync. 🚀

![Tests status](https://github.com/envault/envault/workflows/tests/badge.svg)

## Installation

The Envault server is built on [the Laravel PHP framework](https://laravel.com). This makes installation very simple. It requires a minimum PHP version of 7.4 and [Composer](https://getcomposer.org) installed.

1) Clone this repository onto your server.
2) Copy .env.example to .env. Generate a new `APP_KEY` using `php artisan key:generate`. Make sure that your `APP_URL` matches the address of your Envault server.
3) Create a new database. For more details on the databases supported, please refer to [the Laravel documentation](https://laravel.com/docs/7.x/database#introduction). Fill out any connection details in your `.env` file, then run `php artisan migrate`.
4) Set up outgoing mail from your Envault server. For more details on the mail drivers supported, please refer to [the Laravel documentation](https://laravel.com/docs/7.x/mail#introduction). Fill out any connection details in your `.env` file.
5) Set up a queue worker. For more details, please refer to [the Laravel documentation](https://laravel.com/docs/7.x/queues#introduction).
6) Set up a scheduled task to run `php artisan schedule:run` every minute. For more details, please refer to [the Laravel documentation](https://laravel.com/docs/7.x/scheduling#introduction).
7) Create your first user account using the `php artisan make:user -o` command. It will be granted owner permissions.
8) Visit your Envault server URL and sign in.

You can find installation guides for specific platforms like [Laravel Forge](https://vimeo.com/414958726) and [Vapor](https://github.com/envault/envault/wiki/Installing-Envault-on-Laravel-Vapor).

## Update guide

After you update Envault from this repository, please run the following commands on your server. If you're using a platform like Laravel Forge, these can be added to your deploy script -

```
composer install
php artisan migrate
php artisan queue:restart
php artisan livewire:discover
php artisan view:clear
```

## Documentation

Please visit the [wiki](https://github.com/envault/envault/wiki).

## Support

If you spot a bug with Envault, please [submit a detailed issue](https://github.com/envault/envault/issues), and a member of our team, or the community, will assist you.

If you discover a security vulnerability within Envault, please email Dan Harrin via [dan@envault.dev](mailto:dan@envault.dev). All security vulnerabilities will be promptly addressed.
