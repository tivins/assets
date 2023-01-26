<?php
namespace Tivins\Assets;

class Template
{
    public static function container(string $content, string $size = 'lg'): string {
        return '<div class="container-lg px-3 my-5">'.$content.'</div>';
    }
    public static function tpl(
        string $title,
        string $content,
        bool $local,
    ): string
    {
        $basePath = $local
            ? ''
            : 'https://tivins.github.io';
        return '<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="'.$basePath.'/assets/layout.css">
    <link type="text/css" rel="stylesheet" href="'.$basePath.'/assets/over.css">
    <link href="'.$basePath.'/assets/fontawesome6/css/all.min.css" rel="stylesheet">
    <script type="module" src="'.$basePath.'/assets/main.js"></script>
  </head>
  <body>
    '.$content.'
  </body>
</html>';
    }
}