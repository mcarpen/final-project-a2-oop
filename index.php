<?php
/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

use App\Entity\User;

/** @var \Doctrine\ORM\EntityManager $em */
$em = $container->get('doctrine');

// 1. Create a User
/** @var \Doctrine\ORM\EntityRepository $userRepository */
$userRepository = $container->get('doctrine.repository.user');

/** @var User $admin */
$admin = $userRepository->findOneBy(['username' => 'admin']);

// 2. Link a User to an Article
/** @var \App\Repository\ArticleRepository $articleRepository */
$articleRepository = $container->get('doctrine.repository.article');

/** @var \App\Entity\Article $article */
$article = $articleRepository->find(4);

/** @var Twig_Environment $twig */
$twig = $container->get('twig');

isset($_GET['loggedIn']) ? $loggedIn = true : $loggedIn = false;
isset($_GET['loggedOut']) ? $loggedOut = true : $loggedOut = false;

echo $twig->render('homepage.html.twig', [
    'title'     => 'Homepage',
    'loggedIn'  => $loggedIn,
    'loggedOut' => $loggedOut,
]);

/*
$article->setAuthor($admin);
dump($article);

$em->flush();
*/