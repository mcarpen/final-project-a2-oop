<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */

$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    /** @var \Doctrine\ORM\EntityRepository $repo */
    $repo = $container->get('doctrine.repository.user');

    /** @var \App\Entity\User $user */
    $user = $repo->find($_GET['id']);

    if ($user === null) {
        header('Location: admin_users_list.php?notFound&id=' . $_GET['id']);
    } else {
        $username = $user->getUsername();
        $id       = $user->getId();

        if (isset($_POST) && ! empty($_POST)) {
            /** @var \Doctrine\ORM\EntityManager $em */
            $em = $container->get('doctrine');

            $user->setUsername($_POST['username']);

            if ( ! empty($_POST['password'])) {
                $user->setPassword($_POST['password']);
            }

            $em->persist($user);
            $em->flush();

            header('Location: admin_users_edit.php?id=' . $id . '&userUpdated&page=' . $_GET['page']);
        } else {
            isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
            isset($_GET['userUpdated']) ? $userUpdated = true : $userUpdated = false;

            echo $container->get('twig')->render('admin/users/edit.html.twig', [
                'title'         => 'Edit user : ' . $username,
                'id'            => $id,
                'username'      => $username,
                'userUpdated'   => $userUpdated,
                'page'          => $page,
            ]);
        }
    }
} else {
    header('Location: login.php?accessDenied');
}