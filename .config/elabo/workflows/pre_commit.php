#!/usr/bin/env php
<?php

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Fake;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\ListSeparator;
use Tivins\Assets\MicroLayout;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
use Tivins\Assets\Structures\BlogPost;
use Tivins\Assets\Structures\ConfirmationPage;
use Tivins\Assets\Structures\ForgotPasswordPage;
use Tivins\Assets\Structures\InteractivePath;
use Tivins\Assets\Structures\ModalPage;
use Tivins\Assets\Structures\Page;
use Tivins\Assets\Structures\UserLoginPage;
use Tivins\Assets\Structures\UserRegisterPage;
use Tivins\Assets\Template;
use Tivins\Assets\Website;
use Tivins\Core\System\File;

require 'vendor/autoload.php';


function buildPageTemplate(): void
{
    $box1 = (new Box())
        ->setBackURL('/assets')
        ->setTitle('Page Template')
        ->addHeaderOption(Components::getCloneLink(
            target: '#html-page-code',
            tooltip: 'Copy code',
            linkClass: 'header-item b-left',
            successText: 'Copié'
        )
        )
        ->addHTML('<pre id="html-page-code" class="p-3">')
        ->addText(Template::tpl("{{title}}", "", false))
        ->addHTML('</pre>');

    $box2 = (new Box())
        ->setBackURL('/assets')
        ->setTitle('Page Template (local)')
        ->addHeaderOption(Components::getCloneLink(
            target: '#html-page-code',
            tooltip: 'Copy code',
            linkClass: 'header-item b-left',
            text: 'Copy code'
        )
        )
        ->setBodyClasses('p')
        /* ->addHTML('<pre class="highlight p"><a href="#" class="clipper" data-target="#code-7d643166">COPY</a><div id="code-7d643166"><span class="kn">use</span> <span class="nn">Tivins\Dev\JS\Env</span><span class="p">;</span>

<span class="nv">window</span> = <span class="nc">Env</span><span class="o">.</span><span class="nf">init</span>()<span class="p">;</span>
<span class="kd">class</span> <span class="nc">Test</span>
{
    test;
    <span class="k">#</span>testPrivate;
    static <span class="k">function</span> <span class="n">log</span><span class="p">(</span><span class="nv">label</span><span class="p">, </span><span class="nv">info</span><span class="p">)</span><span class="p">: </span><span class="kt">void</span>
    <span class="p">{</span>
        <span class="nc">Env</span><span class="o">.</span><span class="nf">window</span>()<span class="o">.</span><span class="n">console</span><span class="o">.</span><span class="nf">log</span>(<span class="nv">label</span>, <span class="nv">info</span>)<span class="p">;</span>
    <span class="p">}</span>
}

Test<span class="o">.</span><span class="n">test</span> = <span class="s1">&#039;world&#039;</span><span class="p">;</span>
<span class="nc">Test</span><span class="o">.</span><span class="nf">log</span>(<span class="s2">&quot;yo&quot;</span>, [<span class="mi">1</span>, <span class="mi">2</span>, <span class="mi">3</span>])<span class="p">;</span>
<span class="nv">window</span><span class="o">.</span><span class="n">body</span><span class="o">.</span><span class="n">innerText</span> = <span class="s1">&#039;test&#039;</span><span class="p">;</span>
</div></pre>');*/
        ->addHTML('<pre id="html-page-code" class="p-3">')
        ->addText(Template::tpl('{{title}}', '', true))
        ->addHTML('</pre>');

    $layout = new Page();
    $layout->setTitle('Templates');
    $layout->setContent($box1 . $box2);
    File::save('pages/build/assets/tpl-page.html', $layout);
}

