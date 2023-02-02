<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Icon;

class Website
{
    private static string $title = 'MyWebSite';
    private static Icon $icon;
    private static string $rootURL = '';

    public static function setIcon(Icon $icon): void
    {
        self::$icon = $icon;
    }

    public static function getIcon(): Icon
    {
        return self::$icon;
    }

    public static function getTitle(): string
    {
        return self::$title;
    }

    public static function setTitle(string $title): void
    {
        self::$title = $title;
    }

    public static function getRootURL(): string
    {
        return self::$rootURL;
    }

    public static function setRootURL(string $rootURL): void
    {
        self::$rootURL = rtrim($rootURL, '/');
    }

    public static function getLink(string $path = '/'): string {
        return self::$rootURL . $path;
    }


}