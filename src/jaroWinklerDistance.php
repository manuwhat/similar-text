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
    class jaroWinklerDistance extends distance
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
                    self::_jwMatches($chr, $char, $index, $ind, $transpositions, $Δ);
                }
            }
        }
        
        private static function _jwMatches($chr, $char, $index, $ind, &$transpositions, $Δ)
        {
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
