<?php

/**
*
* @Name : similar-text
* @Programmer : Akpé Aurelle Emmanuel Moïse Zinsou
* @Date : 2019-04-01
* @Released under : https://github.com/manuwhat/similar-text/blob/master/LICENSE
* @Repository : https://github.com/manuwhat/similar
*
**/


namespace EZAMA{
    class diceDistance extends distance
    {
        public static function dice($a, $b, $round = 2)
        {
            if ($distance = in_array(self::handleVeryCommonDiceCases($a, $b), array(false, 0.0, 1.0), true)) {
                return $distance;
            }
            static $distance = 0;
            static $previous = array();
            if (array($a, $b) === $previous) {
                return $distance;
            }
            $previous = array($a, $b);
            $a = self::split($a, 2);
            $b = self::split($b, 2);
            self::diceDistance($distance, $a, $b, $round);
            return $distance;
        }
        
        private static function handleVeryCommonDiceCases(&$a, &$b)
        {
            if (!is_string($a) || !is_string($b)) {
                return false;
            }
            if (empty($a) || empty($b)) {
                return 0.0;
            }
            if ($a === $b) {
                return 1.0;
            }
        }
        
        private static function diceDistance(&$distance, &$a, &$b, $round)
        {
            $ca = ($caGrams = count($a)) * 2 - self::getEndStrLen($a);
            $cb = ($cbGrams = count($b)) * 2 - self::getEndStrLen($b);
            $distance = round(2 * count($caGrams > $cbGrams ?array_intersect($a, $b) : array_intersect($b, $a)) / ($ca + $cb), $round);
        }
        
        private static function getEndStrLen($a)
        {
            if (function_exists('array_key_last')) {
                $end = array_key_last($a);
                $end = count(self::split($end))>1 ? 0 : 1;
            } else {
                $end = end($a);
                $end = count(self::split($end))>1 ? 0 : 1;
                reset($a);
            }
            return $end;
        }
    }
}
