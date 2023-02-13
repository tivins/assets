<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\ClassList;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\Str;
use Tivins\Core\StrUtil;

class HTMLElement
{
    protected string $nodeName;
    protected ClassList $classList;
    protected array $attributes = [];
    protected Str $content;
    protected int $selfClosedType = 0; // 0: <b></b>, 1: '<hr>', 2: '<img />'

    public function __construct(string $nodeName)
    {
        $this->classList = new ClassList();
        $this->content = new Str('');
        $this->nodeName = $nodeName;
    }

    public function __toString(): string
    {
        $tag = '<' . $this->nodeName;
        foreach ($this->attributes as $attrName => $attrValue) {
            if (!preg_match('~[a-z\-]~', $attrName)) {
                continue;
            }
            if (is_null($attrValue)) {
                $tag .= ' '.$attrName;
            } else {
                $tag .= ' '.$attrName.'="' . StrUtil::html($attrValue) . '"';
            }
        }

        $tag .= $this->classList->toHTMLString(' ');
        //foreach ($this->attributes as $key => $value) {
        //    $tag .= ' ' . $key . '="' . StrUtil::html($value) . '"';
        //}
        $tag .= ($this->selfClosedType == 2 ? '/' : '');
        $tag .= '>';
        if (!$this->selfClosedType) {
            if (!$this->content->empty()) {
                $tag .= $this->content;
            }
            $tag .= '</' . $this->nodeName . '>';
        }
        return $tag;
    }

    // ------------( getters / setters )------------

    public function setNodeName(string $nodeName): static
    {
        $this->nodeName = $nodeName;
        return $this;
    }

    public function addClasses(string ...$classes): static
    {
        $this->classList->add(...$classes);
        return $this;
    }
    public function setClassList(string ...$classes): static
    {
        $this->classList->set(...$classes);
        return $this;
    }

    public function addAttribute(string $key, ?string $value): static {
        $this->attributes[$key] = $value;
        return $this;
    }
    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function setContent(Str $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param int $selfClosedType 0: `&lt;b>&lt;/b>`, 1: `&lt;hr>`, 2: `&lt;img />
     */
    public function setSelfClosedType(int $selfClosedType): static
    {
        $this->selfClosedType = $selfClosedType;
        return $this;
    }
}