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
    class hammingDistance extends Distance
    {
        public static function hamming($a, $b)
        {
            if (!is_string($a)||!is_string($b)||(strlen($a)!==strlen($b))) {
                return false;
            }
            static $distance=0;
            static $previous=array();
            if (array($a,$b)===$previous) {
                return $distance;
            }
            $previous=array($a,$b);
            $a=self::split($a);
            $b=self::split($b);
            $distance=count(array_diff_assoc((array)$a, (array)$b));
            return $distance;
        }
    }
    
    
}
