<?php

use PhpParser\ParserFactory;
use Tivins\Assets\Assets;
use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Components\BoxList;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Demo;
use Tivins\Assets\Fake;
use Tivins\Assets\FieldButtons;
use Tivins\Assets\FieldInput;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\ListItem;
use Tivins\Assets\MicroLayout;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Style;
use Tivins\Assets\Website;
use Tivins\Core\StrUtil;

require '../vendor/autoload.php';

Website::setTitle('Asset Test');
Website::setRootURL('/');
Website::setIcon(new Icon('lemon', true));
Assets::compile(__dir__);

$user = (object)[
    'name' => Fake::name(),
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
//
//function beautifyPHP($code):string {
//    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
//    $stmts = $parser->parse($code);
//    $prettyPrinter = new PhpParser\PrettyPrinter\Standard;
//    return $prettyPrinter->prettyPrintFile($stmts);
//}

/**
 * @throws ReflectionException
 */
function demoButtons(): string
{
    return Components::boxMessage(new HTMLStr(StrUtil::markdown("The class `Button` implements `__toString()`")))
        . (new Box())->setTitle('Buttons')->addHTML(''
            . Demo::header()
            . Demo::democb('Basic button', function () {
                return Button::new()->setLabel('Button');
            })
            . Demo::democb('', function () {
                return Button::newGhost()->setLabel('Button');
            })
            . Demo::democb('', function () {
                return Button::newLink()->setLabel('Button');
            })
            . Demo::democb('Anchor vs Button (see [`Button::setUrl()`](#))', function () {
                return Button::new()
                    ->setLabel('Button')
                    ->setUrl('#');
            })
            . Demo::democb('Title',
                function () {
                    return Button::new()
                        ->setLabel('Button')
                        ->setTitle('This will happen...');
                }
            )
            . Demo::democb('Icon (see [`Icon` class](#))',
                function () {
                    return Button::new()
                        ->setLabel('Button')
                        ->setIcon(new Icon('check'));
                }
            )
            . Demo::democb('',
                function () {
                    return Button::new()
                        ->setIcon(Icon::newSingle('lemon', 'regular'));
                }
            )
            . Demo::democb('Styles (see [`Style` enum](#))',
                function () {
                    return Button::new()
                        ->setLabel('Button')
                        ->setStyle(Style::Info);
                }
            )
            . Demo::democb('',
                function () {
                    return Button::newGhost()
                        ->setLabel('Button')
                        ->setStyle(Style::Warning);
                }
            )
            . Demo::democb('States',
                function () {
                    return Button::newGhost()
                        ->setLabel('Button')
                        ->setStyle(Style::Danger)
                        ->setActive(true);
                }
            )
            . Demo::democb('', function () {
                return Button::new()
                    ->setLabel('Button')
                    ->setStyle(Style::Danger)
                    ->setDisabled(true);
            })
            . Demo::democb('', function () {
                return Button::new()
                    ->setUrl('#')
                    ->setLabel('Button')
                    ->setDisabled(true);
            })
            . Demo::democb('Size', function () {
                return Button::new()
                    ->setLabel('Button')
                    ->setSize(Size::SM);
            })
        )
        . (new Box())->setTitleHTML('HTML button')->addBodyClasses('p')->addHTML(''
            . Components::div('my-2', ''
                . Button::new()->setLabel('Default')->addClasses('mr-1')
                . Button::new()->setLabel('Info')->addClasses('mr-1 info')
                . Button::new()->setLabel('Success')->addClasses('mr-1 success')
                . Button::new()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::new()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::new()->setLabel('Disabled')->addClasses('mr-1')->setDisabled(true)
            )
            . Components::div('my-2', ''
                . Button::newGhost()->setLabel('Default')->addClasses('mr-1')
                . Button::newGhost()->setLabel('Info')->addClasses('mr-1 info')
                . Button::newGhost()->setLabel('Success')->addClasses('mr-1 success')
                . Button::newGhost()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::newGhost()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::newGhost()->setLabel('Disabled')->addClasses('mr-1')->setDisabled(true)
            )
            . Components::div('my-2', ''
                . Button::newLink()->setLabel('Default')->addClasses('mr-1')
                . Button::newLink()->setLabel('Info')->addClasses('mr-1 info')
                . Button::newLink()->setLabel('Success')->addClasses('mr-1 success')
                . Button::newLink()->setLabel('Warning')->addClasses('mr-1 warning')
                . Button::newLink()->setLabel('Danger')->addClasses('mr-1 danger')
                . Button::newLink()->setLabel('Disabled')->addClasses('mr-1')->setDisabled(true)
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
        . (new Box())->setTitleHTML('Size')->addBodyClasses('p')->addHTML(
            Button::new()->setLabel('Button XS')->addClasses('mr-1 xs')
            . Button::new()->setLabel('Button SM')->addClasses('mr-1 sm')
            . Button::new()->setLabel('Button')->addClasses('mr-1')
            . Button::new()->setLabel('Button LG')->addClasses('mr-1', 'lg')
            . Button::new()->setLabel('Button XL')->addClasses('mr-1', 'xl')
            . Button::new()->setLabel('Button XXL')->addClasses('mr-1', 'xxl')
        );
}

if (isset($_GET['buttons'])) {
    $page->setContent(
        (new MicroLayout([2, 8, 2]))
            ->setGutterSize(Size::SM)
            ->setColumnContent(0,
                (new BoxList(Size::SM))
                    ->setTitle('Menu')
                    ->push(new ListItem('Quick start', '', '#', 'fa fa-bolt'))
                    ->push(new ListItem('Layout', 'How to deal with it', '#', 'fa fa-table-columns'))
                    ->push(new ListItem('Components', 'How to deal with it', '#', 'fa fa-cube'))
                    ->push(new ListItem('Structures', ' How to deal with it', '#', 'fa fa-cubes'))
            )
            ->setColumnContent(1, demoButtons())
            ->setColumnContent(2, ''
                . (new BoxList(Size::SM))
                    ->setTitle('Related')
                    ->push(new ListItem('Icons', '', '#'))
                    ->push(new ListItem('Styles', '', '#'))
                . (new BoxList(Size::SM))
                    ->setTitle('Components')
                    ->push(new ListItem('Lists', '', '#'))
                    ->push(new ListItem('Icons', '', '#'))
                    ->push(new ListItem('Drop-down', '', '#'))
                    ->push(new ListItem('Form', '', '#'))
                . (new BoxList(Size::SM))
                    ->setTitle('Enums')
                    ->push(new ListItem('Style', '', '#', 'fa fa-palette'))
                    ->push(new ListItem('Size', '', '#', 'fa fa-up-right-and-down-left-from-center'))
            )
    )
        ->setTitle('Buttons')
        ->setContainerWidth(Size::Fluid);
    $page->getHeaderBar()->title = 'Button API';
}
elseif (isset($_GET['cookies'])) {
    $page->setContent(Components::div('cookie-list', ''));
}
else {

    if (!empty($_POST)) {
        var_dump($_POST);
        die;
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
            ->setLabelButton(Button::newLink()->setUrl('#')->addClasses('p-2 pr-0 fs-80')->setLabel(new Str('forgot password?')))
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
                'val2' => new ListItem('Label 2', icon: 'fa fa-check'),
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

    $lay = new MicroLayout([6, 6]);
    $lay->setColumnContent(0, '');
    $lay->setColumnContent(1, $form);
    $page->setContent("<p>Hi, {$user->name}.</p>" . Fake::paragraph() . $lay);
}


echo $page;