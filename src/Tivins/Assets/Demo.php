<?php

namespace Tivins\Assets;

use ReflectionException;
use ReflectionFunction;
use Tivins\Core\StrUtil;

class Demo
{

    public static function unIndent(array $loc): array
    {
        $maxIndex = [];
        foreach ($loc as $line) {
            preg_match('~^(\s*)~', $line, $matches);
            $maxIndex[] = strlen($matches[1]);
        }
        $max = min($maxIndex);

        return array_map(fn($s) => substr($s, $max), $loc);
    }
    /**
     * @throws ReflectionException
     */
    public static function democb(string $info, callable $callback) {
        $api = new ReflectionFunction($callback);
        $lines = file($api->getFileName());
        $len = $api->getEndLine() - $api->getStartLine();

        $loc = array_splice($lines, $api->getStartLine(), $len -1);
        $loc[0] = str_replace('return ','echo ', $loc[0]);
        $code = (join(self::unIndent($loc)));
        return self::demo($info, $code, $callback());

    }
    public static function header(): string
    {
        return '<div class="d-flex-md gutter-sm py-2 b-bottom">'
            . '<div class="col-5 fw-bold text-center">PHP Code</div>'
            . '<div class="col-2 fw-bold text-center">Render</div>'
            . '<div class="col-5 fw-bold text-center">Generated HTML</div>'
            . '</div>';
    }
    public static function demo($info,$code,$html): Components\HTMLElement
    {
        // $code = (new \Tivins\Dev\PHPHighlight())->highlight('<' . '?' . 'php' . "\n\n" . $code);
        $code = '<pre class="h-100">' . htmlentities($code) . '</pre>';

        return Components::div('b-bottom',
            ($info ? Components::div('b-bottom p markdown-body', StrUtil::markdown('####' . $info)) : '')
            . Components::div('d-flex-md', ''
                . Components::div('col-5 markdown-body', $code)
                . Components::div('col-2 text-center py', $html)
                . '<div class="col-5 markdown-body "><pre class="h-100 max-w-100" style="max-width:100%;overflow:auto;">' . htmlentities($html) . '</pre></div>'
            )
        );
    }

}