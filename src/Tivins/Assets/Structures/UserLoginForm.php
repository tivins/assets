<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Components\Button;
use Tivins\Assets\FieldButtons;
use Tivins\Assets\FieldInput;
use Tivins\Assets\Form;
use Tivins\Assets\Str;

class UserLoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('post');

        $this->addField(
            (new FieldInput('text'))
                ->setName('email')
                ->setLabel('Email')
                ->setPlaceholder('Type your email address')
                ->setRequired()
        );
        $this->addField(
            (new FieldInput('password'))
                ->setName('password')
                ->setLabel('Password')
                ->setLabelButton(Button::newLink()->setUrl('#')->setClasses('p-2 pr-0 fs-80')->setLabel(new Str('forgot password?')))
                ->setPlaceholder('Password')
                ->setRequired()
        );
        $this->addField(
            (new FieldButtons())
                ->addButton(
                    Button::new()
                        ->addClasses('success', 'w-100')
                        ->setLabel(new Str('Sign in'))
                )
        );
    }
}