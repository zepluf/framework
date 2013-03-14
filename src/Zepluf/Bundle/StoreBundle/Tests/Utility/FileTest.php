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

use Zepluf\Bundle\StoreBundle\Utility\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function testGetRelativePath()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $from = __DIR__;
        $to = __DIR__ . '/../Fixtures/Utility';
        $path = $this->object->getRelativePath($from, $to);
        $this->assertEquals('../Fixtures/Utility', $path);
    }

    public function testCalculatePath()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $stringUtility
            ->expects($this->once())
            ->method('stripNonAlphaNumeric')
            ->with($this->equalTo(strtolower('testname')))
            ->will($this->returnValue('testname'));

        $this->object = new File($stringUtility);

        $path = $this->object->calculatePath('testname', __DIR__ . '/', 4);
        $this->assertEquals(__DIR__ . '/t/e/s/t', $path);
    }

    public function testSureRemoveDir()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $dir = __DIR__ . '/../Fixtures/Utility/DirToRemove/';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $fileHandle = fopen($dir . 'testFile.txt', 'w') or die("can't open file");

        $stringData = "Bobby Bopper\n";
        fwrite($fileHandle, $stringData);
        $stringData = "Tracy Tanner\n";
        fwrite($fileHandle, $stringData);

        fclose($fileHandle);

        $this->assertTrue(file_exists($dir) && is_dir($dir));

        $this->object->sureRemoveDir($dir, true);
        $this->assertTrue(!file_exists($dir));
    }

    public function testWrite()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $dir = __DIR__ . '/../Fixtures/Utility/';
        $data = "Hello world";
        $this->object->write($dir . 'FileWrite', $data);

        $file_contents = file_get_contents($dir . "FileWrite");
        $this->assertEquals($file_contents, $data);
    }

    public function testXCopy()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $source = __DIR__ . '/../Fixtures/Utility/xcopySource';
        $dest = __DIR__ . '/../Fixtures/Utility/xcopyDest';

        $sourceHandle = opendir($source);
        $sourceArray = array();
        while (false !== ($entry = readdir($sourceHandle))) {
            $sourceArray[] = $entry;
        }

        $this->object->xcopy($source, $dest);

        $destHandle = opendir($dest);
        $destArray = array();
        while (false !== ($entry = readdir($destHandle))) {
            $destArray[] = $entry;
        }

        //Assertion: Compare two dirs
        $this->assertEquals($sourceArray, $destArray);

        //Clear junks
        $this->object->sureRemoveDir($dest, true);
    }

    /**
     * test sanitizeFilename()
     */
    public function testSanitizeFilename()
    {
        $stringUtility = $this->getMock('Zepluf\Bundle\StoreBundle\Utility\String');
        $this->object = new File($stringUtility);

        $this->assertEquals('logo_orange.gif', $this->object->sanitizeFilename('--logö  _  __   ___   ora@@ñ--~gé--.gif'), '::sanitizeFilename() handles complex filename with specials chars');
        $this->assertEquals('coilstack', $this->object->sanitizeFilename('cOiLsTaCk'), '::sanitizeFilename() converts all characters to lower case');
        $this->assertEquals('cOiLsTaCk', $this->object->sanitizeFilename('cOiLsTaCk', 'default', '_', false), '::sanitizeFilename() lower case can be desactivated, passing false as the 4th argument');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename('coil stack'), '::sanitizeFilename() convert a white space to a separator');
        $this->assertEquals('coil-stack', $this->object->sanitizeFilename('coil stack', 'default', '-'), '::sanitizeFilename() can use a different separator as the 3rd argument');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename('coil          stack'), '::sanitizeFilename() removes successive white spaces to a single separator');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename('       coil stack'), '::sanitizeFilename() removes spaces at the beginning of the string');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename('coil   stack         '), '::sanitizeFilename() removes spaces at the end of the string');
        $this->assertEquals('coilstack', $this->object->sanitizeFilename('coil,,,,,,stack'), '::sanitizeFilename() removes non-ASCII characters');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename('coil_stack  '), '::sanitizeFilename() keeps separators');
        $this->assertEquals('coil_stack', $this->object->sanitizeFilename(' coil________stack'), '::sanitizeFilename() converts successive separators into a single one');
        $this->assertEquals('coil_stack.gif', $this->object->sanitizeFilename('cOil Stack.GiF'), '::sanitizeFilename() lower case filename and extension');
        $this->assertEquals('copy_of_coil.stack.exe', $this->object->sanitizeFilename('Copy of coil.stack.exe'), '::sanitizeFilename() keeps dots before the extension');
        $this->assertEquals('default.doc', $this->object->sanitizeFilename('____________.doc'), '::sanitizeFilename() returns a default file name if filename only contains special chars');
        $this->assertEquals('default.docx', $this->object->sanitizeFilename('     ___ -  --_     __%%%%__¨¨¨***____      .docx'), '::sanitizeFilename() returns a default file name if filename only contains special chars');
        $this->assertEquals('logo_edition_1314352521.jpg', $this->object->sanitizeFilename('logo_edition_1314352521.jpg'), '::sanitizeFilename() returns the filename untouched if it does not need to be modified');
        $userId = rand(1, 10);
        $this->assertEquals('user_doc_'. $userId. '.doc', $this->object->sanitizeFilename('亐亐亐亐亐.doc', 'user_doc_'. $userId), '::sanitizeFilename() returns the default string (the 2nd argument) if it can\'t be sanitized');
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
