<?php


use Tivins\Assets\Assets;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Size;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Website;

require '../vendor/autoload.php';
Website::setTitle('Asset Test');
Website::setIcon(new Icon('check'));

Assets::buildCSS(__dir__.'/assets/css/all.css');

$layout = (new Page('Hello', Size::LG))
    ->setContent('world');

echo $layout;