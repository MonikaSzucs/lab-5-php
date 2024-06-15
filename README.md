# Posts Web App

### Setup

For this example application, a database must be created and the connection info added to a `.env` file.

### Install dependencies

```
$ composer install
```

### Running tests

```
$ vendor/bin/phpunit
```

### Running the application

You can run the application using the built-in PHP web server, specifying the document root as the `src` directory:

```
$ php -S localhost:7777 -t src/Views
```

Alternatively, you can run it using Apache or Nginx.

## install
phpunit
https://phpunit.de/documentation.html
https://docs.phpunit.de/en/11.2/installation.html#installing-phpunit-with-composer
composer require --dev phpunit/phpunit

once you install it
to run tests you do
vendor/bin/phpunit

## PHP dotenv can install wtih composer
composer require vlucas/phpdotenv

## see ENV in debug console
`$_ENV write it in terminal to see the env stuff`

## Create a new repository
- for this lab 5 must be on its own repo in order to run the pipeline

Where does composer search for its packages?
packagist

When is the functionally spl_autoload_register called?
whenever php encounters a class it doesn't know about. No need for require statements. so it wont know what the classes . It will invoke the callback that is invoked

What is semantic versioning?
Major - breaking API change - when a client upgrades then they will have to modify some of the code
Minor - 
Patch

How can we check for secuirty bunerabilit yin 3rd party packages?
audit command

If a package we're using has  security vulnerability what should we do?
- update it

Why should the composer.lock file be used, what does it do?
- it garuntees that dependencies installed with it - all developers will have the same verions of dependencies  - will get back vendor folder back