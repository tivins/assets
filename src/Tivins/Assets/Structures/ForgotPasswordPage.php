<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\ListItem;
use Tivins\Assets\Str;

class ForgotPasswordPage //extends ModalPage
{
    private string $step = 'form';

    public function setStep(string $step): static
    {
        $this->step = $step;
        return $this;
    }

    public function __toString(): string
    {
        if ($this->step == 'done') {

            $content = Components::boxMessage(new Str('Information'), 'warning', 'mx-over-5',
                false,
                icon: 'fa fa-info mr', body: ('<div class="p">Dans le cadre du respect de la vie privée, nous ne pouvons pas vous informer si
            votre requête a bien abouti. Merci de votre compréhension.</div>')
            );
            $content .= Components::boxMessage(new Str('Vérifiez votre boîte mail. Si votre demande a été effectuée, vous trouverez 
            un email contenant un lien temporaire pour créer un nouveau mot de passe.'), 'success',
                closable: false
            );
            $content .= '<div class="p-3"><a href="/assets/modal-user-login.html" class="button d-block text-center">Back to login page</a></div>';
            // return parent::__toString();
            return $content;
        }

        $content = '
          <form class="form p-3" action="/assets/modal-user-password-done.html">
            <div class="field">
              <label>
                <span class="form-label">Email</span>
                <input type="email" name="email" required>
              </label>
            </div>
            <div class="field">
              <button type="submit" class="button success w-100">Send procedure</button>
            </div>
          </form>
        ';

        $box1 = (new Box())
            ->setTitle('')
            ->setIcon('fa fa-lock')
            ->setBackURL('/assets')
            ->setHeaderClasses('text-center')
            ->setBoxClasses('flex-grow')
            ->setFooterClasses('no-background')
            ->setFooter('<div class="flex-grow">
            <a href="/assets/modal-user-login.html" class="p-3 d-block text-center w-100 simi-link">
                Back to <span class="simi-react">Sign in</span> page.
            </a>
            </div>
          '
            )
            ->addHeaderOption(
                Components::getMoreLink('Connect with...', 'fa fa-plus',
                    new ListItem('Log in with StackOverflow', 'use your StackOverflow account', '#', 'fa-brands fa-stack-overflow'),
                    new ListItem('Log in with StackOverflow', 'use your StackOverflow account', '#', 'fa-brands fa-stack-overflow'),
                )
            )
            ->addHTML($content);

        return $box1;
        //return parent::__toString();
    }
}