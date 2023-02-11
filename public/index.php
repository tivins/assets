<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Box;
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
use Tivins\Assets\Style;
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
$header->getUserMenu()
    ->push(
        $header->getThemeItem(),
    );
$header->getConfigList()
    ->push(
        $header->getThemeItem(),
        Components::getCookieListItem('/?cookies'),
        new ListItem('Buttons','buttons','/?buttons','fa fa-stop'),
        new ListItem('test','test','#','fa fa-check'),
    );

function demoButtons()
{
    return Components::div('p', '<h3>Buttons</h3>'

        . '<h5>Buttons Types</h5>'
        . '<div class="d-flex gutter-sm">'
        . '<div class="col-6 markdown-body"><pre>echo Button::new()-&gt;setLabel(\'Button\');
echo Button::newGhost()-&gt;setLabel(\'Button\');
echo Button::newLink()-&gt;setLabel(\'Button\');</pre></div>'
        . '<div class="col-6">'
        .Button::new()->setLabel('Button')
        .' '.Button::newGhost()->setLabel('Button')
        .' '. Button::newLink()->setLabel('Button').'</div>'
        . '</div>'


        . '<h5>Buttons Styles | see enum Style</h5>'
        . '<div class="d-flex gutter-sm">'
        . '<div class="col-6 markdown-body"><pre>echo Button::new()<br>   -&gt;setLabel(\'Button\')<br>   -&gt;setStyle(Style::Info);</pre></div>'
        . '<div class="col-6">'.Button::new()->setLabel('Button')->setStyle(Style::Info).'</div>'
        . '</div>'

        . '<div class="d-flex gutter-sm">'
        . '<div class="col-6 markdown-body"><pre>'.htmlentities("
echo Button::new()
    ->setLabel('Button')
    ->setStyle(Style::Success)
    ->setIcon(new Icon('check'));").'</pre></div>'
        . '<div class="col-6">'.
            Button::new()
                ->setLabel('Button')
                ->setStyle(Style::Success)
                ->setIcon(new Icon('check'))
        .'</div>'
        . '</div>'

        . (new Box())->setTitleHTML('HTML button')->addBodyClasses('p')->addHTML(''
            . Components::div('my-2', ''
                . Button::new()->setLabel('Default')->addClasses('mr-1')
                . Button::new()->setLabel('Info')->addClasses('mr-1 info')
                . Button::new()->setLabel('Success')->addClasses('mr-1 success')
                . Button::new()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::new()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::new()->setLabel('Disabled')->addClasses('mr-1 disabled')
            )
            . Components::div('my-2', ''
                . Button::newGhost()->setLabel('Default')->addClasses('mr-1')
                . Button::newGhost()->setLabel('Info')->addClasses('mr-1 info')
                . Button::newGhost()->setLabel('Success')->addClasses('mr-1 success')
                . Button::newGhost()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::newGhost()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::newGhost()->setLabel('Disabled')->addClasses('mr-1 disabled')
            )
            . Components::div('my-2', ''
                . Button::newLink()->setLabel('Default')->addClasses('mr-1')
                . Button::newLink()->setLabel('Info')->addClasses('mr-1 info')
                . Button::newLink()->setLabel('Success')->addClasses('mr-1 success')
                . Button::newLink()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::newLink()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::newLink()->setLabel('Disabled')->addClasses('mr-1 disabled')
            )
        )
        . (new Box())->setTitleHTML('HTML Anchor')->addBodyClasses('p')->addHTML(''
            . Components::div('my-2', ''
                . Button::new()->setLabel('Default')->addClasses('button mr-1')->setUrl('#link')
                . Button::new()->setLabel('Info')->addClasses('button mr-1 info')->setUrl('#link')
                . Button::new()->setLabel('Success')->addClasses('button mr-1 success')->setUrl('#link')
                . Button::new()->setLabel('Warning')->addClasses('button mr-1 warning')->setUrl('#link')
                . Button::new()->setLabel('Danger')->addClasses('button mr-1 danger')->setUrl('#link')
                . Button::new()->setLabel('Disabled')->addClasses('button mr-1 disabled')->setUrl('#link')
            )
            . Components::div('my-2', ''
                . Button::newGhost()->setLabel('Default')->addClasses('button mr-1')->setUrl('#link')
                . Button::newGhost()->setLabel('Info')->addClasses('button mr-1 info')->setUrl('#link')
                . Button::newGhost()->setLabel('Success')->addClasses('button mr-1 success')->setUrl('#link')
                . Button::newGhost()->setLabel('Warning')->addClasses('button mr-1 warning')->setUrl('#link')
                . Button::newGhost()->setLabel('Danger')->addClasses('button mr-1 danger')->setUrl('#link')
                . Button::newGhost()->setLabel('Disabled')->addClasses('button mr-1 disabled')->setUrl('#link')
            )
            . Components::div('my-2', ''
                . Button::newLink()->setLabel('Default')->addClasses('mr-1')->setUrl('#link')
                . Button::newLink()->setLabel('Info')->addClasses('mr-1 info')->setUrl('#link')
                . Button::newLink()->setLabel('Success')->addClasses('mr-1 success')->setUrl('#link')
                . Button::newLink()->setLabel('Warning')->addClasses('mr-1 warning')->setUrl('#link')
                . Button::newLink()->setLabel('Danger')->addClasses('mr-1 danger')->setUrl('#link')
                . Button::newLink()->setLabel('Disabled')->addClasses('mr-1 disabled')->setUrl('#link')
            )
        )
        . '<h3>Size</h3>'
        . Components::div('my-2',
            Button::new()->setLabel('Button XS')->addClasses('mr-1 xs')
            . Button::new()->setLabel('Button SM')->addClasses('mr-1 sm')
            . Button::new()->setLabel('Button')->addClasses('mr-1')
            . Button::new()->setLabel('Button LG')->addClasses('mr-1','lg')
            . Button::new()->setLabel('Button XL')->addClasses('mr-1','xl')
            . Button::new()->setLabel('Button XXL')->addClasses('mr-1', 'xxl')
        )
    );
}

if (isset($_GET['buttons'])) {
    $page->setContent(Components::div('', demoButtons()))->setTitle('Buttons');
}
elseif (isset($_GET['cookies'])) {
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
            ->setValue('test')
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
            ->setValue("test <html>")
    );
    $form->addField(
        (new \Tivins\Assets\FieldSelect())
            ->setName('select_value')
            ->setLabel('Select option')
            ->setPlaceholder('Label 1')
            ->setValue('val1')
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