<?php

namespace Tivins\Assets\Tools;

class Fake
{
    static public function timestamp($since = '2000-01-01', $to = 'now'): string
    {
        return rand(strtotime($since), strtotime($to));
    }

    static public function name(): string
    {
        return ucwords(self::words(2));
    }

    static public function paragraph(): string
    {
        self::load();
        $key = array_rand(self::$paragraphs);
        return self::$paragraphs[$key];
    }

    static public function sentence(int $qty = 1, float $withNumbers = 0.0): string
    {
        $sentences = array_filter(explode('. ', self::paragraph() . ' '));
        $out       = [];
        while ($qty--) {
            $key      = array_rand($sentences);
            $sentence = trim($sentences[$key], " \r\n\t.") . '.';
            if ($withNumbers > PHP_FLOAT_EPSILON) {
                $words  = explode(' ', $sentence);
                $nWords = [];
                foreach ($words as $k => $word) {
                    if (rand(0, 99) < $withNumbers * 100) {
                        $nWords[] = number_format(self::number());
                    }
                    $nWords[] = $word;
                }
                $sentence = join(' ', $nWords);
            }
            $out[] = $sentence;
        }
        return join(' ', $out);
    }

    static public function words(int $count = 1): string
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

    static public function getAddress1(object $addressStruct): string
    {
        return "$addressStruct->nb $addressStruct->way $addressStruct->street";
    }

    static public function addressStruct(): object
    {
        $ways = ['rue','impasse','avenue','boulevard','allée','chemin'];
        $countries = ['France','Span','Italy','Germany','United Kingdom','Belgium'];
        //
        $address = (object)[];
        $address->nb = self::number(1000);
        $address->way = self::anyOf($ways);
        $address->street = self::name();
        $address->complement = rand(0,99)<50?'':self::words(5);
        $address->postCode = self::number(100000);
        $address->city = self::name();
        $address->country = self::anyOf($countries);
        return $address;
    }

    static public function anyChance(float $probability = 50): bool {
        return rand(0,99) < $probability;
    }

    static public function anyOf(array $items): mixed {
        $key = array_rand($items);
        return $items[$key];
    }

    // ------------------ DATA ------------------

    static private array $paragraphs;
    static private function load(): void
    {
        if (isset(self::$paragraphs)) return;
        self::$paragraphs = file(__file__ . '.data');
    }

    public static function email(): string
    {
        return str_replace(' ','-',strtolower(self::name()))
            . '@'
            . str_replace(' ','-',strtolower(self::name()))
            . '.' . self::anyOf(['com','org','io','me']);
    }
}