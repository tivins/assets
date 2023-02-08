<?php

namespace Tivins\Assets\Stylesheet;

class RuleSet
{
    /** @var string[] */
    protected array $selectors = [];
    /** @var Rule[] */
    protected array $rules = [];
    protected Media $media;

    public function setMedia(Media $media): static {
        $this->media = $media;
        return $this;
    }
    public function setSelectors(string ...$selectors): static {
        $this->selectors = $selectors;
        return $this;
    }
    public function addSelectors(string ...$selectors): static {
        $this->selectors = array_merge($this->selectors, $selectors);
        return $this;
    }
    public function setRules(Rule ...$rules): static {
        $this->rules = $rules;
        return $this;
    }
    public function addRules(Rule ...$rules): static {
        $this->rules = array_merge($this->rules, $rules);
        return $this;
    }
    public function __toString(): string
    {
        return join(',',$this->selectors).'{'.join(';',$this->rules).'}';
    }
}