<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    if (isset($_POST) && ! empty($_POST)) {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $container->get('doctrine');

        /** @var \App\Entity\User $author */
        $author = $em->find('\App\Entity\User', $_POST['author']);

        $article = new \App\Entity\Article();
        $article->setName($_POST['name'])
                ->setContent($_POST['content'])
                ->setStatus($_POST['status'])
                ->setAuthor($author);

        $em->persist($article);
        $em->flush();

        header('Location: admin_articles_new.php?articleCreated');
    } else {
        $users = $container->get('doctrine.repository.user')->findAll();

        echo $container->get('twig')->render('admin/articles/new.html.twig', [
            'title' => 'Create new article',
            'users' => $users,
        ]);
    }
} else {
    header('Location: login.php?accessDenied');
}
