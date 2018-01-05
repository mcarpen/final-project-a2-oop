<?php

use App\Entity\Article;

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    $page = $_GET['page'] ?? 1;

    /** @var \App\Repository\ArticleRepository $repo */
    $repo = $container->get('doctrine.repository.article');

    $articles = $repo->loadAll(Article::MAX_PER_PAGE, ($page - 1) * Article::MAX_PER_PAGE);
    $count    = $repo->count();

    $maxPagination = (int)ceil($count / Article::MAX_PER_PAGE);

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

    isset($_GET['articleCreated']) ? $articleCreated = true : $articleCreated = false;
    isset($_GET['articleDeleted']) ? $articleDeleted = true : $articleDeleted = false;
    if (isset($_GET['notFound']) && isset($_GET['id'])) {
        $notFound = true;
        $id       = $_GET['id'];
    } else {
        $notFound = false;
        $id       = null;
    }

    echo $container->get('twig')->render('admin/articles/list.html.twig', [
        'title'          => 'Articles\' list',
        'articles'       => $articles,
        'currentPage'    => $page,
        'maxPagination'  => $maxPagination,
        'minPage'        => $minPage,
        'maxPage'        => $maxPage,
        'articleCreated' => $articleCreated,
        'articleDeleted' => $articleDeleted,
        'count'          => $count,
        'notFound'       => $notFound,
        'id'             => $id,
    ]);
} else {
    header('Location: login.php?accessDenied');
}
