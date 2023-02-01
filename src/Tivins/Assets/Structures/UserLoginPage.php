<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\Str;

class UserLoginPage
{
    private bool $showErrorMessage = false;

    public function setShowErrorMessage(bool $show): static
    {
        $this->showErrorMessage = $show;
        return $this;
    }

    public function __toString(): string {
        $content = '';

        $form = '
    <form class="form p-3 mx-auto max-w-350px">
    <div class="field">
      <label>
        <span class="form-label">Email</span>
        <input type="email" name="email" required placeholder="Type your email">
        <!--<div class="validation">invalid</div>-->
      </label>
    </div>
    <div class="field">
      <div class="d-flex">
      <label for="password" class="flex-grow"><span class="form-label">Password</span></label>
      <a href="/assets/modal-user-password.html" class="fs-80 p-1">forgot password?</a> 
      </div>
      <input type="password" name="password" id="password" required placeholder="Password">
    </div>
    <div class="field">
    <button type="submit" class="button success w-100">Sign in</button>
    </div>
    </form>';

        if ($this->showErrorMessage) {
            $message = new Str('Incorrect username or password.');
            $content .= Components::boxMessage($message, 'warning');
        }

        $box1 = (new Box())
            ->setTitle('')
            ->setIcon('fa fa-lock')
            ->setBackURL('/assets')
            ->setHeaderClasses('text-center')
            ->setBoxClasses('flex-grow')
            ->setFooterClasses('no-background')
            ->setFooter('<div class="flex-grow">
            <a href="/assets/modal-user-register.html" class="p-3 d-block text-center w-100 simi-link">
                New here? <span class="simi-react">Create an account</span>.
            </a>
            </div>
          ')
            ->addHeaderOption(Components::getMoreLink2('.pop-menu-login','Connect with...','fa fa-plus'))
            ->addHTML($form);

        $content .= $box1;
        $content .= (new LinkList())
            ->addClasses('pop-menu-login hidden')
            ->push(
                new ListItem('Log in with StackOverflow', 'use your StackOverflow account','#', 'fa-brands fa-stack-overflow'),
                new ListItem('Log in with GitHub', 'use your GitHub account','#', 'fa-brands fa-github'),
                new ListItem('Log in with Google', 'use your Google account','#', 'fa-brands fa-google'),
            );
        return $content;
    }
}