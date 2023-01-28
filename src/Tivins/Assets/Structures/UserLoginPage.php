<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\ListItem;
use Tivins\Assets\Template;

class UserLoginPage
{
    private bool $showErrorMessage = false;

    public function render(): string {

        $content = '
    <form class="form p-3">
    <div class="field">
      <label>
        <span class="form-label">Email</span>
        <input type="text" name="username" required>
      </label>
    </div>
    <div class="field">
      <div class="d-flex">
      <label for="password" class="flex-grow"><span class="form-label">Password</span></label>
      <a href="#" class="fs-80 p-1">forgot password?</a> 
      </div>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="field">
    <button type="submit" class="button success w-100">Sign in</button>
    </div>
    </form>';

        $boxError = '';
        if ($this->showErrorMessage) {
            $boxError = (new Box())
                ->setTitle('Incorrect username or password.')
                ->setBoxClasses(    'box-warning mb')
                ->setHeaderClasses('no-borders')
                ->addHeaderOption(Components::getCloseLink());
        }

        $box1 = (new Box())
            ->setTitle('')
            ->setIcon('fa fa-lock')
            ->setBackURL('/assets')
            ->setHeaderClasses('text-center')
            ->setBoxClasses('flex-grow')
            ->setFooter('<div class="flex-grow">
            <a href="/assets/modal-user-register.html" class="p-3 d-block text-center w-100 simi-link">
                New here? <span class="simi-react">Create an account</span>.
            </a>
            </div>
          ')
            ->addHeaderOption(Components::getMoreLink('Connect with...','fa fa-plus',
                new ListItem('Log in with StackOverflow', 'use your StackOverflow account','#', 'fa-brands fa-stack-overflow'),
                new ListItem('Log in with StackOverflow', 'use your StackOverflow account','#', 'fa-brands fa-stack-overflow'),
            ))
            ->addHTML($content);

        $content = Template::container(
            '<div class="" style="max-width: 350px;margin-left:auto;margin-right:auto">
    <div class="text-center">
      <i class="fa fa-globe-europe fs-250 p-4 op-05" title="WebSite Logo"></i>
      <h2 class="mt-0 mb-4 fw-light">Sign in to WebSite</h2>
    </div>
    <div class="pb-4">
    '.$boxError->render().'
    '.$box1->render().'
    <div class="py-4 d-flex fs-80">
      <a href="/assets/" class="flex-grow text-center p-2"><i class="fa fa-globe-europe mr-2"></i>WebSite</a>
      <a href="assets/legal.html" class="flex-grow text-center p-2">terms &amp; privacy</a>
    </div>
    </div>
        </div>'
        );

        return Template::tpl('Template', $content, true);
        // File::save('pages/build/assets/modal-user-login.html', $tpl);
    }
}