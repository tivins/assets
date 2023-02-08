<?php

namespace Tivins\Assets;

use Tivins\Assets\Stylesheet\Media;
use Tivins\Assets\Stylesheet\Property;
use Tivins\Assets\Stylesheet\Rule;
use Tivins\Assets\Stylesheet\RuleSet;
use Tivins\Assets\Stylesheet\Stylesheet;
use Tivins\Assets\Stylesheet\Value;
use Tivins\Assets\Stylesheet\ValueType;
use Tivins\Core\System\File;
use Tivins\Core\System\FileSys;

class Assets
{
    public static function compile3(string $publicDir): void
    {
        $css = '/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */

/* Document
   ========================================================================== */

/**
 * 1. Correct the line height in all browsers.
 * 2. Prevent adjustments of font size after orientation changes in iOS.
 */

html {
  line-height: 1.15; /* 1 */
  -webkit-text-size-adjust: 100%; /* 2 */
}

/* Sections
   ========================================================================== */

/**
 * Remove the margin in all browsers.
 */

body {
  margin: 0;
}

/**
 * Render the `main` element consistently in IE.
 */

main {
  display: block;
}
';
    }
    public static function compile2(string $publicDir): void
    {
        $normalize = new Stylesheet();
        $defaultMedia = new Media();

        $normalize->addRuleset(
            (new RuleSet())
                ->setMedia($defaultMedia)
                ->setSelectors('html')
                ->addRules(
                    new Rule(Property::lineHeight, new Value(ValueType::NUMBER, 1.5)),
                    new Rule(Property::webkitTextSizeAdjust, new Value(ValueType::PERCENT, 100)),
                )
        );
        $normalize->addRuleset(
            (new RuleSet())
                ->setMedia($defaultMedia)
                ->setSelectors('body')
                ->addRules(
                    new Rule(Property::margin, new Value(ValueType::NUMBER, 0)),
                )
        );
        $normalize->addRuleset(
            (new RuleSet())
                ->setMedia($defaultMedia)
                ->setSelectors('main')
                ->addRules(
                    new Rule(Property::display, new Value(ValueType::STR, 'block')),
                )
        );
        $normalize->addRuleset(
            (new RuleSet())
                ->setMedia($defaultMedia)
                ->setSelectors('h1')
                ->addRules(
                    new Rule(Property::fontSize, new Value(ValueType::EM, 2)),
                    new Rule(Property::margin, new Value(ValueType::STR, ".67em 0")),
                )
        );
        $normalize->addRuleset(
            (new RuleSet())
                ->setMedia($defaultMedia)
                ->setSelectors('hr')
                ->addRules(
                    new Rule(Property::boxSizing, new Value(ValueType::STR, 'content-box')),
                    new Rule(Property::height, new Value(ValueType::NUMBER, 0)),
                    new Rule(Property::overflow, new Value(ValueType::STR, 'visible')),
                )
        );
/*

pre {
  font-family: monospace, monospace;
    font-size: 1em;
}
*/

        echo $normalize;
        exit;
    }

    public static function compile(string $publicDir): void
    {
        self::buildCSS($publicDir.'/assets/css/all.css');
        self::buildJS($publicDir.'/assets/js');
    }

    public static function buildCSS(string $outfile): void
    {
        $dir        = __dir__ . '/Front/css';
        $sources    = [
            $dir . '/font.css',
            $dir . '/normalize.css',
            $dir . '/layout.css',
            $dir . '/highlight.css',
            $dir . '/markdown.css',
            $dir . '/over.css',
        ];
        $lastUpdate = max(array_map('filemtime', $sources));
        $lastBuild  = File::isReadable($outfile) ? filemtime($outfile) : 0;
        if ($lastUpdate < $lastBuild)
            return;

        File::save($outfile, "/*! all.css v1.0.1 | MIT License | github.com/tivins/assets */\n");
        foreach ($sources as $source) {
            File::save(
                $outfile,
                data: "/* $source */\n" . File::load($source) . "\n\n",
                append: true
            );
        }
    }
    public static function buildJS(string $outDir): void
    {
        $inDir    = __dir__ . '/Front/js';
        $iterator = FileSys::getIterator($inDir);
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }
            $inFile = $file->getPathname();
            $outFile = str_replace($inDir, $outDir, $inFile);
            if (!File::isReadable($outFile) || filemtime($outFile) < filemtime($inFile)) {
                $pfx = '/*! '.gmdate('r').' */'."\n\n";
                File::save($outFile, $pfx . File::load($inFile));
            }
        }
    }
}