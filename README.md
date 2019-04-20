PHP Similar Text Percentage: Compare two strings to compute a similarity score
==============================================================================

[![Build Status](https://travis-ci.org/manuwhat/similar-text.svg?branch=master)](https://travis-ci.org/manuwhat/similar-text)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/manuwhat/similar-text/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/manuwhat/similar-text/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/manuwhat/similar-text/badges/build.png?b=master)](https://scrutinizer-ci.com/g/manuwhat/similar-text/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/manuwhat/similar-text/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
Library which help to Compare two strings to compute a similarity score and get stats on how linked are the strings.


**Requires**: PHP 5.3+


### What this library exactly does?
this library can compare two strings to compute a similarity score.

It takes the text of two strings and analyze them using pure PHP code to evaluate how equal they are.

The class returns a number that represents a percentage of the two strings to tell the level of similarity.

Based on the stats provided It actually can help to detect similarity even if these cases occurred :
WORD REORDER,WHITESPACE AND PUNCTUATION,REMOVE WORDS,ADD WORDS,URL STRIPPING,
FORM ACRONYM,EXPAND ACRONYM,STEMMING,SUBSTRING ,SUPERSTRING,ABBREVIATION ,ANAGRAM


### How to use it

Require the library by issuing this command:

```bash
composer require manuwhat/similar-text
```

Add `require 'vendor/autoload.php';` to the top of your script.

Next, use it in your script, just like this:

```php
use ezama/similar-text;

100.0===similarText('qwerty', 'ytrewq')
```

This is an example of how to use the stats to check a special case.Here we will use them to check about anagrams
(note that this has already been implemented in the library) 

```php
function areAnagrams($a, $b)
{
	return  Ezama\similar_text::similarText($a, $b, 2, true, $check)?$check['similar'] === 100.0&&$check['contain']===true:false;
}

areAnagrams('qwerty', 'ytrewq');// return true;

```



###How To run unit tests 
```bash
phpunit  ./tests
```
