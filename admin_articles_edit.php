<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */

$container = require __DIR__ . '/bootstrap.php';

if (isset($session->username)) {
    /** @var \Doctrine\ORM\EntityRepository $repo */
    $repo = $container->get('doctrine.repository.article');

    /** @var \App\Entity\Article $article */
    $article = $repo->find($_GET['id']);

    if ($article === null) {
        header('Location: admin_articles_list.php?notFound&id=' . $_GET['id']);
    } else {
        $id     = $article->getId();

        if (isset($_POST) && ! empty($_POST)) {
            /** @var \Doctrine\ORM\EntityManager $em */
            $em = $container->get('doctrine');

            /** @var \App\Entity\User $author */
            $author = $em->find('\App\Entity\User', $_POST['author']);

            $article->setName($_POST['name'])
                    ->setContent($_POST['content'])
                    ->setStatus($_POST['status'])
                    ->setAuthor($author);

            $em->persist($article);
            $em->flush();

            header('Location: admin_articles_edit.php?id=' . $id . '&articleUpdated&page=' . $_GET['page']);
        } else {
            $name = $article->getName();
            /** @var \App\Entity\User $author */
            $author = $article->getAuthor();
            $author = $author->getId();

            $statuses               = [];
            $statuses['Published']  = \App\Entity\Article::STATUS_PUBLISHED;
            $statuses['Unublished'] = \App\Entity\Article::STATUS_UNPUBLISHED;
            $statuses['Draft']      = \App\Entity\Article::STATUS_DRAFT;

            $users = $container->get('doctrine.repository.user')->findAll();

            isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
            isset($_GET['articleUpdated']) ? $articleUpdated = true : $articleUpdated = false;

            echo $container->get('twig')->render('admin/articles/edit.html.twig', [
                'title'          => 'Edit article : ' . $name,
                'id'             => $id,
                'name'           => $name,
                'content'        => $article->getContent(),
                'currentStatus'  => $article->getStatus(),
                'currentAuthor'  => $author,
                'articleUpdated' => $articleUpdated,
                'page'           => $page,
                'statuses'       => $statuses,
                'users'          => $users,
            ]);
        }
    }
} else {
    header('Location: login.php?accessDenied');
}