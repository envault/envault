# Envault

[Envault](https://envault.dev) is a repository for your credentials. It lets you manage and sync your entire team’s local .env variables, so you’re all kept up to date. Simply install your Envault server and you're ready to sync. 🚀

![Tests status](https://github.com/envault/envault/workflows/tests/badge.svg)

## Documentation

### Installation
- [Installing Envault](https://github.com/envault/envault/wiki/Installing-Envault)
- [Installing Envault on Laravel Forge](https://vimeo.com/414958726)
- [Installing Envault on Laravel Vapor](https://github.com/envault/envault/wiki/Installing-Envault-on-Laravel-Vapor)

### The basics
- [Introduction](https://vimeo.com/414894566)
- [Creating a new app](https://github.com/envault/envault/wiki/Creating-an-app)
- [Creating a new variable](https://github.com/envault/envault/wiki/Creating-a-new-variable)
- [Syncing to your local .env](https://github.com/envault/envault/wiki/Syncing-to-your-local-.env)
- [Update a variable](https://github.com/envault/envault/wiki/Update-a-variable)

### Diving deeper
- [Importing variables from .env format](https://github.com/envault/envault/wiki/Importing-variables-from-.env-format)
- [Rolling back a variable to a previous version](https://github.com/envault/envault/wiki/Rolling-back-a-variable-to-a-previous-version)
- [Managing Slack notifications](https://github.com/envault/envault/wiki/Managing-Slack-notifications)
- [Update an app](https://github.com/envault/envault/wiki/Update-an-app)

### Users and permissions
- [Creating a new user](https://github.com/envault/envault/wiki/Creating-a-new-user)
- [Managing a user's permissions](https://github.com/envault/envault/wiki/Managing-a-user's-permissions)
- [Managing an app's collaborators](https://github.com/envault/envault/wiki/Managing-an-app's-collaborators)
- [Updating a user's details](https://github.com/envault/envault/wiki/Updating-a-user's-details)

## Update guide

After you update Envault from this repository, please run the following commands on your server. If you're using a platform like Laravel Forge, these can be added to your deploy script -

```
composer install
php artisan migrate
php artisan queue:restart
php artisan livewire:discover
php artisan view:clear
```

## Support

If you spot a bug with Envault, please [submit a detailed issue](https://github.com/envault/envault/issues), and a member of our team, or the community, will assist you.

If you discover a security vulnerability within Envault, please email Dan Harrin via [dan@envault.dev](mailto:dan@envault.dev). All security vulnerabilities will be promptly addressed.
