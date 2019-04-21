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
    use EZAMA\commonTextSimilarities;

    function SimilarText(
        $firstString,
        $secondString,
        $round = 2,
        $insensitive = true,
        &$stats = false,
        $getParts = false,
        $checkposition=false
                        ) {
        return similar_text::similarText(
            $firstString,
            $secondString,
            $round,
            $insensitive,
            $stats,
            $getParts
                                        );
    }
    
    function areAnagrams($a, $b)
    {
        return commonTextSimilarities::areAnagrams($a, $b);
    }
    
    function similarButNotEqual($a, $b)
    {
        return   commonTextSimilarities::similarButNotEqual($a, $b);
    }
    
    function aIsSuperStringOfB($a, $b)
    {
        return commonTextSimilarities::aIsSuperStringOfB($a, $b);
    }
        
    function haveSameRoot($a, $b)
    {
        return commonTextSimilarities::haveSameRoot($a, $b);
    }
    
    function wordsReorderOccured($a, $b, $considerPunctuation=true)
    {
        return commonTextSimilarities::wordsReorderOccured($a, $b, $considerPunctuation);
    }
    
    function punctuactionChangesOccured($a, $b, $considerSpace=true)
    {
        return commonTextSimilarities::punctuactionChangesOccured($a, $b, $considerSpace);
    }
    
    function areStems($a, $b)
    {
        return commonTextSimilarities::areStems($a, $b);
    }
    
    function strippedUrl($a, $b)
    {
        return commonTextSimilarities::strippedUrl($a, $b);
    }
    
    function acronymOrExpanded($a, $b)
    {
        return commonTextSimilarities::acronymOrExpanded($a, $b);
    }
    
    function wordsAddedOrRemoved($a, $b)
    {
        return commonTextSimilarities::wordsAddedOrRemoved($a, $b);
    }
}
