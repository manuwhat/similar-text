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
    
    class complexCommonTextSimilarities extends simpleCommonTextSimilarities
    {
        const URL_FORMAT_EXTENDED_PATTERN = '/^((https?|ftps?|file):\/\/){0,1}'.// protocol
                                            '(([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+'.// username
                                            '(:([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+)?'.// password
                                            '@)?(?#'.// auth requires @
                                            ')((([a-z0-9]\.|[a-z0-9][a-z0-9-]*[a-z0-9]\.)*'.// domain segments AND
                                            '[a-z][a-z0-9-]*[a-z0-9]'.// top level domain OR
                                            '|((\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])\.){3}'.
                                            '(\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])'.// IP address
                                            ')(:\d+)?'.// port
                                            ')(((\/+([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)*'.// path
                                            '(\?([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)'.// query string
                                            '?)?)?'.// path and query string optional
                                            '(#([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)?'.// fragment
                                            '$/i';




        const URL_POSIX_FORMAT = '"^(\b(https?|ftps?|file):\/\/)?[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/%=~_|]$"i';
        
        protected static function isUrl($url, &$getDomain = '')
        {
            $matches=array();
            $bool= is_string($url) && preg_match('/\./', $url) && preg_match(self::URL_POSIX_FORMAT, $url) && preg_match(self::URL_FORMAT_EXTENDED_PATTERN, $url, $matches);
            $getDomain = $bool && ($getDomain = explode('.', parse_url($url, $matches[1] ? PHP_URL_HOST : PHP_URL_PATH))) ? (($c = count($getDomain)) > 1 ? ($getDomain[$c-2]) : '') : '';
            return $bool;
        }
        
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
            foreach ($a as $index=>$word) {
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
            $filter = function($v) {
                return !(ctype_space($v));
            };
            self::filter($a, $b, $filter, true);
            return self::waorDiff($a, $b, count($a), count($b));
        }
        
        private static function filter(&$a, &$b, $filter, $insensitive = true)
        {
            if ($insensitive) {
                $a = array_filter(self::getParts(self::strtolower($a)), $filter);
                $b = array_filter(self::getParts(self::strtolower($b)), $filter);
            } else {
                $a = array_filter(self::getParts(self::split($a)), $filter);
                $b = array_filter(self::getParts(self::split($b)), $filter);
            }
        }
        
        private static function waorDiff($a, $b, $ca, $cb)
        {
            return (bool) (($ca > $cb) ?array_diff_assoc(array_values($a), array_values($b)) : array_diff_assoc(array_values($b), array_values($a)));
        }
        
        
        public static function punctuactionChangesOccured($a, $b, $insensitive = true, $considerSpace = true)
        {
            $filter = function($v) use ($considerSpace) {
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
            $filter = function($v) {
                return !(ctype_space($v) || ctype_punct($v));
            };
            
            self::filter($a, $b, $filter, true);
            return self::aoeStemming($a, $b);
        }
        
        private static function aoeStemming($a, $b)
        {
            foreach ($a as $index=>$word) {
                if (!self::haveSameRoot($word, $b[$index]) || (isset($a[$index][2]) && isset($b[$index][2]))) {
                    return false;
                }
            }
            return true;
        }
    }
}
