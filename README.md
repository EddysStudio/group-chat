# Group chat for Laravel width Filament 

This package is an anonymous group chat for your website. Multiple users who know the chat URL (by default, `yoursite.com/ourchat`) can exchange messages on the chat page. The site administrator can view these users and their messages via the Filament admin panel, where an "Our chat" group will appear in the sidebar. 
Both users and their messages are stored in the database. It is assumed that the users and the administrator are known to one another; a cookie is stored on the user's device to identify them, and the administrator can assign a name to the user within the database.

## Requirements

- PHP 8.2 or higher
- Laravel 12
- Filament 4.x


## Installation

1. Add the following to the `repositories` section of your project's `composer.json`:

```json
"repositories": [

    {
        "type": "vcs",
        "url": "https://github.com/EddysStudio/group-chat"
    }
]
```

Add the following to the `require` section of your project's `composer.json`:

``json
"require":
    {

        "eddysstudio/group-chat": "^0.9"
    }
```

2. Run the following composer commands in your project directory: 
```bash
    composer update eddysstudio/group-chat
    composer dump-autoload
```

3. Run the following artisan commands in your project directory:
```bash
    php artisan vendor:publish --tag=group-chat-assets --force
    php artisan migrate
```

4. Finally, register the plugin in your Filament panel provider (usually /app/Providers/Filament/AdminPanelProvider.php) :
```php
    ->plugin(new \EddysStudio\GroupChat\GroupChat())
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
