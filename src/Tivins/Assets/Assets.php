<?php

namespace Tivins\Assets;

use Tivins\Core\System\File;

class Assets
{
    public static function buildCSS(string $outfile): void
    {
        $dir     = __dir__ . '/Front/css';
        $sources = [
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
}