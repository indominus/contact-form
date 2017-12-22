<?php
namespace Dev\Controller;

use Silex\Application;

class MainController
{

    public function contactFormAction(Application $app)
    {
        return $app['twig']->render('contact-form.html.twig', []);
    }
}
