<?php

/** @var \Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = require __DIR__.'/bootstrap.php';

if (! isset($session->username)) {
    $errors = [];

    /** @var \App\Entity\User $user */
    if (isset($_POST) && ! empty($_POST)) {
        $user = $container->get('doctrine.repository.user')->findOneBy(['username' => $_POST['username']]);
        if (isset($user) && ! empty($user)) {
            $checkPwd = password_verify($_POST['password'], $user->getPassword());

            if ($checkPwd) {
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
        isset($_GET['accessDenied']) ? $accessDenied = true : $accessDenied = false;
        echo $container->get('twig')->render('login.html.twig', [
            'title' => 'Login',
            'errors' => $errors,
            'accessDenied' => $accessDenied,
        ]);
    }
} else {
    header('Location: index.php');
}
