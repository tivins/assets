#!/usr/bin/env php
<?php

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\ListSeparator;
use Tivins\Assets\Str;
use Tivins\Assets\Structures\BlogPost;
use Tivins\Assets\Structures\ForgotPasswordPage;
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
        ))
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
        ))
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
function buildPageUserSettings(): void {

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
            <input type="checkbox" id="recinf"> 
            <label for="recinf" class="d-flex">
                <div>
                    <span class="form-label">Receive informations</span>
                    <div class="subtext">Vous souhaitez reçevoir des newsletters de notre part de manière quotidienne.</div>
                </div>
            </label>
        </div>
        
      </form>    
    ';

    $html = '
      <div class="d-flex-md gutter-sm">
        <div class="col-8">'.$html.'</div>
        <div class="col-4 b-left-md b-top-sm text-center">
          <h4>Représentation graphique</h4>
          <img class="radius no-overflow" src="https://i.stack.imgur.com/2EeK7.png" />
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
        ->addHTML($html)
    ;

    $content = Template::container(
        Components::getHeaderBar('User Settings')
        . $box1
        //. $box2->render()
        , 'lg'
    );

    $tpl     = Template::tpl('Template', $content, true);
    File::save('pages/build/assets/user-settings.html', $tpl);

}
function buildPageUserSettings2(): void {

    $linkList = new LinkList();
    $linkList->addClasses('col-8');
    $linkList->push(new ListItem(
        title: 'The right thing to do',
        subTitle: 'or the wrongest thing to do...',
        link: '#',
        icon: 'fa fa-passport'
    ));
    $linkList->push(new ListItem(
        title: 'The right thing to do',
        subTitle: 'or the wrongest thing to do...',
        link: '#',
        icon: 'fa fa-anchor'
    ));
    $linkList->push(new ListItem(
        title: 'Trophées et récompenses',
        subTitle: 'Reconnaissance pour services rendus',
        link: '#',
        icon: 'fa fa-award'
    ));

    $box1 = new Box();
    $box1->setTitle('John Doe')
        // ->setBackURL('/assets')
        ->addHeaderOption('<a href="#" class="header-item">...</a>')
        ->addHeaderInfo('<i class="fa fa-user header-item b-right"></i>')
        ->addHTML(
            '<div class="d-flex-md">'
            .$linkList
            .'<div class="col-4 b-left">zff</div>'
            .'</div>'
        )
    ;

    $content = Template::container(
        '<h1><a href="/assets">Assets!</a> - User Settings</h1><hr>'
        . $box1
        //. $box2->render()
        , 'lg'
    );

    $tpl     = Template::tpl('Template', $content, true);
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
    $page = (new ForgotPasswordPage());
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
    $page = (new BlogPost());
    $layout = new Page();
    $layout->setTitle('Blog Post');
    $layout->setContent($page);
    File::save('pages/build/assets/page-blog-post.html', $layout);
}
function buildPageConfirm(): void
{
    $page = (new \Tivins\Assets\Structures\ConfirmationPage());
    $layout = new Page();
    $layout->setTitle('Confirmation request');
    $layout->setContent($page);
    File::save('pages/build/assets/modal-confirm.html', $layout);
}
function buildPageIndex(): void
{
    $linkList = new LinkList();

    $linkList->push(new ListItem(
        title: 'HTML Page template',
        subTitle: 'How to start with assets…',
        link: '/assets/tpl-page.html',
        icon: 'fa fa-chess'
    ));
    $linkList->push(new ListSeparator());
    $linkList->push(new ListItem(
        title: 'User settings page',
        subTitle: 'A landing user page with basic components',
        link: '/assets/user-settings.html',
        icon: 'fa fa-user-cog'
    ));
    $linkList->push(new ListItem(
        title: 'User Login',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-user-login.html',
        icon: 'fa fa-user-circle'
    ));
    $linkList->push(new ListItem(
        title: 'User Register',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-user-register.html',
        icon: 'fa fa-contact-card'
    ));

    $linkList->push(new ListItem(
        title: 'Confirm page',
        subTitle: 'A modal page with basic components',
        link: '/assets/modal-confirm.html',
        icon: 'fa fa-question'
    ));
    $linkList->push(new ListItem(
        title: 'Blog post',
        subTitle: 'A modal page with basic components',
        link: '/assets/page-blog-post.html',
        icon: 'fa fa-book'
    ));

    $card1 = (new Box())
        ->setBodyClasses('p-3 d-flex')
        ->addHTML('
                <div class="pr-3 text-center">
                  <i class="fa-2x fa-fw fa-brands fa-stack-overflow" style="color:#ccc"></i>
                  <hr>
                  <i class="fa-regular fa-circle-up"></i>
                  <div class="fs-80">19K</div> 
                </div>
                <div class="flex-grow">
                  <b>@johndoe65</b><br>
                  <div class="my-2 fs-90">Developer, Ready to help on StackOverflow, Share code on GitHub.</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>created on 2023</div>
                </div>
              ');

    $card2 = (new Box())
        ->setBodyClasses('p-3 d-flex')
        ->setFooter(
            '
                        <a href="#" class="p">follow</a>
                        <a href="#" class="p"><i class="fa fa-code-fork mr-1"></i>fork</a>
                        '
        )
        ->addHTML('
                <div class="pr-3 text-center">
                  <i class="fa-brands fa-fw fa-2x fa-github" style="color:#ccc"></i>
                  <hr>
                  <div class="fs-80"><i class="fa-regular fa-star"></i><br>24</div> 
                </div>
                <div class="flex-grow">
                  <b>@jdoe987</b><br>
                  <div class="my-2 fs-90">Developer, Ready to help on StackOverflow, Share code on GitHub.</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>created on 2023</div>
                </div>
              ');
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
                  <b class="fs-120">John Doe</b>
                  <div class="subtext-2">real estate agent</div>
                  <div class="my-2 fs-90"><span class="fs-90">123 Anywhere on Earth St.,</span><br>Another City, ST 12354<br>CA, Country</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>joined on 2023</div>
                </div>
              ');

    //$linkList->addClasses('col-8');

    $box1 = new Box();
    $box1->setTitle('Summary')
        // ->setBackURL('/assets')
        ->addHeaderOption('<a href="#" class="header-item">...</a>')
        //->addHeaderInfo('<i class="fa fa-user header-item b-right"></i>')
        ->addHTML($linkList)
    ;

    $content = '
    <div class="d-flex-md">
      <div class="col-8 pr-md-3">'.$box1.'</div>
      <div class="col-4 pl-md-3 b-left-md"><h3 class="mt-0">Cards</h3>'.$card1.$card2.$card3.'</div>
    </div>
    ';


    $layout = new Page();
    $layout->setTitle(Website::getTitle());
    $layout->setContent($content);


    File::save('pages/build/assets/index.html', $layout);
}
function buildCSS(): void {
    $dir = 'pages/build/assets/css';
    $outfile = $dir . '/all.css';
    $sources = [
        $dir . '/normalize.css',
        $dir . '/layout.css',
        $dir . '/highlight.css',
        $dir . '/markdown.css',
        $dir . '/over.css',
    ];
    file_put_contents($outfile, "");
    foreach ($sources as $source) {
        file_put_contents($outfile,
            "/* $source */\n"
            . file_get_contents($source) . "\n\n",
        FILE_APPEND
        );
    }
}

Website::setTitle('Assets!');
buildCSS();
buildPageIndex();
buildPageTemplate();
buildPageUserSettings();
buildPageUserSettings2();
buildPageModalLogin();
buildPageModalRegister();
buildPageModalForgot();
buildPageConfirm();
buildPageBlogPost();