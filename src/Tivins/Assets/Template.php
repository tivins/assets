<?php
namespace Tivins\Assets;

class Template
{
    public static function container(string $content, Size $size = Size::LG): string
    {
        return '<div class="' . $size->suffix('container') . ' px-3 my-5">' . $content . '</div>';
    }

    public static function tpl(
        string $title,
        string $content,
        bool   $local,
    ): string
    {
        $theme    = ''; // ($_COOKIE['theme']??"") === 'dark' ? '' : 'dark-theme';
        $basePath = $local
            ? '/assets'
            : 'https://tivins.github.io/assets';
        return '<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>' . $title . ' | ' . Website::getTitle() . '</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/all.css">
    <!--<link type="text/css" rel="stylesheet" href="https://tivins.github.io/assets/fonts/fontawesome6/css/all.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="' . $basePath . '/js/default.js"></script>
  </head>
  <body class="' . $theme . '">' . $content . '</body>
</html>';
    }
}