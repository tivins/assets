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
Assets::compile(__dir__);

$layout = (new Page('Home', Size::LG))
    ->setContent('world');

echo $layout;