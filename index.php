<?php
include_once './vendor/autoload.php';

// start sessions
session_start();

// load env 
(new Dotenv\Dotenv(__DIR__))->load();

// initialize application
$app = new \Slim\App(new Slim\Container(include './app/config/container.php'));

// define routes
$app->map(['GET', 'POST'], '/', App\Controller\HomeController::class)->setName('homepage');

// run application
$app->run();
