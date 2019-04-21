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
    use EZAMA\simpleCommonTextSimilarities;
    use EZAMA\complexCommonTextSimilarities;

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
        return simpleCommonTextSimilarities::areAnagrams($a, $b);
    }
    
    function similarButNotEqual($a, $b)
    {
        return   simpleCommonTextSimilarities::similarButNotEqual($a, $b);
    }
    
    function aIsSuperStringOfB($a, $b)
    {
        return simpleCommonTextSimilarities::aIsSuperStringOfB($a, $b);
    }
        
    function haveSameRoot($a, $b)
    {
        return simpleCommonTextSimilarities::haveSameRoot($a, $b);
    }
    
    function wordsReorderOccured($a, $b, $considerPunctuation = true)
    {
        return simpleCommonTextSimilarities::wordsReorderOccured($a, $b, $considerPunctuation);
    }
    
    function punctuactionChangesOccured($a, $b, $considerSpace = true)
    {
        return complexCommonTextSimilarities::punctuactionChangesOccured($a, $b, $considerSpace);
    }
    
    function areStems($a, $b)
    {
        return complexCommonTextSimilarities::areStems($a, $b);
    }
    
    function strippedUrl($a, $b)
    {
        return complexCommonTextSimilarities::strippedUrl($a, $b);
    }
    
    function acronymOrExpanded($a, $b)
    {
        return complexCommonTextSimilarities::acronymOrExpanded($a, $b);
    }
    
    function wordsAddedOrRemoved($a, $b)
    {
        return complexCommonTextSimilarities::wordsAddedOrRemoved($a, $b);
    }
}
