# NIKLA Framework

Small framework for simple PHP projects.

## Installation

Use Composer to install.
```
composer require nikla/nikla-framework
```

## Dependencies
* PHP 7.2+
* Slim Framework [http://www.slimframework.com/](http://www.slimframework.com/)

## Usage

```php
use nikla\NIKLA;
$NIKLA = new \nikla\NIKLA();
$NIKLA->setConfig([
    'sql_password' => YOUR_PASSWORD,
    'sql_username' => YOUR_USERNAME,
    'sql_database' => YOUR_DATABASE,
    'sql_server'   => YOUR_SERVER,
    // More config details coming
]);

// Get SQL object
$NIKLA->SQL();


// More usage coming eventually. Still mostly a generic placeholder readme.
```

## Future Feature Ideas
* Simple routing wrapping Slim Framework
* Simpler functions for SQL object (getArray, getValue, getTable, etc) which simply returns what you actually want.
* Setup CORS via config
* Send quick & simple emails -- ex: $NIKLA->sendEmail(MESSAGE_HTML)