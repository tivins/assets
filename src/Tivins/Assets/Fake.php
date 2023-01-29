<?php

namespace Tivins\Assets;

class Fake
{
    static array $paragraphs;

    static public function paragraph(): string
    {
        self::load();
        $key = array_rand(self::$paragraphs);
        return self::$paragraphs[$key];
    }

    static public function sentence(int $qty = 1): string
    {
        $sentences = array_filter(explode('. ', self::paragraph() . ' '));
        $out       = [];
        while ($qty--) {
            $key   = array_rand($sentences);
            $out[] = trim($sentences[$key], " \r\n\t.") . '.';
        }
        return join(' ', $out);
    }

    static public function words(int $count): string
    {
        $sentence = self::sentence();
        $words    = explode(' ', $sentence);
        $words    = array_filter($words, fn($w) => strlen($w) > 4);
        $start    = rand(0, count($words) - 1 - $count);
        return join(' ', array_map(
                fn($word) => trim($word, ',.;'),
                array_splice($words, $start, $count)
            )
        );
    }

    static public function name(): string
    {
        return ucwords(self::words(2));
    }

    static public function timestamp($since = '2000-01-01', $to = 'now'): string
    {
        return rand(strtotime($since), strtotime($to));
    }

    static public function number(string|int $max = 'dk'): string
    {
        return rand(0, is_int($max) ? $max : match ($max) {
            'd' => 10,
            'u' => 100,
            'k' => 1000,
            'dk' => 10000,
            'uk' => 100000,
            'm' => 1000000,
        }
        );
    }

    static private function load(): void
    {
        if (isset(self::$paragraphs)) return;
        self::$paragraphs = file(__file__ . '.data');
    }
}