<p align="center">
    <img src="https://assets.laralabs.uk/packages/menu/menu_logo.png" height="92px" width="408px" />
</p>
<p align="center">
<a href="https://packagist.org/packages/laralabs/menu"><img src="https://poser.pugx.org/laralabs/menu/version" alt="Stable Build" /></a>
<a href="https://travis-ci.org/Laralabs/menu"><img src="https://travis-ci.org/Laralabs/menu.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/222321899"><img src="https://styleci.io/repos/222321899/shield?branch=master" alt="StyleCI"></a>
<a href="https://codeclimate.com/github/Laralabs/menu/maintainability"><img src="https://api.codeclimate.com/v1/badges/9199f640a72bc35c1b10/maintainability" /></a>
<a href="https://codeclimate.com/github/Laralabs/menu/test_coverage"><img src="https://api.codeclimate.com/v1/badges/9199f640a72bc35c1b10/test_coverage" /></a>
</p>

## Laralabs Menu

Simple, extendable menu package for Laravel. 

You define how it renders, the package just gives you the data to do it with.
* Attach to a blade file via a view composer.
* Pass data into a Vue component, or do whatever you want with it!

## :rocket: Quick Start

### Installation
Require the package in the `composer.json` of your project.
```
composer require laralabs/menu
```
Publish the configuration file.
```
php artisan vendor:publish --tag=laralabs-menu-config
```

Not much in the configuration file at the moment, but you can choose to register your menus in here if you wish.

### Usage

Add the `ResolveMenus` middleware to your `app/Http/Kernel.php` in the `$middleware` array:
```
    protected $middleware = [
        // Existing Middleware
        \Laralabs\Menu\Middleware\ResolveMenus::class,
    ];
```

Currently there are no make commands, but there are example menus found in the `tests/Fakes` directory.

Build a class that extends `Laralabs\Menu\Contracts\Menu` and implement the required methods.

Extenders can be built by creating a class that extends implements `Laralabs\Menu\Contracts\MenuExtender`, edit the menu and then return then return it out of the handle method with the closure `$next($menu)`.

Quick example of creating a menu in the `build()` method:
```
    public function build(): void
    {
        $this->menu->group('groupOne', static function (Group $group) {
            $group->item('Group One, Item One', function (Item $item) {
                $item->subItem('Sub Item');
            });
        });
    }
```

## :orange_book: Documentation
Documentation TBC, take a look at the tests :)

## :speech_balloon: Support
Please raise an issue on GitHub if there is a problem.

## :key: License
This is open-sourced software licensed under the [MIT License](http://opensource.org/licenses/MIT).

## :pray: Credits
Adapted from [Maatwebsite/Laravel-Sidebar](https://github.com/Maatwebsite/Laravel-Sidebar) for my own requirements, thank you to everyone at Maatwebsite for the work they do. Also, theirs might have a feature mine doesn't so go check it out too!
