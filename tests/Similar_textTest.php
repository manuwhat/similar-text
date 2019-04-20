<?php
namespace Ezama\tests{
    require dirname(__DIR__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'similar_text.php';


    use PHPUnit\Framework\TestCase;

    class similar_textTest extends TestCase
    {
        public function testSimilarText()
        {
            $this->assertTrue(100.0===similarText('qwerty', 'ytrewq'));
            $this->assertTrue(similarText('qwerty', 'ytreq')>=80);
            $this->assertTrue(similarButNotEqual('qwerty', 'ytrewq'));
            $this->assertTrue(areAnagrams('qwerty', 'ytrewq'));
            $this->assertTrue(0.0===similarText('qwerty', ';lkjhg'));
        }
    }
}
