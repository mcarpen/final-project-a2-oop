<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__.'/bootstrap.php';

if (! isset($session->username)) {
    $errors = [];

    /** @var \App\Entity\User $user */
    if (isset($_POST) && ! empty($_POST)) {
        $user = $container->get('doctrine.repository.user')->findOneBy(['username' => $_POST['username']]);
        if (isset($user) && ! empty($user)) {
            if ($user->getPassword() === $_POST['password']) {
                $session->username = $user->getUsername();
                header('Location: index.php?loggedIn');
            } else {
                array_push($errors, 'Wrong password');
                echo $container->get('twig')->render('login.html.twig', [
                    'title' => 'Login',
                    'errors' => $errors,
                ]);
                $session->destroy();
            }
        } else {
            array_push($errors, 'No user found, sorry :(');
            echo $container->get('twig')->render('login.html.twig', [
                'title' => 'Login',
                'errors' => $errors,
            ]);
            $session->destroy();
        }
    } else {
        echo $container->get('twig')->render('login.html.twig', [
            'title' => 'Login',
            'errors' => $errors,
        ]);
    }
} else {
    header('Location: index.php');
}
