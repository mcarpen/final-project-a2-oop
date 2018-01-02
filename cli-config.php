<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($container->get('doctrine'));