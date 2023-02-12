<?php

use Tivins\Assets\Assets;
use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Components\BoxList;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\ButtonType;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Demo;
use Tivins\Assets\Field;
use Tivins\Assets\FieldButtons;
use Tivins\Assets\FieldInput;
use Tivins\Assets\HDirection;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\ListItem;
use Tivins\Assets\MicroLayout;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Style;
use Tivins\Assets\Tools\Fake;
use Tivins\Assets\Website;
use Tivins\Core\Code\DocParser;
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
        new ListItem('Buttons','buttons Demo','/?demo=buttons','fa fa-stop'),
        new ListItem('test','test','#','fa fa-check'),
    );
//
//function beautifyPHP($code):string {
//    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
//    $stmts = $parser->parse($code);
//    $prettyPrinter = new PhpParser\PrettyPrinter\Standard;
//    return $prettyPrinter->prettyPrintFile($stmts);
//}


function demoButtons(): string
{
    $btns = [
        'Default' => Button::new()->addClasses(''),
        'Ghost' => Button::newGhost()->addClasses(''),
        'Link' => Button::newLink()->addClasses(''),
//        Button::new()->addClasses('mx-1')->setUrl('#'),
//        Button::newGhost()->addClasses('mx-1')->setUrl('#'),
//        Button::newLink()->addClasses('mx-1')->setUrl('#'),
    ];
/*
 *
    overflow-x: scroll;
    width: auto;
    white-space: nowrap;


        S1 S2 S3
    T1
    T2
    T3
 */

    $bar = '<div class="d-flex">';
    foreach (Style::cases() as $k => $style) {
        if ($k == 0) {

            $bar .= '<div class="p-1 m-1 flex-shrink-0"><div class="mb">Type / Style</div>'.join([
                '<div class="p-btn text-right my-1">Default :</div>',
                '<div class="p-btn text-right my-1">Ghost :</div>',
                '<div class="p-btn text-right my-1">Link :</div>',
                ]).'</div>';
        }

        $rows=[];
        foreach ($btns as $k2 => $btn)
        {

            $rows[] = '<div class="d-flex my-1">'
           //  . '<span class="p-btn w-5">'.$k.':</span>'
            . (clone $btn)->setClasses('mr-1')->setLabel('Default')->setStyle($style)
            . (clone $btn)->setClasses('mr-1')->setLabel('Disabled')->setDisabled(true)->setStyle($style)
            . (clone $btn)->setClasses()->setLabel('Active')->setActive(true)->setStyle($style)
            . '</div>';
        }
        $bar .= '<div class="p-1 flex-shrink-0 b-left"><div class="mb text-center">'.$style->name.'</div>'.join($rows).'</div>';
    }
    $bar .= '</div>';


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
            . Demo::democb('', function () {
                // same as Button::newGhost()
                return Button::new()
                    ->setType(ButtonType::Ghost)
                    ->setLabel('Button');
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
        . (new Box())->setTitleHTML('Button states / Styles')->addBodyClasses('p scroll-x')->addHTML($bar)
        . (new Box())->setTitleHTML('Size')->addBodyClasses('p')->addHTML(
            Button::new()->setLabel('Button XS')->addClasses('mr-1 xs')
            . Button::new()->setLabel('Button SM')->addClasses('mr-1 sm')
            . Button::new()->setLabel('Button')->addClasses('mr-1')
            . Button::new()->setLabel('Button LG')->addClasses('mr-1', 'lg')
            . Button::new()->setLabel('Button XL')->addClasses('mr-1', 'xl')
            . Button::new()->setLabel('Button XXL')->addClasses('mr-1', 'xxl')
        );
}

$menuMain = (new BoxList(Size::SM))
    ->setTitle('Menu')
    ->push(new ListItem('Quick start', '', '#', 'fa fa-bolt'))
    ->push(new ListItem('Layout', 'How to deal with it', '#', 'fa fa-table-columns'))
    ->push(new ListItem('Components', 'How to deal with it', '/?demo', 'fa fa-cube'))
    ->push(new ListItem('Structures', ' How to deal with it', '#', 'fa fa-cubes'))
    ->push(new ListItem('API', 'How to deal with it', '/?api', 'fa-regular fa-file-lines'))
    ;

/**
 * @param ReflectionClass $class
 * @param ReflectionMethod[] $methods
 * @return string
 */
function showMethods(ReflectionClass $class, array $methods): string {
    if (empty($methods)) {
        return '';
    }
    $html = '';
    foreach ($methods as $method) {
        $args = [];
        foreach ($method->getParameters() as $k => $p) {
            $args[] = '<span style="color:#669">' . $p->getType() . '</span> '.($p->isVariadic()?'...':'').'$' . $p->name;
        }
        $docSrc = $method->getDocComment();
        $fDoc   = $docSrc ? DocParser::parse($docSrc) : null;
        if ($fDoc && ($fDoc['brief'] ?? '')) {
            $doc = $fDoc['brief'];
        }
        else {
            [$doc] = explode('@', DocParser::clean($docSrc), 2);
        }
        $returnType = $method->getReturnType();
        if ($returnType?->getName() == 'static') {
            $returnType = '<i class="muted-2">static</i>';
        }
        elseif ($returnType?->isBuiltin()) {
            $returnType = '<span class="text-danger">' . $returnType . '</span>';
        }
        $inherit = $method->getDeclaringClass()->getName() != $class->getName();

        $docSub = '';
        if (!empty($fDoc['param'])) {
            $docSub = '<div class="fs-90 muted-2 mr hidden" id="d'.substr(sha1($method->name),0,7).'"><i class="fs-90">Where</i>';//.htmlentities(json_encode($fDoc));
            $docSub .= '<table class="table sm ml">';
            foreach ($fDoc['param'] as $name => $value) {
                $docSub .= '<tr><th><code>$' . $name . '</code></th><td>' . $value['doc'] . '</td></tr>';
            }
            $docSub .= '</table>';
            $docSub .= '</div>';
        }

        $html .=
            Components::div('d-flex p-1 b-bottom flex-align-top',
            Components::div('py-2 px flex-grow',
                Components::div('d-flex-md markdown-body',
                    Components::div('ff-mono flex-grow', ''
                        . ($inherit ? Icon::newSingle('arrow-up mr-2 muted-3') : '')
                        . '<span class="muted-1">' . $method->getDeclaringClass()->getShortName() . '::</span>'
                        . '<b>' . $method->name . '</b>'
                        . '('
                            . (count($args)>3
                            ? '<br>&nbsp;&nbsp;&nbsp;' . join(',<br>&nbsp;&nbsp;&nbsp;', $args).'<br>'
                            : join(', ', $args)
                        )
                        . ')'
                        . ($returnType ? ': ' . $returnType : '')
                    )
                    . Components::div('muted-2 text-right', substr(StrUtil::markdown($doc), 3, -4))

                )
                . $docSub
            ). ($docSub
                ? Button::newGhost()
                    ->setIcon(Icon::newSingle('plus'))
                    ->addClasses('toggle-view')
                    ->setDataAttr('target', '#d' . substr(sha1($method->name),0,7))
                : ''
            )
            )
        ;
    }
    return $html;
}

function pageDoc(string $className): string
{
    try {
        $class = new ReflectionClass($className);
    } catch (ReflectionException $e) {
        return 'error';
    }
    $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
    usort($methods, fn($a, $b) => strcmp($a->name, $b->name));
    $staticMethods = array_filter($methods, fn(ReflectionMethod $m) => $m->isStatic());
    $publicMethods = array_filter($methods, fn(ReflectionMethod $m) => !$m->isStatic() && $m->getDeclaringClass()->name == $class->name);
    $publicInheritedMethods = array_filter($methods, fn(ReflectionMethod $m) => !$m->isStatic() && $m->getDeclaringClass()->name != $class->name);
    //$html .= (new \Tivins\Assets\Structures\InteractivePath('/path/to/button'));
    $head = '<h1 class="my-0">'.$class->getShortName().'</h1>'
        .Components::subText($class->getNamespaceName())
    ;
    if ($class->getParentClass()) {
        $head .= Components::subText('extends <a href="/?api='.$class->getParentClass()->getName().'">'.$class->getParentClass()->getName().'</a>');
    }
    $html = Components::div('d-flex mb flex-align-top',''
        . Components::div('flex-grow', $head)
        . Button::new()
            ->setSize(Size::LG)
            ->setUrl('/?demo=buttons')
            ->setLabel('DEMO')
        ->setIcon(new Icon('play'))
    );

    [$classDoc] = explode('* @', DocParser::clean($class->getDocComment()), 2);
    if ($classDoc) {


        $html .= (new Box())
            ->setTitle('Overview')
            ->setBoxClasses('box-info', 'mb')
            ->addHTML('<div class="m markdown-body">' . StrUtil::markdown($classDoc) . '</div>');

    }
    if ($class->isEnum()) {
        $enum = new ReflectionEnum($className);
        $html .= (new Box())
            ->setTitle('Enum cases')
            ->setHeaderClasses('fw-bold')
            ->addHTML(join(array_map(
                fn($e)=>
                Components::div('py-2 px b-bottom ff-mono',
                '<span class="muted-1">' . $class->getShortName() . '::</span>' .$e->getName() . '<span class="muted-2"> = "'.$e->getBackingValue().'"</span>'
                ),
                $enum->getCases()
            )));
    }

    if (!empty($staticMethods)) {
        $html .= (new Box())
            ->setTitle('Static methods')
            ->setHeaderClasses('fw-bold')
            ->addHTML(showMethods($class, $staticMethods));
    }
    if (!empty($publicMethods)) {
        $html .= (new Box())
            ->setTitle('Instance methods')
            ->setHeaderClasses('fw-bold')
            ->addHTML(showMethods($class, $publicMethods));
    }
    if (!empty($publicInheritedMethods)) {
        $html .= (new Box())
            ->setTitle('Inherited Instance methods')
            ->setHeaderClasses('fw-bold')
            ->addHTML(showMethods($class, $publicInheritedMethods));
    }
    return $html;
}

if (isset($_GET['api'])) {

    $allowed = [
        'Components' => [
            ' fa-tower-observation' => Button::class,
            ' fa-palette' => Icon::class,
            ' fa-list' => ListItem::class,
            ' fa-stop' => Box::class,
            ' fa-markup' => Components\HTMLElement  ::class,
        ],
        'Enums' => [
            ButtonType::class,
            ' fa-up-right-and-down-left-from-center' => Size::class,
            ' fa-arrows-up-down' => HDirection::class,
        ],
        'Form' => [
            Field::class,
            FieldInput::class,
            \Tivins\Assets\FieldSelect::class,
            \Tivins\Assets\FieldTextArea::class,
            \Tivins\Assets\FieldButtons::class,
        ],
        'Structures' => [

            '-regular fa-rectangle-list' => BoxList::class,
            '-regular fa-calendar' => Components\Timeline::class,
            '-regular fa-clock' => Components\TimelineItem::class,
            Components\Message::class,
        ],
    ];

    function getAllowedBoxlist(Size $size = Size::LG): string
    {
        global $allowed;

        $boxes = [];
        foreach ($allowed as $k => $classes) {
            $box = (new BoxList($size))->setBoxClasses('h-100')->setTitle($k);
            foreach ($classes as $icon => $class) {
                $path      = explode('\\', $class);
                $className = array_pop($path);
                $box->push(new ListItem($className, join('\\', $path), '/?api=' . $class, 'fa'.$icon));
            }
            $boxes[] = Components::div(($size != Size::SM ? 'col-4' : ''). ' px-2 pb-2', $box);
        }
        return join($boxes);
    }

    $layout = (new MicroLayout([2, 8, 2]))
        ->setGutterSize(Size::SM)
        ->setColumnContent(0, $menuMain);
    $page->setContainerWidth(Size::Fluid);
    $page->getHeaderBar()->title = 'API';

    $requestedClass = $_GET['api'] ?? '';

    if (in_array($requestedClass, array_merge(...array_values($allowed)))) {
        $layout->setColumnContent(1, pageDoc($requestedClass));
        $layout->setColumnContent(2, getAllowedBoxlist(Size::SM));
        $page->setTitle($requestedClass);
    }
    else{
        $layout->setColumnContent(1, '<h2 class="box mt-0 p mb-2">API</h2>'.'<div class="d-flex flex-wrap mx--2">'.getAllowedBoxlist().'</div>');
        $page->setTitle('API');
    }
    $page->setContent($layout);
}
elseif (isset($_GET['demo'])) {
    $requestedDemo = $_GET['demo'] ?? '';

    $page->setTitle('Demo');
    $page->setContainerWidth(Size::Fluid);
    $page->getHeaderBar()->title = 'Demo';

    $layout = (new MicroLayout([2, 8, 2]))
        ->setGutterSize(Size::SM)
        ->setColumnContent(0, $menuMain);

    if ($requestedDemo == 'buttons') {
        $layout->setColumnContent(1, demoButtons());
    }
    else {
        $layout->setColumnContent(1, 'list');
    }
    $layout->setColumnContent(2, ''
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
    );
    $page->setContent($layout);
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

    $intro = StrUtil::markdown("**Assets** est un ");
    $page->setContent($intro."<p></p><p>Hi, {$user->name}.</p>" . Fake::paragraph() . $lay);
}


echo $page;