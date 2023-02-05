<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Size;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Website;

require '../vendor/autoload.php';

Website::setTitle('Asset Test');
Website::setRootURL('/');
Website::setIcon(new Icon('lemon', true));
Assets::buildCSS(__dir__.'/assets/css/all.css');
Assets::buildJS(__dir__.'/assets/js');

$layout = (new Page('Home', Size::LG))
    ->setContent('world');

echo $layout;