<?php

namespace Tivins\Assets\Stylesheet;

class Stylesheet
{
    protected array $medias = [];
    /**
     * @var RuleSet[]
     */
    protected array $ruleSets = [];

    public function addRuleset(RuleSet $ruleSet): static {
        $this->ruleSets[]=$ruleSet;
        return $this;
    }

    public function __toString(): string
    {
        return join("\n", $this->ruleSets);
    }
}