<?php

require __DIR__ . '/vendor/autoload.php';

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

$params    = require __DIR__ . '/parameters.php';
$container = new ContainerBuilder();

/***************
 * SWIFTMAILER *
 ***************/

$container
    ->register('mailer_transport', Swift_SmtpTransport::class)
    ->addArgument('smtp.example.org')
    ->addArgument(25)
    ->addMethodCall('setUsername', ['username'])
    ->addMethodCall('setPassword', ['password'])
    ->setPublic(false)
    ->setPrivate(true);

// 2. Create the service `mailer` with configuration
$container
    ->register('mailer', Swift_Mailer::class)
    ->addArgument(new Reference('mailer_transport'));

/************
 * DOCTRINE *
 ************/
//Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$container
    ->register('doctrine_config', \Doctrine\ORM\Configuration::class)
    ->setFactory([Setup::class, 'createAnnotationMetadataConfiguration'])
    ->addArgument([__DIR__ . "/src/Entity"])
    ->addArgument(true)
    ->addArgument(null)
    ->addArgument(null)
    ->addArgument(false)
    ->setPublic(false)
    ->setPrivate(true);

//EntityManager::create($params['db'], $config);
$container
    ->register('doctrine', EntityManager::class)
    ->setFactory([EntityManager::class, 'create'])
    ->addArgument($params['db'])
    ->addArgument(new Reference('doctrine_config'));

// getRepository(Article::class);
$container
    ->register('doctrine.repository.article', EntityRepository::class)
    ->setFactory([new Reference('doctrine'), 'getRepository'])
    ->addArgument(Article::class);

$container
    ->register('doctrine.repository.user', EntityRepository::class)
    ->setFactory([new Reference('doctrine'), 'getRepository'])
    ->addArgument(User::class);

return $container;
