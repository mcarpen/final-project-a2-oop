<?php

use App\Entity\User;

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    $page = $_GET['page'] ?? 1;

    /** @var \App\Repository\UserRepository $repo */
    $repo = $container->get('doctrine.repository.user');

    $users = $repo->loadAll(User::MAX_PER_PAGE, ($page - 1) * User::MAX_PER_PAGE);
    $count = $repo->count();

    $maxPagination = (int)ceil($count / User::MAX_PER_PAGE);

    $minPage = (int)max(1, ($page - 5));
    $maxPage = (int)min($maxPagination, ($page + 5));

    $max = 0;

    while (abs($minPage - $maxPage) < 10) {
        if ($minPage > 1) {
            $minPage--;
        }
        if ($maxPage < $maxPagination) {
            $maxPage++;
        }

        $max++;

        if ($max > 10) {
            break;
        }
    }

    isset($_GET['userCreated']) ? $userCreated = true : $userCreated = false;

    echo $container->get('twig')->render('admin/users/list.html.twig', [
        'title'         => 'Users\' list',
        'users'         => $users,
        'currentPage'   => $page,
        'maxPagination' => $maxPagination,
        'minPage'       => $minPage,
        'maxPage'       => $maxPage,
        'userCreated'   => $userCreated,
        'count'         => $count,
    ]);
} else {
    header('Location: login.php?accessDenied');
}
