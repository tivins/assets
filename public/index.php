<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Components;
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

$user = (object)[
    'name'=>Fake::name(),
];

$page = new Page('Home', Size::LG);
$header = $page->getHeaderBar();
$header->setUsername($user->name);
$header->setSearchShown(false);
$header->setUserNameShown(true);
$header->setUserIsLogged(true);
$header->getConfigList()
    ->push(
        $header->getThemeItem(),
        new ListItem('Cookies','Manage your cookies','/?cookies','fa fa-cookie'),
        new ListItem('test','test','#','fa fa-check'),
    );

if (isset($_GET['cookies'])) {
    $page->setContent(Components::div('cookie-list', ''));
}
else {
    $page->setContent("<p>Hi, {$user->name}.</p>".Fake::paragraph());
}


echo $page;