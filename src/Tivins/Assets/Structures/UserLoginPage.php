<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\ListSeparator;
use Tivins\Assets\Size;
use Tivins\Assets\Str;

class UserLoginPage
{
    protected bool $showErrorMessage = false;
    protected UserLoginForm $form;

    public function __construct()
    {
        $this->form = new UserLoginForm();
    }

    public function setShowErrorMessage(bool $show): static
    {
        $this->showErrorMessage = $show;
        return $this;
    }

    public function __toString(): string {
        $content = '';

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
            ->addHTML($this->form);

        $content .= $box1;
        $content .= (new LinkList(Size::SM))
            ->addClasses('pop-menu-login hidden')
            ->push(
                new ListSeparator('Log in with'),
                new ListItem('StackOverflow', '','#', 'fa-brands fa-stack-overflow'),
                new ListItem('GitHub', '','#', 'fa-brands fa-github'),
                new ListItem('Google', '','#', 'fa-brands fa-google'),
            );
        return $content;
    }
}