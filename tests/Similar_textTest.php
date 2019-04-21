<?php
namespace Ezama\tests{
    require($dir=dirname(__DIR__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'similar_text.php';
    require $dir.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'commonTextSimilarities.php';
    require $dir.DIRECTORY_SEPARATOR.'similar_text.php';

    use PHPUnit\Framework\TestCase;

    class similar_textTest extends TestCase
    {
        public function testSimilarText()
        {
            $this->assertTrue(100.0===similarText('qwerty', 'ytrewq'));
            $this->assertTrue(similarText('qwerty', 'ytreq')>=80);
            $this->assertTrue(areAnagrams('qwerty', 'ytrewq'));
            $this->assertTrue(0.0===similarText('qwerty', ';lkjhg'));
            $this->assertTrue(haveSameRoot('qwerty', 'qwertyuiop'));
            $this->assertTrue(wordsReorderOccured('joker is a cloon.', 'a cloon is joker'));
            $this->assertTrue(similarButNotEqual('qwerty', 'ytrewq'));
            $this->assertTrue(StrippedUrl('yahoo.com', 'yahoo'));
            $this->assertTrue(acronymorExpanded('p.d.a', 'personal digital assistant'));
            $this->assertTrue(wordsAddedOrRemoved('personal digital', 'personal digital assistant'));
        }
    }
}
