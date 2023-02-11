<?php

use PhpParser\ParserFactory;
use Tivins\Assets\Assets;
use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Fake;
use Tivins\Assets\FieldButtons;
use Tivins\Assets\FieldInput;
use Tivins\Assets\HDirection;
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

function unIndent(array $loc): array
{
    $maxIndex = [];
    foreach ($loc as $line) {
        preg_match('~^(\s*)~', $line, $matches);
        $maxIndex[] = strlen($matches[1]);
    }
    $max = min($maxIndex);

    return array_map(fn($s) => substr($s, $max), $loc);
}
function beautifyPHP($code):string {
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    $stmts = $parser->parse($code);
    $prettyPrinter = new PhpParser\PrettyPrinter\Standard;
    return $prettyPrinter->prettyPrintFile($stmts);
}
/**
 * @throws ReflectionException
 */
function democb($info,callable $callback) {
    $api = new ReflectionFunction($callback);
    $lines = file($api->getFileName());
    $len = $api->getEndLine() - $api->getStartLine();

    $loc = array_splice($lines, $api->getStartLine(), $len -1);
    $loc[0] = str_replace('return ','echo ', $loc[0]);
    $code = beautifyPHP(join(unIndent($loc)));
    return demo($info, $code, $callback());

}
function demo($info,$code,$html) {

    $toHigh = '<'.'?' . 'php' . "\n\n" . $code;
    // $code = (new \Tivins\Dev\PHPHighlight())->highlight($toHigh);
    $code = '<pre class="h-100">'.htmlentities($code).'</pre>';

    return '<div class="b-bottom">'
    . ($info ? '<div class="b-bottom p markdown-body ">'.\Tivins\Core\StrUtil::markdown($info).'</div>' : '')
    . '<div class="d-flex-md">'
    . '<div class="col-5 markdown-body">'.$code.'</div>'
    . '<div class="col-2 text-center py">'.$html.'</div>'
    . '<div class="col-5 markdown-body "><pre class="h-100 max-w-100" style="max-width:100%;overflow:auto;">'.htmlentities($html).'</pre></div>'
    . '</div></div>';
}

/**
 * @throws ReflectionException
 */
function demoButtons(): string
{
    return  Components::boxMessage(new \Tivins\Assets\HTMLStr(\Tivins\Core\StrUtil::markdown("The class `Button` implements `__toString()`")))
        . (new Box())->setTitle('Buttons')->addHTML(''
            . '<div class="d-flex-md gutter-sm py-2 b-bottom">'
            . '<div class="col-5 fw-bold text-center">PHP Code</div>'
            . '<div class="col-2 fw-bold text-center">Render</div>'
            . '<div class="col-5 fw-bold text-center">Generated HTML</div>'
            . '</div>'
        .democb('Basic button', function () {
            return Button::new()->setLabel('Button');
        })
        .democb('', function () {
            return Button::newGhost()->setLabel('Button');
        })
        .democb('', function () {
            return Button::newLink()->setLabel('Button');
        })
        .democb('Anchor vs Button (see [`Button::setUrl()`](#))', function () {
            return Button::new()
                ->setLabel('Button')
                ->setUrl('#');
        })
        .democb('Title',
            function () {
                return Button::new()
                    ->setLabel('Button')
                    ->setTitle('This will happen...');
            }
        )
        .democb('Icon (see [`Icon` class](#))',
            function () {
                return Button::new()
                    ->setLabel('Button')
                    ->setIcon(new Icon('check'));
            }
        )
        .democb('',
            function () {
                return Button::new()
                    ->setIcon(Icon::newSingle('lemon','regular'));
            }
        )
            .democb('Styles (see [`Style` enum](#))',
                function () {
                    return Button::new()
                        ->setLabel('Button')
                        ->setStyle(Style::Info);
                }
            )
            .democb('',
                function () {
                    return Button::newGhost()
                        ->setLabel('Button')
                        ->setStyle(Style::Warning);
                }
            )
            .democb('States',
                function () {
                    return Button::newGhost()
                        ->setLabel('Button')
                        ->setStyle(Style::Danger)
                        ->setActive(true);
                }
            )
        . democb('',function() {
                return Button::new()
                    ->setLabel('Button')
                    ->setStyle(Style::Danger)
                    ->setDisabled(true);
            })
        . democb('', function() {
                return Button::new()
                    ->setUrl('#')
                    ->setLabel('Button')
                    ->setDisabled(true);
            })
        . democb('Size',function() {
            return Button::new()
                ->setLabel('Button')
                ->setSize(Size::SM);
            })
//        . demo('',
//                "Button::new()->setLabel('Button')->setStyle(Style::Danger)->setSize(Size::XS)",
//                Button::new()->setLabel('Button')->setStyle(Style::Danger)->setSize(Size::XS)
//            )
//        . demo('',
//                "Button::new()->setLabel('Button')->setStyle(Style::Success)->setSize(Size::LG)->setUrl('#'))",
//                Button::new()->setLabel('Button')->setStyle(Style::Success)->setSize(Size::LG)->setUrl('#')
//        )
        )

        . '<hr>'
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
            . Button::new()->setLabel('Button LG')->addClasses('mr-1','lg')
            . Button::new()->setLabel('Button XL')->addClasses('mr-1','xl')
            . Button::new()->setLabel('Button XXL')->addClasses('mr-1', 'xxl')
        )
    ;
}

if (isset($_GET['buttons'])) {
    $page->setContent(
        (new \Tivins\Assets\MicroLayout([2, 10]))
            ->setGutterSize(Size::SM)
            ->setColumnContent(1, demoButtons())
            ->setColumnContent(0,
                (new Box())
                    ->setTitle('Related')
                    ->addHTML(
                        (new \Tivins\Assets\LinkList())
                            ->push(new ListItem('Icons', '', '#'))
                            ->push(new ListItem('Styles', '', '#'))
                    )
                . (new Box())
                    ->setTitle('Components')
                    ->addHTML(
                        (new \Tivins\Assets\LinkList())
                            ->push(new ListItem('Lists', '', '#'))
                    )
                . (new Box())
                    ->setTitle('Enums')
                    ->addHTML(
                        (new \Tivins\Assets\LinkList())
                            ->push(new ListItem('Style', '', '#'))
                            ->push(new ListItem('Size', '', '#'))
                    )
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