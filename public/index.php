<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Fake;
use Tivins\Assets\ListItem;
use Tivins\Assets\Size;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Website;

require '../vendor/autoload.php';

Website::setTitle('Asset Test');
Website::setRootURL('/');
Website::setIcon(new Icon('lemon', true));
Assets::compile(__dir__);

$page = new Page('Home', Size::LG);
$header = $page->getHeaderBar();
$header->setUsername(Fake::name());
$header->setSearchShown(false);
$header->setUserNameShown(false);
$header->getConfigList()
    ->push(
        $header->getThemeItem(),
        new ListItem('test','yo','#','fa fa-check'),
    );
$page->setContent(Fake::paragraph());

echo $page;