Doctrine DateRange Type
==========================

[![Build Status](https://travis-ci.org/Salamek/doctrine-daterange.svg?branch=master)](https://travis-ci.org/salamek/doctrine-daterange)

Supports PostgreSQL DateRange in Doctrine DBAL.

Summary
-------

The `DateRange` library

- adds a `daterange` type to DBAL

Installation
------------

Add it to your list of Composer dependencies:

```sh
composer require salamek/doctrine-daterange
```

Register it with Doctrine DBAL:

```php
<?php

use Doctrine\DBAL\Types\Type;
use Salamek\Doctrine\DBAL\Types\DateRangeType;

Type::addType(
    DateRangeType::DATERANGE,
    'Salamek\\Doctrine\\DBAL\\Types\\DateRangeType'
);
```

When using Symfony2 with Doctrine you can do the same as above by only changing your configuration:

```yaml
# app/config/config.yml

# Doctrine Configuration
doctrine:
    dbal:
        # ...
        mapping_types:
            daterange: daterange
        types:
            daterange:  Salamek\Doctrine\DBAL\Types\DateRangeType
```

Usage
-----

```php
<?php

/**
 * @Entity()
 * @Table(name="jobs")
 */
class Job
{
    /**
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @Id()
     */
    private $id;

    /**
     * @Column(type="daterange")
     */
    private $range;

    /**
     * @return \Salamek\DateRange
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param \Salamek\DateRange $range
     */
    public function setRange(\Salamek\DateRange $range)
    {
        $this->range = $range;
    }
}

$annualJob = new Job();
$annualJob->setRange(new \Salamek\DateRange(new \DateTime, (new \DateTime)->modify('+1 year')));

$entityManager->persist($annualJob);
$entityManager->flush();
$entityManager->clear();

$jobs = $entityManager->createQuery(
    "SELECT j FROM Jobs j"
)->getResult();

echo $jobs[0]->getRange()->getStartDate()->format(DateTime::ISO8601); // "NOW"
echo $jobs[0]->getRange()->getEndDate()->format(DateTime::ISO8601); //  "NOW +1 year"
```
