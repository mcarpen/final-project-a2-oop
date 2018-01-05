<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    if (isset($_POST) && ! empty($_POST)) {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $container->get('doctrine');

        $user = new \App\Entity\User();
        $user->setUsername($_POST['username'])
             ->setPassword($_POST['password']);

        $em->persist($user);
        $em->flush();

        header('Location: admin_users_list.php?userCreated=' . $_POST['username']);
    } else {
        echo $container->get('twig')->render('admin/users/new.html.twig', [
            'title' => 'Create new user',
        ]);
    }
} else {
    header('Location: login.php?accessDenied');
}

