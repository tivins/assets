#!/usr/bin/env php
<?php

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\Template;
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
        );
    $box1->addHTML('<pre id="html-page-code" class="p-3">');
    $box1->addText(Template::tpl("{{title}}", "", false));
    $box1->addHTML('</pre>');

    $box2 = (new Box())
        ->setBackURL('/assets')
        ->setTitle('Page Template (local)')
        ->addHeaderOption(Components::getCloneLink(
            target: '#html-page-code',
            tooltip: 'Copy code',
            linkClass: 'header-item b-left',
            text: 'Copy code'
        )
        );
    $box2->addHTML('<pre id="html-page-code" class="p-3">');
    $box2->addText(Template::tpl('{{title}}', '', true));
    $box2->addHTML('</pre>');


    $content = Template::container(
        '<h1>Assets! Templates</h1>'
        . $box1->render()
        . $box2->render(), 'lg'
    );
    $tpl     = Template::tpl('Template', $content, true);

    File::save('pages/build/assets/tpl-page.html', $tpl);
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
            <input type="email" name="email-primary" value="john.doe@example.com">
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
        '<h1><a href="/assets">Assets!</a> - User Settings</h1><hr>'
        . $box1->render()
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
        . $box1->render()
        //. $box2->render()
        , 'lg'
    );

    $tpl     = Template::tpl('Template', $content, true);
    File::save('pages/build/assets/user-settings2.html', $tpl);

}

buildPageTemplate();
buildPageUserSettings();
buildPageUserSettings2();
