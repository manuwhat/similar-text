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
    
    class complexCommonTextSimilarities extends complexCommonTextSimilaritiesHelper
    {
        public static function strippedUrl($a, $b)
        {
            if (self::isUrl($a, $domain) && is_string($b)) {
                return $domain === trim($b);
            } elseif (self::isUrl($b, $domain) && is_string($a)) {
                return $domain === trim($a);
            } else {
                return false;
            }
        }
        public static function areStems($a, $b)
        {
            if (!is_string($a) || !is_string($b)) {
                return false;
            }
            
            $a = self::getParts(self::strtolower($a));
            $b = self::getParts(self::strtolower($b));
            foreach ((array) $a as $index=>$word) {
                if (!self::haveSameRoot($word, $b[$index])) {
                    return false;
                }
            }
            return true;
        }
        
        public static function wordsAddedOrRemoved($a, $b)
        {
            if (!is_string($a) || !is_string($b)) {
                return false;
            }
            $filter = function ($v) {
                return !(ctype_space($v));
            };
            self::filter($a, $b, $filter, true);
            return self::waorDiff($a, $b, count($a), count($b));
        }
        
        
        public static function punctuationChangesOccured($a, $b, $insensitive = true, $considerSpace = true)
        {
            $filter = function ($v) use ($considerSpace) {
                return $considerSpace ? !(ctype_space($v) || ctype_punct($v)) : !ctype_punct($v);
            };
            if (!is_string($a) || !is_string($b)) {
                return false;
            }
            self::filter($a, $b, $filter, $insensitive);
            return empty(array_diff($a, $b));
        }
        
        
        public static function acronymOrExpanded($a, $b)
        {
            if (!is_string($a) || !is_string($b)) {
                return false;
            }
            $filter = function ($v) {
                return !(ctype_space($v[0]) || ctype_punct($v[0]));
            };
            
            self::filter($a, $b, $filter, true, true);
            return self::aoeStemming($a, $b);
        }
    }
}
