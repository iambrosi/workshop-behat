<?php

use PHPMvd\Validator\UniqueEmail;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;

/** @var Application $app */

$app->get('/', function (Application $app) {
    $users = $app['db']->fetchAll('SELECT * FROM users');

    return $app['twig']->render('index.html.twig', array('users' => $users, 'page' => 'users'));
})->bind('homepage');

$app->get('/users/new', function (Application $app) {
    $form = $app['form.factory']->createBuilder('form')
        ->add('name')
        ->add('email')
        ->getForm();

    return $app['twig']->render('users/new.html.twig', array(
        'form' => $form->createView(),
        'page' => 'new_user'
    ));
})->bind('users_new');

$app->post('/users/create', function (Application $app, Request $request) {
    /** @var \Symfony\Component\Form\FormInterface $form */
    $form = $app['form.factory']->createBuilder('form')
        ->add('name')
        ->add('email', 'email', array('constraints' => array(new Email(), new UniqueEmail($app['db']))))
        ->getForm();

    $form->handleRequest($request);

    if (!$form->isValid()) {
        return new Response($app['twig']->render('users/new.html.twig', array(
            'form' => $form->createView(),
            'page' => 'new_user'
        )), 400);
    }

    $data = $form->getData();

    $app['db']->executeUpdate('INSERT INTO users (name, email) VALUES (:name, :email)', array(
        ':name'  => $data['name'],
        ':email' => $data['email'],
    ));

    return $app->redirect($app['url_generator']->generate('homepage'));
})->bind('users_create');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $page = 404 == $code ? '404.html.twig' : '500.html.twig';

    return new Response($app['twig']->render($page, array('code' => $code)), $code);
});
