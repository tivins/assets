<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Fake;
use Tivins\Assets\FieldButtons;
use Tivins\Assets\FieldInput;
use Tivins\Assets\ListItem;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
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
        Components::getCookieListItem('/?cookies'),
        new ListItem('test','test','#','fa fa-check'),
    );

if (isset($_GET['cookies'])) {
    $page->setContent(Components::div('cookie-list', ''));
}
else {

    if (!empty($_POST)) {
        var_dump($_POST);die;
    }

    $form = new \Tivins\Assets\Form();
    $form->addField(
        (new FieldInput('text'))
            ->setName('email')
            ->setLabel('Email')
            ->setPlaceholder('Type your email address')
            ->setRequired()
    );
    $form->addField(
        (new FieldInput('password'))
            ->setName('password')
            ->setLabel('Password')
            ->setLabelButton(Button::newLink()->setUrl('#')->setClasses('p-2 pr-0 fs-80')->setLabel(new Str('forgot password?')))
            ->setPlaceholder('Password')
            ->setRequired()
    );
    $form->addField(
        (new \Tivins\Assets\FieldTextArea())
            ->setName('text')
            ->setLabel('Text')
            ->setPlaceholder('What ever you want to write.')
            ->setRequired()
    );
    $form->addField(
        (new \Tivins\Assets\FieldSelect())
            ->setName('select_value')
            ->setLabel('Select option')
            ->setPlaceholder('Select Placeholder.')
            ->setOptions([
                'val1' => new ListItem('Label 1'),
                'val2' => new ListItem('Label 2',icon: 'fa fa-check'),
            ])
            ->setRequired()
    );
    $form->addField(
        (new FieldButtons())
            ->addButton(
                Button::new()
                    ->addClasses('success', 'w-100')
                    ->setLabel(new Str('Sign in'))
            )
    );

    $lay = new \Tivins\Assets\MicroLayout([6,6]);
    $lay->setColumnContent(0, '');
    $lay->setColumnContent(1, $form);
    $page->setContent("<p>Hi, {$user->name}.</p>".Fake::paragraph().$lay);
}


echo $page;