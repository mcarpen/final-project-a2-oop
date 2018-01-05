<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var \Doctrine\ORM\EntityRepository $repo */
$repo = $container->get('doctrine.repository.article');

/** @var \App\Entity\Article $article */
$article = $repo->find($_GET['id']);

if ($article === null) {
    header('Location: index.php?notFound&id=' . $_GET['id']);
} else {
    echo $container->get('twig')->render('article.html.twig', [
        'title'   => $article->getName(),
        'article' => $article,
    ]);
}

