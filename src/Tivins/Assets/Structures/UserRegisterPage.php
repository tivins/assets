<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\ListItem;

class UserRegisterPage
{
    private bool $showErrorMessage = false;

    public function setShowErrorMessage(bool $show): static
    {
        $this->showErrorMessage = $show;
        return $this;
    }

    public function __toString(): string
    {
        $content = '';
        $form = '
    <form class="form p-3">
    <div class="field">
      <label>
        <span class="form-label">User name</span>
        <input type="text" name="username" required>
      </label>
    </div>
    <div class="field">
      <label>
        <span class="form-label">Email</span>
        <input type="email" name="email" required>
      </label>
    </div>
    <div class="field">
      <label>
        <span class="form-label">Password</span>
        <input type="password" name="password" required>
      </label>
    </div>
    <div class="field">
      <label>
        <span class="form-label">Password confirm</span>
        <input type="password" name="password-confirm" required>
      </label>
    </div>
    <div class="field">
    <button type="submit" class="button success w-100">Sign up</button>
    </div>
    </form>';

        if ($this->showErrorMessage) {
            $messages = ['username already used','Invalid email','password too weak','passwords does not match'];
            $content .= Components::boxMessage($messages, 'warning');
        }

        $box1 = (new Box())
            ->setTitle('')
            ->setIcon('fa fa-contact-card')
            ->setBackURL('/assets')
            ->setHeaderClasses('text-center')
            ->setBoxClasses('flex-grow')
            ->setFooterClasses('no-background')
            ->setFooter('<div class="flex-grow">
            <a href="/assets/modal-user-login.html" class="p-3 d-block text-center w-100 simi-link">
                Already registered? <span class="simi-react">Sign in</span>!
            </a>
            </div>
          ')
            ->addHeaderOption(Components::getMoreLink('Connect with...','fa fa-plus',
                new ListItem('Log in with StackOverflow', 'use your StackOverflow account','#', 'fa-brands fa-stack-overflow'),
                new ListItem('Log in with StackOverflow', 'use your StackOverflow account','#', 'fa-brands fa-stack-overflow'),
            ))
            ->addHTML($form);

        $content .= $box1;
        return $content;
    }
}