<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/16/12
 * Time: 6:55 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Utility;

use \Zepluf\Bundle\StoreBundle\Utility\String;

class StringTest extends \Zepluf\Bundle\StoreBundle\Tests\BaseTestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new String();
    }

    public function testFromCamelCase()
    {
        $expectedString = 'hello_world_test_content';
        $content = 'helloWorldTestContent';
        $convertedString = String::fromCamelCase($content);
        $this->assertEquals($expectedString, $convertedString);
    }

    public function testToCamelCase()
    {
        $expectedString = 'helloWorldTestContent';

        $content = 'hello_world_test_content';
        $convertedString = String::toCamelCase($content);
        $this->assertEquals($expectedString, $convertedString);

        $content = 'hello-world-test-content';
        $convertedString = String::toCamelCase($content);
        $this->assertEquals($expectedString, $convertedString);

        $content = 'hello world test content';
        $convertedString = String::toCamelCase($content);
        $this->assertEquals($expectedString, $convertedString);
    }

    public function testNormalizeCharacters()
    {
        $content = 'hello� world�ܟ� test content �����';
        $expectedResult = 'hello world test content';
        $this->assertEquals($this->object->normalizeCharacters($content), $expectedResult);
    }

    public function testStripNonAlphaNumeric()
    {
        $expectedString = 'Loremipsumdolorsitametconsecteturadipiscingelit214';
        $content = 'Lorem@# ipsum$# do*&^lor s~~!it a%$met, cons@#@ectetur ad%*^ipiscing el$it 214';

        $convertedString = $this->object->stripNonAlphaNumeric($content);
        $this->assertEquals($expectedString, $convertedString);
    }

    public function testStripExcessWhitespace()
    {
        $expectedString = 'This is a test content';
        $content = 'This  is a         test content';

        $convertedString = $this->object->stripExcessWhitespace($content);
        $this->assertEquals($expectedString, $convertedString);
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
