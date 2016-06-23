<?php

namespace Salamek\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Salamek\DateRange;

/**
 * Class DateRangeType
 * @package Salamek\Doctrine\DBAL\Types
 */
class DateRangeType extends StringType
{
    const DATERANGE = 'daterange';

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : DateRange::toString($value);
    }

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|DateRange
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null !== $value) {
            if (false == preg_match('/^(\[|\()(\d{4})-(\d{2})-(\d{2}),(\d{4})-(\d{2})-(\d{2})(\]|\))$/', $value)) {
                throw ConversionException::conversionFailedFormat(
                    $value,
                    $this->getName(),
                    '(\[|\()(\d{4})-(\d{2})-(\d{2}),(\d{4})-(\d{2})-(\d{2})(\]|\))$'
                );
            }

            $value = DateRange::fromString($value);
        }

        return $value;
    }

    /**
     * @override
     * @return string
     */
    public function getName()
    {
        return self::DATERANGE;
    }
}