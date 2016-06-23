<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Doctrine\\Tests', __DIR__ . '/../vendor/doctrine/dbal/tests');
$loader->add('Doctrine\\Tests', __DIR__ . '/../vendor/doctrine/orm/tests');

use Doctrine\DBAL\Types\Type;
use Salamek\Doctrine\DBAL\Types\DateRangeType;

Type::addType(
    DateRangeType::DATERANGE,
    'Salamek\\Doctrine\\DBAL\\Types\\DateRangeType'
);