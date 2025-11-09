<?php

use NumberFormatter as IntlNumberFormatter;


if (!function_exists('numberToLetter')) {
    function numberToLetter($number)
    {
        $formatter = new IntlNumberFormatter('es', IntlNumberFormatter::SPELLOUT);

        $integer = floor($number);
        $decimal = round(($number - $integer) * 100);

        $text = ucfirst($formatter->format($integer)) . " pesos";
        $text .= $decimal > 0 ? " {$decimal}/100 M.N." : " 00/100 M.N.";

        return $text;
    }
}
