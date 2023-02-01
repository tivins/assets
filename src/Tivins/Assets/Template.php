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
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/all.css">'
    /*
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/layout.css">
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/highlight.css">
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/markdown.css">
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/css/over.css">
    */
    .'
    <link type="text/css" rel="stylesheet" href="' . $basePath . '/fonts/fontawesome6/css/all.min.css">
    <script type="module" src="' . $basePath . '/js/default.js"></script>
  </head>
  <body class="' . $theme . '">' . $content . '</body>
</html>';
    }
}