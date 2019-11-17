<?php

use Laralabs\Menu\MenuPresenter;
use Laralabs\Menu\Facades\Menu;
use Laralabs\Menu\Exceptions\MenuPresenterFormatterNotFound;

if (!function_exists('get_menu')) {
    function get_menu(string $format, ?string $name = null)
    {
        if ($format === MenuPresenter::TO_ARRAY) {
            return Menu::toArray($name);
        }

        if ($format === MenuPresenter::TO_COLLECTION) {
            return Menu::toCollection($name);
        }

        if ($format === MenuPresenter::TO_JSON) {
            return Menu::toJson($name);
        }

        if ($format === MenuPresenter::TO_BOOTSTRAP) {
            return Menu::toBootstrap($name);
        }

        throw new MenuPresenterFormatterNotFound('The format: ' . $format . ' is not a valid presenter format');
    }
}
