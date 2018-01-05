<?php

use App\Entity\Article;

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var \App\Repository\ArticleRepository $repo */
$repo = $container->get('doctrine.repository.article');

$page = $_GET['page'] ?? 1;

$articles = $repo->loadAll(Article::MAX_PER_PAGE, ($page - 1) * Article::MAX_PER_PAGE, true);
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

isset($_GET['loggedIn']) ? $loggedIn = true : $loggedIn = false;
isset($_GET['loggedOut']) ? $loggedOut = true : $loggedOut = false;

echo $container->get('twig')->render('homepage.html.twig', [
    'title'         => 'Homepage',
    'articles'      => $articles,
    'loggedIn'      => $loggedIn,
    'loggedOut'     => $loggedOut,
    'currentPage'   => $page,
    'maxPagination' => $maxPagination,
    'minPage'       => $minPage,
    'maxPage'       => $maxPage,
    'count'         => $count,
]);