function buildPageUserSettings(): void
{

    $html = '

      <form class="form">
      
        <h2 class="mt-0">Primary settings</h2>
      
        <div class="field">
          <label>
            <span class="form-label">UserName</span>
            <input type="text" name="username" value="John Doe">
            <div class="subtext-2">Ce nom sera utilisé publiquement pour vous désigner.</div>
          </label>
        </div>
        
        
        <div class="field">
          <label>
            <span class="form-label">Preference email</span>
            <input type="email" name="email-primary" value="john.doe@example.com" readonly>
          </label>
          <div class="subtext">Vous pouvez configurer la préférence de vos adresses de
           communications dans la <a href="#">section emails</a>.</div>
        </div>
        
        
        
        <div class="field">
          <label>
            <span class="form-label">URL</span>
            <input type="url" name="url" value="" placeholder="https://my-website.example.com"> 
          </label>
        </div>
        
        
        <div class="field">
            <input type="checkbox" id="rec-inf"> 
            <label for="rec-inf" class="d-flex">
                <div>
                    <span class="form-label">Receive informations</span>
                    <div class="subtext">Vous souhaitez recevoir des newsletters de notre part de manière quotidienne.</div>
                </div>
            </label>
        </div>
        
      </form>    
    ';

    $html = '
      <div class="d-flex-md gutter-sm">
        <div class="col-8">' . $html . '</div>
        <div class="col-4 b-left-md b-top-sm text-center">
          <h4>Représentation graphique</h4>
          <img class="radius no-overflow" src="https://i.stack.imgur.com/2EeK7.png" alt="" />
          <div class="p-3"><a href="#" class="button"><i class="fa fa-pencil fa-fw mr-2"></i> modifier</a></div>
        </div>
      </div>
    ';


    $box1 = new Box();
    $box1->setTitle('John Doe')
        ->setBackURL('/assets')
        ->addHeaderOption('<a href="#" class="header-item">...</a>')
        //->addHeaderInfo('<i class="fa fa-user header-item b-right"></i>')
        ->setBodyClasses('p-3')
        ->addHTML($html);

    $content = Template::container(
        Components::getHeaderBar('User Settings')
        . $box1
    );

    $tpl = Template::tpl('Template', $content, true);
    File::save('pages/build/assets/user-settings.html', $tpl);

}

function buildPageUserSettings2(): void
{

    $linkList = new LinkList();
    $linkList->addClasses('col-8');
    $linkList->push(new ListItem(
            title: 'The right thing to do',
            subTitle: 'or the wrongest thing to do...',
            link: '#',
            icon: 'fa fa-passport'
        )
    );
    $linkList->push(new ListItem(
            title: 'The right thing to do',
            subTitle: 'or the wrongest thing to do...',
            link: '#',
            icon: 'fa fa-anchor'
        )
    );
    $linkList->push(new ListItem(
            title: 'Trophées et récompenses',
            subTitle: 'Reconnaissance pour services rendus',
            link: '#',
            icon: 'fa fa-award'
        )
    );

    $box1 = new Box();
    $box1->setTitle('John Doe')
        // ->setBackURL('/assets')
        ->addHeaderOption('<a href="#" class="header-item">...</a>')
        ->addHeaderInfo('<i class="fa fa-user header-item b-right"></i>')
        ->addHTML(
            '<div class="d-flex-md">'
            . $linkList
            . '<div class="col-4 b-left">zff</div>'
            . '</div>'
        );

    $content = Template::container(
        '<h1><a href="/assets">Assets!</a> - User Settings</h1><hr>'
        . $box1
    );

    $tpl = Template::tpl('Template', $content, true);
    File::save('pages/build/assets/user-settings2.html', $tpl);

}

function buildPageModalLogin(): void
{
    $page = new UserLoginPage();
    $page->setShowErrorMessage(true);
    $layout = new ModalPage();
    $layout->setTitle('Sign in to ' . Website::getTitle());
    $layout->setContent($page);
    File::save('pages/build/assets/modal-user-login.html', $layout);
}

function buildPageModalRegister(): void
{
    $page = (new UserRegisterPage());
    $page->setShowErrorMessage(true);
    $layout = new ModalPage();
    $layout->setTitle('Sign up to ' . Website::getTitle());
    $layout->setContent($page);
    File::save('pages/build/assets/modal-user-register.html', $layout);
}

function buildPageModalForgot(): void
{
    $page   = (new ForgotPasswordPage());
    $layout = new ModalPage();
    $layout->setTitle('Request a new password');
    $layout->setContent($page);
    File::save('pages/build/assets/modal-user-password.html', $layout);
    $page->setStep('done');
    $layout->setContent($page);
    File::save('pages/build/assets/modal-user-password-done.html', $layout);
}

function buildPageBlogPost(): void
{
    $page   = (new BlogPost());
    $layout = new Page();
    $layout->setTitle('Blog Post');
    $layout->setContent($page);
    File::save('pages/build/assets/page-blog-post.html', $layout);
}

function buildPageConfirm(): void
{
    $page   = (new ConfirmationPage());
    $layout = new Page();
    $layout->setTitle('Confirmation request');
    $layout->setContent($page);
    File::save('pages/build/assets/modal-confirm.html', $layout);
}

