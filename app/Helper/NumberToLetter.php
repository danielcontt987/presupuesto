<?php

if (!function_exists('numberToLetter')) {
    function numberToLetter($number)
    {
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);

        $integer = (int) floor($number);
        $decimal = (int) round(($number - $integer) * 100);

        $text = ucfirst($formatter->format($integer)) . " pesos";
        $text .= " " . str_pad($decimal, 2, '0', STR_PAD_LEFT) . "/100 M.N.";

        return $text;
    }
}
