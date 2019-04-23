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
    
    
    class simpleCommonTextSimilarities extends similar_text
    {
        public static function areAnagrams($a, $b)
        {
            return  self::similarText($a, $b, 2, true, $check) && $check['similar'] === 100.0 && $check['contain'] === true;
        }
        
        public static function similarButNotEqual($a, $b)
        {
            return self::similarText($a, $b, 2, true, $check) && is_array($check) && $check['similar'] === 100.0 && $check['equal'] === false;
        }
        
        public static function aIsSuperStringOfB($a, $b)
        {
            if (strlen($a) > strlen($b)) {
                return   self::similarText($a, $b, 2, true, $check) && is_array($check) && $check['substr'] === 100.0;
            } else {
                return false;
            }
        }
        
        public static function wordsReorderOccured($a, $b, $considerPunctuation = true)
        {
            $filter = function($v) use ($considerPunctuation) {
                return $considerPunctuation ? !(ctype_space($v) || ctype_punct($v)) : !ctype_space($v);
            };
            return self::similarText($a, $b, 2, true, $check, true) && is_array($check) && self::wro_filter($check, $filter) ?true :false;
        }
        
        private static function wro_filter($check, $filter)
        {
            return  empty(array_filter($check['a-b'], $filter)) && empty(array_filter($check['b-a'], $filter)) && $check['substr'] && !$check['equal'];
        }
        
        public static function haveSameRoot($a, $b)
        {
            return self::similarText($a, $b, 2, true, $check, true, true) && is_array($check) && range(0, count($check['a&b']) - 1) === array_keys($check['a&b'])/*?true:false*/;
        }
    }
}
