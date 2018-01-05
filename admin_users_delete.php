<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    /** @var \Doctrine\ORM\EntityManager $em */
    $em = $container->get('doctrine');

    $id = $_GET['id'];
    $user = $em->find('\App\Entity\User', $id);
    $em->remove($user);
    $em->flush();

    header('Location: admin_users_list.php?userDeleted');
} else {
    header('Location: login.php?accessDenied');
}