function buildPageIndex(): void
{
    $linkList = new LinkList();
    $linkList->push(new ListItem(
        title: 'Blog post',
        subTitle: 'A modal page with basic components',
        link: '/assets/page-blog-post.html',
        icon: 'fa fa-book'
    )
    );
    $linkList->push(new ListItem(
        title: 'Layout & Columns',
        subTitle: 'A modal page with basic components',
        link: '/assets/container-xl.html',
        icon: 'fa fa-question'
    )
    );
    $linkList->push(new ListItem(
            title: 'Cards',
            subTitle: 'A modal page with basic components',
            link: '/assets/cards.html',
            icon: 'fa fa-contact-card'
        )
    );
    $linkList->push(new ListSeparator('User related pages'));
    $linkList->push(new ListItem(
        title: 'User settings page',
        subTitle: 'A landing user page with basic components',
        link: '/assets/user-settings.html',
        icon: 'fa fa-user-cog'
    )
    );
    $linkList->push(new ListItem(
        title: 'User Login',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-user-login.html',
        icon: 'fa fa-user-circle'
    )
    );
    $linkList->push(new ListItem(
        title: 'User Register',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-user-register.html',
        icon: 'fa fa-contact-card'
    )
    );
    $linkList->push(new ListSeparator('Components'));
    $linkList->push(new ListItem(
        title: 'Confirm page',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-confirm.html',
        icon: 'fa fa-question'
    )
    );
    $linkList->push(new ListItem(
        title: 'Table XL',
        subTitle: 'A modal page with basic components',
        link: '/assets/buildPageTable-xl.html',
        icon: 'fa fa-question'
    )
    );
    $linkList->push(new ListItem(
        title: 'HTML Page template',
        subTitle: 'How to start with assets…',
        link: '/assets/tpl-page.html',
        icon: 'fa fa-code'
    ));
    $linkList->push(new ListItem(
        title: 'buildPageMenuMobile',
        subTitle: 'buildPageMenuMobile',
        link: '/assets/buildPageMenuMobile.html',
        icon: 'fa fa-code'
    ));
    $linkList->push(new ListItem(
        title: 'container-fluid',
        subTitle: 'container-fluid',
        link: '/assets/container-fluid.html',
        icon: 'fa fa-code'
    ));
    $card1 = (new Components\Card('@' . Fake::words(), Fake::sentence(2)));
    $card2 = (new Components\Card('@' . Fake::words() . ' <span class="tag info small-caps">pro</span>', Fake::sentence(2)))
        ->addFooterLink((new Button())
            ->setUrl('#')
            ->setClasses('px', 'py-2')
            ->setLabel(new Str('Follow'))
            ->setUrl('#')
        )
        ->addFooterLink((new Button())
            ->setUrl('#')
            ->setClasses('px', 'py-2')
            ->setLabel(new Str('Fork'))
            ->setIcon(
                (new Components\Icon('code-fork', mutedLevel: false))
            )
            ->setUrl('#')
        );

    $addr = Fake::addressStruct();

    $card3 = (new Box())
        ->setBodyClasses('p-3 d-flex')
        ->setFooterClasses('p-1 flex-align')
        ->setFooter(
            '
            <a href="#" class="p col-4 py-2 button ghost text-center"><i class="fa-regular fa-envelope d-block"></i></a>
            <a href="#" class="p col-4 py-2 mx-1 button success text-center"><i class="fa fa-phone d-block"></i></a>
            <a href="#" class="p col-4 py-2 button ghost text-center"><i class="fa fa-globe-americas d-block"></i></a>
            '
        )
        ->addHTML('
                <div class="pr-3 text-center">
                  <img src="https://i.stack.imgur.com/2EeK7.png" width="64" class="rounded" alt="user-avatar"/>
                 <!-- <hr>
                  <div class="fs-80"><i class="fa-regular fa-handshake"></i><br>86%</div>--> 
                </div>
                <div class="flex-grow">
                  <b class="fs-120">' . Fake::name() . '</b>
                  <div class="subtext-2">' . Fake::words(4) . '</div>
                  <div class="my-2 fs-90">
                      <span class="fs-90">' . Fake::getAddress1($addr) . '</span>
                      <br>' . $addr->postCode . ' ' . $addr->city . '
                      <br>' . $addr->country . '</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>joined on ' . date('Y', Fake::timestamp()) . '</div>
                </div>
              '
        );

    $box1 = new Box();
    $box1->setTitle('Summary')
        ->addHeaderOption('<a href="#" class="header-item">...</a>')
        ->addHTML($linkList);

    $col2 = '<h3 class="mt-0">Cards</h3>' . $card1 . $card2 . $card3;

    $content = MicroLayout::col84GutterBorder($box1, $col2);

    $layout = (new Page(Website::getTitle()))->setContent($content);
    File::save('pages/build/assets/index.html', $layout);
}

