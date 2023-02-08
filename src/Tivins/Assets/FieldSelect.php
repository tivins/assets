<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\HTMLElement;

class FieldSelect extends Field
{
    /** @var ListItem[] */
    protected array $options = [];
    public function __construct()
    {

    }
    public function setOptions(array $options): static
    {
        $this->options = $options;
        return $this;
    }


    public function __toString(): string
    {
        $label = $this->getLabel();
        $input      = (new HTMLElement('input'))
            ->setAttributes([
                'id'   => $this->getID(),
                'type'   => 'hidden',
                'name' => $this->name,
                'rows' => 5,
                'value' => '',
            ])
            ->setSelfClosedType(1);

        $target = 'pop-menu-select-'. $this->getID();

        // $input .= Button::newGhost()
        //     ->setLabel($this->placeholder ? 'select' :'')
        //     ->addClasses('w-100 pop-trigger')
        //     ->setDataAttr('target', '.' . $target)
        //     ->setDropDir(HDirection::Down);

        $input .= (new LinkList(Size::SM))
            ->addClasses('box pop-trigger')
            ->push(new ListItem($this->placeholder ? 'select' :''))
            ->addAttributes(['data-target' => '.' . $target])
            ;

        $list = (new LinkList(Size::SM))
            ->addClasses($target, 'hidden', 'select-selector')
            ->addAttributes(['data-select' => '#'.$this->getID()])
        ;
        foreach ($this->options as $key => $value) {
            $list->push($value->addAttributes(['data-value' => $key]));
        }
        $input .= $list;

        // if ($this->required) {
        //     $input->addAttribute('required', null);
        // }
        // if ($this->placeholder) {
        //     $input->addAttribute('placeholder', $this->placeholder);
        // }

        return $this->wrap($label . $input);
    }
}