<?php

namespace Salamek\Doctrine\DBAL\Types\Tests;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Salamek\DateRange;
use Salamek\Doctrine\DBAL\Types\DateRangeType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;

/**
 * Class DateRangeTypeTest
 * @package Salamek\Doctrine\DBAL\Types\Tests
 */
class DateRangeTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractPlatform */
    protected $platform;

    /** @var DateRangeType */
    protected $type;

    public function testConvertToDatabaseValue()
    {
        $range = new DateRange(new \DateTime('2016-06-23'), (new \DateTime('2016-06-23'))->modify('+1 year'));

        $this->assertEquals(
            '[2016-06-23,2017-06-23]',
            $this->type->convertToDatabaseValue($range, $this->platform)
        );
        $this->assertNull(
            $this->type->convertToDatabaseValue(null, $this->platform)
        );
    }

    public function testConvertToPHPValueInvalid()
    {
        $this->setExpectedException(
            'Doctrine\\DBAL\\Types\\ConversionException'
        );

        $this->type->convertToPHPValue('abcd', $this->platform);
    }

    public function testConvertToPHPValue()
    {
        $range = $this->type->convertToPHPValue('[2016-10-10,2016-12-10]', $this->platform);

        $this->assertEquals(new \DateTime('2016-10-10'), $range->getStartDate());
        $this->assertEquals(new \DateTime('2016-12-10'), $range->getEndDate());
        $this->assertNull(
            $this->type->convertToPHPValue(null, $this->platform)
        );
    }

    protected function setUp()
    {
        $this->platform = new PostgreSqlPlatform();
        $this->type = Type::getType('daterange');
    }
}