function generateCards(Closure $callback, int $n = 6): string
{
    $cards = '';
    for ($i = 0; $i < $n; $i++) {
        $cards .= Components::div('col-4 p-1',
            $callback()->setBoxClasses('m-0 h-100')
        );
    }
    return Components::div('d-flex-md flex-wrap', $cards);
}

function buildPageCards(): void
{
    $content = '';
    // ------------------------------
    $content .= '<h3>Cards</h3>' . generateCards(
            fn() => (new Components\Card())
                ->setUserName(Fake::name())
                ->setCardIcon('user')
                ->setText(Fake::sentence())
        );
    // ------------------------------
    $content .= '<h3>Brand Cards</h3>'
        . '<h4>StackOverflow</h4>'
        . generateCards(
            fn() => (new Components\StackOverflowCard())
                ->setUserName(Fake::name())
                ->setText(Fake::sentence())
            , 3
        )
        . '<h4>GitHub</h4>'
        . generateCards(
            fn() => (new Components\GitHubCard())
                ->setUserName(Fake::name())
                ->setText(Fake::sentence())
            , 3
        );
    // ------------------------------
    $layout = new Page();
    $layout->setTitle('Cards');
    $layout->setContent($content);
    File::save('pages/build/assets/cards.html', $layout);
}

function buildCSS(): void
{
    $dir     = 'pages/build/assets/css';
    $outfile = $dir . '/all.css';
    $sources = [
        $dir . '/font.css',
        $dir . '/normalize.css',
        $dir . '/layout.css',
        $dir . '/highlight.css',
        $dir . '/markdown.css',
        $dir . '/over.css',

    ];
    file_put_contents($outfile, "/*! all.css v1.0.1 | MIT License | github.com/tivins/assets */\n");
    foreach ($sources as $source) {
        file_put_contents($outfile,
            "/* $source */\n"
            . file_get_contents($source) . "\n\n",
            FILE_APPEND
        );
    }
}

function buildPageTable(Size $size): void
{
    $content = '<h2>Sales</h2>';

    $content .= '
  <table class="table">
    <thead>
      <tr>
        <th style="width: 1rem"></th>
        <th>Date</th>
        <th>Name</th>
        <th>Company</th>
        <th>Interventions</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    ';
    $tm      = Fake::timestamp();

    for ($i = 0; $i < 30; $i++) {
        $tm      -= Fake::number(10000);
        $isUser  = Fake::anyChance();
        $isPro   = $isUser && Fake::anyChance();
        $content .= '<tr class="' . (Fake::anyChance(30) ? 'checked' : '') . '">
        <td></td>
        <td>' . date('H:i:s', $tm) . Components::subText(date('F jS,Y', $tm)) . '</td>
      <td>'
            . ($isUser
                ? new Components\Icon('user', fixedWidth: true)
                : new Components\Icon('cart-shopping', fixedWidth: true)
            )
            . Fake::name()
            . ($isPro ? ' <span class="tag small-caps info">pro</span>'
                . Components::subText(
                    new Components\Icon('building', fixedWidth: true)
                    . Fake::name()
                ) : '')
            . Components::subText2(
                new Components\Icon('envelope', 'regular', fixedWidth: true)
                . Fake::email()
            )

            . '</td>
        <td>' . new Components\Icon('dollar-sign') . number_format(Fake::number()) . '</td>
        <td>' . Fake::number() . '</td>
        <td>' . Button::new()->setIcon(new Icon('list'))->addClasses('info p-2') . '</td>
      </tr>';
    }
    $content .= '</tbody>
  </table>';

    $content .= '<div class="box mt p-1">'
        . Button::newGhost()->setLabel(new Str(1))
        . Button::newGhost()->setLabel(new Str(2))
        . Button::newGhost()->setLabel(new Str(3))->addClasses('active')
        . Button::newGhost()->setLabel(new Str(4))
        . Button::newGhost()->setLabel(new Str(5))
        . Button::newGhost()->setLabel(new Str('&hellip;', true))->addClasses('disabled')
        . Button::newGhost()->setLabel(new Str(6))
        . '</div>';

    $layout = (new Page())
        ->setTitle(__function__)
        ->setContent($content)
        ->setContainerWidth($size);

    File::save('pages/build/assets/' . $size->suffix(__function__) . '.html', $layout);
}

