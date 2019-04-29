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
    class distance extends complexCommonTextSimilarities
    {
        public static function jaroWinkler($a, $b, $round=2)
        {
            if (!is_string($a)||!is_string($b)) {
                return false;
            }
            static $distance=array();
            static $previous=array();
            if (array($a,$b)===$previous) {
                return $distance;
            }
            $previous=array($a,$b);
            return self::getJWDistance($a, $b, $distance, $round);
        }
        
        
        
        private static function getJWDistance(&$a, &$b, &$distance, $round)
        {
            extract(self::prepareJaroWinkler($a, $b));
            for ($i=0,$min=min(count($a), count($b)),$t=0;$i<$min;$i++) {
                if ($a[$i]!==$b[$i]) {
                    $t++;
                }
            }
            $t/=2;
            $distance['jaro']=1/3*($corresponding/$ca+$corresponding/$cb+($corresponding-$t)/$corresponding);
            $distance['jaro-winkler']=$distance['jaro']+(min($longCommonSubstr, 4)*0.1*(1-$distance['jaro']));
            $distance=array_map(function ($v) use ($round) {
                return round($v, $round);
            }, $distance);
            
            return $distance;
        }
        
        private static function prepareJaroWinkler(&$a, &$b)
        {
            $a=self::split($a);
            $b=self::split($b);
            $transpositions=array('a'=>array(),'b'=>array(),'corresponding'=>0,'longCommonSubstr'=>0,'ca'=>count($a),'cb'=>count($b));
            $Δ=max($transpositions['ca'], $transpositions['cb'])/2-1;
            self::jwMatches($a, $b, $transpositions, $Δ);
            ksort($transpositions['a']);
            ksort($transpositions['b']);
            $transpositions['a']=array_values($transpositions['a']);
            $transpositions['b']=array_values($transpositions['b']);
            return $transpositions;
        }
        
        private static function jwMatches(&$a, &$b, &$transpositions, $Δ)
        {
            foreach ($a as $ind=>$chr) {
                foreach ($b as $index=>$char) {
                    if ($chr===$char&&(abs($index-$ind)<=$Δ)) {
                        if ($ind!==$index) {
                            $transpositions['a'][$ind]=$chr;
                            $transpositions['b'][$index]=$char;
                        } else {
                            if ($ind-1<=$transpositions['longCommonSubstr']) {
                                $transpositions['longCommonSubstr']++;
                            }
                        }
                        $transpositions['corresponding']++;
                    }
                }
            }
        }
        
        
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
            $distance=count(array_diff_assoc($a, $b));
            return $distance;
        }
        
        public static function dice($a, $b, $round=2)
        {
            if (!is_string($a)||!is_string($b)) {
                return false;
            }
            if (empty($a)||empty($b)) {
                return 0.0;
            }
            if ($a===$b) {
                return 1.0;
            }
            
            static $distance=0;
            static $previous=array();
            if (array($a,$b)===$previous) {
                return $distance;
            }
            $previous=array($a,$b);
            $a=self::split($a, 2);
            $b=self::split($b, 2);
            $ca=($caGrams=count($a))*2-self::getEndStrLen($a);
            $cb=($cbGrams=count($b))*2-self::getEndStrLen($b);
            $distance=round(2*count($caGrams>$cbGrams?array_intersect($a, $b):array_intersect($b, $a))/($ca+$cb), $round);
            return $distance;
        }
        
        private static function getEndStrLen($a)
        {
            if (function_exists('array_key_last')) {
                $end=array_key_last($a);
                $end=(isset($end[1]))?0:1;
            } else {
                $end=end($a);
                $end=(isset($end[1]))?0:1;
                reset($a);
            }
            return $end;
        }
        
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
            $ca = count($a);
            $cb = count($b);
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
            $ca = count($a);
            $cb = count($b);
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
                    $c = ($a[$x-1] == $b[$y-1])?0:1;
                    $dis_new[$y] = min($dis[$y]+1, $dis_new[$y-1]+1, $dis[$y-1]+$c);
                    if ($damerau) {
                        if ($x > 1 && $y > 1 && $a[$x-1] == $b[$y-2] && $a[$x-2] == $b[$y-1]) {
                            $dis_new[$y]= min($dis_new[$y-1], $dis[$y-3] + $c) ;
                        }
                    }
                }
                $dis = $dis_new;
            }
        }
    }
    
    
}
