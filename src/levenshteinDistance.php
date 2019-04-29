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
    class levenshteinDistance extends distance
    {
        public static function levenshtein($a, $b)
        {
            if (!is_string($a)||!is_string($b)) {
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
            $ca = count((array)$a);
            $cb = count((array)$b);
            $dis = range(0, $cb);
            self::BuildLevenshteinCostMatrix($a, $b, $ca, $cb, $dis);

            return $distance=$dis[$cb];
        }
        
        
        public static function levenshteinDamerau($a, $b)
        {
            if (!is_string($a)||!is_string($b)) {
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
            $ca = count((array)$a);
            $cb = count((array)$b);
            $dis = range(0, $cb);
            self::BuildLevenshteinCostMatrix($a, $b, $ca, $cb, $dis, true);
        
            return $distance=$dis[$cb];
        }
        
        private static function BuildLevenshteinCostMatrix($a, $b, $ca, $cb, &$dis, $damerau=false)
        {
            $dis_new=array();
            for ($x=1;$x<=$ca;$x++) {
                $dis_new[0]=$x;
                for ($y=1;$y<=$cb;$y++) {
                    self::costMatrix($a, $b, $dis_new, $dis, $damerau, $x, $y);
                }
                $dis = $dis_new;
            }
        }
        
        private static function costMatrix(&$a, &$b, &$dis_new, &$dis, $damerau, $x, $y)
        {
            $c = ($a[$x-1] == $b[$y-1])?0:1;
            $dis_new[$y] = min($dis[$y]+1, $dis_new[$y-1]+1, $dis[$y-1]+$c);
            if ($damerau) {
                self::handleDamerau($a, $b, $dis_new, $dis, $x, $y ,$c);
            }
        }
		
		private static function handleDamerau(&$a, &$b, &$dis_new, &$dis, $x, $y, $c){
			if ($x > 1 && $y > 1 && $a[$x-1] == $b[$y-2] && $a[$x-2] == $b[$y-1]) {
                $dis_new[$y]= min($dis_new[$y-1], $dis[$y-3] + $c) ;
            }
		}
		
    }
}