function buildPageMenuMobile(): void
{
    $list = new LinkList(Size::SM);

    for ($i = 0; $i < 10; $i++) {

        $list->push(new ListItem(
                title: Fake::words(),
                link: '#',
                icon: 'fa fa-' . Fake::anyOf(['code','check','user','times','envelope','database'])
            )
        );
    }

    $btn = Button::newGhost()->addClasses('menu-btn')->setIcon(new Icon('times', margin: 'none'));


    $layout = (new MicroLayout([2,7,3]))->setGutterSize(Size::SM);
    $layout->setColumnContent(0,$list);/*
        // Components::div('menu-sm active visible-md',
            (new Box())
                ->setTitle(Website::getTitle() . ' menu')
                ->setHeaderClasses('visible-sm')
                ->setBoxClasses('')
                ->addHTML($list)
            ->addHeaderOption(Components::getCloseLink())
       // )
    );*/
    $layout->setColumnClasses(0, 'menu-sm visible-md');
    $layout->setColumnContent(1, (new Box())->setTitle(Fake::name())->setBodyClasses('p')->addText(Fake::paragraph()));
    $layout->setColumnContent(2, (new Box())->setTitle(Fake::name())->setBodyClasses('p')->addText(Fake::paragraph()));

    $content = $layout;

    $page = (new Page('Side menu', Size::XL))
        ->setContent($content);
    File::save('pages/build/assets/' . __function__ . '.html', $page);
}

function buildPageContainerWidth(Size $size): void
{
    $colsGen = function (array $conf) {
        $colContent = function (int $sentencesCount = 5): Box {
            return (new Box)
                ->setTitleHTML('<code>col-' . $sentencesCount . '</code>')
                ->setBoxClasses('h-100')
                ->setBodyClasses('p')
                ->addHTML(
                    preg_replace('~\b(consequat|ipsum|Vestibulum)\b~i', '<i>$1</i>',
                        preg_replace('~\b(libero|sagittis|lorem)\b~i', '<b>$1</b>',
                            Fake::sentence($sentencesCount)
                        )
                    )
                );
        };
        $l          = new MicroLayout($conf);
        foreach ($conf as $k => $size) {
            $l->setColumnContent($k, $colContent($size));
        }
        return $l;
    };
    $rows    = '';
    $rows    .= new InteractivePath('/pages/docs/menu/item');
    $rows    .= $colsGen([2, 6, 4])->setGutterSize(Size::SM);
    $rows    .= $colsGen([2, 7, 3])->setGutterSize(Size::SM);
    $rows    .= $colsGen([3, 4, 5])->setGutterSize(Size::SM);
    $rows    .= $colsGen([3, 6, 3])->setGutterSize(Size::SM);
    $rows    .= $colsGen([6, 6])->setGutterSize(Size::SM);
    $rows    .= $colsGen([9, 3])->setGutterSize(Size::SM);
    $rows    .= $colsGen([2, 8, 2])->setGutterSize(Size::SM);
    $rows    .= $colsGen([12])->setGutterSize(Size::SM);
    $rows    .= $colsGen([4, 8])->setColumnContent(0, '<i class="muted-2">offset</i>')->setGutterSize(Size::SM);


    $layout = (new Page('Confirmation request'))
        ->setContent($rows)
        ->setContainerWidth($size);

    File::save('pages/build/assets/container-' . $size->value . '.html', $layout);
}
function buildPageFluid(): void
{
    $content = 'hello';

    $layout = (new Page(__FUNCTION__, Size::Fluid))
    ->setContent($content);
    File::save('pages/build/assets/container-fluid.html', $layout);
}


Website::setTitle('Assets!');
buildCSS();
buildPageIndex();
buildPageContainerWidth(Size::XL);
buildPageContainerWidth(Size::LG);
buildPageContainerWidth(Size::MD);
buildPageTemplate();
buildPageUserSettings();
buildPageUserSettings2();
buildPageModalLogin();
buildPageModalRegister();
buildPageModalForgot();
buildPageConfirm();
buildPageBlogPost();
buildPageCards();
buildPageTable(Size::XL);
buildPageTable(Size::LG);
buildPageTable(Size::MD);
buildPageMenuMobile();
buildPageFluid();
