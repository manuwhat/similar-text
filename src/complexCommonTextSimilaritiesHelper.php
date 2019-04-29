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
    
    class complexCommonTextSimilaritiesHelper extends simpleCommonTextSimilarities
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
            $matches = array();
            $bool = is_string($url) && preg_match('/\./', $url) && preg_match(self::URL_POSIX_FORMAT, $url) && preg_match(self::URL_FORMAT_EXTENDED_PATTERN, $url, $matches);
            $getDomain = $bool ? self::getDomain($url, $matches[1]) : '';
            return $bool;
        }
        
        protected static function getDomain($url, $match)
        {
            return ($getDomain = explode('.', parse_url($url, $match ? PHP_URL_HOST : PHP_URL_PATH))) ? (($c = count($getDomain)) > 1 ? ($getDomain[$c - 2]) : '') : '';
        }
        
        
        protected static function filter(&$a, &$b, $filter, $insensitive = true, $captureLength = false)
        {
            if ($insensitive) {
                $a = array_filter(self::getParts(self::strtolower($a), $c, $captureLength), $filter);
                if ($c === 1) {
                    $a = self::strtolower($a);
                }
                $b = array_filter(self::getParts(self::strtolower($b), $c, $captureLength), $filter);
                if ($c === 1) {
                    $b = self::strtolower($b);
                }
            } else {
                $a = array_filter(self::getParts(self::split($a), $c, $captureLength), $filter);
                if ($c === 1) {
                    $a = self::strtolower($a);
                }
                $b = array_filter(self::getParts(self::split($b), $c, $captureLength), $filter);
                if ($c === 1) {
                    $b = self::strtolower($b);
                }
            }
        }
        
        
        protected static function waorDiff($a, $b, $ca, $cb)
        {
            return (bool) (($ca > $cb) ?array_diff_assoc(array_values($a), array_values($b)) : array_diff_assoc(array_values($b), array_values($a)));
        }
        
        
        
        protected static function aoeStemming($a, $b)
        {
            foreach ($a as $index=>$word) {
                if (!self::haveSameRoot($word[0], $b[$index][0]) || ($a[$index][1] > 2 && $b[$index][1] > 2)) {
                    return false;
                }
            }
            return true;
        }
    }
}
