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
namespace{
    use EZAMA\similar_text;
    use EZAMA\Distance;

    function SimilarText(
        $firstString,
        $secondString,
        $round = 2,
        $insensitive = true,
        &$stats = false,
        $getParts = false,
        $checkposition = false
                        ) {
        return similar_text::similarText(
            $firstString,
            $secondString,
            $round,
            $insensitive,
            $stats,
            $getParts,
            $checkposition
                                        );
    }
    
    function areAnagrams($a, $b)
    {
        return Distance::areAnagrams($a, $b);
    }
    
    function similarButNotEqual($a, $b)
    {
        return   Distance::similarButNotEqual($a, $b);
    }
    
    function aIsSuperStringOfB($a, $b)
    {
        return Distance::aIsSuperStringOfB($a, $b);
    }
        
    function haveSameRoot($a, $b)
    {
        return Distance::haveSameRoot($a, $b);
    }
    
    function wordsReorderOccured($a, $b, $considerPunctuation = true)
    {
        return Distance::wordsReorderOccured($a, $b, $considerPunctuation);
    }
    
    function punctuationChangesOccured($a, $b, $considerSpace = true)
    {
        return Distance::punctuationChangesOccured($a, $b, $considerSpace);
    }
    
    function areStems($a, $b)
    {
        return Distance::areStems($a, $b);
    }
    
    function strippedUrl($a, $b)
    {
        return Distance::strippedUrl($a, $b);
    }
    
    function acronymOrExpanded($a, $b)
    {
        return Distance::acronymOrExpanded($a, $b);
    }
    
    function wordsAddedOrRemoved($a, $b)
    {
        return Distance::wordsAddedOrRemoved($a, $b);
    }
    
    function _levenshtein($a, $b)
    {
        return Distance::levenshtein($a, $b);
    }
    
    
    function levenshteinDamerau($a, $b)
    {
        return Distance::levenshteinDamerau($a, $b);
    }
    
    
    function dice($a, $b, $round=2)
    {
        return Distance::dice($a, $b, $round);
    }
    
    
    function hamming($a, $b)
    {
        return Distance::hamming($a, $b);
    }
    
    
    function jaroWinkler($a, $b, $round=2)
    {
        return Distance::jaroWinkler($a, $b, $round);
    }
    
}
