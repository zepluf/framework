<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/15/12
 * Time: 11:53 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests;

use Zepluf\Bundle\StoreBundle\Entity\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Address();
    }

    public function testGetSetId()
    {
        $this->object->setId(1);
        $this->assertEquals(1, $this->object->getId());
    }

    public function testGetSetAccountId()
    {
        $this->object->setAccountId(2);
        $this->assertEquals(2, $this->object->getAccountId());
    }

    public function testGetSetFirstName()
    {
        $this->object->setFirstName('Tuan de thuong');
        $this->assertEquals('Tuan de thuong', $this->object->getFirstName());
    }

    public function testGetSetLastName()
    {
        $this->object->setLastName('Nguyen');
        $this->assertEquals('Nguyen', $this->object->getLastName());
    }

    public function testGetSetGender()
    {
        $this->object->setGender('m');
        $this->assertEquals('m', $this->object->getGender());
        $this->object->setGender('f');
        $this->assertEquals('f', $this->object->getGender());
    }

    public function testGetSetCompanyName()
    {
        $this->object->setCompanyName('Rubikin');
        $this->assertEquals('Rubikin', $this->object->getCompanyName());
    }

    public function testGetSetAddressLine1()
    {
        $this->object->setAddressLine1('1 Nguyen Hue');
        $this->assertEquals('1 Nguyen Hue', $this->object->getAddressLine1());
    }

    public function testGetSetSuburb()
    {
        $this->object->setSuburb('Hoc Mon');
        $this->assertEquals('Hoc Mon', $this->object->getSuburb());
    }

    public function testGetSetPostcode()
    {
        $this->object->setPostcode('12345');
        $this->assertEquals('12345', $this->object->getPostcode());
    }

    public function testGetSetCity()
    {
        $this->object->setCity('NT');
        $this->assertEquals('NT', $this->object->getCity());
    }

    public function testGetSetState()
    {
        $this->object->setState('California');
        $this->assertEquals('California', $this->object->getState());
    }

    public function testGetSetZoneId()
    {
        $this->object->setZoneId(15612);
        $this->assertEquals(15612, $this->object->getZoneId());
    }

//    public function testGetSetCountry()
//    {
//        $country = new Country;
//        $this->object->setCountry($country);
//        $this->assertSame($country, $this->object->getCountry());
//    }

    public function testGetSetCountryId()
    {
        $this->object->setCountryId(15612);
        $this->assertEquals(15612, $this->object->getCountryId());
    }

    public function testGetSetPrimary()
    {
        $this->object->setPrimary(true);
        $this->assertEquals(true, $this->object->isPrimary());
    }

    //What's this for?
    public function testGetSetFormat()
    {
        $this->object->setFormat('??');
        $this->assertEquals('??', $this->object->getFormat());
    }

    public function testGetFullName()
    {
        $this->object->setFirstName("Tuan");
        $this->object->setLastName("Nguyen");
        $this->assertEquals('Tuan Nguyen', $this->object->getFullName());
    }

//    public function testGetAddressFormatId()
//    {
//        $country = $this->getMock('Country');
//        $country->expects($this->once())
//            ->method('getAddressFormatId')
//            ->will($this->returnValue('1'));
//        $this->object->setCountry($country);
//        $this->assertEquals('1', $this->object->getAddressFormatId());
//    }

//    public function testGetAddressFormat()
//    {
//
//    }

    public function tearDown()
    {
        unset($this->object);
    }
}