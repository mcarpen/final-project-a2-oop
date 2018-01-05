<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    /** @var \Doctrine\ORM\EntityManager $em */
    $em = $container->get('doctrine');

    $id      = $_GET['id'];
    $article = $em->find('\App\Entity\Article', $id);
    $em->remove($article);
    $em->flush();

    header('Location: admin_articles_list.php?articleDeleted');
} else {
    header('Location: login.php?accessDenied');
}