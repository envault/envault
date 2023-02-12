<p align="center">
    <a href="https://github.com/envault/envault"><img src="https://user-images.githubusercontent.com/41773797/103277136-3cf26880-49c0-11eb-8e8d-a8feec4f27a2.png" alt="Envault banner" style="width: 100%; max-width: 800px;" /></a>
</p>

<h1 align="center">Envault</h1>

<p align="center">
    <a href="https://github.com/envault/envault/actions"><img alt="Tests passing" src="https://img.shields.io/badge/Tests-passing-green?style=for-the-badge&logo=github"></a>
    <a href="https://laravel.com"><img alt="Laravel v8.x" src="https://img.shields.io/badge/Laravel-v8.x-FF2D20?style=for-the-badge&logo=laravel"></a>
    <a href="https://laravel-livewire.com"><img alt="Livewire v2.x" src="https://img.shields.io/badge/Livewire-v2.x-FB70A9?style=for-the-badge"></a>
    <a href="https://php.net"><img alt="PHP 8" src="https://img.shields.io/badge/PHP-8-777BB4?style=for-the-badge&logo=php"></a>
</p>

[Envault](https://github.com/envault/envault) is a tool to share .env secrets.

It lets you manage and sync your entire team’s local .env files, across all your projects, so you’re all kept up to date with the latest changes.

Simply install Envault onto your own web server and you're ready to sync all your projects. 🚀

[**Interested? Click here to watch a demo of the app.**](https://vimeo.com/414894566)

## Requirements

- PHP 7.4 or higher
- HTTP server with PHP support (e.g.: Apache, Nginx, Caddy)
- [Composer](https://getcomposer.org)
- [A database](https://laravel.com/docs/master/database#introduction)
- [A mail provider](https://laravel.com/docs/master/mail#introduction)

## Setup

Envault is built on [the Laravel PHP framework](https://laravel.com). This makes installation very simple.

1) Clone this repository onto your server and run `composer update`
2) Copy the `.env.example` to `.env`.
3) Generate a new `APP_KEY` in your `.env` by running `php artisan key:generate` in the terminal.
4) Ensure that the `APP_URL` in `.env` matches the address of your Envault server.
3) Create a new database. For more details on the databases supported, please refer to [the Laravel documentation](https://laravel.com/docs/master/database#introduction). Fill out any appropriate connection details in your `.env` file.
4) Run `php artisan migrate` to prepare your database.
4) Configure outgoing mail from your Envault server. For more details on the mail drivers supported, please refer to [the Laravel documentation](https://laravel.com/docs/master/mail#introduction). Fill out any appropriate connection details in your `.env` file.
5) Set up a scheduled task to run `php artisan schedule:run` every minute. For more details, please refer to [the Laravel documentation](https://laravel.com/docs/master/scheduling#introduction).
6) Visit your Envault server URL and setup your owner account.

We also have installation guides for specific platforms like [Laravel Forge](https://vimeo.com/414958726) and [Laravel Vapor](https://github.com/envault/envault/wiki/Installing-Envault-on-Laravel-Vapor).

## Update Guide

After you update Envault from this repository, please run the following commands on your server. If you're using a platform like Laravel Forge, these can be added to your deploy script:

```
composer install
php artisan migrate
php artisan view:cache
php artisan queue:restart
```

## Documentation

### The Basics
- [Introduction](https://vimeo.com/414894566)
- [Creating a new app](https://github.com/envault/envault/wiki/Creating-an-app)
- [Creating a new variable](https://github.com/envault/envault/wiki/Creating-a-new-variable)
- [Syncing to your local .env](https://github.com/envault/envault/wiki/Syncing-to-your-local-.env)
- [Update a variable](https://github.com/envault/envault/wiki/Update-a-variable)

### Diving Deeper
- [Importing variables from .env format](https://github.com/envault/envault/wiki/Importing-variables-from-.env-format)
- [Rolling back a variable to a previous version](https://github.com/envault/envault/wiki/Rolling-back-a-variable-to-a-previous-version)
- [Managing Slack notifications](https://github.com/envault/envault/wiki/Managing-Slack-notifications)
- [Update an app](https://github.com/envault/envault/wiki/Update-an-app)

### Users and Permissions
- [Creating a new user](https://github.com/envault/envault/wiki/Creating-a-new-user)
- [Managing a user's permissions](https://github.com/envault/envault/wiki/Managing-a-user's-permissions)
- [Managing an app's collaborators](https://github.com/envault/envault/wiki/Managing-an-app's-collaborators)
- [Updating a user's details](https://github.com/envault/envault/wiki/Updating-a-user's-details)

## Roadmap

- [Multiple environments per app.](https://github.com/envault/envault/discussions/23)
- [Webooks.](https://github.com/envault/envault/discussions/17)
- [Granular user permissions system.](https://github.com/envault/envault/discussions/15)
- Bidirectional syncing.
- [Docker image.](https://github.com/envault/envault/discussions/1)

## Need Help?

🐞 If you spot a bug with Envault, please [submit a detailed issue](https://github.com/envault/envault/issues/new), and wait for assistance.

🤔 If you have a question or feature request, please [start a new discussion](https://github.com/envault/envault/discussions/new).

🔐 If you discover a vulnerability within Envault, please review our [security policy](https://github.com/envault/envault/blob/main/SECURITY.md).
