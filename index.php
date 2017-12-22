<?php
include_once './vendor/autoload.php';

$app = (new Silex\Application(array('debug' => true)));

$app->register(new \Silex\Provider\TwigServiceProvider(),[
    'twig.path' => 'resources/views'
]);

$app->match('/', function() use ($app) {
    return (new Dev\Controller\MainController())->contactFormAction($app);
})->bind('homepage');

$app->run();
